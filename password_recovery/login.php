<?php include('app_logic.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Réinitialisation Mot de Passe</title>
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<form class="login-form" action="login.php" method="post">
		<h2 class="form-title">Connexion</h2>
		<!-- form validation messages -->
		<?php include('messages.php'); ?>
		<div class="form-group">
			<label>Email</label>
			<input type="text" value="<?php echo $user_id; ?>" name="user_id">
		</div>
		<div class="form-group">
			<label>Mot de Passe</label>
			<input type="password" name="password">
		</div>
		<div class="form-group">
			<button type="submit" name="login_user" class="login-btn">Se Connecter</button>
		</div>
		<p><a href="enter_email.php">Mot de Passe oublié ?</a></p>
	</form>
</body>
</html>