<?php



?><!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="fr-FR" class="no-js ie ie9 lte9 recent"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html dir="ltr" lang="fr-FR" class="recent noie no-js"><!--<![endif]-->
	<head>
		<meta charset="UTF-8" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<title>Annivelo'v 2014</title>
		<link rel='canonical' href='http://www.annivelov.fr' />

		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

		<link rel="stylesheet" href="tpl/css/common.css" />
		<link rel="stylesheet" href="tpl/css/jquery.fancybox.css" />
		<link rel="stylesheet" href="tpl/css/smoothness/jquery-ui-1.8.18.custom.css" />
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

		<!--[if lt IE 8]>
		<link rel="stylesheet" href="tpl/css/ie.css" />
		<script src="tpl/js/IE9.js">IE7_PNG_SUFFIX=":";</script>
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

	$valid = true;
	$fields = array("prenom", "nom", "naissance", "sexe", "adresse", "codepostal", "ville", "pays", "tel", "email", "conditions");
	$errorsFields = array(
		"prenom" => "Saisissez votre prénom",
		"nom" => "Saisissez votre nom",
		"naissance" => "Saisissez votre date de naissance",
		"sexe" => "Indiquez votre sexe",
		"adresse" => "Saisissez votre adresse",
		"codepostal" => "Saisissez votre code postal",
		"ville" => "Saisissez votre ville",
		"pays" => "Saisissez votre pays",
		"tel" => "Saisissez votre numéro de téléphone",
		"conditions" => "Vous devez accepter les conditions",
		"email" => "Saisissez votre adresse email",
		"email2" => "Saisissez une adresse email valide",
		"email3" => "Cette adresse email existe déjà");
	$errors = array();
	if(isset($_POST) && sizeof($_POST) > 0) {
		foreach($fields as $value) {

			if(!isset($_POST[$value]) || empty($_POST[$value])) {
				$valid = false;
				$errors[$value] = $errorsFields[$value];
			}

			if($value == "email" && (isset($_POST[$value]) && !empty($_POST[$value]))){

				if(!preg_match($regex, $_POST["email"])) {
					$valid = false;
					$errors[$value] = $errorsFields["email2"];
				} else {

					try {
						$request = $bdd->query('SELECT email FROM av_inscrits WHERE email="'.$_POST["email"].'"');
						if(isset($request)) {
							$mails = $request->fetch();
							if(!empty($mails)) {
								$valid = false;
								$errors[$value] = $errorsFields["email3"];
							}
						} else {
								$valid = false;
								$errors[$value] = $errorsFields["email3"];
						}
						$request->closeCursor();
					} catch (Exception $e) {
						die('Erreur : ' . $e->getMessage());
					}
				}

			}

		}
	} else {

		$valid = false;

	}

	if($valid) {
		try {
			$date = DateTime::createFromFormat('d/m/Y', $_POST["naissance"]);
			$req = $bdd->prepare('INSERT INTO av_inscrits(date_creation, prenom, nom, naissance, sexe, adresse, codepostal, ville, pays, tel, email, confirm) VALUES(NOW(), :prenom, :nom, :naissance, :sexe, :adresse, :codepostal, :ville, :pays, :tel, :email, :confirm)');
			$req->execute(array(
				'prenom' => $_POST["prenom"],
				'nom' => $_POST["nom"],
				'naissance' => $date->format('Y-m-d'),
				'sexe' => $_POST["sexe"],
				'adresse' => $_POST["adresse"],
				'codepostal' => $_POST["codepostal"],
				'ville' => $_POST["ville"],
				'pays' => $_POST["pays"],
				'tel' => $_POST["tel"],
				'email' => $_POST["email"],
				'confirm' => '1'
			));
		} catch(Exception $e) {
 			die('Erreur : '.$e->getMessage());
		}
	}
