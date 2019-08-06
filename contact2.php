<?php
/* contact2.php */

$titrePage = "Contactez-nous";
//entete + navigation
include 'includes/header.php';
include 'includes/nav.php';

// Mr Propre
$safe = array_map('strip_tags', $_POST);

/* import des classes de PHPMailer */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer;
/* paramétrage du SMTP */
$mail->SMTPOptions = ['ssl' => 
											['verify_peer' => false,
											 'verify_peer_name' => false,
											 'allow_self_signed' => true]
										 ];
// $mail->SMTPDebug = 3; //mode debug si > 2
$mail->CharSet = 'UTF-8'; //charset utf-8
$mail->isSMTP(); //connexion directe à un serveur SMTP
$mail->isHTML(true); //mail au format HTML
$mail->Host = 'smtp.gmail.com'; //serveur SMTP
$mail->SMTPAuth = true; //serveur sécurisé
$mail->Port = 465; //port utilisé par le serveur
$mail->SMTPSecure = 'ssl'; //certificat SSL
$mail->Username = 'wf3toulouse@gmail.com'; //login 
$mail->Password = '244Seysses'; //mot de passe
$mail->AddAddress('ophois34@gmail.com'); //destinataire
$mail->SetFrom('wf3toulouse@gmail.com', 'bibli WF3'); //expediteur
$mail->Subject = 'Message de '.$safe['email']; //sujet
// le corps du mail au forma HTML
$mail->Body = '<html>
								<head>
								 <style>
								  h1{color: green; }
								 </style>
								</head>
								<body>
								 <h1>Message de '.$safe['email'].'</h1>
								 <p>Prénom: '.$safe['username'].'</p>
								 <p>Message: '.$safe['message'].'</p>
								</body>
							 </html>';
// envoi
if($mail->Send())
{
	echo '<div class="alert alert-primary" style="text-align: center;width: 50%;margin: auto;margin-top: 20%;">Votre mail à été envoyé. Merci de nous avoir contacté</div>';
}
else echo '<p>Oups '. $mail->ErrorInfo . '</p>';

?>
