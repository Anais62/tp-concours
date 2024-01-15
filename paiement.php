<?php
session_start();
require('connexionBDD.php');


if (isset($_POST['annuler']) && !empty($_POST['annuler'])) {
    $userid = $_SESSION["id"];

    // Supprimer la tâche de la base de données
    $sqlDelete = "UPDATE user SET status = 0 WHERE id = :userid";
    $queryDelete = $db->prepare($sqlDelete);
    $queryDelete->bindValue(":userid", $userid, PDO::PARAM_INT);
    $queryDelete->execute();
    
    $sql = "DELETE FROM  `selected_songs` WHERE `user_id` = :userid";
    $query = $db->prepare($sql);
    $query->bindValue(":userid", $userid, PDO::PARAM_INT);
    $query->execute();
    header("Location: index.php");
    
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
<div class="progress-bar">
        <div class="step active">Étape 1</div>
        <div class="step active">Étape 2</div>
        <div class="step active">Étape 3</div>
        <div class="step ">Étape 4</div>
        
    </div>
<div class="enattentepaiementfond">
    <h1>EN ATTENTE de reception du paiement par la secretaire</h1> 
    <br>
    Merci d'envoyer un cheque à l'ordre de la mairie de longuenesse d'un montant de 50 euros :
    <br>
    <br>Commune de Longuenesse
    <br>13, rue Joliot Curie 
    <br>62219 Longuenesse - FRANCE
    <br>+33 3 21 12 23 00
    <br>
<img class="taper"src="image/taper-clavier-test.gif">
<br>
SI vous souhaitez annuler votre inscription :
<br>
<br>
<form action="" method="post">
    <button id="annuler" name="annuler" value="<?php echo $_SESSION["id"];?>" type="submit">Cliquez ici</button>
</form>
<div class="conditioncache">*On ne vous garenti pas de ne pas garder l'argent</div>
</div>


</main>
</body>
</html>