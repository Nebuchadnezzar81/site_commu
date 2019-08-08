<?php
session_start() ;
require_once '../includes/connexion.php'; 

$safe = array_map('strip_tags', $_POST);


$q = $pdo->prepare("DELETE FROM messages WHERE id ='$_POST['id']'")



->execute(array($safe['id']));
//sauf que l'id du message n'est pas du tout dans le post, il est dans la table messages


//$q->execute($params);

// if($q->execute($params)) {
// 	echo 'Le message est bien supprimé';
// }
// else {
// 	echo false; // si la requête ne s'exécute pas correctement
// }


?>