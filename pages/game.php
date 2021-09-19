<?php
    if (isset($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
    } else {
        $action = '404.php';
    }

?>