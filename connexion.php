<?php
session_start();
require_once 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pseudo = trim($_POST["pseudo"]) ?? "";
    $password = $_POST["mot_de_passe"] ?? "";

    // vérifier si l'utilisateur existe en base de données
    $stmt = $pdo->prepare("SELECT id, mot_de_passe, pseudo FROM utilisateurs WHERE pseudo = :pseudo");
    $stmt->execute([':pseudo' => $pseudo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['mot_de_passe'])) {
            // Réussit -> header location dashboard
            $_SESSION['pseudo'] = $user ['pseudo'];
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[]= "Id ou Mdp Invalide ! Je peux pas te dire le quelle ";

            };
    }
} ;


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Connecte Toi !</h1>

    <?php if(!empty($errors)): ?>
        <div style="color: red";>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required>
        </div>
        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="text" name="mot_de_passe" id="mot_de_passe" required>
        </div>

        <button type="submit">Valide</button>
    <a href="inscription.php">Je veux m'inscrire</a>

    </form>




