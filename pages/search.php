<h2 class="title_search">Résultats de votre recherche :</h2>

<?php
    if (isset($_POST['search'])) {
        $search = htmlspecialchars($_POST['search']);
    } else {
        $search = "";
    }

    $req = $bdd->prepare('SELECT id, name, description, image, prix, DATE_FORMAT(release_date, "%d / %m / %Y") AS date, editeur FROM jeuxvideos WHERE name LIKE :search OR editeur LIKE :search');
    $req->execute([
        'search' => '%' . $search . '%'
    ]);

    $count = $req->rowCount();

    if ($count <= 0) {
        echo '<p>Aucun résultat ne correspond à votre recherche</p>';
    } else {

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
        <?php endwhile;
    }


?>