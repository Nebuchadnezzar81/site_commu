<?php
/* contact.php */
$titrePage = "Contactez nous";
//entete + navbar
include 'includes/header.php';
include 'includes/nav.php';
?>

<div class="body-content">
	<div class="module">
		<form method="post" action="contact2.php">
			<h1>Contactez-nous</h1>
			<p>
				<input type="text" name="username" required placeholder="Nom d'utilisateur">
			</p>
			<p>
				<input type="email" name="email" placeholder="Email" id="email" required>
			</p>
			<p>
				<textarea name="message" placeholder="Votre message..." style="height: 150px;"></textarea>
			</p>
			<p>
				<input type="submit" value="Envoyez votre message" class="btn btn-block btn-primary">
			</p>
		</form>
	</div>
</div>