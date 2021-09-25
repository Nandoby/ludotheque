<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
}

$source = imagecreatefrompng("../images/".$_GET['image']); // La photo est la source



// getimagesize retourne un array contenant la largeur [0] et la longueur [1]
$tailleImageChoisie = getimagesize("../images/".$_GET['image']);

// Je définis la largeur de mon image
$nouvelleLargeur = 300;


// Je calcule le pourcentage de réduction qui correspond au quotient de l'ancienne largeur par la nouvelle.
$reduction = (($nouvelleLargeur * 100)/$tailleImageChoisie[0]);

// Je détermine la hauteur de la nouvelle image en applicant le pourcentage de réduction à l'ancienne hauteur
$nouvelleHauteur = (($tailleImageChoisie[1] * $reduction)/100);

$destination = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur) or die ("Erreur"); // On crée la miniature vide

/* Pour garder la transparence du fichier png */
imagealphablending($destination, false);
imagesavealpha($destination, true);

// On crée la miniature

imagecopyresampled($destination, $source, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $tailleImageChoisie[0], $tailleImageChoisie[1]);

// On enregistre la miniature sous le nom de "mini_"

$rep_nom = "../images/mini_".$_GET['image'];

imagepng($destination,$rep_nom);

// redirection

if(isset($_GET['update']))
{
    header("LOCATION:games.php?update=success&id=".$_GET['update']);
} else {
    header("LOCATION:games.php?add=success");
}