<?php
    $req = $bdd->prepare('SELECT *, DATE_FORMAT(release_date, "%d / %m / %Y") AS date FROM jeuxvideos WHERE id = ?');
    $req->execute([$id]);
    while ($don = $req->fetch()) :?>
        <div class="game">
            <img src="images/<?= $don['image'] ?>" alt="">
            <div class="infos">
                <h2><?= $don['name'] ?></h2>
                <p><?= $don['description'] ?></p>
                <p><b>Date de sortie :</b> <?= $don['date'] ?></p>
                <p><b>Prix :</b> <?= $don['prix'] ?> €</p>
            </div>
        </div>
        <a class="btn-primary" href="home">Retour</a>
    <?php endwhile;

    $req->closeCursor();
