<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["pseudo"])) {
    header("Location: connexion.php");
    exit();
}

$stmt = $pdo->prepare("SELECT id, pseudo, email, cree_le FROM utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste_utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            background-color: #1a2b4a;
            color:azure;
        }
        a{
            color: #7eb3ff;
            text-decoration: none;
        }
        
       a:hover,
        a:focus {
            color: #be448f !important;
        }

   
</style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 bg-dark">
       <div class="card shadow-sm p-4" style="width: 100%; max-width: 420px;">

   <?php
    foreach ($utilisateurs as $utilisateur) : ?>

   <p class="text"> ID : <?= $utilisateur['id'] ?> <br>
    Pseudo : <?= $utilisateur['pseudo']  ?> <br>

<a href="profile.php?id=<?= $utilisateur['id'] ?>"> Voir le profile</a><br>
<a href="delete.php?id=<?= $utilisateur['id'] ?>"> Supprimer le profile</a></p><br>


    <?php endforeach; ?>

</body>

</html>