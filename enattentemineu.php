<?php
session_start();
// if ($_SESSION['status']!== 1 && $_SESSION['status']!== 2 ) {
//     header("Location: reglement.php");
// }
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
    
    <h1>EN ATTENTE de validation par la secretaire</h1> 
    <br>
<img class="taper"src="image/taper-clavier-test.gif">

</div>

<footer>Tous droits réservés à moi.</footer>

</main>
</body>
</html>