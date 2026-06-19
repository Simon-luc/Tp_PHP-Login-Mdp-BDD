<?php
session_start();
require_once 'config.php';



if(!isset($_SESSION["pseudo"])){
    header("Location: connexion.php");
    exit;
} 
$username = $_SESSION["pseudo"];





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1> Bienvenue <?=   $_SESSION["pseudo"]?></h1>
    <p>La seul Option possible est la déconnextion</p>  
    <a href="deconexion.php">Déconnexion</a>
</body>
</html>