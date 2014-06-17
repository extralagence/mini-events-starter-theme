<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 10:10
 */

namespace fields;

class Email extends AbstractField {
	public $error_label;

	public function __construct($data) {
		parent::__construct($data);
		$this->error_label = (isset($data['error_label'])) ? $data['error_label'] : null;
		if ($this->error_label == null) {
			throw new \Exception('Missing error_label for "'.$this->name.'"');
		}
	}

	public function is_valid($data) {
		$valid = parent::is_valid($data);

		$value = $this->get_value($data);
		if ($valid) {

			$atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   // caractères autorisés avant l'arobase
			$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // caractères autorisés après l'arobase (nom de domaine)

			$regex = '/^' . $atom . '+' .   // Une ou plusieurs fois les caractères autorisés avant l'arobase
				'(\.' . $atom . '+)*' .         // Suivis par zéro point ou plus
				// séparés par des caractères autorisés avant l'arobase
				'@' .                           // Suivis d'un arobase
				'(' . $domain . '{1,63}\.)+' .  // Suivis par 1 à 63 caractères autorisés pour le nom de domaine
				// séparés par des points
				$domain . '{2,63}$/i';          // Suivi de 2 à 63 caractères autorisés pour le nom de domaine

			if(!preg_match($regex, $value)) {
				$this->errors[] = array(
					'field_name' => $this->name,
					'label' => $this->error_label
				);
				$valid = false;
			}
		}

		return $valid;
	}
} 