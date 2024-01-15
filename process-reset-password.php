<?php
// process-reset-password.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $token = $_POST["token"];

    // Valider les données (assurez-vous que le mot de passe respecte vos exigences)

    // Vérifier si le mot de passe et la confirmation correspondent
    if ($password === $confirmPassword) {
        // Mettre à jour le mot de passe dans la base de données et supprimer le token
        // (Assurez-vous de remplacer les valeurs de connexion à la base de données par les vôtres)
        $conn = new mysqli("localhost", "anais", "bastien62", "competition");

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        // Hasher le nouveau mot de passe (vous pouvez utiliser password_hash)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE user SET password = '$hashedPassword', reset_token = NULL WHERE reset_token = '$token'";
        $conn->query($updateQuery);

        echo "Le mot de passe a été réinitialisé avec succès.";
    } else {
        echo "Le mot de passe et la confirmation ne correspondent pas.";
    }
}
