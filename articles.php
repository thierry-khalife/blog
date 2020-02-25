<?php
session_start();
$connexion = mysqli_connect("localhost", "root", "", "blog");

if ( isset($_GET["start"]) ) {
    $start = $_GET["start"];
    if ( isset($_GET["categorie"]) ) {
        $categorie = $_GET["categorie"];
        $requeterecuparticles = "SELECT * FROM articles WHERE id_categorie = $categorie LIMIT 5 OFFSET $start";
    }
    else {
        $requeterecuparticles = "SELECT * FROM articles LIMIT 5 OFFSET $start";
    }
    $queryrecuparticles = mysqli_query($connexion, $requeterecuparticles);
    $resultatrecuparticles = mysqli_fetch_all($queryrecuparticles);

    var_dump($resultatrecuparticles);
}

?>

<!DOCTYPE html>

<html>
<head>
    <title>Articles - Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php 
include("header.php");
?>
    <main>
    <?php
        foreach( $resultatrecuparticles as $values) {
            echo $values[1];
        }