<?php
session_start();
require_once 'config.php';

if(isset($_GET['id'])){
    if(filter_var($_GET['id'], FILTER_VALIDATE_INT)){
        $stmt= $pdo -> prepare("DELETE FROM utilisateurs WHERE id = :id");
        $stmt -> execute(['id' => (int) $_GET['id']]);

        header("Location: connexion.php");
        exit();
    }
}