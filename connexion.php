<?php

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=ludotheque;charset=utf8','root','root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (Exception $e) {
        die ('Error : ' . $e->getMessage());
    }

?>