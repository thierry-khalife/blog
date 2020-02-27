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
    <meta charset="UTF-8">
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
        <form method="post" action="creer-article.php" class="form_site" enctype="multipart/form-data">
            <fieldset>
                <legend>Votre article</legend>
                <section class="cform">
                    <label>Titre de l'article</label>
                    <input type="text" name="titre" />
                    <label>Contenu de l'article</label>
                    <textarea name="article" ></textarea><br />
                    <label for="categorie"><b>Catégorie</b></label>
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
                    <label>Image de profil</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input class= "mybutton" type="submit" value="Envoyer" name="envoyer" >
                </section>
            </fieldset>
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
        <p class="red center">Vous devez être connecté en tant qu'admin ou modérateur pour pouvoir accéder à cette page.</p>
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
        $titre = $_POST["titre"];
        $img = preg_replace("/[^a-zA-Z]/", "", $titre);
        $retitre = addslashes($titre);
        $go = false;
        if ( !empty($_FILES["fileToUpload"]["name"]) ) {
            $target_dir = "img/";
            $name = $_FILES["fileToUpload"]["name"];
            $yo = explode(".", $name);
            $ext = end($yo);
            $target_file = "img/p".$img.".".$ext;
            echo $target_file;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if( $check !== false ) {
                $uploadOk = 1;
            } 
            else {
                $uploadOk = 0;
            }
            // Vérifie la taille de l'image
            if ( $_FILES["fileToUpload"]["size"] > 500000000000 ) {
                $uploadOk = 0;
            }
            // Autorise que certains format d'images
            if( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $uploadOk = 0;
            }
            else {
                if ($uploadOk == 1 && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $go = true;
                }
            }
        }
        if ( $go == true ) {
            $requete2 = "INSERT INTO articles (article, id_utilisateur, id_categorie, date, titre, img) VALUES ('$remsg', ".$resultat[0][0].", '$categorie','".date("Y-m-d H:i:s")."', '$retitre', '$target_file')";
            $query2 = mysqli_query($connexion, $requete2);
            echo $requete2;
        }
        
        mysqli_close($connexion);
        // header("Location: creer-article.php");
    }
    elseif ( isset($_POST['envoyer']) == true && isset($_POST['article']) && strlen($_POST['article']) < 10 ) {
        $is10car = true;
    }
?>
