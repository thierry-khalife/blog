<?php

session_start();

if (isset($_GET["deco"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}

$cnx = mysqli_connect("localhost", "root", "", "blog");


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Blog - Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
    include("header.php");
?>

<main>
    <?php
    $requete = "SELECT * FROM articles ORDER BY id DESC LIMIT 3";
    $query = mysqli_query($cnx, $requete);
    $resultat = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $size = count($resultat);
    
    $i = 0;
    while ($i < $size) {
       $iduser = $resultat[$i]['id_utilisateur'];
       $requeteuser = "SELECT login FROM utilisateurs WHERE id = $iduser";
       $queryuser = mysqli_query($cnx, $requeteuser);
       $resultatuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);
       echo "Article : <br>";
       echo $resultat[$i]['article'];
       echo "<br> Posté Le <b>".$resultat[$i]['date']."</b> ";
       echo "Par <b>".$resultatuser[0]['login']."</b><br>";
       $i++;
    }
    
    ?>

<a href="articles.php">Page Articles</a>

</main>

<?php
    include("footer.php");
    mysqli_close($cnx);

?>

</body>
</html>