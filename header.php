<header>
        <nav class="nav">
            <section class="headerleft">
                <section id="logo">
                <a href="index.php">Accueil</a>
                </section>
            </section>
            <section class="headerright">
                  <?php if( !isset($_SESSION['login']) ){ ?>
            <section class="undernav">
                <a href="connexion.php">Connexion</a>
            </section>
            <section class="undernav">
                <a href="inscription.php">Inscription</a>
            </section>
            <?php } if( isset($_SESSION['login']) ){ ?>
             <section class="undernav">
                <a href="profil.php">Profil</a>
            </section>
             <?php if( $_SESSION['droits'] == 42 || $_SESSION['droits'] == 1337 ){ ?>
             <section class="undernav">
                <a href="creer-article.php">Créer un Article</a>
            </section>
             <?php } ?>
              <?php if( $_SESSION['droits'] == 1337 ){ ?>
            <section class="undernav">
                <a href="admin.php">Admin</a>
            </section>
             <?php } ?>
            <section class="undernav">
                <a href="index.php?deco">Déconnexion</a>
            </section>
            <?php } ?>
            </section>
        </nav>
    </header>