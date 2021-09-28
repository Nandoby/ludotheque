<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) $error = 'Le nom est obligatoire';
    if ($_GET['error'] == 2) $error = 'La description est obligatoire';
    if ($_GET['error'] == 3) $error = 'Le prix est obligatoire';
    if ($_GET['error'] == 4) $error = 'La date est obligatoire';
    if ($_GET['error'] == 5) $error = "L'éditeur est obligatoire";
    if ($_GET['error'] == 6) $error = "Une image est obligatoire";
    if ($_GET['error'] == 7) $error = "Au moins un genre doit être ajouté";
    if ($_GET['error'] == "name" && isset($_GET['name']))  $error = $_GET['name'] . ' existe déjà dans notre base de données';

}

require '../connexion.php';
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration | Ajout d'un jeu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="text-center mt-3">Administration - Ajout d'un jeu</h1>
    <?php if (isset($error)) echo '<p class="alert alert-danger">'.$error.'</p>' ?>
    <form action="treatmentAdd.php" method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label class="form-label" for="name">Nom :</label>
            <input class="form-control" type="text" name="name" id="name">
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="description">Description :</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="file">Ajout d'image</label>
            <input class="form-control" id="file" name="file" type="file">
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="prix">Prix :</label>
            <input class="form-control" id="prix" name="prix" type="text">
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="date">Date de sortie :</label>
            <input class="form-control" id="date" name="date" type="date">
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="editeur">Editeur :</label>
            <input class="form-control" id="editeur" name="editeur" type="text">
        </div>
        <div class="form-group mb-3">

            <?php
            $genres = $bdd->query('SELECT * FROM genres');
            while ($data = $genres->fetch()) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?= $data['id'] ?>" name="genres[]"
                           id="id-<?= $data['id'] ?>">
                    <label for="id-<?= $data['id'] ?>" class="form-check-label"><?= $data['name'] ?></label>
                </div>
            <?php endwhile;
            $genres->closeCursor();
            ?>
        </div>


        <input type="submit" class="btn btn-success mb-3">
        <a href="games.php" class="btn btn-warning mb-3">Retour</a>
    </form>
</div>
</body>
</html>
