<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

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
		// Préparation de la requete
		$request = $pdo->prepare('INSERT INTO password_resets (email, token) VALUES (:email, :token)');

		// Association des paramètres avec les valeurs
		// Les paramètres permettent de sécuriser les données
		$paramsInsert = [
			':email' => $safe['email'],
			':token' => $token
		];

		// Let's go
		if($request->execute($paramsInsert)) {
			$success = true;
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
			$mail->Username = 'mathieu.webforce3@gmail.com'; // login
			$mail->Password = 'AbC123456789'; // mot de passe
			$mail->AddAddress($safe['email']); // destinataire
			// $mail->AddAddress('truc.muche@gmail.com'); // autre destinataire
			// $mail->AddCC('machin@bidule.fr'); // copie carbone
			// $mail->AddBCC('patron@societe.com'); // copie cachée
			$mail->SetFrom('mathieu.webforce3@gmail.com', 'GSM3'); // expéditeur
			$mail->Subject = 'Message de GSM3'; // sujet
			// le corps du mail au format HTML
			$mail->Body = '<html>
							<head>
								<style>
									h1{color: grey;}
									p{color: grey;}
								</style>
							</head>
							<body>
								<h1>Mot de passe perdu ?</h1>
								<p>Bonjour, vous avez indiqué que vous avez perdu votre mot de passe, veuillez cliquer sur le lien suivant pour récupérer l\'accès à votre compte.</p>
								<p><a href="localhost/site_commu/index.php?page=reinit_password&token='.$token.'">Réinitialiser mon mot de passe</a></p>
								<p>Si vous n\'êtes pas à l\'origine de cette demande, veuillez ignorer cet email. Vous pouvez continuer à utiliser votre mot de passe actuel.</p>
							</body>
						</html>';
			// envoi
			$mail->Send();
			// if($mail->Send()) {
			// 	$success = true;
			// 	echo $token;
			// }
		}
	}
}

?>

<?php if(isset($success)):?>
	<div class="alert alert-success">
		Un email vient de vous être envoyé
	</div>
<?php elseif (count($errors) > 0): // Si j'ai des erreurs, je les affiche ?>		
	<div class="alert alert-danger">
		<?=implode('<br>', $errors);?>
	</div>
<?php endif;?>
<div class="body-content">
	<div class="module">
		<form method="post">
			<p>
				<label>Email</label>
				<input type="email" name="email" required placeholder="votre@email.ici">
			</p>
			<p>
				<input type="submit" value="Go" id="btnSub" class="btn btn-block btn-primary">
			</p>
		</form>
	</div>
</div>