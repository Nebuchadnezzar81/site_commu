<?php

$errors = array();

if(!empty($_POST) && isset($_GET['token'])) {

	$safe = array_map('strip_tags', $_POST);

	if(!verifPassword($safe['pwd'])){
		$errors[] = 'Le mot de passe doit comporter minimum 8 caractères, dont au moins une majuscule et un chiffre';
	}

	if($safe['pwd'] != $safe['confirmpwd']) {
		$errors[] = 'Les mots de passe ne correspondent pas';
	}

	if(count($errors) === 0){

		$request1 = $pdo->prepare('SELECT email FROM password_resets WHERE token = :token');

		$paramsInsert1 = [
			':token' => $_GET['token'],
		];

		$request1->execute($paramsInsert1);

		if($email = $request1->fetchColumn()) {
			$request2 = $pdo->prepare('UPDATE users SET password = :password WHERE email = :email');
			$paramsInsert2 = [
				':password'  => password_hash($safe['password'],
      			PASSWORD_DEFAULT),
				':email' => $email
			];

			if($request2->execute($paramsInsert2)) {
				$success = true;
				header('Refresh: 3; index.php?page=login');
			}
		}
	}
}

?>

<?php if(isset($success)):?>
	<div class="alert alert-success">
		Votre mot de passe a bien été modifié, vous allez être redirigé dans quelques secondes.
	</div>

<?php elseif (count($errors) > 0): // Si j'ai des erreurs, je les affiche ?>
	<div class="alert alert-danger">
		<?=implode('<br>', $errors);?>
	</div>
<?php endif;?>
<div class="body-content">
	<div class="module">
		<form method="post">
			<p>
				<label>Saisir un Mot de Passe</label>
				<input type="password" name="pwd" required placeholder="8 caractères min, 1 Majuscule min, 1 chiffre min" minlength="8">
			</p>
			<p>
				<label>Confirmer le Mot de Passe</label>
				<input type="password" name="confirmpwd" required placeholder="Confirmer le mot de passe" minlength="8">
			</p>
			<p>
				<input type="submit" value="Go" id="btnSub" class="btn btn-block btn-primary">
			</p>
		</form>
	</div>
</div>