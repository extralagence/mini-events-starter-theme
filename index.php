<?php

require_once 'utils.php';

require_once 'includes/less/Less.php';

require_once 'Config.php';
require_once 'Form.php';

$bdd = Config::get_connection();
$form = Config::get_form();

/*
 * EMAIL CONFIRMATION
 */
if(isset($_GET["confirmation"])) {
	$confirmation_key = $_GET["confirmation"];
	$status = $form->confirm($confirmation_key);
	header('Location: '.Email::EMAIL_CONFIRMED_URL.$status);
	die;
}

?><!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie9 lte9 recent"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html dir="ltr" lang="fr-FR" class="recent noie no-js"><!--<![endif]-->
	<head>
		<meta charset="UTF-8" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<title>Mini Plateforme - Mondial Events</title>
		<link rel='canonical' href='http://dev.extralagence.com/www.mycorpevent.com/mini' />

		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />


		<?php
		$parser = new Less_Parser();
		$parser->parseFile( 'assets/css/common.less');
		$css = $parser->getCss();
		echo '<style>';
		echo $css;
		echo '</style>';
		// <link rel="stylesheet" href="assets/css/common.css" />
		?>
		<link rel="stylesheet" href="assets/css/jquery.fancybox.css" />
		<link rel="stylesheet" href="assets/css/smoothness/jquery-ui-1.8.18.custom.css" />
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

		<!--[if lt IE 8]>
		<link rel="stylesheet" href="assets/css/ie.css" />
		<script src="assets/js/IE9.js">IE7_PNG_SUFFIX=":";</script>
		<![endif]-->

		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-31777856-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</head>
	<body><?php

	$success = true;
	if(isset($_POST) && sizeof($_POST) > 0) {
		$success = $form->execute($_POST);
	}
