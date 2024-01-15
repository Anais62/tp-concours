<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>



<script src="https://web3forms.com/client/script.js" async defer></script>


<?php
require ("include/header.php");
?>
<div class="fond contact">
    <form action="https://api.web3forms.com/submit" method="POST">

        <input type="hidden" name="access_key" value="10b24f55-b11b-46e8-bfed-84c0bbcd48fd">
        
        <label for="surname">Entrer votre nom :</label><br>
        <input class="form" type="text" name="name" required placeholder="John Smith">
        <label for="surname">Entrer votre email :</label><br>
        <input class="form" type="email" name="email" required placeholder="abcdef@gmail.com">
        <label for="surname">Message :</label><br>
        <textarea  name="message" rows="5" required placeholder="Raison de votre contact troll = ban !!!"></textarea>
        <div class="h-captcha" data-captcha="true"></div>
        <button type="submit">Envoyer</button>

    </form>
    <div class="trollfab">* En cas de troll nous nous réservons le droit d'appeller <a href="fab.php">Fabrice</a> pour la punition ou Alexis pour la baguarre</div>
</div>
    </main>
    <script src="https://web3forms.com/client/script.js" async defer></script>

</body>
</html>