<?php
$servername = "localhost";
$username = "root"; // ou ton nom d'utilisateur
$password = "";     // ou ton mot de passe
$dbname = "contact_form"; // nom de ta base de données

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}
?>
