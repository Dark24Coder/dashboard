<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Si tu utilises Composer, sinon inclure le fichier PHPMailer.php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $queryType = htmlspecialchars($_POST['queryType']);
    $message = htmlspecialchars($_POST['message']);

    // Valider l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }

    // Enregistrer les données dans la base de données
    $sql = "INSERT INTO submissions (firstName, lastName, email, queryType, message) 
            VALUES ('$firstName', '$lastName', '$email', '$queryType', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Enregistrement réussi dans la base de données
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    // Utilisation de PHPMailer pour l'envoi de l'email
    $mail = new PHPMailer(true);
    try {
        // Configuration SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'francylkoudanou@gmail.com';  // Remplace par ton email
        $mail->Password = 'ton-mot-de-passe';  // Remplace par ton mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('francylkoudanou@gmail.com', 'Francyl Koudanou');
        $mail->addAddress('francylkoudanou@gmail.com');  // Ton adresse email

        // Contenu du message
        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de $firstName $lastName";
        $mail->Body = "Nom: $firstName $lastName <br>Email: $email <br>Type de requête: $queryType <br><br>Message: $message";

        // Envoi de l'email
        $mail->send();
        echo 'Votre message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
