<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// bibliothèque PHPMailer
require 'vendor/autoload.php';



   // Récupération 
   $nom = $_POST['nom'];
   $email = $_POST['email'];
   $sujet = $_POST['sujet'];
   $message = $_POST['message'];
   
      // Connexion 
   $servername = "localhost"; 
   $username = "root"; 
   $password = "";
   $dbname = "portfolio"; 
   
   // Création de la connexion
   $conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Préparer et exécuter la requête d'insertion
$stmt = $conn->prepare("INSERT INTO info (nom, email, sujet, messages) VALUES ('$nom', '$email', '$sujet', '$message')");
//$stmt->bind_param("ssss", $nom, $email, $sujet, $message);


if ($stmt->execute()) {
    //réussie

    // Envoi de l'e-mail  avec PHPMailer
    $mail = new PHPMailer(true);
   try {
        // Paramètres 
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = '59e82955e9ce93'; //adresse e-mail SMTP
        $mail->Password = '1f769b7cd78e87'; // mot de passe SMTP
       // $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;
 
        // Destinataire
        $mail->setFrom('hotsifriday@gmail.com');
        $mail->addAddress('setadonis0@gmail.com'); // adresse e-mail reception
        $mail->IsHTML(true);
        $mail->Subject = 'Nouveau message reçu depuis le formulaire de contact';
        $mail->Body = "Nom: $nom\nEmail: $email\nSujet: $sujet\nMessage: $message";

        // Envoi de l'e-mail
        $mail->send();

        echo 'Votre message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "Une erreur s'est produite lors de l'envoi du message : {$mail->ErrorInfo}";
    }
} 
else {
    echo "Une erreur s'est produite lors de l'envoi du message.";
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();


