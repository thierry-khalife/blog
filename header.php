<header>
        <nav class="nav">
            <section class="headerleft">
                <section id="logo">
                <a href="index.php"><img src="img/logo.png"></a>
                </section>
            </section>
            <section class="headerright">
                  <?php if( !isset($_SESSION['login']) ){ ?>
            <section class="undernav">
                <a href="connexion.php"><img src="img/connexion.png"></a>
                <a href="connexion.php">Connexion</a>
            </section>
            <section class="undernav">
                <a href="inscription.php"><img src="img/inscription.png"></a>
                <a href="inscription.php">Inscription</a>
            </section>
            <?php } if( isset($_SESSION['login']) ){ ?>
             <section class="undernav">
                <a href="profil.php"><img src="img/profil.png"></a>
                <a href="profil.php">Profil</a>
            </section>
             <?php if( $_SESSION['droits'] == 42 || $_SESSION['droits'] == 1337 ){ ?>
             <section class="undernav">
                <a href="creer-article.php"><img src="img/article.png"></a>
                <a href="creer-article.php">Créer un Article</a>
            </section>
             <?php } ?>
              <?php if( $_SESSION['droits'] == 1337 ){ ?>
            <section class="undernav">
                <a href="admin.php"><img src="img/admin.png"></a>
                <a href="admin.php">Admin</a>
            </section>
             <?php } ?>
            <section class="undernav">
                <a href="index.php?deco"><img src="img/deconnexion.png"></a>
                <a href="index.php?deco">Déconnexion</a>
            </section>
            <?php } ?>
            </section>
        </nav>
    </header>