<?php  


$errors = array(); // dans cette variable, je vais stocker mes erreurs
// $maxFileSize = 3 * 1000 * 1000; // Limite à 3 Mo

// Le point d'exclamation devant une condition, veut dire NOT 
// Ici => not empty $_POST d

// les variables superglobales sont définies par défaut dans PHP, elles sont forcément un tableau
if(!empty($_POST)){

	// Nettoie les données reçues du formulaire en supprimant toutes les balises HTML / PHP
	$safe = array_map('strip_tags', $_POST);

	// Vérifie le bon format de mon email
	if(!filter_var($safe['newemail'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'Votre adresse email est invalide';
	}

	if(strlen($safe['newpassword']) < 7){
		// $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
		$errors[] = 'Votre mot de passe doit comporter au moins 8 caractères';
	}

	if($safe['confirmnewpassword'] != $safe['newpassword']){
		// $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
		$errors[] = 'Votre mot de passe ne correspond pas';
	}

	if(strlen($safe['newname']) < 3){
		$errors[] = 'Le nom doit faire au moins 3 caractères';
	}

	if(strlen($safe['newfirstname']) < 3){
		$errors[] = 'Le prénom doit faire au moins 3 caractères';
	}

	// Vérifie que le numéro de téléphone a exactement 10 caractères

	if(strlen($safe['newphone']) != 10){

		$errors[] = 'Le numéro de téléphone doit comporter 10 caractères';
	}

	// Vérifie que le numéro de téléphone ne contient que des chiffres

	if(!is_numeric($safe['newphone'])){

		$errors[] = 'Le numéro de téléphone n\'est pas un nombre valide';
	}

	// La fonction count() permet de compter les entrées d'un tableau (le nombre de ligne)
	// Ici, je compte le nombre de ligne dans le tableau $errors
	// Si c'est à 0, alors a priori, tout va bien (l'utilisateur a bien rempli tous les champs)
	if(count($errors) === 0){

		include 'includes/connexion.php';
		

		if(isset($_SESSION['id_users'])) {

			   $request = $pdo->prepare("SELECT * FROM users WHERE id_users = ?");
			   $request->execute(array($_SESSION['id_users']));
			   $user = $request->fetch();

			   if(isset($_POST['newusername']) AND !empty($_POST['newusername']) AND $_POST['newusername'] != $user['newusername']) {

			      $newusername = htmlspecialchars($_POST['newusername']);
			      $insertpseudo = $pdo->prepare("UPDATE users SET username = ? WHERE id_users = ?");
			      $insertpseudo->execute(array($newusername, $_SESSION['id_users']));
			      header('Location: index.php?page=index?id_users='.$_SESSION['id_users']);
			   }

			   if(isset($_POST['newname']) AND !empty($_POST['newname']) AND $_POST['newname'] != $user['newname']) {

			      $newname = htmlspecialchars($_POST['newname']);
			      $insertname = $pdo->prepare("UPDATE users SET name = ? WHERE id_users = ?");
			      $insertname->execute(array($newname, $_SESSION['id_users']));
			      header('Location: index.php?page=index?id_users='.$_SESSION['id_users']);
			   }

			   if(isset($_POST['newfirstname']) AND !empty($_POST['newfirstname']) AND $_POST['newfirstname'] != $user['newfirstname']) {

			      $newfirstname = htmlspecialchars($_POST['newfirstname']);
			      $insertfirstname = $pdo->prepare("UPDATE users SET firstname = ? WHERE id_users = ?");
			      $insertfirstname->execute(array($newfirstname, $_SESSION['id_users']));
			      header('Location: index.php?page=index?id_users='.$_SESSION['id_users']);
			   }

			   if(isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user['newemail']) {

			      $newemail = htmlspecialchars($_POST['newemail']);
			      $insertemail = $pdo->prepare("UPDATE users SET mail = ? WHERE id_users = ?");
			      $insertemail->execute(array($newemail, $_SESSION['id_users']));
			      header('Location: index.php?page=index?id_users='.$_SESSION['id_users']);
			   }

			   if(isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND isset($_POST['confirmnewpassword']) AND !empty($_POST['confirmnewpassword'])) {

			      $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
			      $confirmnewpassword = password_hash($_POST['confirmnewpassword']);

			     if($newpassword == $confirmnewpassword) {

			         $insertmdp = $pdo->prepare("UPDATE users SET password = ? WHERE id_users = ?");
			         $insertmdp->execute(array($newpassword, $_SESSION['id_users']));

			         header('Location: index.php?page=index?id_users='.$_SESSION['id_users']);

			      }
			   }

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
							<div class="alert alert-success">
								Félicitations, vos identifiants viennent d'être modifiés avec succès
							</div>	
						<?php endif;?>
				<h1>Mon Compte</h1>

				<h2>Voici votre compte, vous pouvez modifier vos identifiants à tout moment</h2>

				<p>
					<input type="text" name="newname" placeholder="Votre Nom" id="newname" minlength="2" >
				</p>
				<p>
					<input type="text" name="newfirstname" placeholder="Votre Prénom" id="newfirstname" minlength="2" >
				</p>
				<p>
					<input type="text" name="newusername" placeholder="Votre Pseudo" id="newusername" minlength="2" >
				</p>
				<p>					
					<input type="email" name="newemail" placeholder="Email" id="newemail" >
				</p>
				<p>					
					<input type="password" name="newpassword" placeholder="Mot de passe" id="newpassword" >
				</p>
				<p>					
					<input type="password" name="confirmnewpassword" placeholder="Confirmer mot de passe" id="confirmnewpassword" >
				</p>
				<p>
					<input type="text" name="newphone" placeholder="Votre Téléphone" id="newphone" maxlength="10" >
				</p>
				<p>
					<input type="submit" value="Modifier mon profil" name="modify" class="btn btn-block btn-primary" />
				</p>
			</form>

      </div>
</div>