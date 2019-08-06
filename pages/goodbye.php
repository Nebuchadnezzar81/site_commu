<?php  

// suppression d'une variable de session
unset($_SESSION["auth"]);

// suppression de toutes las variables de session
session_unset();
// ou $_SESSION = [];

// destruction de la session
session_destroy();

// retour à la page d'accueil
header('location: index.php');

?>