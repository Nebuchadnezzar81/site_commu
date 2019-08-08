<?php
session_start() ;
require_once '../includes/connexion.php'; 

$safe = array_map('strip_tags', $_POST);
$errors = [];

// if(empty($safe['pseudo'])) {
// 	$errors[] = 'Le pseudo doit être renseigné';
// }
if(empty($safe['message'])) {
	$errors[] = 'Le message est vide';
}

if(count($errors) === 0) {

	$q = $pdo->prepare('INSERT INTO messages (user_id, message, datetime_post) VALUES (:user_id, :message, NOW())');

	$params = array(
		':user_id' => $_SESSION['id'],
		':message' => $safe['message'],

	);

	//$q->execute($params);

	if($q->execute($params)) {
		echo 'Le message a bien été envoyé';
	}
	else {
		echo false; // si la requête ne s'exécute pas correctement
	}
}
else {
	print_r($errors); // s'il y  a des erreurs dans le formulaire
}

?>