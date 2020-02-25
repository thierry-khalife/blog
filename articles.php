<?php
session_start();
$start = $_GET["start"];
$categorie = $_GET["categorie"];
?>

<!DOCTYPE html>

<html>
<head>
    <title>Articles - Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php 
include("header.php");
?>
    <main>