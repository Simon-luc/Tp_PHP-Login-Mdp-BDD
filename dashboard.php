<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["pseudo"])) {
    header("Location: connexion.php");
    exit;
}

$username = $_SESSION["pseudo"];
$stmt = $pdo->prepare("SELECT id, pseudo, email, cree_le FROM utilisateurs WHERE pseudo = :pseudo");
$stmt->execute(['pseudo' => $username]);
$utilisateur = $stmt->fetch();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       a:hover,
        a:focus {
            color: #be448f !important;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">

        <h1 class="fw-bold text-uppercase fs-4 mb-3"> Bienvenue <?= $_SESSION["pseudo"] ?></h1>
        <p>Hey ! <?= $_SESSION["pseudo"] ?> tu peux : </p>

        <a href="profile.php?id=<?= $utilisateur['id'] ?>"> Voir mon profil</a>
        <a href="delete.php?id=<?= $utilisateur['id'] ?>"> Supprimer mon profil</a>

        <a href="deconexion.php">Déconnexion</a>
    </div>
</body>

</html>