?>

		<img id="alertArrow" src="tpl/img/visu/arrow.png" width="126" height="127" alt="Scrollez pour vous inscrire" />

		<div id="global">
			<div id="header">
				<div class="content">
					<h1>9ème anniVélo’V</h1>
					<p>Samedi 28 juin de 11 à 16h</p>
				</div>
			</div>
			<div id="main">
				<div id="content" class="content">

					<h2>Laissez-vous penter !</h2>
					<h3>9% de pente ! Et plus si affinités</h3>
					<p>Après Ben en 2010, Robert Combas en 2012, "Le Gentil Garçon" en 2013, c'est Skertzo, artiste Lumière bien connu notamment à Lyon pour avoir mis en lumière le tunnel de mode doux de la Croix-Rousse, qui a été inspiré par les célèbres vélos rouges et gris et qui va parrainer ce 9ème anniversaire de Vélo'V. Et oui, le pionnier du vélo en libre service, grâce au Grand Lyon et à sa collaboration avec JC Decaux, fait désormais partie de notre paysage urbain et de nos déplacements quotidiens depuis déjà 9 ans. C’est devenu une tradition, nos plus de 50 000 abonnés Vélo'V, qui ont prouvé qu’ils ne manquaient pas de souffle, pourront comme chaque année grimper à <strong>Fourviére en Vélo'V, au départ de la place Bellecour en 2014 (une première).</strong></p>
					<hr />
					<h4>Un défi pour tous</h4>
					<p><strong>Samedi 28 juin, de 11h à 16h,</strong> serez-vous capable de rallier sur votre Vélo'V la place Bellecour à l'esplanade de Fourviére : soit 2500 m dont les <strong>1200 m de la montée Saint-Barthélémy depuis la place Saint-Paul (150m de dénivelé positif à minimum 9% de moyenne).</strong></p>
					<hr />
					<h3>Pédaleurs ou supporters, c’est ambiance assurée !</h3>
					<h4>Au départ</h4>
					<p>Venez avec votre Vélo'V ou utilisez un des 300 Vélo'V mis à disposition par JC Decaux place Bellecour, dans le cadre de Mobil’idées (pièce d’identité obligatoire) :</p>
					<ul>
						<li>Vérification technique de votre Vélo'V</li>
						<li>Vous pourrez rencontrer les techniciens qui réparent chaque jour les bobos des Vélo'V</li>
					</ul>
					<p>Il ne s’agit pas d’une course mais d’un petit challenge personnel. Vous partez quand vous voulez (pas trop vite quand même, c’est un conseil) entre 11h et 16h. Vous roulez jusqu'à Saint-Paul en respectant le code de la route puis grimpez à votre rythme (sur le vélo, c’est mieux pour le public) et vous n’hésitez pas à faire une petite pause si nécessaire. L’objectif est d’arriver en haut sur votre Vélo'V.<br />
