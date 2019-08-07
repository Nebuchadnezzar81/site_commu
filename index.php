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
</head>
<body>
    <div>
        <?php require 'includes/header.php'; ?>

        <main>
            <?php require 'pages/'.$page.'.php'; ?>
        </main>
    </div>

    <?php require 'includes/footer.php'; ?>

</body>
</html>