<?php
// Configuration de la connexion à la base de données MySQL

$servername = "localhost"; 
$username = "root"; 
$password = ""; 

try {
    // Création d'une connexion PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO pour afficher les exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Afficher un message en cas d'échec de la connexion
    echo "Connection failed: " . $e->getMessage();
}
?>
