<?php
session_start();

// Ici je vérifie que tous mes champs sont remplis

// Vérification du login de session
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
    exit();
}
require '../connexion.php';

// Vérification du nom
if (isset($_POST['name']) && !empty($_POST['name'])) {

    $nameVerify = $bdd->prepare('SELECT * FROM jeuxvideos WHERE name = ? ');
    $nameVerify->execute([$_POST['name']]);
    if ($don = $nameVerify->fetch()) {
        header("LOCATION:addGame.php?error=name&name=" . $don['name']);
        $nameVerify->closeCursor();
        exit();
    } else {
        $name = $_POST['name'];
        $nameVerify->closeCursor();
    }
} else {
    $error = 1;
    header("LOCATION:addGame.php?error=" . $error);
    exit();

}

if (isset($_POST['description']) && !empty($_POST['description'])) {
    $description = $_POST['description'];
} else {
    $error = 2;
    header("LOCATION:addGame.php?error=" . $error);
    exit();
}

if (isset($_POST['prix']) && !empty($_POST['prix'])) {
    $prix = $_POST['prix'];
} else {
    $error = 3;
    header("LOCATION:addGame.php?error=" . $error);
    exit();
}

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $date = $_POST['date'];
} else {
    $error = 4;
    header("LOCATION:addGame.php?error=" . $error);
    exit();
}

if (isset($_POST['editeur']) && !empty($_POST['editeur'])) {
    $editeur = $_POST['editeur'];
} else {
    $error = 5;
    header("LOCATION:addGame.php?error=" . $error);
    exit();
}


if (!isset($_FILES['file']['tmp_name']) && empty($_FILES['file']['tmp_name'])) {
    $error = 6;
    header("LOCATION:addGame.php?error=" . $error);
    exit();
}

if (isset($_POST['genres']) && !empty($_POST['genres'])) {
    $genres = $_POST['genres'];
} else {
    $error = 7;
    header("LOCATION:addGame.php?error=" . $error);
}

// Si tous mes champs sont correctement remplis je peux poursuivre
if (!isset($error)) {


    // Traitement de mon image uploadé
    $dossier = '../images/';
    $image = basename($_FILES['file']['name']);
    $size = filesize($_FILES['file']['tmp_name']);
    $extensions = ['.jpg', '.jpeg', '.png'];
    $imageExtension = strrchr($_FILES['file']['name'], '.');
    $maxSize = 2000000;

    // Test de l'extension de l'image
    if (!in_array($imageExtension, $extensions)) {
        $fileError = "wrong-extension";
    }
    // Test du poids de l'image
    if ($size > $maxSize) {
        $fileError = "wrong-size";
    }

    // S'il n'y a pas d'erreur dans le fichier alors on poursuit
    if (!isset($fileError)) {
        // Formatage du nom de fichier envoyé
        $image = strtr($image,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
        );

        // remplacement des caractères spéciaux
        $image = preg_replace('/([^.a-z0-9]+)/i', '-', $image);

        // Traitement des fichiers doublons
        $imagecpt = rand() . $image;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $imagecpt)) {
            $insert = $bdd->prepare('INSERT INTO jeuxvideos (name, description, image, prix, release_date, editeur) VALUES (:name, :description, :image, :prix, :date, :editeur)');
            $insert->execute([
                'name' => $name,
                'description' => $description,
                'image' => $imagecpt,
                'prix' => $prix,
                'date' => $date,
                'editeur' => $editeur
            ]);
            $insert->closeCursor();


            // Je récupère l'id du jeu
            $idJeu = $bdd->prepare('SELECT id FROM jeuxvideos WHERE name = ?');
            $idJeu->execute([$name]);

            if ($don = $idJeu->fetch()) {

                // J'ajoute mes genres sur la table genres_jeux
                foreach ($genres as $gen) {
                    $insertGen = $bdd->prepare('INSERT INTO genres_jeux (id_genre, id_jeux) VALUES(:genre, :jeu)');
                    $insertGen->execute([
                        'genre' => $gen,
                        'jeu' => $don['id']
                    ]);
                    $insertGen->closeCursor();
                }
            }
            $idJeu->closeCursor();

            if ($imageExtension == ".png") {
                header("LOCATION:redimpng.php?image=".$imagecpt);
            } else {
                header("LOCATION:redim.php?image=".$imagecpt);
            }

        } else {
            header("LOCATION:addGame.php?error=file");
        }
    }


}