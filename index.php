<?php

session_start();

if (isset($_GET["deco"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}

$cnx = mysqli_connect("localhost", "root", "", "blog");
$requete = "SELECT * FROM articles ORDER BY id DESC LIMIT 3";
$query = mysqli_query($cnx, $requete);
$resultat = mysqli_fetch_all($query, MYSQLI_ASSOC);
$size = count($resultat);

var_dump($resultat);

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

<main class="mainarticles">
  
    <?php
   
    $i = 0;
    while ($i < $size) {
    ?>
    <section class="carticles">
    <article class="imgarticles">
    <img class="imgsize" src="<?php echo $resultat[$i]['img']; ?>" alt="<?php echo $resultat[$i]['titre']; ?>" />
    </article>
    <?php
       $iduser = $resultat[$i]['id_utilisateur'];
       $requeteuser = "SELECT login FROM utilisateurs WHERE id = $iduser";
       $queryuser = mysqli_query($cnx, $requeteuser);
       $resultatuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);
       ?>
       <article class="titrearticles">
                    <?php echo $resultat[$i]['titre']; ?>
       </article>
       
       <article class="descarticles">
                    <?php echo $resultat[$i]['article']; ?>
       </article>
       <article class="basarticles">
                    <article class="basleftarticles">
                        <p>Créé le <img class="iconarticles" src="img/icondate.png"><?php echo $resultat[$i]['date'];?> par <img class="iconarticles" src="img/iconuser.png"><?php echo $resultatuser[0]['login'];?></p>
                    </article>
                    <article class="basrightarticles">
                        <a href="article.php?idarticle=<?php echo $resultat[$i]['id']; ?>">Voir plus</a>
                    </article>
                </article>
          </section>
       <?php 
       $i++;
    }
    
    ?>

<a href="articles.php?start=0">Plus d'Articles</a>

</main>

<?php
    include("footer.php");
    mysqli_close($cnx);

?>

</body>
</html>