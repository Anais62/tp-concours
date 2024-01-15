<?php
session_start();

require('connexionBDD.php');

if (!empty($_POST['bande_son'])) {
    $bande_son = $_POST['bande_son'];


    // Préparation de la requête pour l'adresse
    $requete = 'INSERT INTO soundtrack (id_user, tape) VALUES (:id_user, :tape)';
    $query = $db->prepare($requete);
    $query->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
    $query->bindValue(':tape', $bande_son, PDO::PARAM_STR);
    $query->execute();
    $query->closeCursor();
    header("Location: utilisateur.php");
} 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
    <script src="script.js" defer></script>
</head>
<audio class="music" src="audio/tape.mp3"></audio>
<body><main>
<?php require("include/header.php")
?>

<div class="enattentefond">
    <h1>Déposé votre bande son</h1> 
    <br>
    <form action="" method="post">
        <input class="form" type="text" name="bande_son" id="bande_son" placeholder="Entrez votre URL (optionnel)" autofocus>
        <button type="submit">Envoyez</button>
    </form>
</div>

<footer>Tous droits réservés à moi.</footer>

</main>
</body>
</html>