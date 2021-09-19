<?php

    require 'connexion.php';

    if (isset($_GET['action'])) {
        $pages = [
            'home' => 'home.php',
            'genres' => 'genres.php',
        ];

        if (array_key_exists($_GET['action'], $pages)) {

            if ($_GET['action'] == 'genres')
            {

                if (isset($_GET['id']) && !empty($_GET['id']))
                {
                    $id = htmlspecialchars($_GET['id']);
                    $req = $bdd->prepare('SELECT * FROM genres WHERE id = ?');
                    $req->execute([$id]);
                    if ($don = $req->fetch())
                    {
                        $action = $pages['genres'];

                    } else {
                        $action = '404.php';
                    }
                    $req->closeCursor();
                } else {
                    $action = '404.php';
                }
            } else {
                $action = $pages[$_GET['action']];
            }

        } else {
            $action = '404.php';
        }
    } else {
        $action = 'home.php';
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Ludothèque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div id="logo">Ludothèque</div>
    <form action="">
        <label for="search">Rechercher :</label>
        <input type="text" name="search" id="search">
    </form>
    <nav>
        <ul>
            <li><a href="index.php?action=home">Home</a></li>
            <li><a href="">Genres</a>
                <ul>
                    <?php
                        $req = $bdd->query('SELECT * FROM genres');
                        while ($don = $req->fetch()) {
                            $count = $bdd->prepare('
                                                SELECT COUNT(*) as numb FROM jeuxvideos
                                                INNER JOIN genres_jeux gj on jeuxvideos.id = gj.id_jeux
                                                INNER JOIN genres g on gj.id_genre = g.id
                                                WHERE g.name = ?');
                            $count -> execute([$don['name']]);
                            $data = $count->fetch();


                            echo '<li><a href="index.php?action=genres&id=' . $don['id'] . '">' . $don['name'] . ' ' .'<i>('.$data['numb'].')</i></a></li>';
                        }
                        $req->closeCursor();
                    ?>
                </ul>
            </li>
        </ul>
    </nav>
</header>


<main>
    <?php include 'pages/' . $action ?>
</main>

<footer>

</footer>
</body>
</html>