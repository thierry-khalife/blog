  <footer>
        <nav>
            <a href="index.php">Accueil</a>
            <?php if(!isset($_SESSION['login'])){ ?>
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
            <?php } if(isset($_SESSION['login'])){ ?>
            <a href="profil.php">Profil</a>
            <?php 
            if( $_SESSION['droits'] == 42 || $_SESSION['droits'] == 1337 ){ 
            ?>
            <a href="creer-article.php">Créer un Article</a>
            <?php } 
            if( $_SESSION['droits'] == 1337 ){ 
            ?>
            <a href="admin.php">Admin Panel</a>
            <?php }
            }?>
        </nav>
        <article>
            <p id="copyrights">Copyright 2020 Coding School | All Rights Reserved | Project by Thierry, Nicolas & Paul.</p>
        </article>
    </footer>
