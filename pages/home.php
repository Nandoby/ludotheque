<h2 class="home_title">Listing de mes jeux</h2>

<ul>
    <?php
        $req = $bdd->query('SELECT * FROM jeuxvideos');
        while ($don = $req->fetch())
        {
            echo '<li class="game_list"><a href="game-'.$don['id'].'">'.$don['name'].'</a></li>';
        }
    ?>
</ul>