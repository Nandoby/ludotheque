<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
}

$source = imagecreatefromjpeg("../images/".$_GET['image']);



// 'getimagesize' retourne un array contenant la largeur [0] et la hauteur [1]
$tailleImageChoisie = getimagesize("../images/".$_GET['image']);

// Je définis la largeur de l'image.

$nouvelleLargeur = 300;


// Je calcule le pourcentage de réduction qui correspond au quotient de l'ancienne largeur par la nouvelle largeur

$reduction = ( ($nouvelleLargeur * 100) / $tailleImageChoisie[0] );



// je détermine la hauteur de la nouvelle image en appliquant le pourcentage de reduction à l'ancienne hauteur

$nouvelleHauteur = ( ($tailleImageChoisie[1] * $reduction) / 100 );

$destination = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur) or die ("Erreur");

// On crée la miniature

imagecopyresampled($destination, $source, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $tailleImageChoisie[0], $tailleImageChoisie[1]);

// On enregistre la miniature sous le nom de "mini_"

$rep_nom = "../images/mini_".$_GET['image'];

imagejpeg($destination,$rep_nom,80);

// redirection

if(isset($_GET['update']))
{
    header("LOCATION:games.php?update=success&id=".$_GET['update']);
} else {
    header("LOCATION:games.php?add=success");
}