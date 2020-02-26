<?php

session_start();
ob_start();

$phraseok = "<span class=\"green center\">Modification effectuée avec succès.</span>";

if (isset($_GET["deco"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}

$connexion = mysqli_connect("localhost", "root", "", "blog");

$requeteArticles = "SELECT * FROM articles";
$queryArticles = mysqli_query($connexion,$requeteArticles);
$resultatArticles = mysqli_fetch_all($queryArticles);
$countArticles = count($resultatArticles);

$requeteCateNb = "SELECT * FROM categories";
$queryCateNb = mysqli_query($connexion,$requeteCateNb);
$resultatCateNb = mysqli_fetch_all($queryCateNb);
$countCateNb = count($resultatCateNb);

$requeteUsers = "SELECT * FROM utilisateurs";
$queryUsers = mysqli_query($connexion,$requeteUsers);
$resultatUsers = mysqli_fetch_all($queryUsers);
$countUsers = count($resultatUsers);

?>

<!doctype html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <title>Blog - Administration</title>
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
<?php

include("header.php");

if(isset($_SESSION['login']) && $_SESSION['droits'] == 1337)
{
    if ( isset($_GET["phrase"]) ) {
        echo $phraseok;
    }
    $nbArticles = 0;
    ?>
    <h1 class="titleadmin">Articles</h1>
    <section class="modif">
    <?php
    while($nbArticles != $countArticles)
    {   
        $idArticle = $resultatArticles[$nbArticles][0];
    ?>
        <article>
        <form method="post" action="">
            <fieldset>
                <legend><?php echo "".$resultatArticles[$nbArticles][5].""; ?></legend>
                <section class="cform">
                    <input type="submit" name="modifArticle<?php echo $idArticle; ?>" value="Modifier">
        </form>

        <form method="post" action="">
            <input type="submit" name="supprimerArticle<?php echo $idArticle; ?>" value="Supprimer">
                </section>
            </fieldset>
        </form>
        </article>

        <?php
        
        if(isset($_POST["modifArticle$idArticle"]))
        {
            header('Location:article.php?idarticle='.$idArticle.'');
        }

        if(isset($_POST["supprimerArticle$idArticle"]))
        {
            $deleteArticle ="DELETE FROM articles WHERE id = '".$idArticle."'";
            $queryDeletedArticle = mysqli_query($connexion,$deleteArticle);
            header('Location:admin.php');
        }
        $nbArticles++;
    }
    ?>
    </section>
    <h1 class="titleadmin">Catégories</h1>
    <section class="modif">
    <?php
    $nbCate = 0;
    while($nbCate != $countCateNb)
    {
        $idCate = $resultatCateNb[$nbCate][0];
        $nomCate = $resultatCateNb[$nbCate][1];
        if(isset($_POST["envoyerCateModif$idCate"]) && strlen($_POST["cateModifier$idCate"]) != 0)
        {
            $updateCatePost = $_POST["cateModifier$idCate"];
            $updateCate ="UPDATE categories SET nom = '".$updateCatePost."' WHERE nom='".$nomCate."'";
            $queryUpdateCate =mysqli_query($connexion,$updateCate);
            header('Location:admin.php?phrase=ok');
        }
        
        if(isset($_POST["supprimerCate$idCate"]))
            {
                $deleteCate ="DELETE FROM categories WHERE id = '".$idCate."'";
                $queryDeletedCate = mysqli_query($connexion,$deleteCate);
                header('Location:admin.php?phrase=ok');
            }
        ?>
        <article>
        <form method="post" action="">
            <fieldset>
                <legend><?php echo "".$resultatCateNb[$nbCate][1]."" ?></legend>
                <section class="cform">
                <input type="text" name="cateModifier<?php echo $idCate; ?>" placeholder="<?php echo "".$resultatCateNb[$nbCate][1]."" ?> ">
                <input type="submit" name="envoyerCateModif<?php echo $idCate; ?>" value="Modifier">
        </form>

            <form method="post" action="">
                <input type="submit" name="supprimerCate<?php echo $idCate; ?>" value="Supprimer">
                </section>
            </fieldset>
        </form>
        </article>
<?php
        $nbCate++;
    }
?>
<br>
<form method="post" action="">
    <fieldset>
        <legend>Ajout d'une catégorie</legend>
        <section class="cform">
                <input type="text" name="ajoutCategorie">
                <input type="submit" name="envoyerCategorie">
        </section>
    </fieldset>
</form>
<?php
    if(isset($_POST['envoyerCategorie']) && strlen($_POST['ajoutCategorie']) != 0)
    {
        $cate = $_POST['ajoutCategorie'];
        $requeteCate = "INSERT INTO categories (nom) VALUES('".$cate."')";
        $queryCate = mysqli_query($connexion,$requeteCate);
        $phraseok = "<span class=\"green center\">La catégorie a été créé avec succès.</span>";
        header('Location:admin.php?phrase=ok');
    }
    ?>
    </section>
    <?php

    if(isset($_POST['envoyerDroitAdmin']) && strlen($_POST['droitNameAdmin']) != 0)
    {
        $upAdmin = $_POST["droitNameAdmin"];
        $nbUsers = 0;
        while($nbUsers != $countUsers)
        {
            if($resultatUsers[$nbUsers][1] == $upAdmin && $resultatUsers[$nbUsers][4] != 1337)
            {
                $updateDroitAdmin = "UPDATE utilisateurs SET id_droits = 1337 WHERE login = '".$upAdmin."'";
                $queryDroitAdmin = mysqli_query($connexion,$updateDroitAdmin);
                $phraseok = "<span class=\"green center\">L'administrateur a été ajouté avec succès.</span>";
                header('Location:admin.php?phrase=ok');
            }
            $nbUsers++;
        }
    }

    if(isset($_POST['envoyerDroitModo']) && strlen($_POST['droitNameModo']) != 0)
    {
        $upModo = $_POST["droitNameModo"];
        $nbUsers = 0;
        while($nbUsers != $countUsers)
        {
            if($resultatUsers[$nbUsers][1] == $upModo && $resultatUsers[$nbUsers][4] != 42)
            {
                $updateDroitModo = "UPDATE utilisateurs SET id_droits = 42 WHERE login = '".$upModo."'";
                $queryDroitModo = mysqli_query($connexion,$updateDroitModo);
                $phraseok = "<span class=\"green center\">Le modérateur a été ajouté avec succès.</span>";
                header('Location:admin.php?phrase=ok');
            }
            $nbUsers++;
        }
    }

    if(isset($_POST['envoyerDroitMembre']) && strlen($_POST['droitNameMembre']) != 0)
    {
        $upMembre = $_POST["droitNameMembre"];
        $nbUsers = 0;
        while($nbUsers != $countUsers)
        {
            if($resultatUsers[$nbUsers][0] != 1 && $resultatUsers[$nbUsers][1] == $upMembre && $resultatUsers[$nbUsers][4] != 1)
            {
                $updateDroitMembre = "UPDATE utilisateurs SET id_droits = 1 WHERE login = '".$upMembre."'";
                $queryDroitMembre = mysqli_query($connexion,$updateDroitMembre);
                $phraseok = "<span class=\"green center\">Le Membre a été ajouté avec succès.</span>";
                header('Location:admin.php?phrase=ok');
            }
            $nbUsers++;
        }
    }


?>
<br>
<h1 class="titleadmin">Membres</h1>
<section class="modif">
<form method="post" action="">
    <fieldset>
        <section class="cform">
            <legend>Définir un administrateur</legend>
            <input type="text" name="droitNameAdmin">
            <input type="submit" name="envoyerDroitAdmin">
        </section>
    </fieldset>
</form>
<br>
<form method="post" action="">
    <fieldset>
        <section class="cform">
            <legend>Définir un modérateur</legend>
            <input type="text" name="droitNameModo">
            <input type="submit" name="envoyerDroitModo">
        </section>
    </fieldset>
</form>
<br>
<form method="post" action="">
    <fieldset>
        <section class="cform">
            <legend>Rétrograder au rang de membre</legend>
            <input type="text" name="droitNameMembre">
            <input type="submit" name="envoyerDroitMembre">
        </section>
    </fieldset>
</form>
</section>
<?php
}
else {
    echo "<span class=\"red center\">Vous n'avez pas les droits pour accéder à cette page.</span>";
}
?>
</main>
<?php
mysqli_close($connexion);
include("footer.php");
ob_end_flush();
?>
<body>
