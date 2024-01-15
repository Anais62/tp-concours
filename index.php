<?php
session_start();
require('connexionBDD.php');
// Flemme
if ($_SESSION["admin"] !== null) {    
    header("Location: utilisateur.php");
    exit();
}

// On récupère les données envoyées par le formulaire
if (!empty($_POST['userEmailco']) && !empty($_POST['userPasswordco'])) {
    $emailco = $_POST['userEmailco'];
    $mdpco = $_POST['userPasswordco'];

    // Vérification de l'e-mail
    $sql = "SELECT * FROM `user` WHERE email = :email";
    $query = $db->prepare($sql);
    $query->bindValue(":email", $emailco, PDO::PARAM_STR);
    $query->execute();
    $verifEmail = $query->fetch(PDO::FETCH_ASSOC);
    
  
        
}
if ($verifEmail && password_verify($mdpco, $verifEmail['password'])) {
        
    echo "Connexion réussie";
    $sql = "SELECT YEAR(date_birth) as year_of_birth FROM `user` WHERE id = :id";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $verifEmail['id'], PDO::PARAM_STR);
    $query->execute();
    $userData = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION["age"] = $userData["year_of_birth"];
    // Ouverture de la session
    
    session_start();
    
    $_SESSION["id"] = $verifEmail['id'];
    $_SESSION["surname"] = $verifEmail['surname'];
    $_SESSION["name"] = $verifEmail['name'];
    $_SESSION["admin"] = $verifEmail['admin'];
    $_SESSION["logged"] = true;
    $_SESSION["status"] = $verifEmail["status"];
    $_SESSION['bill'] =$verifEmail["bill"];

    echo "Bonjour ".$_SESSION["status"];
    
    // Redirection vers la page de l'utilisateur

    header("Location: utilisateur.php");
    
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecacheprize.css">
    <script src="scriptcacheprize.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


</head>
<body><main>
<?php require("include/header.php")
?>
<div class="indexmain">

    <div class="fond gain">
    <div id="app">
            <div id="prize">
                <div id="prize-lines" class="prize-filter"></div>
                <div id="prize-shadow" class="prize-filter"></div>
                <h2 id="prize-label">
                <span class="asterisk">*</span>
                <span>CASH PRIZE</span>
                <span class="asterisk">*</span>      
                </h2>
                <h1 id="prize-text"></h1>
            </div>
            
            <div id="shapes">
                <i class="fa-regular fa-circle"></i>
                <i class="fa-regular fa-square"></i>
                <i class="fa-regular fa-triangle"></i>
            </div>
</div>
        
    
    <h1>Notes Rigolotes à Longuenesse : Faites Vibrer Votre Joie Musicale! 🎶</h1>

<p>Bienvenue, mélomanes et artistes passionnés,</p>

<p>La scène est prête, les instruments sont accordés, et l'excitation musicale envahit l'air à Longuenesse! C'est avec une joie contagieuse que nous vous invitons à participer à notre concours de musique exceptionnel, intitulé "Notes Rigolotes." 🎉🎼</p>

<h2>Un Festival de Notes et de Rires!</h2>

<p>"Notes Rigolotes" célèbre la magie de la musique et l'humour qui résonne à travers chaque accord. Que vous soyez un virtuose du rire en rythme, un maître des mélodies comiques, ou un compositeur de notes hilarantes, cette compétition vous offre une opportunité unique de faire rayonner votre talent musical sous une lumière joyeuse.</p>

<h2>Prix Ludiques à Gagner!</h2>

<p>Au-delà des applaudissements et des rires partagés, des récompenses spectaculaires attendent les artistes qui sauront marquer les esprits. Des trophées scintillants et des prix sensationnels sont à portée de main pour ceux qui feront résonner leurs notes rigolotes avec éclat.</p>

<h2>Comment Participer:</h2>

<p>🎸 Préparez votre numéro musical comique ou votre composition joyeuse.<br>
🎤 Enregistrez-vous en train de partager votre performance unique.<br>
📧 Envoyez-nous votre création avant la date limite, et soyez prêt à émerveiller Longuenesse de vos "Notes Rigolotes"!</p>

<p>Joignez-vous à cette symphonie de rires et de mélodies. Que la fête musicale commence! 🎶✨</p>
</body>
    </div>
        
    
    
        <div class="connexion formulaireavecbtn">
        <form action="" method="POST">
                <h1>Connexion</h1><br><br><br>
                <div class="centre">
                    <label for="emailco">Entrez votre adresse email:</label><br>
                    <input class="formco" type="email" name="userEmailco">
                </div> 

                <br>
                
                <div class="centre">
                    <label for="passwordco">Entrez votre mot de passe:</label><br>
                    <input class="formco" type="password" id="password" name="userPasswordco">
                </div>

                <br>
<?php   if (isset($_POST["userEmailco"])&& isset($_POST["userPasswordco"])) {
        echo "Adresse e-mail ou mot de passe incorrect";
    }
        
    ?>
    
                <div class= "flex-center">
                    <div class="spcace-button">
                        <button type="submit">Connexion </button>
                    </div>
                <br>
                
                
                </div>
            
            </form>
           
             <div class="btninscription">
                <button id="noSign" name="noSign" type="submit"><a href="inscription.php">Pas encore inscrit ?</a></button>
            </div>
            
        </div>
        
       
</div>
<div class='footer'>Tous droits réservés à moi.</div>
</main>
</body>
</html>
