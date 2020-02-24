<?php

session_start();
$connexion = mysqli_connect("localhost", "root", "", "blog");

$requeteArticles = "SELECT * FROM articles";
$queryArticles = mysqli_query($connexion,$requeteArticles);
$resultatArticles = mysqli_fetch_all($queryArticles);
$countArticles = count($resultatArticles);

var_dump($resultatArticles);

if(isset($_SESSION['login']) && $_SESSION['droits'] == 1337)
{
    $nbArticles = 0;
    while($nbArticles != $countArticles)
    {
        echo "".$resultatArticles[$nbArticles][5]." Modifier Supprimer <br>";
        $nbArticles++;
    }
}

