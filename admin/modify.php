<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
}
if (isset($_GET['id']) && !empty($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
}else{
    header("LOCATION:index.php");
}

require '../connexion.php';
$req = $bdd->prepare('SELECT * FROM jeuxvideos WHERE id = ?');
$req->execute([$id]);

if (isset($_GET['error']))
{
    $_GET['error'] = 1 ? $error = 'Veuillez entrer le nom' : null;
}
if (isset($_GET['success']))
{
    $update = 'Votre article a bien été modifié';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php if (isset($error)) echo '<p class="alert alert-danger">'.$error.'</p>' ?>
    <?php if (isset($update)) echo '<p class="alert alert-success">'.$update.'</p>' ?>
    <form action="treatmentModify.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <?php
        if ($don = $req->fetch()) :?>
            <div class="form-group mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= $don['name'] ?>">
            </div>
            <div class="form-group mb-3">
                <label for="desc" class="form-label">Description</label>
                <textarea id="desc" class="form-control" name="desc"><?= $don['description'] ?></textarea>
            </div>
            <div class="form-group mb-3">
                <p>Image actuelle :</p>
                <img src="../images/<?= $don['image'] ?>" alt="<?= $don['name'] ?>" width="180">
            </div>
            <div class="form-group mb-3">
                <label for="file" class="form-label">Changer d'image</label>
                <input class="form-control" type="file" name="file" id="file">
            </div>
            <div class="form-group mb-3">
                <label for="prix" class="form-label">Prix :</label>
                <input class="form-control" type="text" name="prix" id="prix" value="<?= $don['prix'] ?>">
            </div>
            <div class="form-group mb-3">
                <label for="date" class="form-label">Date de sortie :</label>
                <input class="form-control" type="date" name="date" id="date" value="<?= $don['release_date'] ?>">
            </div>
            <div class="form-group mb-3">
               <p>Genres :</p>
                <?php
                $genres = $bdd->prepare('SELECT * FROM genres_jeux gj RIGHT JOIN genres g on gj.id_genre = g.id AND gj.id_jeux = ? ORDER BY name');
                $genres->execute([$id]);
                while ($donGenres = $genres->fetch())
                {
                    if ($donGenres['id_jeux'] == $id)
                    {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" name="genres[]" value="'.$donGenres['id_genre'].'" checked>';
                        echo '<label class="form-check-label">'.$donGenres['name'].'</label>';
                        echo '</div>';
                    } else {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" name="genres[]" value="'.$donGenres['id_genre'].'">';
                        echo '<label class="form-check-label">'.$donGenres['name'].'</label>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="form-group mb-3">
                <label for="editeur" class="form-label">Editeur :</label>
                <input class="form-control" type="text" name="editeur" id="editeur" value="<?= $don['editeur'] ?>">
            </div>
            <div class="form-group mb-3">
                <input type="submit" class="btn btn-success" value="Modifier">
                <a class="btn btn-warning" href="games.php">Retour</a>
            </div>
        <?php endif;
        $req->closeCursor();
        ?>
    </form>
</div>


</body>
</html>
