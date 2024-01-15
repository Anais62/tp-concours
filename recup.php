<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body><main>
<?php require("include/header.php")
?>

<div class="fond">
    <h1>Veuillez renseigner une adresse mail :</h1>
    <br><br>
<form action="process-recovery.php" method="post">
    <label for="email">Adresse e-mail :</label>
    <input class="form" type="email" name="email" required>
    <input class="form" type="submit" value="Envoyer le lien de récupération">
</form>

</div>

</main>
</body>
</html>