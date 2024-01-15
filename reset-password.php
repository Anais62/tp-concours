<?php
// reset-password.php

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Vérifier si le token existe dans la base de données
    // (Assurez-vous de remplacer les valeurs de connexion à la base de données par les vôtres)
    $conn = new mysqli("localhost", "anais", "bastien62", "competition");

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $query = "SELECT * FROM user WHERE reset_token = '$token'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Afficher le formulaire de réinitialisation du mot de passe
        // (Vous pouvez créer un formulaire avec les champs nouveau mot de passe et confirmation)
        echo '<form action="process-reset-password.php" method="post">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" name="password" required>
                <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
                <input type="password" name="confirm_password" required>
                <input type="hidden" name="token" value="' . $token . '">
                <input type="submit" value="Réinitialiser le mot de passe">
              </form>';
    } else {
        echo "Token invalide.";
    }

    $conn->close();
} else {
    echo "Token manquant.";
}
