<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 09:44
 */
class Config
{
	const DB_NAME = 'me_mini';
	const DB_USER = 'root';
	const DB_PASSWORD = '5J+gy)7Q6@Xg';
	const DB_HOST = 'localhost';
	const DB_CHARSET = 'utf8';
	const DB_REGISTRATION_TABLE = 'mini_registration';

	private static $connection = null;

	/**
	 * @return $connection PDO
	 */
	public static function get_connection() {
		if (self::$connection === null) {
			// CONNEXION A LA BASE DE DONNEES
			try {
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				self::$connection = new PDO('mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME, self::DB_USER, self::DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".self::DB_CHARSET));
			} catch (Exception $e) {
				die('Erreur : ' . $e->getMessage());
			}
		}

		return self::$connection;
	}

	public static function get_form() {
		return new Form(array(
			array(
				'type' => 'fieldset',
				'name' => 'booking_information',
				'label' => "Détails du compte",
				'subfields' => array(
					array(
						'type' => 'text',
						'name' => 'first_name',
						'label' => "Prénom",
						'required' => "Saisissez votre prénom",
						'max_length' => array(
							255,
							"Le prénom renseigné est trop long"
						)
					),
					array(
						'type' => 'text',
						'name' => 'last_name',
						'label' => "Nom",
						'required' => "Saisissez votre nom",
						'max_length' => array(
							255,
							"Le nom renseigné est trop long"
						)
					),
					array(
						'type' => 'email',
						'name' => 'email',
						'label' => "Email",
						'required' => "Saisissez votre email",
						'unique' => "Cette adresse email existe déjà",
						'error_label' => 'Saisissez une adresse email valide'
					)
				)
			),

			array(
				'type' => 'fieldset',
				'name' => 'booking_gala',
				'label' => "Dîner de gala",
				'subfields' => array(
					array(
						'type' => 'checkbox',
						'name' => 'gala',
						'label' => "Je participe au dîner de gala",
						'confirmation' => 'Vous participerez au dîner de gala'
					),
					array(
						'type' => 'textarea',
						'name' => 'diet',
						'label' => "J'ai un régime spécifique",
						'max_length' => array(
							500,
							"Le texte renseigné est trop long"
						)
					),
				)
			),

			array(
				'type' => 'fieldset',
				'name' => 'booking_hotel',
				'label' => "Hébergement",
				'subfields' => array(
					array(
						'type' => 'date',
						'name' => 'arrival_date',
						'label' => "Date d'arrivée",
						'required' => "Précisez une date d'arrivée",
						'format' => array(
							'd/m/Y',
							"La date n'est pas au bon format (ex: 04/11/2013)",
							'dd/mm/yy'
						),
						'min' => array(
							'28/06/2014',
							"Choisissez une date postérieure au 27/06/2014"
						),
						'max' => array(
							'04/07/2014',
							"Choisissez une date antérieure au 05/07/2014"
						),
						'confirmation' => 'Vous arriverez le :value'
					),
					array(
						'type' => 'time',
						'name' => 'arrival_time',
						'label' => "Heure d'arrivée",
						'required' => "Précisez une heure d'arrivée",
						'format' => array(
							'G\hi',
							"L'heure n'est pas au bon format (ex: 19h30)",
							'h'
						),
						'min' => array(
							'17h00',
							"Choisissez une heure après 17h00"
						),
						'max' => array(
							'23h00',
							"Choisissez une heure avant 23h00"
						),
						'confirmation' => 'Vous arriverez à :value'
					),
					array(
						'type' => 'select',
						'name' => 'formula',
						'label' => "Formule",
						'required' => "Choisissez une formule",
						'options' => array(
							array(
								'value' => '',
								'label' => 'Choisir...'
							),
							'Formule 1',
							'Formule 2',
							'Formule 3',
						),
						'confirmation' => 'Vous avez retenu la :value'
					),
					array(
						'type' => 'radio_group',
						'name' => 'plus_one',
						'label' => "Je serais",
						'required' => "Êtes vous accompagné ?",
						'options' => array(
							'Seul(e)',
							'Accompagné(e)'
						),
						'confirmation' => 'Vous serez :value'
					)
				)
			),
		), 'email', 'first_name', 'last_name');
	}
}