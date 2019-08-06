<?php  

function verifPassword($password) {

		$cptInt = $cptMaj = 0;
		// longueur du mot de passe
		$longueur = strlen($password);
		// une chaîne est aussi un tableau
		for ($i=0; $i <$longueur ; $i++) 
		{ 
			// un nombre ?
			if (is_numeric($password[$i])) $cptInt++;
			// majuscule ?
			else if (strtoupper($password[$i]) == $password[$i])
				$cptMaj++;
		}
			if ($longueur >= 8 AND $cptInt >=1 AND $cptMaj >= 1) 
		{
			return true;
		}
			else return false;
		}

?>