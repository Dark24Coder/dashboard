<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Récupérer les données
$sql = "SELECT * FROM contact_form_data";
$result = $conn->query($sql);

// Créer le fichier CSV
if ($result->num_rows > 0) {
    // Définir les entêtes HTTP pour télécharger le fichier
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="contact_form_data.csv"');

    $output = fopen('php://output', 'w');

    // Ajouter les en-têtes du fichier CSV
    fputcsv($output, ['First Name', 'Last Name', 'Email', 'Message']);

    // Ajouter les lignes de données
    while($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
} else {
    echo "Aucune donnée trouvée.";
}

$conn->close();
?>
