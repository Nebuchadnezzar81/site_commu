<?php  

$rq = $pdo->prepare('SELECT avatar FROM users WHERE id = :id');
	 $rq->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
	 $rq->execute();
	 $user = $rq->fetch();

?>


	<div class="jumbotron jumbotron-fluid" style="background: rgba(255,255,255,.5); height: 150px;">

		<ul class="nav justify-content-center" style="margin: -20px;">

			<li class="nav-item"><a class="nav-link" href="index.php"><button type="button" class="btn btn-primary">Acceuil</button></a></li>
			<li class="m-3"> | </li>
			<li class="nav-item"><a class="nav-link" href="index.php?page=contact"><button type="button" class="btn btn-primary">Contact</button></a></li>

		</ul>

		<input type="checkbox" name="" id="box" checked="checked">
	<span class="icon"></span>

	<ul class="menu">
		<?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>

			<li class="m-2 badge badge-success text-wrap">Bonjour <?= $_SESSION['username']; ?></li>
			<figure class="dash-avatar">
				<img src="<?php if($user['avatar'] != '') { echo 'uploads/avatars/'.$user['avatar']; } ?>">
			</figure>


			<li><a href="index.php?page=dashboard">Mon Compte</a></li>
			<li><a href="index.php?page=tchat">Mini-tchat</a></li>
			<li><a href="#">Modifier Identifiants</a></li>
			<li><a href="index.php?page=goodbye">Deconnexion</a></li>
			<li><a href="index.php?page=login">Changer d'utilisateur</a></li>

			<?php else: ?>

			<li><a href="index.php?page=inscription">Inscription</a></li>
			<li><a href="index.php?page=login">Connexion</a></li>

			<?php endif; ?>
	</ul>
	</div>
