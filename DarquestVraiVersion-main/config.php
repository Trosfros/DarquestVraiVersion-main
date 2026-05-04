<?php
require_once 'include/user.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$domain = $scheme . '://' . $_SERVER['HTTP_HOST'];

$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$nomBaseDonnees = "mydb";

$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $nomBaseDonnees);

if ($connexion->connect_error) {
    die("Erreur de connexion: " . $connexion->connect_error);
}

$connexion->set_charset("utf8");

if (isset($_SESSION['user']))
    UpdateUserSessionInfo();
?>
