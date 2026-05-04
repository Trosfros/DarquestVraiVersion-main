<?php
require_once 'config.php';
require_once 'Email.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $alias = $_POST['alias'];
    $mail = $_POST['mail'];
    $mdp_hashe = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $guid = bin2hex(openssl_random_pseudo_bytes(16));

    try {
        $sql = "INSERT INTO Joueurs (Alias, Nom, Prenom, MDP, Mail, Guid) VALUES (?, ?, ?, ?, ?, '$guid')";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("sssss", $alias, $nom, $prenom, $mdp_hashe, $mail);

        require 'mail_confirmation.php'; // $body

        Email::readConfig('gmail.ini');
        Email::send($mail, 'Activation du Compte Darquest', $body);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        
        if ($e->getCode() === 1062) {
            header("Location: register.php?error=alias_taken");
            exit();
        } else {
            die("Erreur fatale du grimoire : " . $e->getMessage());
        }
    }
}
?>
