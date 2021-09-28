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
    }
    $id = htmlspecialchars($_GET['id']);

    if (unlink('../images/' . $don['image']) && unlink('../images/mini_' . $don['image'])) {
        $deleteGen = $bdd->prepare('DELETE FROM genres_jeux WHERE id_jeux = ?');
        $deleteGen->execute([$id]);

        $delete = $bdd->prepare('DELETE FROM jeuxvideos WHERE id = ?');
        $delete->execute([$id]);
        $delete->closeCursor();



        header("LOCATION:games.php?delete=ok");
    }
}





