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
<main class="mainindex">
    <section class="mainarticles">
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
        <article class="btnbottom">
        <a href="articles.php?start=0">Plus d'articles</a>
        </article>
    </section>
    <section class="indexright">
        <article class="profilepart">
            <article class="profilepartimg"></article>
            <h1>Qui suis-je ?</h1>
            <p>Je m'appelle John et je suis passionné par les voyages. A l'âge de 23 ans je suis partie en tour du monde sur un coup de tête, et c'est à ce moment-là que j'ai créé ce blog voyage.<br /><br />Il regroupe de nombreux conseils aux voyageurs et des récits de voyage inspirants, agrémentés de nombreuses photos.<br /><br />Le but, t'aider dans tes voyages et t'inspirer au quotidien !</p>
        </article>
        <article class="categoriepart">
            <h1>Catégories</h1>
            <ul>
            <?php
            $requeterecupcategories = "SELECT nom FROM categories";
            $queryrecupcategories = mysqli_query($cnx, $requeterecupcategories);
            $resultatrecupcategories = mysqli_fetch_all($queryrecupcategories);
            $i = 1;
            foreach ( $resultatrecupcategories as $values ) {
                ?>
                <li><span>></span> <a href="articles?start=0&categorie=<?php echo $i; ?>"><?php echo $values[0]; ?></a></li>
                <?php
                $i++;
            }
            ?>
            </ul>
        </article>
    </section>
</main>

<?php
    include("footer.php");
    mysqli_close($cnx);
?>

</body>
</html>