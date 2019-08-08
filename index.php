<?php
session_start();

require_once 'includes/connexion.php';
require_once 'includes/fonctions.php';

// Choix de la page

if(!empty($_GET['page']) && is_file('pages/'.$_GET['page'].'.php'))
{
    $page = $_GET['page'];
}
else { $page = "accueil"; }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= ucfirst($page) ?></title>
    
    <link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div>
        <?php require 'includes/header.php'; ?>

        <main>
            <?php require 'pages/'.$page.'.php'; ?>
        </main>
    </div>

    <?php require 'includes/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="js/tchat.js"></script>

</body>
</html>