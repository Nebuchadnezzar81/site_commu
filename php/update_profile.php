<?php
session_start() ;
require_once '../includes/connexion.php';

if(!empty($_POST) && isset($_SESSION['id'])) {

	$post = array_map('trim', array_map('strip_tags', $_POST));

	// print_r($post);

	$q = $pdo->prepare('UPDATE users SET '.$post['col'].' = :val WHERE id = :id');

	$params = array(
		// ':col' => $post['col'],
		':val' => $post['val'],
		':id' => $_SESSION['id']
	);

	if($q->execute($params)) {

		$_SESSION[$post['col']] = $post['val']; 
		echo $post['val'];
	}
}
else {
	echo false;
}

?>