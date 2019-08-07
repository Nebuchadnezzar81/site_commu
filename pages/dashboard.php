<?php

// echo '<pre style="color: #fff;">';
// print_r($_SESSION);
// print_r($_GET);
// print_r($_POST);
// echo '</pre>';


if(!empty($_SESSION) && $_SESSION['auth']) {

	$q = $pdo->prepare('SELECT * FROM users WHERE id = :id');
	$q->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
	$q->execute();
	$user = $q->fetch();

}
else { header('Location: index.php'); }
// avatar

// formulaire edition des données

// Couleur préférée


// Checkbox affichage du nom
// Checkbox présence en ligne

?>
<div class="body-content">
	<div class="module">
		<div class="container">
			<div class="row">
				<div class="col-3">
					<form>
					<figure class="dash-avatar">
							<img src="">
					</figure>
					<input type="file" name="avatar" value="Changer d'avatar">
					</form>
				</div>
				<div class="col-9">
					<h3>Profil</h3>
					<div class="dash-pseudo">
						<input type="text" name="username" value="<?= $user['username'] ?? ''; ?>">	
					</div>
					<div class="dash-name">
						<input type="text" name="firstname" value="<?= $user['firstname'] ?? ''; ?>">	
						<input type="text" name="name" value="<?= $user['name'] ?? ''; ?>">	
					</div>
					<div>
						<input type="text" name="email" value="<?= $user['email'] ?? ''; ?>" disabled>	
					</div>
					<h3>Confidentialité</h3>
					<form>
						<div>
							<label for="pwd">Mot de passe actuel</label>
							<input id="pwd" name="pwd" type="password">
						</div>
						<div>
							<label for="new_pwd">Mot de passe actuel</label>
							<input id="new_pwd" name="new_pwd" type="password">
						</div>
						<div>
							<label for="new_pwd_confirm">Mot de passe actuel</label>
							<input id="new_pwd_confirm" name="new_pwd_confirm" type="password">
						</div>
						<div>
							<input type="submit" value="Réinitialiser le mot de passe">
						</div>				
					</form>
					<form>
						<div>
							<label for="show_name">Afficher mon nom en ligne</label>
							<input id="show_name" name="show_name" type="checkbox">
						</div>
						<div>
							<label for="show_online">Afficher ma présence en ligne</label>
							<input id="show_online" name="show_online" type="checkbox">
						</div>

					</form>

					<h3>Style</h3>

					<div>
						<label for="color_theme">Couleur du thème</label>
						<input id="color_theme" name="color_theme" type="color">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	
	$(document).ready(function() {
		$('body:before').css('background-color', '#c0c');
	});

</script>
