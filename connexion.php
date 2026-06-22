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
            $_SESSION['pseudo'] = $user['pseudo'];
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Id ou Mdp Invalide ! Je peux pas te dire le quelle ";
        };
    }
};


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control:focus {
            border-color: #44be54 !important;
            box-shadow: none !important;
        }

        a:hover,
        a:focus {
            color: #be448f !important;
        }
    </style>

</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 420px;">
        <h1 class="fw-bold text-uppercase fs-4 mb-3">Connecte Toi !</h1>
         <div class="card shadow-sm p-4" style="width: 100%; max-width: 420px;">
        
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            
        </body>
        </html></a></p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="text" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Valide</button>
            <a href="inscription.php">Je veux m'inscrire</a>

        </form>
    </div>

</body>

</html>