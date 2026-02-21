<?php
// db.php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'reseau_social';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");


