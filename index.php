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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
        <?php require 'includes/header.php'; ?>
        <?php require 'includes/nav.php'; ?>

        <main>
            <?php require 'pages/'.$page.'.php'; ?>
        </main>
    </div>

    <?php require 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</body>
</html>