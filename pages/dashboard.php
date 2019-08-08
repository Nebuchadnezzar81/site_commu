<?php

// echo '<pre style="color: #fff;">';
// print_r($_SESSION);
// print_r($_GET);
// print_r($_POST);
// print_r($_FILES);
// echo '</pre>';

$errors = [];

$maxFileSize = 3 * 1000 * 1000; // Limite à 3 Mo


if(!empty($_SESSION) && $_SESSION['auth']) {


	// Changement d'avatar
	if(!empty($_FILES)) {

		$av_errors = [];

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


	if(!empty($_POST) && isset($_POST['action'])) {

		$post = array_map('trim', array_map('strip_tags', $_POST));


		if($post['action'] == 'user-infos-form') {




		}
		elseif($post['action'] == 'user-pwd-form') {

			$pwd_errors = [];

			if(empty($post['pwd']) || empty($post['new_pwd']) || empty($post['new_pwd_confirm'])) {
				$pwd_errors[] = 'Tous les champs doivent être renseignés';
			}
			elseif(!verifPassword($post['pwd']) || !verifPassword($post['new_pwd'])) {
				$pwd_errors[] = 'Les mots de passe doivent comporter 8 caractères, un nombre et une majuscule';
			}
			elseif($post['new_pwd'] != $post['new_pwd_confirm']) {
				$pwd_errors[] = 'Le nouveau mot de passe doit être identique à la confirmation de mot de passe';
			}



			if(count($pwd_errors) === 0) {

				// Vérif mot de passe existe
				$q = $pdo->prepare('SELECT password FROM users WHERE id = :id');
				$q->bindValue(':id', $_SESSION['id']);
				$q->execute();
				$hashed_pwd = $q->fetchColumn();

				if(password_verify($post['pwd'], $hashed_pwd)) {

					$new_pwd_hash = password_hash($post['new_pwd'], PASSWORD_DEFAULT);

					$q = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');

					$params = array(
						':password' => $new_pwd_hash,
						':id' => $_SESSION['id']
					);

					if($q->execute($params)) {
						$pwd_success = true;
					}
					else
					{
						$pwd_errors[] = 'Une erreur est servenue lors de la mise à jour du mot de passe';
					}
				}
				else {
					$pwd_errors[] = 'Le mot de passe est incorrect';
				}

			}





		}
		// elseif($post['action'] == 'check-form') {
		// }
		// elseif($post['action'] == 'color-form') {
		// }
	}



	// Récupération données users
	$q = $pdo->prepare('SELECT * FROM users WHERE id = :id');
	$q->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
	$q->execute();
	$user = $q->fetch();

}
else { header('Location: index.php'); }

?>
<div id="dash" class="container">
	<h3>Avatar</h3>
	<form method="post" id="avatar-form" enctype="multipart/form-data">
		<figure class="dash-avatar">
				<img src="<?php if($user['avatar'] != '') { echo 'uploads/avatars/'.$user['avatar']; } ?>">
		</figure>
		<div class="dash-avatar-file">
			<?php if(isset($av_success) && $av_success): ?>
				<div class="alert alert-success">L'avatar a été modifié avec succès</div>
			<?php elseif(isset($av_errors) && count($av_errors) > 0): ?>
				<div class="alert alert-danger"><?=implode('<br>', $av_errors); ?></div>
			<?php endif; ?>
			<div>
				<label for="avatar">Changer mon avatar</label>
				<input id="avatar" name="avatar" type="file" value="Changer d'avatar">
			</div>
		</div>
	</form>

	<h3>Modifier mon profil</h3>
	<form method="post" id="user-infos-form">
		<input type="hidden" name="action" value="user-infos-form">
		<div class="dash-pseudo">
			<!-- <label for="email">Email : </label><input type="text" name="email" value="<?= $user['email'] ?? ''; ?>" disabled>	 -->
			<label for="username">Pseudo : </label><input type="text" name="username" value="<?= $user['username'] ?? ''; ?>">	
			<label for="firstname">Prénom : </label><input type="text" name="firstname" value="<?= $user['firstname'] ?? ''; ?>">	
			<label for="name">Nom : </label><input type="text" name="name" value="<?= $user['name'] ?? ''; ?>">	
		</div>
		<div class="dash-name">
		</div>
	</form>

	<h3>Réinitialiser mon mot de passe</h3>
	<form method="post" id="user-pwd-form">
		<?php if(isset($pwd_success) && $pwd_success): ?>
			<div class="alert alert-success">Le mot de passe a été modifié avec succès</div>
		<?php elseif(isset($pwd_errors) && count($pwd_errors) > 0): ?>
			<div class="alert alert-danger"><?=implode('<br>', $pwd_errors); ?></div>
		<?php endif; ?>
		<input type="hidden" name="action" value="user-pwd-form">
		<div>
			<label for="pwd">Mot de passe actuel : </label>
			<input id="pwd" name="pwd" type="password">
		</div>
		<div>
			<label for="new_pwd">Nouveau mot de passe : </label>
			<input id="new_pwd" name="new_pwd" type="password">
		</div>
		<div>
			<label for="new_pwd_confirm">Confirmation du nouveau mot de passe : </label>
			<input id="new_pwd_confirm" name="new_pwd_confirm" type="password">
		</div>
		<div>
			<input type="submit" class="btn btn-primary" value="Réinitialiser le mot de passe">
		</div>				
	</form>

	<!-- <h3>Confidentialité</h3>
	<form method="post" id="check-form">
		<input type="hidden" name="action" value="check-form">
		<div>
			<label for="show_name">Afficher mon nom en ligne</label>
			<input id="show_name" name="show_name" type="checkbox">
		</div>
		<div>
			<label for="show_online">Afficher ma présence en ligne</label>
			<input id="show_online" name="show_online" type="checkbox">
		</div>
	</form> -->

	<!-- <h3>Style</h3>
	<form method="post" id='color-form'>
		<input type="hidden" name="action" value="color-form">
		<div>
			<label for="color_theme">Couleur du thème</label>
			<input id="color_theme" name="color_theme" type="color">
		</div>
	</form> -->
</div>

<script>
	
	$(document).ready(function() {
		// $('body:before').css('background-color', '#c0c');
	
		$('input#avatar').change(function() {
			$(this).closest('form#avatar-form').trigger('submit');
		});

		$('#avatar-form').submit(function() {
			// alert('submitted');
		});


		$('#user-pwd-form input[type="submit"]').click(function() {
			console.log('clicked');
		});


		// alert('test');


		$('#user-infos-form input').on({

			focus: function(e) {
				$(this).css('box-shadow', 'none');
			},

			change: function(e) {
				$(this).css('box-shadow', '0 0 10px lime');
				// $(this).animate({ box-shadow: '0 0 10px red'}, 5000);
			}

		});

		// $('#user-pwd-form').submit(function(e) {

		// 	e.preventDefault();

		// 	console.log('submitted');

		// 	$.ajax({
		// 		url: 'php/reset_pwd.php',
		// 		method: 'POST',
		// 		data: $(this).serialize(),

		// 		success: function(result) {
		// 			console.log(result);
		// 		},
		// 		error: function() {
		// 			console.log('ajax error');
		// 		}
		// 	});
		// });
	});

</script>
