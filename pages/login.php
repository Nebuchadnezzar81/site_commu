<?php 

$errors = [];
// $message = '';
//mot de passe conforme?

if(!empty($_POST)) {

	$safe = array_map('strip_tags', $_POST);	

	if(empty($safe['password'])) {
		$errors[] = 'Mot de Passe requis';
	}
	elseif(!verifPassword($safe['password']))
	{
		$errors[] = 'Le mot de passe doit comporter minimum 8 caractères, dont au moins une majuscule et un chiffre';
	}


	if(count($errors) === 0) {

		//connexion BDD
		//include 'includes/connexion.php';
		//requete
		$rq = 	"SELECT id, email, username, password
				FROM users
				WHERE email = :email";
		//preparation
		$stmt = $pdo->prepare($rq);
		//paramètres
		$params = [':email' => $safe['email']];

		//exécution
		$stmt->execute($params);

		if($users = $stmt->fetch())
		{
			
			// vérification mot de passe
			if(password_verify($safe['password'], $users['password']))
			{
				//enregistrement de l'abonné dans la session
				$_SESSION['id'] = $users['id'];
				$_SESSION['username'] = $users['username'];
				$_SESSION['email'] = $users['email'];
				$_SESSION['auth'] = true;
				//securisation de la session
				session_regenerate_id();

				$errors[] = "Youpeeeee";

				header('Location: index.php');

			}
			else $errors[] = 'mot de passe incorrect';
		}
		else $errors[] = 'email inconnu';
	}
	else $errors[] = 'mot de passe bidon';
} 


?>
<div class="body-content">
	<div class="module">
		<form method="post">

				<h1>Connexion</h1>

			<?php if(isset($errors) && count($errors) > 0): ?>
				<div class="alert alert-danger text-center">
					<p style="color:red"><?=implode('<br>', $errors);?></p>
				</div>
			<?php endif; ?>

			<p>
				<input type="email" name="email"  placeholder="Votre Email">
			</p>
			<p>
				<input type="password" name="password"  placeholder="Mot de Passe">
			</p>
			<p>
				<input type="submit" name="submit" value="Se Connecter" id="button" class="btn btn-block btn-primary">
			</p>
			<p class="badge badge-pill badge-primary" style="margin-left: 150px; background-image: linear-gradient(to bottom, #37c0ff, #0097dd);">
				<a href="index.php?page=lost_password" class=" text-decoration-none text-white">Mot de passe perdu ?</a>
			</p>
		</form>
	</div>
</div>