<?php
session_start() ;
require_once '../includes/connexion.php'; 


$q = $pdo->query('SELECT messages.id, users.username, message, datetime_post FROM messages INNER JOIN users ON messages.user_id = users.id');

$msg_tab = $q->fetchAll();

echo json_encode($msg_tab);
	
?>