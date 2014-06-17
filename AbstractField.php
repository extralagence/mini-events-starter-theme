<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 09:44
 */

namespace fields;

abstract class AbstractField
{
	public $name;
	public $label;

	public $required;
	public $unique;

	public $regex;

	public $persisted;
	public $confirmation;

	public $errors = array();

	public function __construct($data) {
		$this->name = (isset($data['name'])) ? $data['name'] : null;
		$this->label = (isset($data['label'])) ? $data['label'] : null;

		$this->required = (isset($data['required'])) ? $data['required'] : null;

		$this->unique = (isset($data['unique'])) ? $data['unique'] : null;

		$this->regex = (isset($data['regex'])) ? $data['regex'] : null;

		$this->persisted = (isset($data['persisted'])) ? $data['persisted'] : true;
		$this->confirmation = (isset($data['confirmation'])) ? $data['confirmation'] : null;
	}

	public function script() {

	}

	public function render_label($data) {
		?>
		<label for="<?php echo $this->name; ?>"><?php echo $this->label; ?><?php echo ($this->required !== null) ? '<span class="form-required">*</span>' : ''; ?></label>
		<?php
	}

	public function render_errors($data) {
		foreach ($this->errors as $error) : ?>
			<span class="error"><?php echo $error['label']; ?></span>
		<?php endforeach;
	}

	/**
	 * @param $data
	 */
	public function render($data) {
		$value = $this->get_value($data);
		?>
		<p class="extra-field">
			<?php $this->render_label($data); ?>
			<input class="input" type="text" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>" value="<?php if($value !== null) echo $value; ?>" />
			<?php $this->render_errors($data); ?>
		</p>
		<?php
	}

	/**
	 * @param $data
	 *
	 * @return string|int
	 */
	public function get_value($data) {
		return isset($data[$this->name]) ? $data[$this->name] : null;
	}

	public function get_value_for_database($data) {
		return $this->get_value($data);
	}

	public function get_value_for_export($data) {
		return $this->get_value($data);
	}

	public function get_confirmation_message($data) {
		$confirmation = $this->confirmation;
		if ($confirmation !== null) {
			$value = $this->get_value($data);
			$confirmation = str_replace(':value', $value, $confirmation);
		}

		return $confirmation;
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function is_valid($data) {
		$valid = true;

		if ($valid && $this->required !== null) {
			$valid = $this->is_valid_required($data);
		}

		if ($valid && $this->regex !== null) {
			$valid = $this->is_valid_regex($data);
		}

		if ($valid && $this->unique !== null) {
			$valid = $this->is_valid_unique($data);
		}

		return $valid;
	}

	protected function is_valid_required($data) {
		$valid = true;
		if(!isset($data[$this->name]) || empty($data[$this->name])) {
			$this->errors[] = array(
				'field_name' => $this->name,
				'label' => $this->required
			);
			$valid = false;
		}

		return $valid;
	}

	protected function is_valid_regex($data) {
		$valid = true;
		if(!preg_match($this->regex[0], $data[$this->name])) {
			$this->errors[] = array(
				'field_name' => $this->name,
				'label' => $this->regex[1]
			);
			$valid = false;
		}

		return $valid;
	}

	protected function is_valid_unique($data) {
		$valid = true;

		/** @var \PDO $connection */
		$connection = \Config::get_connection();

		/** @var \PDOStatement $request */
		$request = $connection->prepare('SELECT '.$this->name.' FROM '.\Config::DB_REGISTRATION_TABLE.' WHERE '.$this->name.' = :value');
		$request->bindParam(':value', $data[$this->name]);

		if($request->execute()) {
			$values = $request->fetch();
			if(!empty($values)) {
				$this->errors[] = array(
					'field_name' => $this->name,
					'label' => $this->unique
				);
				$valid = false;
			}
		} else {
			$this->errors[] = array(
				'field_name' => $this->name,
				'label' => $this->unique
			);
			$valid = false;
		}
		$request->closeCursor();

		return $valid;
	}
}