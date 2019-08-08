<h1>Accueil</h1>

<?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>
		
			<h2 class="text-center">Bonjour <?= $_SESSION['username']; ?></h2>

			<h2 class="text-center">Vous êtes désormais connecté sur</h2>

		<?php endif; ?>
		
		<svg>
			<symbol id="text">
				<text text-anchor="middle" x="50%" y="70%">WebForceBook</text>
			</symbol>
			<use xlink:href="#text"></use>
		</svg>
	