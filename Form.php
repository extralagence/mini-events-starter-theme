<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 09:44
 */


require_once 'Email.php';
require_once 'AbstractField.php';
require_once 'AbstractGroup.php';
//Require once each fields
foreach (scandir(dirname(__FILE__).'/fields') as $field_name) {
	$path = dirname(__FILE__).'/fields/'.$field_name.'/'.$field_name.'.php';
	if (is_file($path)) {
		require_once $path;
	}
}

class Form
{
	public $email_field_name;
	public $first_name_name;
	public $last_name_name;
	public $fields;

	protected $valid = null;

	public function is_confirmation_email_enabled() {
		return $this->email_field_name != null;
	}

	protected static function construct_class_name($type) {
		$array = explode('_', $type);
		$class = '';
		foreach ($array as $item) {
			$class .= ucfirst($item);
		}

		return 'fields\\'.$class;
	}

	public static function construct_field($properties) {
		if (!isset($properties['type'])) {
			throw new Exception ('FromField "type" required');
		}
		$class = self::construct_class_name($properties['type']);

		$field = new $class($properties);
		if (!isset($properties['name'])) {
			throw new Exception ('Extra Meta box "name" required for '.$class);
		}

		return $field;
	}

	public function __construct($fields_properties, $email_field_name = null, $first_name_name = null, $last_name_name = null) {
		$this->email_field_name = $email_field_name;
		$this->first_name_name = $first_name_name;
		$this->last_name_name = $last_name_name;
		$this->fields = array();

		foreach ($fields_properties as $properties) {
			$this->fields[] = self::construct_field($properties);
		}
	}

	public function is_valid($data) {
		if ($this->valid === null) {
			$this->valid = true;
			/** @var \fields\AbstractField $field */
			foreach($this->fields as $field) {
				if (!$field->is_valid($data)) {
					$this->valid = false;
				}
			}
		}

		return $this->valid;
	}

	private function get_persisted_fields($level) {
		$all_fields = array();
		foreach ($level as $current_field) {
			if ($current_field instanceof \fields\AbstractGroup) {
				$subfields = $this->get_persisted_fields($current_field->subfields);
				$all_fields = array_merge($all_fields, $subfields);
			} else {
				if ($current_field->persisted) {
					$all_fields[] = $current_field;
				}
			}
		}

		return $all_fields;
	}

	private function get_all_fields($level) {
		$all_fields = array();
		foreach ($level as $current_field) {
			if ($current_field instanceof \fields\AbstractGroup) {
				$subfields = $this->get_persisted_fields($current_field->subfields);
				$all_fields = array_merge($all_fields, $subfields);
			} else {
				$all_fields[] = $current_field;
			}
		}

		return $all_fields;
	}

	public function execute($data) {
		$success = false;
		if ($this->is_valid($data)) {
			try {
				/** @var \PDO $connection */
				$connection = \Config::get_connection();

				$field_names = '';
				$field_param_names = '';
				$first = true;
				$persisted_fields = $this->get_persisted_fields($this->fields);

				/** @var \fields\AbstractField $field */
				foreach ($persisted_fields as $field) {
					if ($first) {
						$first = false;
					} else {
						$field_names .= ', ';
						$field_param_names .= ', ';
					}
					$field_names .= $field->name;
					$field_param_names .= ':'.$field->name;
				}

				$confirmation_key_name = '';
				$confirmation_key_value = '';
				$confirmation_key = '';
				if($this->is_confirmation_email_enabled()) {
					$confirmation_key_name = ', confirmation_key';
					$confirmation_key = md5($data[$this->email_field_name]);
					$confirmation_key_value = ", '".$confirmation_key."'";
				}

				/** @var PDOStatement $request */
				$request = $connection->prepare('INSERT INTO '.Config::DB_REGISTRATION_TABLE.'(creation_date'.$confirmation_key_name.', '.$field_names.') VALUES(NOW()'.$confirmation_key_value.', '.$field_param_names.')');
				foreach ($persisted_fields as $field) {
					$request->bindValue(':'.$field->name, $field->get_value_for_database($data));
				}
				if($request->execute()) {
					if($this->is_confirmation_email_enabled()) {
						$first_name = null;
						if ($this->first_name_name != null) {
							$first_name = $data[$this->first_name_name];
						}
						$last_name = null;
						if ($this->first_name_name != null) {
							$last_name = $data[$this->last_name_name];
						}
						if (Email::send_confirmation($data[$this->email_field_name], $confirmation_key, $persisted_fields, $data, $first_name, $last_name)) {
							$success = true;
						}
					} else {
						$success = true;
					}
				} else {
					die('Error : '.$request->errorInfo()[2]);
				}

			} catch(Exception $e) {
				die('Error : '.$e->getMessage());
			}
		}

		return $success;
	}

	public function render($data) {
		/** @var \fields\AbstractField $field */
		foreach ($this->fields as $field) {
			$field->render($data);
		}
	}

	public function scripts() {
		$scripts_by_class_name = array();
		$all_fields = $this->get_all_fields($this->fields);

		/** @var \fields\AbstractField $field */
		foreach ($all_fields as $field) {
			if(!isset($scripts_by_class_name[get_class($field)])) {
				$scripts_by_class_name[get_class($field)] = get_class($field);
				$field->script();
			}
		}
	}

	public function get_fields_for_export() {
		$fields_for_export = $this->get_persisted_fields($this->fields);
		$creation_date = new \fields\Date(array(
			'type' => 'date',
			'name' => 'creation_date',
			'label' => "Date de création",
			'format' => array(
				'd/m/Y',
				"La date n'est pas au bon format (ex: 04/11/2013)",
				'dd/mm/yy'
			)
		));
		array_unshift($fields_for_export, $creation_date);

		if ($this->is_confirmation_email_enabled()) {
			$confirmed = new \fields\Checkbox(array(
				'type' => 'checkbox',
				'name' => 'confirmed',
				'label' => "Confirmée"
			));
			array_unshift($fields_for_export, $confirmed);
		}

		return $fields_for_export;
	}

	const CONFIRMED = 2;
	const NOT_FOUND_ERROR = 1;
	const SQL_ERROR = 0;

	public function confirm($confirmation_key) {
		$status = self::CONFIRMED;

		/** @var \PDO $connection */
		$connection = \Config::get_connection();
		$request = $connection->prepare('SELECT * FROM '.Config::DB_REGISTRATION_TABLE.' WHERE confirmation_key = :confirmation_key LIMIT 0, 1');
		$request->bindValue(':confirmation_key', $confirmation_key);
		if ($request->execute()) {
			$values = $request->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($values)) {
				$data = $values[0];

				if ($data ['confirmed'] != 1) {
					$update = $connection->prepare('UPDATE '.Config::DB_REGISTRATION_TABLE.' SET confirmed = 1 WHERE confirmation_key = :confirmation_key');
					$update->bindValue(':confirmation_key', $confirmation_key);
					if ($update->execute()) {
						// IF CONFIRMATION WAS DISABLED LATER
						if ($this->is_confirmation_email_enabled()) {
							$first_name = null;
							if ($this->first_name_name != null) {
								$first_name = $data[$this->first_name_name];
							}
							$last_name = null;
							if ($this->first_name_name != null) {
								$last_name = $data[$this->last_name_name];
							}
							Email::send_confirmed($data[$this->email_field_name], $this->get_persisted_fields($this->fields), $data, $first_name, $last_name);
						}
					} else {
						$status = self::SQL_ERROR;
					}
				}
			} else {
				$status = self::NOT_FOUND_ERROR;
			}
		} else {
			$status = self::SQL_ERROR;
		}

		return $status;
	}
}