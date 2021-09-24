<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
}

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
}

if (isset($_POST['nom']) && !empty($_POST['nom'])) {
    require '../connexion.php';
    $nom = $_POST['nom'];
    if (isset($_POST['desc'])) {
        $desc = $_POST['desc'];
    }
    if (isset($_POST['prix'])) {
        $prix = $_POST['prix'];
    }
    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    }
    if (isset($_POST['editeur'])) {
        $editeur = $_POST['editeur'];
    }
    if (isset($_POST['genres'])) {
        $genres = $_POST['genres'];
    }
    if (isset($_FILES['file'])) {
        // Si mon input files est vide je modifie tout sauf l'image
        if (empty($_FILES['file']['tmp_name'])) {
            $update = $bdd->prepare('UPDATE jeuxvideos SET name = :name, description = :desc, prix = :prix, release_date = :date, editeur = :editeur WHERE id = :id');
            $update->execute([
                'name' => $nom,
                'desc' => $desc,
                'prix' => $prix,
                'date' => $date,
                'editeur' => $editeur,
                'id' => $id
            ]);
            $update->closeCursor();
            // Je supprime tous les genres_jeux du jeux
            // Ensuite j'ajoute les genres que j'ai coché

            $deleteGenres = $bdd->prepare('DELETE FROM genres_jeux WHERE id_jeux = ?');
            $deleteGenres->execute([$id]);
            $deleteGenres->closeCursor();

            foreach($genres as $gen)
            {
                $insert = $bdd->prepare('INSERT INTO genres_jeux (id_genre, id_jeux) VALUES(:genre, :jeux)');
                $insert->execute([
                    "genre" => $gen,
                    "jeux" => $id
                ]);
            }



            header('LOCATION:modify.php?id=' . $id . '&success=true');
        } else {

        }
    }

} else {
    $error = 1;
    header('LOCATION:modify.php?error=' . $error . '&id=' . $id);
}