?>
	<div id="wrapper">

		<?php //<img id="alertArrow" src="assets/img/visu/arrow.png" width="126" height="127" alt="Scrollez pour vous inscrire" /> ?>

		<div id="global">
			<div id="header">
				<div class="content">
					<h1>Mini plateforme<br>Mondial Events</h1>
					<p>Du 28 juin au 4 juillet</p>
				</div>
			</div>
			<div id="main">
				<div id="content" class="content">
					<h2>Le séminaire de l'année</h2>
					<h3>Un instant d’évasion au cœur du massif du Mont-Blanc</h3>
					<p>sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
					</p>
					<br>
					<ul>
						<li><strong>Formule 1 : </strong><br>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</li>
						<li><strong>Formule 2 : </strong><br>At vero eos et accusam et justo duo dolores et ea rebum.</li>
						<li><strong>Formule 3 : </strong><br>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</li>
					</ul>

					<hr />
					<h2>Troisième édition</h2>
					<h3>Chaque année un moment pour se retrouver</h3>
					<p><strong>Du 28 juin au 4 juillet,</strong> Fusce non tellus enim. Proin vel scelerisque massa, eget dignissim lorem. Nullam egestas, quam ac molestie bibendum, odio risus posuere lorem, eu faucibus elit justo non eros<strong> Phasellus in iaculis ligula, ut convallis dolor. Sed tincidunt adipiscing justo, et imperdiet odio ultricies non.</strong></p>
					<br>

					<?php
					$gallery2012 = get_images('gallery2012');
					$i = 0;
					$total2012 = count($gallery2012);
					echo '<a class="gallery button pictures" title="Image 1/'.$total2012.'<br />Naviguez avec les flèches de votre clavier, ou en cliquant sur l\'image" href="'.$gallery2012[0].'" data-fancybox-group="gallery2012">Les photos de l\'édition 2012</a>';
					foreach ($gallery2012 as $image) {
						$i++;
						if ($i > 1) {
							echo '<a title="Image '.$i.'/'.$total2012.'" class="gallery" href="'.$image.'" data-fancybox-group="gallery2012"></a>';
						}
					}
					?>
					<?php
					$gallery2012 = get_images('gallery2013');
					$i = 0;
					$total2013 = count($gallery2012);
					echo '<a class="gallery button pictures" title="Image 1/'.$total2013.'<br />Naviguez avec les flèches de votre clavier, ou en cliquant sur l\'image" href="'.$gallery2012[0].'" data-fancybox-group="gallery2013">Les photos de l\'édition 2013</a>';
					foreach ($gallery2012 as $image) {
						$i++;
						if ($i > 1) {
							echo '<a title="Image '.$i.'/'.$total2013.'" class="gallery" href="'.$image.'" data-fancybox-group="gallery2013"></a>';
						}
					}
					?>
					<hr />
					<h3>Invidunt ut labore</h3>
					<p>Etiam odio metus, viverra suscipit facilisis quis, luctus eu est. Nunc venenatis magna at consequat placerat. Sed sed felis odio. Quisque vehicula, tellus vitae rhoncus ultrices, magna nisl vestibulum risus, et mattis nulla augue sed nisi. Donec ultrices dapibus condimentum. Phasellus eu elementum metus. Mauris ac malesuada tellus. Sed molestie dolor vel dignissim tincidunt. Nullam ultricies felis ultrices, sollicitudin libero quis, mollis augue.<br /></p>
				</div><!-- content -->

				<?php if(time() < 1402910609 || array_key_exists("test", $_GET)): ?>
					<div class="content content-right" id="registration-closed">
						<h2>Inscription en ligne</h2>
						<p>Les réservations sont closes pour cet événement.</p>
						<hr />
					</div>
				<?php else: ?>
					<div id="form" class="content content-right">
						<h2>Inscription en ligne</h2>

						<form id="registration" name="registration" method="POST" enctype="multipart/form-data">
							<?php $form->render($_POST); ?>
							<fieldset id="booking_submit">
								<legend>Validation</legend>
								<?php if ($form->is_confirmation_email_enabled()) : ?>
									<p>Vous receverez un email de validation.</p>
								<?php endif; ?>
								<input type="submit" class="submit button" id="submit" value="Envoyer votre demande de réservation">
							</fieldset>
						</form>
					</div><!-- form -->
				<?php endif; ?>
			</div><!-- main -->
		</div><!-- global -->
		<footer id="footer">
			<div class="wrapper">
				<p>Plateforme de réservation - Mondial Events | Agence évènementielle - © Tous droits réservés</p>
			</div>
		</footer>

		<div style="display:none;">
			<?php
				if(isset($_POST) && sizeof($_POST) > 0) {
					if ($success == false) {
						if($form->is_valid($_POST)) {
							echo '<div class="error notification" id="alert"><h2>Oups...</h2><p>Une erreur est survenue.</p></div>';
						} else {
							echo '<div class="error notification" id="alert"><h2>Attention !</h2><p>Merci de vérifier les informations dans le formulaire d\'inscription.</p></div>';
						}
					} else {
						if($form->is_valid($_POST)) {
							if ($form->is_confirmation_email_enabled()) {
								echo '<div class="valid notification" id="alert"><h2>Merci.</h2><p>Un email vous permettant de valider votre inscription vous a été envoyé.</p></div>';
							} else {
								echo '<div class="valid notification" id="alert"><h2>Merci.</h2><p>Votre inscription a bien été prise en compte !</p></div>';
							}
						}
					}

					echo '<a id="alertBtn" href="#alert"></a>';
				}
			?>
			<?php
				if(!isset($_POST) || sizeof($_POST) == 0) {
					if(isset($_GET["confirmation_status"])) {
						$status = $_GET["confirmation_status"];

						if ($status == Form::CONFIRMED) {
							echo '<div class="valid notification" id="confirm"><h2>Merci.</h2><p>Votre inscription a été confirmée ! <br>Vous allez recevoir un email récapitulatif.</p></div>';
						} else if ($status == Form::NOT_FOUND_ERROR) {
							echo '<div class="error notification" id="confirm"><h2>Oups...</h2><p>Aucune inscription ne correspond.</p></div>';
						} else {
							echo '<div class="error notification" id="confirm"><h2>Oups...</h2><p>Une erreur est survenue.<br>Veuillez reéessayer plus tard ou nous contacter.</p></div>';
						}
						echo '<a id="confirmBtn" href="#confirm"></a>';
					}
				}
			?>
		</div>
	</div> <!-- #wrapper -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="assets/js/jquery.ui.datepicker-fr.js"></script>
		<script src="assets/js/jquery.fancybox.pack.js"></script>
		<script src="assets/js/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/TweenMax.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/jquery.gsap.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/plugins/ScrollToPlugin.min.js"></script>
		<script src="assets/js/common.js"></script>
		<script src="assets/js/extra.checkbox.js"></script>
		<?php $form->scripts(); ?>
	</body>
</html>