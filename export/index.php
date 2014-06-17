<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 13/06/2014
 * Time: 12:06
 */

require_once '../Config.php';
require_once '../Form.php';
require_once 'Exporter.php';

/** @var \PDO $connection */
$connection = \Config::get_connection();

/** @var \PDOStatement $request */
$request = $connection->prepare('SELECT * FROM '.\Config::DB_REGISTRATION_TABLE);

$lines = array();
if($request->execute()) {
	$lines = $request->fetchAll(PDO::FETCH_ASSOC);
} else {
	die ('Error: '.$request->errorInfo()[2]);
}

if (!empty($_POST) && isset($_POST['download'])) {
	$exporter = Exporter::get_instance();
	$exporter->export($lines);
	die;
}
$form = Config::get_form();

?><!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie9 lte9 recent"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html dir="ltr" lang="fr-FR" class="recent noie no-js"><!--<![endif]-->
<head>
	<meta charset="UTF-8" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" href="../assets/css/export.css" />
	<title>Export Mini Plateforme - Mondial Events</title>

</head>
<body>
	<header>
		<h1>Export Mini Plateforme</h1>
		<form action="" method="POST">
			<input type="hidden" name="download" value="download">
			<button type="submit">Télécharger au format Excel</button>
		</form>
	</header>

	<table>
		<thead>
			<tr>
				<?php
				/** @var \fields\AbstractField $field */
				foreach($form->get_fields_for_export() as $field) : ?>
					<td><?php echo $field->label; ?></td>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach($lines as $line) : ?>
				<tr>
					<?php foreach($form->get_fields_for_export() as $field) : ?>
						<td><?php echo $field->get_value_for_export($line); ?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>

