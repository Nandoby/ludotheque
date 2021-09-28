<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Administrations | Gestion des jeux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <a class="btn btn-primary mt-3" href="dashboard.php">Retour au Dashboard</a>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Image</th>
            <th>Prix</th>
            <th>Date de sortie</th>
            <th>Genres</th>
            <th>Editeur</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require '../connexion.php';
        $req = $bdd->query("SELECT *, DATE_FORMAT(release_date, '%d / %m / %Y') AS date FROM jeuxvideos");
        while ($don = $req->fetch()) {
            $genre = $bdd->prepare('SELECT GROUP_CONCAT(genres.name) AS genre, j.name AS jeux FROM genres INNER JOIN genres_jeux gj ON genres.id = gj.id_genre INNER JOIN jeuxvideos j on gj.id_jeux = j.id WHERE j.name = ?');
            $genre->execute([$don['name']]);
            ?>
            <tr>
                <td><?= $don['name'] ?></td>
                <td style="max-width:800px"><?= $don['description'] ?></td>
                <td><img src="../images/<?= $don['image'] ?>" style="width:150px" alt="<?= $don['name'] ?>"></td>
                <td><?= $don['prix'] ?> €</td>
                <td style="min-width:100px"><?= $don['date'] ?></td>
                <td><?php if($donGenre = $genre->fetch()) echo $donGenre['genre'] ?></td>
                <td><?= $don['editeur'] ?></td>
                <td>
                    <a class="btn btn-warning" href="modify.php?id=<?= $don['id'] ?>">Modifier</a>
                    <a class="btn btn-danger" href="delete.php?id=<?= $don['id'] ?>">Supprimer</a>
                </td>
            </tr>
            <?php
            $genre->closeCursor();
        }
        $req->closeCursor();
        ?>
        </tbody>
    </table>
    <a class="btn btn-success" href="addGame.php">Ajouter nouveau</a>
</div>
</body>
</html>
