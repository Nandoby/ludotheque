<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("LOCATION:index.php");
    }
    if (isset($_GET['deconnexion'])) {
        session_destroy();
        header("LOCATION:index.php");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Administration</a>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="dashboard.php?deconnexion=ok">Déconnexion</a>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <a class="btn btn-primary mt-3" href="games.php">Gestion des jeux</a>
        <a class="btn btn-warning mt-3" href="genres.php">Gestion des genres</a>
        <a class="btn btn-secondary mt-3" href="../index.php" target="_blank">Retour vers le site</a>
    </div>
</body>
</html>