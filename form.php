<?php  

require_once('includes/connexion.php');

$errors = array(); // dans cette variable, je vais stocker mes erreurs
// $maxFileSize = 3 * 1000 * 1000; // Limite à 3 Mo

// Le point d'exclamation devant une condition, veut dire NOT 
// Ici => not empty $_POST d

// les variables superglobales sont définies par défaut dans PHP, elles sont forcément un tableau
if(!empty($_POST)){

  // Nettoie les données reçues du formulaire en supprimant toutes les balises HTML / PHP
  $safe = array_map('strip_tags', $_POST);

  if(strlen($safe['username']) < 1){
    // $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
    $errors[] = 'Votre prénom doit comporter au moins 2 caractères';
  }

  // Vérifie le bon format de mon email
  if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
    $errors[] = 'Votre adresse email est invalide';
  }

  if(strlen($safe['password']) < 7){
    // $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
    $errors[] = 'Votre mot de passe doit comporter au moins 8 caractères';
  }

  if($safe['confirmpassword'] != $safe['password']){
    // $errors[] = '' permet d'ajouter une entrée dans le tableau $errors
    $errors[] = 'Votre mot de passe ne correspond pas';
  }


  // La fonction count() permet de compter les entrées d'un tableau (le nombre de ligne)
  // Ici, je compte le nombre de ligne dans le tableau $errors
  // Si c'est à 0, alors a priori, tout va bien (l'utilisateur a bien rempli tous les champs)
  if(count($errors) === 0){

    // Préparation de la requete
    $request = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');


    // Association des paramètres avec les valeurs
    // Les paramètres permettent de sécuriser les données
    $paramsInsert = [
      ':username'    => $safe['username'],
      ':email'    => $safe['email'],
      ':password'  => password_hash($safe['password'],
      PASSWORD_DEFAULT),
    ];

    // Let's go
    if($request->execute($paramsInsert)){
      $success = true;

      $safe = array_map('strip_tags', $_POST);

    }
  }


}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Compte</title>
<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="css/form.css" type="text/css">
</head>
  <body>

    <div>

      <?php if(isset($success)):?>
        <p style="color:green;">Votre compte vient d'être créer</p>

      <?php elseif (count($errors) > 0): // Si j'ai des erreurs, je les affiche ?>    
        <p style="color:red"><?=implode('<br>', $errors);?></p>
      <?php endif;?>
          <!-- <?php  
        if (isset($_POST['register'])) {
          
          $username = $_POST['username'];
          $email    = $_POST['email'];
          $password = $_POST['password'];

          $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
          $stmtinsert = $pdo->prepare($sql);
          $result = $stmtinsert->execute([$username, $email, $password]);
          if ($result) {
            echo "Votre compte à été créer";
          }else{
            echo "Une erreur est survenue lors de la création de votre compte";
          }
        }
      ?> -->
    </div>

    <div class="body-content">
      <div class="module">

        <h1>Création d'un Compte</h1>

        <form class="form" action="form.php" method="post" enctype="multipart/form-data" autocomplete="off">

          <div class="alert alert-error"></div>

          <input type="text" placeholder="Nom d'utilisateur" name="username" required />

          <input type="email" placeholder="Email" name="email" required />

          <input type="password" placeholder="Mot de passe" name="password" autocomplete="new-password" required />

          <input type="password" placeholder="Confirmer mot de passe" name="confirmpassword" required />

          <!-- <div class="avatar"><label>Choisissez votre avatar: </label><input type="file" name="avatar" accept="image/*" required /></div> -->

          <input type="submit" value="Enregistrer" name="register" class="btn btn-block btn-primary" />

        </form>
      </div>
    </div>

  </body>
</html>

