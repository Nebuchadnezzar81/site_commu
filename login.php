<?php 

/* login.php */
session_start(); //toujours en haut

//Mr Propre
$safe = array_map('strip_tags', $_POST);

// boite à outils pour verifPassword
include 'fonctions.php';
$message = '';
//mot de passe conforme?
if(verifPassword($safe['password']))
{
	//connexion BDD
	include 'includes/connexion.php';
	//requete
	$rq = "SELECT id_users, username, password
				 FROM users
				 WHERE email = :email";
	//preparation
	$stmt = $pdo->prepare($rq);
	//paramètres
	$params = [':email' => $safe['email']];
	//exécution
	if($stmt->execute($params))
	{
		// récupération
		$users = $stmt->fetch();
		// vérification mot de passe
		if(password_verify($safe['password'], $users['password']))
		{
			//enregistrement de l'abonné dans la session
			$_SESSION['id_users'] = $users['id_users'];
			$_SESSION['username'] = $users['username'];
			$_SESSION['email'] = $users['email'];
			$_SESSION['auth'] = 'ok';
			//securisation de la session
			session_regenerate_id();

			$message = "Youpeeeee";

		}
		else $message = 'mot de passe incorrect';
	}
	else $message = 'email inconnu';
}
else $message = 'mot de passe bidon';

//affichage
echo '<script>
				alert("'.$message.'");
				window.location.href="formLogin.php";
			</script>';

/*
ALTER TABLE abonne
ADD nom VARCHAR(50),
ADD email VARCHAR(100),
ADD password VARCHAR(64);

ALTER TABLE livre
ADD photo VARCHAR(100);
*/

?>