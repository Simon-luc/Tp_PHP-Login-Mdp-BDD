<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pseudo = trim($_POST["pseudo"]) ?? "";
    $email = trim($_POST["email"]) ?? "";
    $password = $_POST["mot_de_passe"] ?? "";
    $password_confirm = $_POST["mot_de_passe_confirm"] ?? "";


    // validation basique

    if (strlen($pseudo) < 3) {
        $errors[] = "Le pseudo doit faire au moins 3 caractères";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide";
    }
    if (strlen($password) < 5) {
        $errors[] = "Le mot de passe doit faire au moins 5 caractères";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    if (empty($errors)) {
        // vérifier si l'utilisateur existe en base de données
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email OR pseudo = :pseudo");
        $stmt->execute([':email' => $email, ':pseudo' => $pseudo]);

        if ($stmt->fetch()) {
            $errors[] = "Le pseudo ou l'email est déjà utilisé.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // insérer dans la base de donnée;

            $insert = $pdo->prepare("INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES(:pseudo, :email, :mdp)");
            $insert->execute([
                ':email' => $email,
                ':pseudo' => $pseudo,
                ':mdp' => $hashedPassword
            ]);

            $_SESSION['success_message'] = "Inscription réussie ! Vous pouvez vous connecter";
            header("Location: connexion.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h1>Créer un son compte</h1>
    <p><a href="connexion.php">Déjà inscrit ? Connectez-vous</a></p>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
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
            <label for="email">Email</label>
            <input type="text" name="email" id="email" required>
        </div>
        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="text" name="mot_de_passe" id="mot_de_passe" required>
        </div>
        <div>
            <label for="mot_de_passe_confirm">Confirmation de mot de passe</label>
            <input type="text" name="mot_de_passe_confirm" id="mot_de_passe_confirm" required>
        </div>
        <button type="submit">S'incrire</button>
    </form>