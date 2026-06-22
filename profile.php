<?php
session_start();
require_once 'config.php';

if(!isset($_SESSION["pseudo"])){
    header("Location: connexion.php");
    exit();
}

if(isset($_GET['id'])){
if(filter_var($_GET['id'], FILTER_VALIDATE_INT)){
$stmt = $pdo->prepare("SELECT id, email, cree_le FROM utilisateurs WHERE id= :id");
$stmt->execute(['id'=> (int) $_GET['id']]);
$utilisateur = $stmt->fetch();
}

}

if((int)$utilisateur['id'] != (int)$_SESSION['user_id']){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
       a:hover,
        a:focus {
            color: #be448f !important;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-sm p-4" >
    <h1 class="fw-bold text-uppercase fs-4 mb-3">PROFIL</h1>

            <?php if ($utilisateur): ?>
   <p>Profil de : <?= $utilisateur['email'] ?> </p>
   <p>Crée le :  <?= $utilisateur['cree_le'] ?></p>
    <a href="delete.php?id=<?=  $utilisateur['id']  ?>"> Supprimer Mon profil</a>
<?php else : ?>
    Utilisateur introuvable <br>;
<?php endif; ?>


<a href="dashboard.php"> Retour Vers le dashboard</a>

<p class="mb-3"><a href="list_users.php">Admin ? par ici !</a><p>
</div>
</body>
</html>