C’est possible ! <strong>Plus de 1000 courageux ont réussi cet exploit en 2013.</strong></p>
                    <hr />
                    <h4>Sur le parcours</h4>
                    <p>Vous aurez droit à une petite ambiance musicale pour vous relancer en danseuse. Malgré l’effort, gardez le sourire. Vous serez photographiés durant cette ascension héroïque. Les photos de votre exploit seront disponibles sur le site Internet dès le lundi 30 juin.</p>
                    <hr />
                    <h4>À l’arrivée à Fourvière</h4>
                    <p>Sur l’esplanade de Fourvière, des rafraîchissements vous attendent pour vous remettre et vous permettre ensuite de rejoindre l’arrivée, la place Bellecour. Nous vous offrirons également un tee-shirt collector signé par l’artiste parrain de cet anniversaire (pour ceux qui sont montés en Vélo'V, uniquement).</p>
                    <hr />
                    <h4>À l’arrivée sur la place Bellecour</h4>
                    <p>Retour et restitution de votre Vélo'V sur la place Bellecour. Pour les participants au défi, une collation et des rafraîchissements vous attendent sous chapiteau à partir de 12h.<br />
Vous pourrez visiter, sur la place Bellecour, le village Mobil’idées pour découvrir toutes les solutions durables pour bouger sur le Grand Lyon.<br />
JC Decaux offrira également 50 abonnements Vélo'V (à gagner par tirage au sort parmi les arrivants). <strong>Inscriptions possibles sur place.</strong></p>
					<hr />
					<h4 class="gallerylink"><a class="gallery" title="Image 1/25<br />Naviguez avec les flèches de votre clavier, ou en cliquant sur l'image" href="tpl/img/gallery2012/img01.jpg" rel="gallery">Les photos de l'Annivelo'v 2012</a></h4>
					<?php
						for($i = 2; $i<=25; $i++) {
							echo '<a title="Image '.$i.'/25" class="gallery" href="tpl/img/gallery2012/img'.str_pad ($i, 2, "0", STR_PAD_LEFT).'.jpg" rel="gallery"></a>';
						}
					?>					<h4 class="gallerylink"><a class="gallery" title="Image 1/12<br />Naviguez avec les flèches de votre clavier, ou en cliquant sur l'image" href="tpl/img/gallery2013/img1.jpg" rel="gallery-2013">Les photos de l'Annivelo'v 2013</a></h4>
					<?php
						for($i = 2; $i<=12; $i++) {
							echo '<a title="Image '.$i.'/12" class="gallery" href="tpl/img/gallery2013/img'.$i.'.jpg" rel="gallery-2013"></a>';
						}
					?>
					<hr />
					<h3>Zoom sur Skerzo</h3>
					<p>Maître de l'illusion et du trompe-l’œil, Skertzò métamorphose les sites et théâtralise l’espace urbain. Créateur de ‪spectacles, ‪images &amp; ‪scénographie, dans la nuit des villes comme dans l’espace clos de la scène, Skertzò est le scénographe de territoires fantasmagoriques où ombres et lumières révèlent des réalités imaginaires.<br />
<a href="http://www.skertzo.fr">www.skertzo.fr</a></p>
				</div><!-- content -->
				<?php if(time() < 1370613600 || array_key_exists("test", $_GET)): ?>
				<div class="content" id="inscCloses">
					<img src="tpl/img/visu/inscriptions-closes.png" alt="Les inscriptions en ligne sont closes - Vous pouvez encorevous inscrire sur place" height="480" width="380" />
					<hr />
					<!--<p>Il est toujours possible de s'inscrire sur place !<br />
					Rendez-vous samedi à partir de 11h à la gare Saint-Paul.<br />
					Complétez le bulletin d'inscription pour gagner du temps :</p>
					<h4><a href="annivelov_2013_bulletin_inscription.pdf" target="_blank">Télécharger le bulletin d'inscription</a></h4>-->
					<h4><a class="participants" href="./participants/">Découvrez les photos de l'édition 2013</a></h4>
				<?php else: ?>
				<div id="form">
					<div class="velov">
						<img src="tpl/img/visu/velov.gif" alt="Logo Vélo'V" />
					</div>
					<h2><img src="tpl/img/visu/titre-inscription.png" alt="Bulletin d'inscription" height="43" width="315" /></h2>
					<form id="inscription" name="inscription" method="post" enctype="multipart/form-data" action="">

						<?php if(isset($errors["nom"])): ?>
						<p class="error"><?php echo $errors["nom"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="nom">Nom</label>
							<input type="text" name="nom" id="nom" value="<?php if(isset($_POST["nom"])) echo $_POST["nom"]; ?>" />
						</p>

						<?php if(isset($errors["prenom"])): ?>
						<p class="error"><?php echo $errors["prenom"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="prenom">Prénom</label>
							<input type="text" name="prenom" id="prenom" value="<?php if(isset($_POST["prenom"])) echo $_POST["prenom"]; ?>" />
						</p>

						<?php if(isset($errors["naissance"])): ?>
						<p class="error"><?php echo $errors["naissance"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="naissance">Date de naissance</label>
							<input type="text" name="naissance" id="naissance" value="<?php if(isset($_POST["naissance"])) echo $_POST["naissance"]; ?>" />
						</p>

						<?php if(isset($errors["sexe"])): ?>
						<p class="error"><?php echo $errors["sexe"]; ?></p>
						<?php endif; ?>
						<p class="inline">
							<label for="sexe1">Sexe</label>
							<input type="radio" class="inline" name="sexe" id="sexe1" value="m" <?php if(isset($_POST["sexe"]) && $_POST["sexe"] == "m") echo 'checked="checked" '; ?>/><label class="inline" for="sexe1">Masculin</label>
							<input type="radio" class="inline" name="sexe" id="sexe2" value="f" <?php if(isset($_POST["sexe"]) && $_POST["sexe"] == "f") echo 'checked="checked" '; ?>/><label class="inline" for="sexe2">Féminin</label>
						</p>

						<?php if(isset($errors["adresse"])): ?>
						<p class="error"><?php echo $errors["adresse"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="adresse">Adresse</label>
							<input type="text" name="adresse" id="adresse" value="<?php if(isset($_POST["adresse"])) echo $_POST["adresse"]; ?>" />
						</p>

						<?php if(isset($errors["codepostal"])): ?>
						<p class="error"><?php echo $errors["codepostal"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="codepostal">Code postal</label>
							<input type="text" name="codepostal" id="codepostal" value="<?php if(isset($_POST["codepostal"])) echo $_POST["codepostal"]; ?>" />
						</p>

						<?php if(isset($errors["ville"])): ?>
						<p class="error"><?php echo $errors["ville"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="ville">Ville</label>
							<input type="text" name="ville" id="ville" value="<?php if(isset($_POST["ville"])) echo $_POST["ville"]; ?>" />
						</p>

						<?php if(isset($errors["pays"])): ?>
						<p class="error"><?php echo $errors["pays"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="pays">Pays</label>
							<input type="text" name="pays" id="pays" value="<?php if(isset($_POST["pays"])) echo $_POST["pays"]; ?>" />
						</p>

						<?php if(isset($errors["tel"])): ?>
						<p class="error"><?php echo $errors["tel"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="tel">Téléphone</label>
							<input type="text" name="tel" id="tel" value="<?php if(isset($_POST["tel"])) echo $_POST["tel"]; ?>" />
						</p>

						<?php if(isset($errors["email"])): ?>
						<p class="error"><?php echo $errors["email"]; ?></p>
						<?php endif; ?>
						<p>
							<label for="email">E-mail</label>
							<input type="text" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>" />
						</p>

						<?php if(isset($errors["conditions"])): ?>
						<p class="error"><?php echo $errors["conditions"]; ?></p>
						<?php endif; ?>
						<p class="inline">
							<input type="checkbox" class="inline" name="conditions" id="conditions" value="conditions" <?php if(isset($_POST["conditions"]) && $_POST["conditions"] == "conditions") echo 'checked="checked" '; ?>/>
							<label for="conditions" class="inline">J'accepte les <a href="#inscriptions" title="Afficher les conditions de participation" class="inscriptions">conditions de participation</a></label>
						</p>
						<input type="submit" id="submit" value="S'inscrire" />
					</form>
					<div class="deco"></div>
				</div><!-- form -->
				<?php endif; ?>
			</div><!-- main -->
		</div><!-- global -->
		<div id="footer">
			<div class="wrapper">
				<div class="top">
					<a href="http://www.velov.grandlyon.com" class="logo-velov" target="_blank" title="Ouvrir le site Velo'v dans une nouvelle fenêtre"><img src="tpl/img/visu/logo-velov.png" alt="Velo'v 2005 / 2013 - Logo" /></a>
					<a href="http://www.grandlyon.com" class="logo-glyon" target="_blank" title="Ouvrir le site du Grand Lyon dans une nouvelle fenêtre"><img src="tpl/img/visu/logo-grand-lyon.png" alt="Grand Lyon - Communauté Urbaine - Logo" /></a>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fvelov.officiel&amp;width=292&amp;height=62&amp;colorscheme=light&amp;show_faces=false&amp;border_color&amp;stream=false&amp;header=false&amp;appId=220611784722096" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe>
				</div>
				<ul class="navigation">
					<li><span>2014 &copy; Annivélo'V</span></li>
					<li><a href="#mentions" class="mentions" title="Afficher les mentions légales">Mentions légales</a></li>
					<li><a href="#credits" class="credits" title="Afficher les crédits">Crédits</a></li>
                    <li><a href="http://2012.annivelov.fr" class="2012" title="Afficher le site de l'édition 2012">L'édition 2012</a></li>
                    <li><a href="http://2013.annivelov.fr" class="2013" title="Afficher le site de l'édition 2013">L'édition 2013</a></li>
				</ul>
			</div>
		</div>

		<div style="display:none;">

			<div id="inscriptions" class="content">

				<h4>Règlement</h4>
				<p>L’Annivélo'V  est organisé pour le compte du Grand Lyon. Le défi Vélo'V consiste à rallier la place Bellecour à l’esplanade de Fourvière en Vélo'V. Il se déroulera le 28 juin 2014 de 11h à 16h. Il n’y a aucune notion de performance, de temps ou de classement dans cet événement. Il s’agit d’une randonnée et non d’une épreuve sportive. Les participants sont considérés comme étant en excursion personnelle. Le parcours se fera à allure libre dans le strict respect du Code de la Route (rouler à droite, s’arrêter aux feux rouges, respecter les "stops" et "cédez le passage"… ) et des autres usagers de la ville (piétons, automobiles…). Il est à noter que, même à vélo. Tout manquement aux règles du Code de la Route et tout comportement dangereux sera sanctionné par un arrêt du participant. Une assistance médicale sera présente. Tout véhicule suiveur à moteur est interdit sur le parcours.
Les participants s’engagent à parcourir la distance et l’itinéraire aussi bien à la montée qu’à la descente dans le plus grand respect des autres participants. Ils s’engagent également à respecter et rendre le matériel qui lui sera mis à disposition pour sa participation.</p>
                <p>Avant le départ, il vous sera demandé l’original de votre carte d’identité ou autre pièce d’identité.</p>
                <p>Ce défi est ouvert à toute personne de 14 ans et plus (autorisation parentale obligatoire pour les moins de 18 ans).</p>
                <p>Le Grand Lyon décline toute responsabilité en cas d’accident ou de défaillance consécutifs à un mauvais état de santé, en cas de vol, détérioration de matériel… pendant la durée du défi ou sur les sites de départ et d’arrivée.</p>
Tout manquement au présent règlement décharge l’organisateur de toute responsabilité.
Les participants autorisent l’organisateur Grand Lyon ainsi que leurs ayants droits tels que partenaires et médias à utiliser les images fixes ou audiovisuelles sur lesquelles ils pourraient apparaître, prises à l’occasion de leur participation au défi Vélo'V sur tous les supports y compris les documents promotionnels et/ou publicitaires, dans le monde entier et pour la durée la plus longue prévue par la loi. Tout engagement implique la prise de connaissance du présent règlement et l’acceptation des clauses.</p>
			</div>
			<div id="mentions" class="content">
				<h3><img src="tpl/img/visu/titre-mentions-legales.png" alt="Mentions légales" height="35" width="175" /></h3>
				<p>Ce site est édité par la communauté urbaine de Lyon, pour l'anniversaire du service vélo'v</p>
				<p>Vélo'V© est un service de location de vélos proposé par le Grand Lyon et exploité par la société <strong>JCDecaux SA</strong>.<br />
				Vélo'V© est une marque déposée et appartient au Grand Lyon.</p>
				<p><strong>Grand Lyon</strong> - 20, rue du Lac – BP 31 03 - 69399 Lyon cedex 03<br />
				Tél : (33) 4 78 63 40 40<br />
				<a href="mailto:webmestre@grandlyon.org" target="_blank">webmestre@grandlyon.org</a></p>
				<h4>Directrice de publication :</h4>
				<p>Pascale Ammar-Khodja, directrice de la communication</p>
				<h4>Hébergement :</h4>
				<p><a href="http://www.ovh.com" target="_blank">OVH</a> SAS au capital de 10 000 000 €</p>
				<h4>Traitement des données personnelles et droit d'accès, de modification et de suppression</h4>
				<p>Les données personnelles recueillies sur le site résultent de la communication volontaire d'une adresse de courrier électronique lors du dépôt d'un message électronique. Les adresses e-mail ainsi recueillies ne servent qu’à transmettre les éléments d’information demandés.</p>
				<p>Le Grand Lyon conserve de manière confidentielle les adresses e-mails pour une durée ne pouvant excéder 1 an.</p>
				<p>Les adresses électroniques collectées ne feront l’objet d’aucune cession à des tiers ni d’aucun traitement de la part du Grand Lyon.</p>
				<p>Le Grand Lyon n’utilise pas de procédés de collecte automatisée de données (cookies, applet java ou active X).</p>
				<p>Nos serveurs ne sont pas configurés pour collecter des informations personnelles sur les visiteurs du site en dehors des données techniques suivantes : provenance des connexions (fournisseur d'accès), adresse IP, type et version du navigateur utilisé.</p>
				<p>Les données de trafic ont uniquement pour finalité de nous permettre d’analyser la fréquentation de nos pages d'information afin d'en améliorer le contenu. Les données relatives à la navigation des visiteurs ne sont pas exploitées nominativement. Il s'agit de statistiques agrégées permettant de connaître les pages les plus et les moins populaires, les chemins préférés, les niveaux d'activité par jour de la semaine et par heure de la journée, les principales erreurs clients ou serveur…</p>
				<p>Conformément à l'article 34 de la loi 78-17 du 6 janvier 1978 relative à l'information, aux fichiers et aux libertés, toute personne peut obtenir communication et, le cas échéant, rectification ou suppression des informations la concernant.<br />
				Afin d'exercer ce droit, vous pouvez vous adresser par courrier postal à la <strong>Direction des Affaires Juridiques et de la Commande Publique</strong><br />
				Communauté urbaine de Lyon<br />
				20, rue du Lac<br />
				BP 3103<br />
				69399 Lyon Cedex 03</p>
				<h4>Protection des données personnelles</h4>
				<p>En application de la loi Informatique et Libertés du 6 janvier 1978 modifiée, vous disposez d’un droit d’interrogation, d’accès, de rectification et d’opposition pour motifs légitimes relativement à l’ensemble des données vous concernant, que vous pouvez exercer par voie postale auprès du Grand Lyon, Direction de la communication - 20 rue du Lac 69003 Lyon, en joignant une copie d’un titre d’identité à votre demande.</p>
				<h4>Dispositions légales</h4>
				<p>Les divers éléments du site web (la forme, la mise en page, le fonds, la structure …) sont protégés par le droit des dessins et modèles, le droit d’auteur, le droit des marques ainsi que le droit à l’image et ils ne peuvent être copiés ou imités en tout ou partie sauf autorisation expresse du Grand Lyon.</p>
				<p>Toute personne ne respectant pas les dispositions légales applicables se rend coupable du délit de contrefaçon et est passible des sanctions pénales prévues par la loi.</p>
				<h4>Droits d’auteurs</h4>
				<p>Le présent site constitue une œuvre dont la "Communauté urbaine de Lyon" est l'auteur au sens des articles L. 111.1 et suivants du Code de la propriété intellectuelle.</p>
				<p>Les photographies, textes, logos, pictogrammes, ainsi que toutes œuvres intégrées dans le site sont la propriété de la "Communauté urbaine de Lyon" ou de tiers ayant autorisé la "Communauté urbaine de Lyon" à les utiliser.</p>
				<p>Les reproductions, les transmissions, les modifications, les réutilisations, sur un support papier ou informatique, dudit site et des œuvres qui y sont reproduites ne sont autorisées que pour un usage personnel et privé conforme aux dispositions de l'article L 122-5 du Code de la Propriété Intellectuelle. Ces reproductions devront ainsi notamment indiquer clairement la source et l’auteur du site et/ou de ces œuvres multimédias.</p>
				<p>En aucun cas ces reproductions ne sauraient porter préjudice aux droits des tiers.</p>
				<p>Les reproductions, les transmissions, les modifications, les réutilisations à des fins publicitaires, commerciales ou d'information, de tout ou partie du site, sont totalement interdites.</p>
				<h4>Logos Grand Lyon et Vélo'V©</h4>
				<p>Le logo du Grand Lyon, comme celui de Vélo'V©, ne peut être modifié – proportions, couleurs, éléments, constituants – et ne peut être sujet à aucune transformation, animation ou tout autre processus.</p>
				<p>Les logos du Grand Lyon et de Vélo'V© ne peuvent-être utilisés et associés qu’aux seules informations vérifiables. Il ne peuvent être notamment utilisés que pour illustrer des relations avec la communauté urbaine de Lyon ou des actions de sponsorings dûment établies.</p>
				<p>Quel que soit le cas d’espèce, le Grand Lyon se réserve le droit d’approuver ou de désapprouver toute utilisation du logo Grand Lyon ou de Vélo'V©, pour assurer son utilisation correcte, conformément à l’éthique, la morale et aux intérêts de la communauté urbaine de Lyon.</p>
				<p>Les conditions susmentionnées s’appliquent dans le cadre de pages web, elles ne font pas référence à l’utilisation du logo dans tout autre document.</p>
				<p>La communauté urbaine de Lyon se réserve le droit de modifier les conditions d’utilisation du logo Grand Lyon et de Vélo'V© à tout moment et sans préavis.</p>
			</div>
			<div id="credits" class="content">
				<a href="http://www.extralagence.com" target="_blank" title="Visiter le site de l'agence Extra"><img src="tpl/img/visu/signature-extra.png" alt="Conception et création par Extra l'agence" height="201" width="700" /></a>
			</div>
			<?php
				if(isset($_POST) && sizeof($_POST) > 0) {

					if($valid) {
						echo '<div class="valid" id="alert">Votre inscription a bien été prise en compte. Merci !</div>';
					} else {
						echo '<div class="error" id="alert">Merci de vérifier les informations dans le formulaire d\'inscription.</div>';
					}
					echo '<a id="alertBtn" href="#alert"></a>';

				}
			?>
			<?php
				if(isset($_GET["email"])) {
					$request = $bdd->query('SELECT email FROM av_inscrits WHERE email="'.$_GET["email"].'"');
					if(isset($request)) {
						while($mails = $request->fetch()) {
							if($_GET["confirm"] == 1 || $_GET["confirm"] == 0){
								if($_GET["confirm"] == 1){
									echo '<div class="valid" id="confirm">Votre inscription a été confirmée !</div>';
								} else {
									echo '<div id="confirm">Votre inscription a bien été annulée.</div>';
								}
								$bdd->exec('UPDATE av_inscrits SET confirm='.$_GET["confirm"].'  WHERE email="'.$mails[0].'"');
							}
						}
					}
					echo '<a id="confirmBtn" href="#confirm"></a>';
				}
			?>
		</div>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="tpl/js/jquery.ui.datepicker-fr.js"></script>
		<script src="tpl/js/jquery.fancybox.pack.js"></script>
		<script src="tpl/js/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/TweenMax.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/jquery.gsap.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/plugins/ScrollToPlugin.min.js"></script>
		<script src="tpl/js/common.js"></script>

	</body>
</html>