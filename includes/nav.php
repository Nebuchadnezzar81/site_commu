	<ul class="nav justify-content-center">
	  <li class="nav-item">

	  <?php if (isset($_SESSION['auth'])): ?>
	  		<li class="m-2 badge badge-success text-wrap">Bonjour  <br><?= $_SESSION['prenom']
		  					.' '
		  					.$_SESSION['nom']; ?>					
		  	</li>

		  	<li class="nav-item">
		    <a class="nav-link" href="goodbye.php"><button type="button" class="btn btn-danger">Quitter</button></a>
		  </li>

		  <li class="m-2"> | </li>

	  <?php else: ?>

	  <li class="nav-item">
	    <a class="nav-link" href="formInscription.php"><button type="button" class="btn">Inscription</button></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="formLogin.php"><button type="button" class="btn">Connection</button></a>
	  </li>

	<?php endif; ?>

	<li class="nav-item">
	    <a class="nav-link" href="contact.php"><button type="button" class="btn">Contact</button></a>
	  </li>
	</ul>