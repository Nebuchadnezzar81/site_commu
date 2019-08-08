<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// connexion BDD
include '../includes/connexion.php';

$errors = array();

if(!empty($_POST)){

	$safe = array_map('strip_tags', $_POST);

	if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'L\'adresse email est invalide';
	}

	else {
		$rq = "SELECT email FROM users WHERE email = :email";
		$stmt = $pdo->prepare($rq);
		$params = [':email' => $safe['email']];
		$stmt->execute($params);
		
		if(!$stmt->fetch()) {
			$errors[] = 'L\'email est inconnu';
		}
	}

	if(count($errors) === 0){
		$token = bin2hex(random_bytes(50));
		$mail = new PHPMailer;
		$mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
		// $mail->SMTPDebug = 3; // mode debug si > 2
		$mail->CharSet = 'UTF-8'; // charset utf-8
		$mail->isSMTP(); // connexion directe à un serveur SMTP
		$mail->isHTML(true); // mail au format HTML
		$mail->Host = 'smtp.gmail.com'; // serveur SMTP
		$mail->SMTPAuth = true; // serveur sécurisé
		$mail->Port = 465; // port utilisé par le serveur
		$mail->SMTPSecure = 'ssl'; // certificat SSL
		$mail->Username = 'gsm3webforce3@gmail.com'; // login
		$mail->Password = 'GSM3webforce3'; // mot de passe
		$mail->AddAddress($safe['email']); // destinataire
		// $mail->AddAddress('truc.muche@gmail.com'); // autre destinataire
		// $mail->AddCC('machin@bidule.fr'); // copie carbone
		// $mail->AddBCC('patron@societe.com'); // copie cachée
		$mail->SetFrom('gsm3webforce3@gmail.com', 'GSM3'); // expéditeur
		$mail->Subject = 'Message de GSM3'; // sujet
		// le corps du mail au format HTML
		$mail->Body = '<html>
						<head>
							<style>
								h1{color: orange;}
								h2{color: orange;}
								p{color: orange;}
								span{color:purple;text-decoration:none}
							</style>
						</head>
						<body>
							<h1>Bonjour,</h1>
							<p>Vous avez indiqué que vous avez perdu votre mot de passe, veuillez cliquer sur le lien suivant pour récupérer l\'accès à votre compte.</p>
							<p><a href="http://localhost/site_commu/password_recovery/reinit_password.php?token='.$token.'">Réinitialiser mon mot de passe</a></p>
						</body>
					</html>';
		// envoi
		$mail->Send();
		$success = true;
		echo $token;
		// if($mail->Send()) {
		// 	$success = true;
		// 	echo $token;
		// }
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Récupération de mot de passe</title>
</head>
<body>

	<?php if(isset($success)):?>
		<p style="color:green;">Un email vient de vous être envoyé</p>

	<?php elseif (count($errors) > 0): // Si j'ai des erreurs, je les affiche ?>		
		<p style="color:red"><?=implode('<br>', $errors);?></p>
	<?php endif;?>

	<form method="post">
		<p>
			<label>Email</label>
			<input type="email" name="email" required placeholder="votre@email.ici">
		</p>
		<p>
			<input type="submit" value="Go" id="btnSub">
		</p>
	</form>

</body>
</html>