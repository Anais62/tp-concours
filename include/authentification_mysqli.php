<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Ma Banque !!!</title>
    </head>
    <body>
        <h1>Formulaire de connexion à une base de donnees:</h1>
        <form action="recherche_mysqli.php" method="post">
           <label for="nom">Nom:</label> 
           <input type="text" id="nom" name="nom" required="required"><br>
           <label for="mdp">Mot de passe:</label> 
           <input type="password" id="mdp" name="mdp" required="required"><br>
           <button type="submit" >Envoyer</button>
        </form>
    </body>
</html>