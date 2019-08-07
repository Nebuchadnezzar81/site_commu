<?php

echo '<pre style="color: #fff;">';
print_r($_SESSION);
print_r($_GET);
print_r($_POST);
print_r($_FILES);
echo '</pre>';

$errors = [];

$av_errors = array(); // dans cette variable, je vais stocker mes erreurs
$maxFileSize = 3 * 1000 * 1000; // Limite à 3 Mo


if(!empty($_SESSION) && $_SESSION['auth']) {

	$q = $pdo->prepare('SELECT * FROM users WHERE id = :id');
	$q->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
	$q->execute();
	$user = $q->fetch();

}
else { header('Location: index.php'); }



// Changement d'avatar
if(!empty($_FILES)) {

	if($_FILES['avatar']['error'] == UPLOAD_ERR_NO_FILE) {
		$av_errors[] = 'Vous devez sélectionner un fichier';
	}
	elseif($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {

		$info = new finfo(FILEINFO_MIME_TYPE);
		$mime = $info->file($_FILES['avatar']['tmp_name']);
		$type = substr($mime, 0, 5);

		if($type != 'image') {
			$av_errors[] = 'Vous devez sélectionner une image';
		}
		else {
			$image_size = $_FILES['avatar']['size'];
			if($image_size > $maxFileSize){
				$av_errors[] = 'La taille de votre image doit être inférieure à 3 Mo';
			}
		}
	}

	if(count($av_errors) === 0) {

		$extension = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.'));
		$newFilename = md5(uniqid(rand(), true)).$extension;

		// Déplace le fichier temporaire vers son emplacement final
		if(!move_uploaded_file($_FILES['avatar']['tmp_name'], 'uploads/avatars/'.$newFilename)) {
			$av_errors[] = 'Une erreur est survenue lors de l\'upload de l\'image';
		}
		else {
			$q = $pdo->prepare('	UPDATE users 
									SET avatar = :avatar  
									WHERE id = :id
			');

			$params = array(
				':avatar' => $newFilename,
				':id' => $_SESSION['id']
			);

			if($q->execute($params)) {
				$av_success = true;
			}
			else {
				$av_errors[] = 'Votre avatar n\'a pas pu être ajouté à la base de données';
			}


		}

	}
}


if(!empty($_POST)) {

	$post = array_map('trim', array_map('strip_tags', $_POST));


}
// avatar

// formulaire edition des données

// Couleur préférée


// Checkbox affichage du nom
// Checkbox présence en ligne

?>
<div class="container">
	<h3>Avatar</h3>
	<form method="post" id="avatar-form" enctype="multipart/form-data">
		<figure class="dash-avatar">
				<img src="<?php if($user['avatar'] != '') { echo 'uploads/avatars/'.$user['avatar']; } ?>">
		</figure>
		<input id="avatar" name="avatar" type="file" value="Changer d'avatar">
		<?php if(isset($av_success) && $av_success): ?>
			<div class="alert alert-success">L'avatar a été modifié avec succès</div>
		<?php elseif(count($av_errors) > 0): ?>
			<div class="alert alert-danger"><?=implode('<br>', $errors); ?></div>
		<?php endif; ?>
	</form>

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
	<form method="post">
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
	<form method="post">
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

<script>
	
	$(document).ready(function() {
		$('body:before').css('background-color', '#c0c');
	});

	$('input#avatar').change(function() {
		$(this).closest('form#avatar-form').trigger('submit');
	});

	$('#avatar-form').submit(function() {
		// alert('submitted');
	});

</script>
