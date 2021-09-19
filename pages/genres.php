<?php


    $req = $bdd->prepare('SELECT jeuxvideos.name as Nom, description, editeur, image FROM jeuxvideos INNER JOIN genres_jeux ON jeuxvideos.id = genres_jeux.id_jeux INNER JOIN genres ON genres_jeux.id_genre = genres.id WHERE genres.id = ?');
    $req->execute([$id]);

    $count = $req->rowCount();

    while ($don = $req->fetch())
    {
        ?>
        <div class="game">
            <img src="images/<?= $don['image'] ?>" alt="">
            <div class="infos">
                <h2><?= $don['Nom'] ?></h2>
                <p><?= $don['description'] ?></p>
            </div>
        </div>

        <?php
    }

    if ($count == 0)
    {
       echo '<p class="error">Pas d\'article pour ce genre de jeu</p>';
    }



?>


