<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// process-recovery.php

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'e-mail soumis par l'utilisateur
    $email = $_POST["email"];

    // Valider l'adresse e-mail (vous pouvez ajouter une validation plus approfondie si nécessaire)

    // Vérifier si l'adresse e-mail existe dans la base de données
    // (Assurez-vous de remplacer les valeurs de connexion à la base de données par les vôtres)
    $conn = new mysqli("localhost", "anais", "bastien62", "competition");

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Générer un token unique pour la réinitialisation du mot de passe
        $token = bin2hex(random_bytes(32));

        // Enregistrer le token dans la base de données avec l'identifiant de l'utilisateur
        $updateQuery = "UPDATE user SET reset_token = '$token' WHERE email = '$email'";
        $conn->query($updateQuery);

        // Envoyer un e-mail à l'utilisateur avec le lien de réinitialisation
        $resetLink = "http://178.32.107.35/reset-password.php?token=$token";
        $to = $email;
        $subject = "Réinitialisation du mot de passe";
        $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : $resetLink";
        $headers = "From: nanaise@hotmail.fr";

        mail($to, $subject, $message, $headers);

        echo "Un e-mail de réinitialisation a été envoyé à votre adresse e-mail.";
    } else {
        echo "Aucun utilisateur n'a été trouvé avec cette adresse e-mail.";
    }

    $conn->close();
}
