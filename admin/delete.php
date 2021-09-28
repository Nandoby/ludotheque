<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
    exit();
}

if (isset($_GET['id'])) {
    require '../connexion.php';
    $req = $bdd->prepare('SELECT * FROM jeuxvideos WHERE id = ?');
    $req->execute([$_GET['id']]);

    if (!$don = $req->fetch()) {
        $req->closeCursor();
        header("LOCATION:index.php");
        exit();
    }
    $id = htmlspecialchars($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Suppression de <?= $don['name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <p class="col-6 offset-3 alert alert-warning mt-5">Êtes-vous sûre de vouloir supprimer <strong><?= $don['name'] ?> ?</strong></p>
    </div>
    <div class="row">
        <a class="col-1 offset-5 btn btn-success me-1" href="treatmentDelete.php?id=<?= $don['id'] ?>">Oui</a>
        <a class="col-1 btn btn-danger" href="games.php">Non</a>
    </div>
</div>
</body>
</html>
