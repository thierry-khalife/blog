<header>
        <img class="logoheader" src="img/roamsweetroam-logo.png" alt="logoheader" />
        <nav class="nav">
            <section class="navbtn">
                <a class="link1" href="index.php">Accueil</a>
            </section>

            <?php if( !isset($_SESSION['login']) ) { ?>

            <section class="navbtn">
                <a class="link1" href="articles.php?start=0">Articles</a>
                <section class="submenu">
                    <article class="dropdownsubmenu">
                        <a class="link2" href="articles.php?categorie=1&start=0">Destinations</a>
                    </article>
                    <article class="dropdownsubmenu">
                        <a class="link2" href="articles.php?categorie=2&start=0">Conseils</a>
                    </article>
                    <article class="dropdownsubmenu">
                        <a class="link2" href="articles.php?categorie=3&start=0">Recommandations</a>
                    </article>
                </section>
            </section>
            <section class="navbtn">
                <a class="link1" href="connexion.php">Connexion</a>
            </section>
            <section class="navbtn">
                <a class="link1" href="inscription.php">Inscription</a>
            </section>

            <?php
            } 
            
            if( isset($_SESSION['login']) ){ ?>
             <section class="navbtn">
                <a class="link1" href="profil.php">Profil</a>
            </section>
             <?php if( $_SESSION['droits'] == 42 || $_SESSION['droits'] == 1337 ){ ?>
             <section class="navbtn">
                <a class="link1" href="creer-article.php">Créer un Article</a>
            </section>
             <?php } ?>
              <?php if( $_SESSION['droits'] == 1337 ){ ?>
            <section class="navbtn">
                <a class="link1" href="admin.php">Admin</a>
            </section>
             <?php } ?>
            <section class="navbtn">
                <a class="link1" href="index.php?deco">Déconnexion</a>
            </section>
            <?php } ?>
        </nav>
</header>