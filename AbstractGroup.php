<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 09:44
 */

namespace fields;

abstract class AbstractGroup extends AbstractField
{
	public $subfields;

	public function __construct($data) {
		parent::__construct($data);

		if (!isset($data['subfields']) || empty($data['subfields'])) {
			throw new \Exception('Missing subfields for "'.$this->name.'"');
		}

		$this->subfields = array();
		foreach ($data['subfields'] as $properties) {
			$this->subfields[] = \Form::construct_field($properties);
		}
	}

	public function is_valid($data) {
		$valid = true;
		/** @var \fields\AbstractField $field */
		foreach($this->subfields as $field) {
			if (!$field->is_valid($data)) {
				$valid = false;
			}
		}

		return $valid;
	}
}