<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Réinitialisation Mot de Passe</title>
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<form class="login-form" action="new_password.php" method="post">
		<h2 class="form-title">Nouveau Mot de Passe</h2>
		<!-- form validation messages -->
		<?php include('messages.php'); ?>
		<div class="form-group">
			<label>Nouveau Mot de Passe</label>
			<input type="password" name="new_pass">
		</div>
		<div class="form-group">
			<label>Confirmer le nouveau Mot de Passe</label>
			<input type="password" name="new_pass_c">
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Envoyer</button>
		</div>
	</form>
</body>
</html>