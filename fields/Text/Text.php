<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 10:15
 */

namespace fields;

class Text extends AbstractField {
	public $max_length;

	public function __construct($data) {
		parent::__construct($data);
		$this->max_length = (isset($data['max_length'])) ? $data['max_length'] : null;

		if ($this->max_length == null) {
			throw new \Exception('Missing max_length for "'.$this->name.'"');
		}
	}

	public function is_valid($data) {
		$valid = parent::is_valid($data);

		$value = $this->get_value($data);
		if ($valid && $this->max_length != null) {
			if (strlen($value) > $this->max_length[0]) {
				$this->errors[] = array(
					'field_name' => $this->name,
					'label' => $this->max_length[1]
				);
				$valid = false;
			}
		}

		return $valid;
	}
}