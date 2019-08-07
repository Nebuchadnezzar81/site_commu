<?php 


$message = '';
//mot de passe conforme?

if(!empty($_POST)) {

	$safe = array_map('strip_tags', $_POST);

	$errors = [];

	if(empty($safe['password'])) {
		$errors[] = 'Ihre papieren bitte !';
	}
	elseif(!verifPassword($safe['password']))
	{
		$errors[] = 'Le format du mot de passe est incorrect';
	}


	if(count($errors) === 0) {

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
		$stmt->execute($params);

		if($users = $stmt->fetch())
		{
			
			// vérification mot de passe
			if(password_verify($safe['password'], $users['password']))
			{
				//enregistrement de l'abonné dans la session
				$_SESSION['id_users'] = $users['id_users'];
				$_SESSION['username'] = $users['username'];
				$_SESSION['email'] = $users['email'];
				$_SESSION['auth'] = true;
				//securisation de la session
				session_regenerate_id();

				$message = "Youpeeeee";
			}
			else $message = 'mot de passe incorrect';
		}
		else $message = 'email inconnu';
	}
	else $message = 'mot de passe bidon';
} 


?>
<div class="body-content">
	<div class="module">
		<form method="post">

				<h1>Connection</h1>

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
		</form>
	</div>
</div>