<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db_connect.php';

echo "<h2>Connexion à la base de données réussie !</h2>";

// Teste une requête simple
$stmt = $pdo->query("SELECT COUNT(*) FROM profil");
$count = $stmt->fetchColumn();

echo "<p>Nombre d'utilisateurs dans la base : <strong>$count</strong></p>";
?>