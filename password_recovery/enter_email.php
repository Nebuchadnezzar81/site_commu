<?php include('app_logic.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Réinitialisation Mot de Passe</title>
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Réinitialisation Mot de Passe</h2>
		<!-- form validation messages -->
		<?php include('messages.php'); ?>
		<div class="form-group">
			<label>Votre adresse email</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Envoyer</button>
		</div>
	</form>
</body>
</html>