<?php
session_start();
// Inclure votre fichier de connexion à la base de données
require('connexionBDD.php');

if ($_SESSION["status"] != -1) {
    header("Location: utilisateur.php");
}
$id =$_SESSION["id"];
if (!empty($_POST['parent_nom']) && !empty($_POST['parent_prenom']) && 
    !empty($_POST['parent_email']) && !empty($_POST['tel_parent'])) {

    // Récupérer les infos du formulaire et les stocker dans des variables
    $nom = $_POST['parent_nom'];
    $prenom = $_POST['parent_prenom'];
    $email = $_POST['parent_email'];
    $tel = $_POST['tel_parent'];

    // Préparation de la requête
    $requete = 'INSERT INTO parental_consent (id_user, email, phone_number, name, surname) VALUES (:user_id, :email, :phone_number, :name, :surname)';

    // Création d'un objet PDOStatement
    $query = $db->prepare($requete);

    // Association d'une valeur à un paramètre de l'objet PDOStatement
    $query->bindValue(':user_id', $id, PDO::PARAM_INT);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':phone_number', $tel, PDO::PARAM_INT);
    $query->bindValue(':surname', $nom, PDO::PARAM_STR);
    $query->bindValue(':name', $prenom, PDO::PARAM_STR);

    // Exécution de la requête
    $query->execute();

    // Redirection après l'insertion des données
    header("Location: enattentemineu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <main>
        <?php require("include/header.php") ?>
        <div class="enattenteparentfond">
            <h2>Déposer un certificat de vos parents pour pouvoir participer</h2><br>
            <form action="" method="post">
                <label for="parent_nom">Nom du parent :</label><br>
                <input class="form" type="text" id="parent_nom" name="parent_nom" required><br><br>
                <label for="parent_email">Mail du parent :</label><br>
                <input class="form" type="email" id="parent_email" name="parent_email" required><br><br>
                <label for="parent_prenom">Prénom du parent :</label><br>
                <input class="form" type="text" id="parent_prenom" name="parent_prenom" required><br><br>
                <label for="tel_parent">Numéro de téléphone du parent :</label><br>
                <input class="form" type="tel" id="tel_parent" name="tel_parent" pattern="[0-9]{10}" required><br><br>
                <button type="submit">Envoyez le dossier</button>
            </form>
        </div>
        <footer>Tous droits réservés à moi.</footer>
    </main>
</body>
</html>
