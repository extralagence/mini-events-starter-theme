<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 16/06/2014
 * Time: 17:29
 */

class Email {

	const EMAIL_FROM = '"Mini Mondial Events" <vincent.saisset@gmail.com>';
	const EMAIL_CONFIRMATION_SUBJECT = 'Mini Mondial Events - Veuillez confirmer votre inscription';
	const EMAIL_CONFIRMED_SUBJECT = 'Mini Mondial Events - Inscription terminée';

	const EMAIL_CONFIRMATION_URL = "http://dev.extralagence.com/www.mycorpevent.com/mini/?confirmation=";
	const EMAIL_CONFIRMED_URL = "http://dev.extralagence.com/www.mycorpevent.com/mini/?confirmation_status=";
	const ASSETS_URL = "http://dev.extralagence.com/www.mycorpevent.com/mini/assets";

	protected static function get_header($email, $first_name = null, $last_name = null) {
		$headers = 'From: '.Email::EMAIL_FROM."\r\n";
		$to = '<'.$email.'>';
		if ($first_name != null && $last_name != null) {
			$to = '"'.$first_name.' '.$last_name.'" '.$to;
		}
		$headers .= 'To: '.$to."\r\n";
		$headers .= "Content-type: text/html\r\n";

		return $headers;
	}


	protected static function get_header_part() {
		$message = '<center><table width="500" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0; border-collapse:collapse; margin: 0px; padding: 0px;"><tr><td colspan="3"><img src="'.self::ASSETS_URL.'/img/emails/header.png" width="500" height="250" alt="MyCorpEvent" /></td></tr><tr><td width="50"></td><td style="font-family:Georgia, serif; font-size: 14px; color: #606060; font-style: normal; line-height: 17px;">
		';

		return $message;
	}

	protected static function get_footer_part() {
		$message = "<p>Cordialement,<br> L'équipe MyCorpEvent Mini</p>";
		$message .= '</td></tr><tr><td colspan="3"><img src="'.self::ASSETS_URL.'/img/emails/bottom.png" width="500" height="60" alt="MyCorpEvent - Copyright 2013" /></td></tr></table></center>
		';

		return $message;
	}

	protected static function get_resume_part($fields, $data) {
		$message = '<ul>';
		/** @var \fields\AbstractField $field */
		foreach ($fields as $field) {
			$confirmation_message = $field->get_confirmation_message($data);
			if ($confirmation_message != null) {
				$message .= '<li>'.$confirmation_message.'</li>';
			}
		}
		$message .= '</ul>';

		return $message;
	}

	protected static function get_confirmation_message($confirmation_key, $fields, $data, $first_name = null, $last_name = null) {
		$message = self::get_header_part();

		$message .= '<p>Cher '.$first_name.' '.$last_name.'</p>';
		$message .= '<p>Voici un résumé de votre inscription : </p>';

		$message .= self::get_resume_part($fields, $data);

		$confirmation_url = self::EMAIL_CONFIRMATION_URL.$confirmation_key;
		$message .= '<p>Pour que votre inscription soit effective <a href="'.$confirmation_url.'">veuillez confirmer votre inscription</a></p>';

		$message .= self::get_footer_part();

		return $message;
	}

	protected static function get_confirmed_message($fields, $data, $first_name = null, $last_name = null) {
		$message = self::get_header_part();

		$message .= '<p>Cher '.$first_name.' '.$last_name.'</p>
		';
		$message .= '<p>Votre inscription est maintenant terminée. Merci ! </p>
		';
		$message .= '<p>Veuillez garder une copie de cette confirmation pour vos dossiers.</p>
		';
		$message .= self::get_resume_part($fields, $data);

		$message .= '<p>Nous avons hâte de vous voir à notre événement<br /> N\'hésitez pas à nous contacter pour toute information complémentaire</p>
		';

		$message .= self::get_footer_part();

		return $message;
	}

	public static function send_confirmation($email, $confirmation_key, $fields, $data, $first_name = null, $last_name = null) {
		$headers = self::get_header($email, $first_name, $last_name);
		$subject = self::EMAIL_CONFIRMATION_SUBJECT;
		$message = self::get_confirmation_message($confirmation_key, $fields, $data, $first_name, $last_name);

		$success = mail($email, $subject, $message, $headers);

		return $success;
	}

	public static function send_confirmed($email, $fields, $data, $first_name = null, $last_name = null) {
		$headers = self::get_header($email, $first_name, $last_name);
		$subject = self::EMAIL_CONFIRMED_SUBJECT;
		$message = self::get_confirmed_message($fields, $data, $first_name, $last_name);

		$success = mail($email, $subject, $message, $headers);

		return $success;
	}
} 