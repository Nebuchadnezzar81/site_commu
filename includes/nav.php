<ul class="nav justify-content-center">

	<?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>

	<li class="m-2 badge badge-success text-wrap">Bonjour <?= $_SESSION['username']; ?></li>

	<li class="nav-item"><a class="nav-link" href="index.php?page=goodbye"><button type="button" class="btn btn-danger">Quitter</button></a></li>
	<li class="nav-item"><a class="nav-link" href="index.php?page=account"><button type="button" class="btn btn-primary">Mon compte</button></a></li>
	<li class="nav-item"><a class="nav-link" href="index.php?page=dashboard"><button type="button" class="btn btn-primary">Dashboard</button></a></li>
	<li class="m-2"> | </li>

	<?php else: ?>

	<li class="nav-item"><a class="nav-link" href="index.php?page=inscription">Inscription</a></li>
	<li class="nav-item"><a class="nav-link" href="index.php?page=login"><button type="button" class="btn">Connexion</button></a></li>

	<?php endif; ?>

	<li class="nav-item"><a class="nav-link" href="index.php?page=contact"><button type="button" class="btn">Contact</button></a></li>
</ul>