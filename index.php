<?php

session_start();

if (isset($_GET["deco"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}

$cnx = mysqli_connect("localhost", "root", "", "blog");


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
?>

<main>
   HI HOW ARE YOU
</main>

<?php
    include("footer.php");
    mysqli_close($cnx);

?>

</body>
</html>