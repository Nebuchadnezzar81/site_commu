<?php 

session_start();
// formInscription.php
$titrePage = 'Login';
include 'includes/nav.php';
include 'includes/header.php';
include 'fonctions.php';
include 'includes/connexion.php';

?>
<div class="body-content">
	<div class="module">
		<form method="post" action="login.php">

				<h1>Connection</h1>

			<p>
				<input type="email" name="email" required placeholder="Nom d'utilisateur">
			</p>
			<p>
				<input type="password" name="password" required placeholder="Mot de Passe">
			</p>
			<p>
				<input type="submit" name="submit" value="Se Connecter" id="button" class="btn btn-block btn-primary">
			</p>
		</form>
	</div>
</div>