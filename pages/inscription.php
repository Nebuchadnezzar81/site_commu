<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$errors = array(); // dans cette variable, je vais stocker mes erreurs
// $maxFileSize = 3 * 1000 * 1000; // Limite à 3 Mo

// Le point d'exclamation devant une condition, veut dire NOT 
// Ici => not empty $_POST d

// les variables superglobales sont définies par défaut dans PHP, elles sont forcément un tableau
if(!empty($_POST)){

	// Nettoie les données reçues du formulaire en supprimant toutes les balises HTML / PHP
	$safe = array_map('strip_tags', $_POST);

	// Vérifie le bon format de mon email
	if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'Votre adresse email est invalide';
	}

	if(strlen($safe['password']) < 7){
		// $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
		$errors[] = 'Votre mot de passe doit comporter au moins 8 caractères';
	}

	if($safe['confirmpassword'] != $safe['password']){
		// $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
		$errors[] = 'Votre mot de passe ne correspond pas';
	}

	if(strlen($safe['name']) < 3){
		$errors[] = 'Le nom doit faire au moins 3 caractères';
	}

	if(strlen($safe['firstname']) < 3){
		$errors[] = 'Le prénom doit faire au moins 3 caractères';
	}

	// Vérifie que le numéro de téléphone a exactement 10 caractères

	if(strlen($safe['phone']) != 10){

		$errors[] = 'Le numéro de téléphone doit comporter 10 caractères';
	}

	// Vérifie que le numéro de téléphone ne contient que des chiffres

	if(!is_numeric($safe['phone'])){

		$errors[] = 'Le numéro de téléphone n\'est pas un nombre valide';
	}

	// La fonction count() permet de compter les entrées d'un tableau (le nombre de ligne)
	// Ici, je compte le nombre de ligne dans le tableau $errors
	// Si c'est à 0, alors a priori, tout va bien (l'utilisateur a bien rempli tous les champs)
	if(count($errors) === 0){

		// Préparation de la requete
		$request = $pdo->prepare('INSERT INTO users (username, email, password, firstname, name, phone) VALUES (:username, :email, :password, :firstname, :name, :phone)');

		// Association des paramètres avec les valeurs
		// Les paramètres permettent de sécuriser les données
		$paramsInsert = [
      ':username'    => $safe['username'],
      ':email'    => $safe['email'],
      ':password'  => password_hash($safe['password'],
      PASSWORD_DEFAULT),
      ':firstname'    => $safe['firstname'],
      ':name'    => $safe['name'],
      ':phone'    => $safe['phone'],
    ];

		// Let's go
		if($request->execute($paramsInsert)){
			$success = true;

			$safe = array_map('strip_tags', $_POST);

		}

		$mail = new PHPMailer;

				// paramétrage du STMP
				$mail->STMPOptions = ['ssl' =>
									  ['verify_peer'      => false,
									  'verify_peer_name'  => false,
									  'allow_self_signed' => true]
									 ];

				// $mail->SMTPDebug = 3; // mode debug si > 2
				$mail->CharSet = 'UTF-8'; // charset utf-8
				$mail->isSMTP(); // connection directe à un serveur SMTP
				$mail->isHTML(true); // mail au format HTML
				$mail->Host = 'smtp.gmail.com'; // serveur SMTP
				$mail->SMTPAuth = true; // serveur sécurisé
				$mail->Port = 465; // port utilisé par le serveur
				$mail->SMTPSecure = 'ssl'; // certificat ssl
				$mail->Username = 'gsm3webforce3@gmail.com'; // login
				$mail->Password = 'GSM3webforce3'; // mot de passe
				$mail->AddAddress($safe['email']); // destinataire
				// $mail->AddAddress('truc@muche.fr'); // autre destinataire
				// $mail->AddCC('machin@bidule.fr'); // copie carbonne
				// $mail->AddBCC('patron@societe.fr'); // copie cachée
				$mail->SetFrom('gsm3webforce3@gmail.com', 'GSM3'); // expediteur
				$mail->Subject = 'Message de GSM3'; // sujet
				// le corps du mail au format HTML
				$mail->Body = '<html>
								<head>
								 <style>
								  h1{color: green; }
								 </style>
								</head>
								<body>
								 <h1>Bonjour '.$safe['firstname'].' '.$safe['name'].'</h1>
								 <br>
								 <p>Vous venez de vous inscrire sur notre site, merci de votre confiance</p>
								 <p>Voici un récapitulatif des informations saisies :</p>
								 <p>Nom : '.$safe['name'].'</p>
								 <p>Prénom : '.$safe['firstname'].'</p>
								 <p>Pseudo : '.$safe['username'].'</p>
								 <p>Email : '.$safe['email'].'</p>
								 <p>Mot de passe : '.$safe['password'].'</p>
								 <p>Téléphone : '.$safe['phone'].'</p>
								 <br>
								 <p>Ceci est un message automatique, merci de ne pas y répondre</p>
								</body>
							   </html>';

				// pièces jointes
				$mail->AddAttachment('images/book.jpg');
				// accusé de réception
				// $mail->AddCustomHeader('X-confirm-Reading-To: wf3toulouse@gmail.com');
				// $mail->AddCustomHeader('Return-receipt-To: wf3toulouse@gmail.com');
				// envoi
				if ($mail->Send()) {
					echo "<p class=my-5>Votre mail à bien été envoyé. Merci de nous avoir contacté</p>";
				}
				else echo "<p>Oups ".$mail->ErrorInfo . "</p>";
					}


}



?>


<div class="body-content">
      <div class="module">
			<form method="post" enctype="multipart/form-data"> <!--action="inscription.php"-->
						<?php if(!empty($_POST) && count($errors) > 0): // Formulaire soumis avec erreur?>
							<div class="alert alert-danger">
								<?=implode('<br>', $errors); ?>
							</div>
						<?php elseif(!empty($_POST) && count($errors) == 0): // Fomulaire soumis sans erreur?>
							<div class="alert alert-primary">
								Félicitations, votre compte vient d'être créer avec succès
							</div>	
						<?php endif;?>
				<h1>Création d'un Compte</h1>

				<p>
					<input type="text" name="name" placeholder="Votre Nom" id="name" minlength="2" >
				</p>
				<p>
					<input type="text" name="firstname" placeholder="Votre Prénom" id="firstname" minlength="2" >
				</p>
				<p>
					<input type="text" name="username" placeholder="Votre Pseudo" id="username" minlength="2" >
				</p>
				<p>					
					<input type="email" name="email" placeholder="Email" id="email" >
				</p>
				<p>					
					<input type="password" name="password" placeholder="Mot de passe" id="password" >
				</p>
				<p>					
					<input type="password" name="confirmpassword" placeholder="Confirmer mot de passe" id="confirmpassword" >
				</p>
				<p>
					<input type="text" name="phone" placeholder="Votre Téléphone" id="phone" maxlength="10" >
				</p>
				<p>
					<input type="submit" value="Enregistrer" name="register" class="btn btn-block btn-primary" />
				</p>
			</form>
	  </div>
</div>
<p>
	<?php 
		if (isset($_GET['msg'])) {
			echo "<h3 style=text-align:center;color:blue;>" .$_GET["msg"] ."</h3>";
		}
	?>
</p>

</body>
</html>