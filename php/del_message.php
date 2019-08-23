<?php
session_start() ;
require_once '../includes/connexion.php'; 

$safe = array_map('trim', array_map('strip_tags', $_POST));

if(!is_numeric($safe['id'])) {
	$errors[] = 'Arrête de tricher';
}


$q = $pdo->prepare('UPDATE messages SET message = "Message supprimé" WHERE id=:id');
$q->bindValue(':id', $safe['id'], PDO::PARAM_INT);

if($q->execute()) {
	echo 'Le message est bien supprimé';
}
else {
	echo false; // si la requête ne s'exécute pas correctement
}


?>
