<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("LOCATION:index.php");
}

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
}
require '../connexion.php';
$req = $bdd->prepare('SELECT * FROM jeuxvideos WHERE id = ?');
$req->execute([$id]);
if (!$don = $req->fetch())
{
    $req->closeCusro();
    header("LOCATION:games.php");
}
$req->closeCursor();

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
            // Ici je traite mon image uploadé
            $dossier = '../images/';
            $image = basename($_FILES['file']['name']);
            $imageSize = filesize($_FILES['file']['tmp_name']);
            $extensions = ['.jpg', '.jpeg', '.png'];
            $imageExtension = strrchr($_FILES['file']['name'], '.');
            $tailleMax = 2000000;

            // Test de l'extension du fichier
            if (!in_array($imageExtension, $extensions))
            {
                $fileError = 'wrong-extension';
            }

            // Test de la taille de l'image
            if ($imageSize > $tailleMax)
            {
                $fileError = 'wrong-size';
            }

            if (!isset($fileError))
            {
                // Formatage du nom de fichier envoyé
                $image = strtr($image,
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
                );

                // remplacement des caractères spéciaux
                $image = preg_replace('/([^.a-z0-9]+)/i', '-', $image);

                // Traitement des fichiers doublons
                $imagecpt = rand() . $image;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $imagecpt))
                {
                    unlink("../images/".$don['image']);
                    $update = $bdd->prepare('UPDATE jeuxvideos SET image = :img, name = :name, description = :desc, prix = :prix, release_date = :date, editeur = :editeur WHERE id = :id');
                    $update->execute([
                        'name' => $nom,
                        'desc' => $desc,
                        'prix' => $prix,
                        'date' => $date,
                        'editeur' => $editeur,
                        'id' => $id,
                        'img' => $imagecpt
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


                };
            } else {
                header("LOCATION:modify.php?id=$id&update=error");
            }
        }
    }

} else {
    $error = 1;
    header('LOCATION:modify.php?error=' . $error . '&id=' . $id);
}