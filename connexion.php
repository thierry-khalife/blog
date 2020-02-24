<?php

    session_start();
    $ismdpwrong = false;
    $isIDinconnu = false;
    $ischampremplis = false;

    if ( isset($_POST['connexion']) == true && isset($_POST['login']) && strlen($_POST['login']) != 0 && isset($_POST['password']) && strlen($_POST['password']) != 0 ) {
        $connexion = mysqli_connect("localhost", "root", "", "blog");
        $requete = "SELECT * FROM utilisateurs WHERE login ='".$_POST['login']."'";
        $query = mysqli_query($connexion, $requete);
        $resultat = mysqli_fetch_all($query);
        if ( !empty($resultat) ) {
            if ( password_verify($_POST['password'], $resultat[0][2]) )
                    {
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['droits'] = $resultat[0][4];
                        header('Location:index.php');
                    }
            else {
                $ismdpwrong = true;
            }
        }
        else {
            $isIDinconnu = true;
        }
        mysqli_close($connexion);
    }
    elseif ( isset($_POST['connexion']) == true && isset($_POST['login']) && strlen($_POST['login']) == 0 || isset($_POST['password']) && strlen($_POST['password']) == 0 ) {
        $ischampremplis = true;
    }

?>

<!DOCTYPE html>

<html>
<head>
    <title>Connexion - Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php include("header.php"); ?>
    <main>
    <?php
    if ( !isset($_SESSION['login']) ) {
    ?>
        <form class="form_site" method="post" action="connexion.php">
            <fieldset>
                <legend>Connexion</legend>
                <section class="cform">
                    <label>Identifiant</label>
                    <input type="text" name="login" ><br />
                    <label>Mot de passe</label>
                    <input type="password" name="password" ><br />
                    <input class="mybutton" type="submit" value="Se connecter" name="connexion" />
        <?php
        if ( $ismdpwrong == true ) {
        ?>
            <p><span class="red">Identifiant ou mot de passe incorrect.</span></p>
        <?php
        }
        elseif ( $isIDinconnu == true ) {
        ?>
            <p><span class="red">Cet identifiant n'exsite pas.</span></p>
        <?php
        }
        elseif ( $ischampremplis == true ) {
        ?>
            <p><span class="red">Merci de remplir tous les champs!</span></p>
        <?php
        }
    }

    elseif ( isset($_SESSION['login']) ) {
    ?>
        <span class="red center"><p>ERREUR<br />
        Vous êtes déjà connecté !</p></span>
    <?php
    }
    ?>
                </section>
            </fieldset>
        </form>
    </main>
   <?php include("footer.php"); ?>
</body>
</html>