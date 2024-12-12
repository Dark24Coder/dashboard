<?php
require('fpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Créer un PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Récupérer les données
$sql = "SELECT * FROM contact_form_data";
$result = $conn->query($sql);

// Ajouter un titre
$pdf->Cell(200, 10, 'Contact Form Submissions', 0, 1, 'C');

// Ajouter les données
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(200, 10, 'First Name: ' . $row['firstName'], 0, 1);
    $pdf->Cell(200, 10, 'Last Name: ' . $row['lastName'], 0, 1);
    $pdf->Cell(200, 10, 'Email: ' . $row['email'], 0, 1);
    $pdf->MultiCell(200, 10, 'Message: ' . $row['message'], 0, 1);
    $pdf->Ln();
}

// Envoi du PDF au navigateur
$pdf->Output('D', 'contact_form_data.pdf');

// Fermer la connexion
$conn->close();
?>
