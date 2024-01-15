<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'autorisation parentale</title>
</head>
<body>

    <h1>Formulaire d'autorisation parentale</h1>

    <form method="post" action="traitement_formulaire.php">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="age">Âge :</label>
        <input type="number" id="age" name="age" min="16" max="18" required><br>

        <h2>Autorisation parentale</h2>

        <label for="parent_nom">Nom du parent :</label>
        <input type="text" id="parent_nom" name="parent_nom" required><br>

        <label for="parent_prenom">Prénom du parent :</label>
        <input type="text" id="parent_prenom" name="parent_prenom" required><br>

        <label for="tel_parent">Numéro de téléphone du parent :</label>
        <input type="tel" id="tel_parent" name="tel_parent" pattern="[0-9]{10}" required><br>

        <label for="adresse_parent">Adresse du parent :</label>
        <textarea id="adresse_parent" name="adresse_parent" required></textarea><br>

        <input type="submit" value="Soumettre">
    </form>

</body>
</html>
