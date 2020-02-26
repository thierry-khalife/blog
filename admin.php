<?php

session_start();

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
            <title>Blog - Accueil</title>
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>

<?php

include("header.php");

if(isset($_SESSION['login']) && $_SESSION['droits'] == 1337)
{
    $nbArticles = 0;
    while($nbArticles != $countArticles)
    {   
        $idArticle = $resultatArticles[$nbArticles][0];
        echo "".$resultatArticles[$nbArticles][5]." Modifier"; ?>

        <form method="post" action="">
            <input type="submit" name="supprimerArticle<?php echo $idArticle; ?>" value="Supprimer">
        </form>

        <?php
        
        if(isset($_POST["supprimerArticle$idArticle"]))
        {
            $deleteArticle ="DELETE FROM articles WHERE id = '".$idArticle."'";
            $queryDeletedArticle = mysqli_query($connexion,$deleteArticle);
            header('Location:admin.php');
        }
        $nbArticles++;
    }

    $nbCate = 0;
    while($nbCate != $countCateNb)
    {
        $idCate = $resultatCateNb[$nbCate][0];
        $nomCate = $resultatCateNb[$nbCate][1];
        ?>
        
        <form method="post" action="">
            <input type="text" name="cateModifier" placeholder="<?php echo "".$resultatCateNb[$nbCate][1]."" ?> ">
            <input type="submit" name="envoyerCateModif<?php echo $idCate; ?>" value="Modifier">
        </form>

        <form method="post" action="">
            <input type="submit" name="supprimerCate<?php echo $idCate; ?>" value="Supprimer">
        </form>

        <?php

        $nbCate++;
    }
    if(isset($_POST['envoyerCateModif']))
    {
        $updateCatePost = $_POST['cateModifier'];
        $updateCate ="UPDATE categories SET nom = '".$updateCatePost."' WHERE nom='".$nomCate."'";
        $queryUpdateCate =mysqli_query($connexion,$updateCate);
    }

    if(isset($_POST["supprimerCate$idCate"]))
        {
            $deleteCate ="DELETE FROM categories WHERE id = '".$idCate."'";
            $queryDeletedCate = mysqli_query($connexion,$deleteCate);
            header('Location:admin.php');
        }

    if(isset($_POST['envoyerCategorie']) && strlen($_POST['ajoutCategorie']) != 0)
    {
        $cate = $_POST['ajoutCategorie'];
        $requeteCate = "INSERT INTO categories (nom) VALUES('".$cate."')";
        $queryCate = mysqli_query($connexion,$requeteCate);
        header('Location:admin.php');
    }

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
                header('Location:admin.php');
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
                header('Location:admin.php');
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
                header('Location:admin.php');
            }
            $nbUsers++;
        }
    }


?>
<br>
<form method="post" action="">
    <label>Ajout d'une catégorie<br></label>
        <input type="text" name="ajoutCategorie">
        <input type="submit" name="envoyerCategorie">
</form>
<br>
<form method="post" action="">
    <label>Changer les droits d'un utilisateur en administrateur<br></label>
        <input type="text" name="droitNameAdmin">
        <input type="submit" name="envoyerDroitAdmin">
</form>
<br>
<form method="post" action="">
    <label>Changer les droits d'un utilisateur en modérateur<br></label>
        <input type="text" name="droitNameModo">
        <input type="submit" name="envoyerDroitModo">
</form>
<br>
<form method="post" action="">
    <label>Rétrograder un utilisateur en membre<br></label>
        <input type="text" name="droitNameMembre">
        <input type="submit" name="envoyerDroitMembre">
</form>

<?php 
} 
?>
