<?php

    session_start();
    date_default_timezone_set('Europe/Paris');
    $is10car = false;
    $connexion = mysqli_connect("localhost", "root", "", "blog");

?>
<!DOCTYPE html>

<html>
<head>
    <title>Blog - Créer un article</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
 <?php include("header.php"); ?>
    <main>
    <?php
      $requete = "SELECT * FROM utilisateurs WHERE login ='".$_SESSION['login']."'";
      $query = mysqli_query($connexion, $requete);
      $resultat = mysqli_fetch_all($query);
      $requetecat= "SELECT * FROM categories ORDER BY id ASC";
      $querycat = mysqli_query($connexion, $requetecat);
      $resultatcat = mysqli_fetch_all($querycat, MYSQLI_ASSOC);

    if ( isset($_SESSION['login']) && ($_SESSION['droits'] == 42 || $_SESSION['droits'] == 1337)) {
    ?>
        <form method="post" action="creer-article.php" class="form_site">
            <label>VOTRE ARTICLE</label>
            <textarea name="article" ></textarea><br />
            <label for="categorie"><b>CATEGORIES</b></label>
            <select name="categorie">
             <?php 
                        $i=0;
                        $taille = count($resultatcat);
                        while($i < $taille)
                        {
                           echo"<option value=".$i.">".$resultatcat[$i]["nom"]."</option>";
                            $i++;
                        } 
                        ?>    
            </select>
            <input class= "mybutton" type="submit" value="Envoyer" name="envoyer" >
        </form>
        <?php
        if ( $is10car == true ) {
        ?>
            <p>Votre message doit comporter au moins 10 caractères.</p>
        <?php
        }
    }

    elseif ( !isset($_SESSION['login']) || $_SESSION['droits'] == 1) {
    ?>
        <center>
        <p><b>ERREUR</b><br />
        Vous devez être connecté en tant qu'admin ou moderateur pour accéder à cette page.</p></center>
    <?php
    }
    ?>
    </main>
<?php include("footer.php"); ?>
</body>
</html>

<?php

    if ( isset($_POST['envoyer']) == true && isset($_POST['article']) && strlen($_POST['article']) >= 10 ) {
        
        $msg = $_POST['article'];
        $categorie = $_POST['categorie'] + 1;
        $remsg = addslashes($msg);
        $requete2 = "INSERT INTO articles (article, id_utilisateur, id_categorie, date) VALUES ('$remsg', ".$resultat[0][0].", '$categorie','".date("Y-m-d H:i:s")."')";
        $query2 = mysqli_query($connexion, $requete2);
        
        mysqli_close($connexion);
        header("Location: creer-article.php");
    }
    elseif ( isset($_POST['envoyer']) == true && isset($_POST['article']) && strlen($_POST['article']) < 10 ) {
        $is10car = true;
    }
?>