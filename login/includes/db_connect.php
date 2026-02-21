<?php
$host = 'localhost';
$dbname = 'reseau_social'; // Nom exact de ta base
$username = 'root';
$password = ''; // XAMPP n’a pas de mot de passe par défaut

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
}
?>s