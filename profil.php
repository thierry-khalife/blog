<?php
session_start();
?>

<!DOCTYPE html>

<html>

<head>
    <title>Profil - Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
 <?php include("header.php"); ?>
    <main>
            <?php
            if (isset($_SESSION['login']))
            {
                $connexion = mysqli_connect("localhost", "root", "", "blog");
                $requete = "SELECT * FROM utilisateurs WHERE login='" . $_SESSION['login'] . "'";
                $query = mysqli_query($connexion, $requete);
                $resultat = mysqli_fetch_assoc($query);

                ?>

                <form action="profil.php" method="post">
                    <fieldset>
                        <legend>Mon profil</legend>
                        <section class="cform">
                            <label>Identifiant</label>
                            <input type="text" name="login" value=<?php echo $resultat['login']; ?> />
                            <label>Adresse email</label>
                            <input type="email" name="email" value=<?php echo $resultat['email']; ?> />
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="passwordx" />
                            <label>Confirmation du mot de passe</label>
                            <input type="password" name="passwordconf" />
                            <input name="ID" type="hidden" value=<?php echo $resultat['id']; ?> />
                            <br>
                            <input type="submit" name="modifier" value="Modifier" />
                        </section>
                        </legend>
                    </fieldset>
                </form>

                <?php 
                    if (isset($_POST['modifier']) ) 
                    {
                         if ($_POST["passwordx"] != $_POST["passwordconf"]) 
                         {
                             ?>
                            <p>Attention ! Mot de passe différents</p>
                        <?php
                        } 
                        elseif(isset($_POST['passwordx']) && !empty($_POST['passwordx'])){
                            $pwdx = password_hash($_POST['passwordx'], PASSWORD_BCRYPT, array('cost' => 12));
                            $updatepwd = "UPDATE utilisateurs SET password = '$pwdx' WHERE id = '" . $resultat['id'] . "'";
                            $query2 = mysqli_query($connexion, $updatepwd); # Execution de la requête;
                            header('Location:profil.php');
                        }
                        $login = $_POST["login"];
                        $req = "SELECT login,email FROM utilisateurs WHERE login = '$login'";
                        $req3 = mysqli_query($connexion, $req);
                        $veriflog = mysqli_fetch_all($req3);
                            if(!empty($veriflog))
                            {
                                ?>
                                <p>Login deja utilisé, requete refusé.<br /></p>
                                <?php
                            }
                        if(empty($veriflog) || ($_SESSION['login'] == $_POST['login']))
                            {
                                $updatelog = "UPDATE utilisateurs SET login ='" . $_POST['login'] . "', email ='" . $_POST['email'] . "' WHERE id = '" . $resultat['id'] . "'";
                                $querylog = mysqli_query($connexion, $updatelog); # Execution de la requête;
                                $_SESSION['login']=$_POST['login'];
                                header("Location:profil.php");
                            }
                    }
                    ?>

    <?php

    } 
    else 
    {
        ?>
        <p class="red center">Veuillez vous connecter pour accéder à votre page !</p>
        <?php
    }
    ?>

    </main>
<?php include("footer.php"); ?>
</body>

</html>