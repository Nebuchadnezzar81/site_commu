<?php
session_start() ;
require_once '../includes/connexion.php'; 

//$safe = array_map('strip_tags', $_POST);
$errors = [];

// if(empty($safe['pseudo'])) {
// 	$errors[] = 'Le pseudo doit être renseigné';
// }
// if(empty($safe['message'])) {
// 	$errors[] = 'Le message est vide';
// }

//if(count($errors) === 0) {

	$q = $pdo->query('SELECT messages.id, users.username, message, datetime_post FROM messages INNER JOIN users ON messages.user_id = users.id');

	$msg_tab = $q->fetchAll();

	echo json_encode($msg_tab);
	


	// $params = array(
	// 	':id'		=> 
	// 	':user_id' 	=> $_SESSION['id'],
	// 	':message' 	=> $safe['message'],

	// );

	//$q->execute($params);

	// if($q->execute($params)) {
	// 	echo 'Le message a bien été envoyé';
	// }
	// else {
	// 	echo false; // si la requête ne s'exécute pas correctement
	// }
// }
// else {
// 	print_r($errors); // s'il y  a des erreurs dans le formulaire
// }

?>