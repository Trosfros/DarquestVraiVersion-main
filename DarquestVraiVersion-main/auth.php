<?php
session_start();
require_once 'config.php';

$alias = $_POST['alias'] ?? '';
$password = $_POST['password'] ?? '';

// jai corriger pour que auth marche
$sql = "SELECT * FROM Joueurs WHERE Alias = ?";
$stmt = $connexion->prepare($sql);
$stmt->bind_param("s", $alias);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); 

// jai corriger pour que auth marche
if ($user && password_verify($password, $user['MDP'])) {
    $_SESSION['user'] = $user;
    header('Location: index.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
?>