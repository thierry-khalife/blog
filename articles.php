<?php
session_start();
$connexion = mysqli_connect("localhost", "root", "", "blog");

if ( isset($_GET["start"]) ) {
    $start = $_GET["start"];
    if ( isset($_GET["categorie"]) ) {
        $categorie = $_GET["categorie"];
        $requeterecuparticles = "SELECT articles.id, articles.article, articles.id_utilisateur, articles.id_categorie, articles.date, articles.titre, articles.img, utilisateurs.login, utilisateurs.id_droits FROM articles INNER JOIN utilisateurs ON utilisateurs.id = id_utilisateur WHERE id_categorie = $categorie ORDER BY date DESC LIMIT 5 OFFSET $start";
        $requetecount = "SELECT COUNT(*) FROM articles WHERE id_categorie = $categorie";
    }
    else {
        $requeterecuparticles = "SELECT articles.id, articles.article, articles.id_utilisateur, articles.id_categorie, articles.date, articles.titre, articles.img, utilisateurs.login, utilisateurs.id_droits FROM articles INNER JOIN utilisateurs ON utilisateurs.id = id_utilisateur ORDER BY date DESC LIMIT 5 OFFSET $start";
        $requetecount = "SELECT COUNT(*) FROM articles";
    }
    $querycount = mysqli_query($connexion, $requetecount);
    $resultatcount = mysqli_fetch_all($querycount);
    $resultatcount2 = ceil($resultatcount[0][0] / 5);
    // var_dump($resultatcount);
    $queryrecuparticles = mysqli_query($connexion, $requeterecuparticles);
    $resultatrecuparticles = mysqli_fetch_all($queryrecuparticles);

    // var_dump($resultatrecuparticles);
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
    <main class="mainarticles">
    <?php
    if ( isset ($_GET["start"]) ) {
        foreach( $resultatrecuparticles as $values) {
            $date = date("d-m-Y", strtotime($values[4]));
        ?>
            <section class="carticles">
                <article class="imgarticles">
                    <img class="imgsize" src="<?php echo $values[6]; ?>" alt="<?php echo $values[5]; ?>" />
                </article>
                <article class="titrearticles">
                    <?php echo $values[5]; ?>
                </article>
                <article class="descarticles">
                    <?php echo nl2br($values[1]); ?>
                </article>
                <article class="basarticles">
                    <article class="basleftarticles">
                        <p>Créé le <img class="iconarticles" src="img/icondate.png"><?php echo $date;?> par <img class="iconarticles" src="img/iconuser.png"><?php echo $values[7];?></p>
                    </article>
                    <article class="basrightarticles">
                        <a href="article.php?idarticle=<?php echo $values[0]; ?>">Voir plus</a>
                    </article>
                </article>
            </section>
        <?php
        }
        ?>
        <article class="btnpages">
        <?php
        $n = 1;
        $j = 0;
        while ( $n <= $resultatcount2 ) {
            if ( isset($_GET["categorie"]) ) {
            ?>
                <a href="articles.php?start=<?php echo $j; ?>&categorie=<?php echo $categorie; ?>"><?php echo $n; ?></a>
            <?php
            }
            else {
            ?>
                <a href="articles.php?start=<?php echo $j; ?>"><?php echo $n; ?></a>
            <?php
            }
            $n++;
            $j += 5;
        }
    }
    else {
        echo "<span class=\"red center\">Erreur 404</span>";
    }
        ?>
            </article>