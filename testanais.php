<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Assurez-vous d'ajuster le chemin du fichier de style -->
    <title>Formulaire de Contact</title>
</head>
<body>
    <main>
        <?php require("include/header.php") ?> <!-- Assurez-vous d'ajuster le chemin du fichier d'en-tête -->
        <div class="formulaireavecbtn">
            <form action="traitement_contact.php" method="post">
                <h1>Contactez-nous</h1><br><br><br>

                <div class="centre">
                    <label for="nom">Nom :</label><br>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <br>

                <div class="centre">
                    <label for="email">Adresse e-mail :</label><br>
                    <input type="email" id="email" name="email" required>
                </div>

                <br>

                <div class="centre">
                    <label for="message">Message :</label><br>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>

                <br>

                <div class="flex-center">
                    <div class="spcace-button">
                        <button type="submit">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
        
    </main>
</body>
</html>
