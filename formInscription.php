<?php

/* import des classes de PHPMailer */
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
require 'includes/connexion.php';
include 'includes/nav.php';
include 'includes/header.php';
$titrePage = 'inscription';
$errors = array(); // dans cette variable, je vais stocker mes erreurs
// $maxFileSize = 3 * 1000 * 1000; // Limite à 3 Mo

// Le point d'exclamation devant une condition, veut dire NOT 
// Ici => not empty $_POST d

// les variables superglobales sont définies par défaut dans PHP, elles sont forcément un tableau
if(!empty($_POST)){

	// Nettoie les données reçues du formulaire en supprimant toutes les balises HTML / PHP
	$safe = array_map('strip_tags', $_POST);

	// Vérifie le bon format de mon email
	if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'Votre adresse email est invalide';
	}

	if(strlen($safe['password']) < 7){
		// $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
		$errors[] = 'Votre mot de passe doit comporter au moins 8 caractères';
	}

	if($safe['confirmpassword'] != $safe['password']){
		// $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
		$errors[] = 'Votre mot de passe ne correspond pas';
	}


	// La fonction count() permet de compter les entrées d'un tableau (le nombre de ligne)
	// Ici, je compte le nombre de ligne dans le tableau $errors
	// Si c'est à 0, alors a priori, tout va bien (l'utilisateur a bien rempli tous les champs)
	if(count($errors) === 0){

		// Préparation de la requete
		$request = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');

		// Association des paramètres avec les valeurs
		// Les paramètres permettent de sécuriser les données
		$paramsInsert = [
      ':username'    => $safe['username'],
      ':email'    => $safe['email'],
      ':password'  => password_hash($safe['password'],
      PASSWORD_DEFAULT),
    ];

		// Let's go
		if($request->execute($paramsInsert)){
			$success = true;

			$safe = array_map('strip_tags', $_POST);

		}
	}


}



?>


<div class="body-content">
      <div class="module">
			<form method="post" enctype="multipart/form-data"> <!--action="inscription.php"-->
						<?php if(!empty($_POST) && count($errors) > 0): // Formulaire soumis avec erreur?>
							<div class="alert alert-danger">
								<?=implode('<br>', $errors); ?>
							</div>
						<?php elseif(!empty($_POST) && count($errors) == 0): // Fomulaire soumis sans erreur?>
							<div class="alert alert-primary">
								Félicitations, votre compte vient d'être créer avec succès
							</div>	
						<?php endif;?>
				<h1>Création d'un Compte</h1>

				<p>
					<input type="text" name="username" placeholder="Nom d'utilisateur" id="nom" minlength="2" required>
				</p>
				<p>					
					<input type="email" name="email" placeholder="Email" id="email" required>
				</p>
				<p>					
					<input type="password" name="password" placeholder="Mot de passe" id="mdp" required>
				</p>
				<p>					
					<input type="password" name="confirmpassword" placeholder="Confirmer mot de passe" id="confirm" required>
				</p>
				<p>
					<input type="submit" value="Enregistrer" name="register" class="btn btn-block btn-primary" />
				</p>
			</form>
	  </div>
</div>
<p>
	<?php 
		if (isset($_GET['msg'])) {
			echo "<h3 style=text-align:center;color:blue;>" .$_GET["msg"] ."</h3>";
		}
	?>
</p>

</body>
</html>