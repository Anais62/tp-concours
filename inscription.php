<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

// On recupere les données envoyées par le formulaire


 if (!empty($_POST['userSurname']) && !empty($_POST['userName']) && 
 !empty($_POST['userEmail']) && !empty($_POST['date']) && !empty($_POST['userPassword']) && !empty($_POST['userPassword2'])) {
    
//     On récupére les infos du formulaire et en les stockants dans des variables 

    $nom = $_POST['userSurname'];
    $prenom = $_POST['userName'];
    $email = $_POST['userEmail'];
    $date = $_POST ['date'];
    $mdp = $_POST['userPassword'];
    $mdp2 = $_POST['userPassword2'];

//      On verifie si l'adresse mail est déjà utilisé
    
     $sql = "SELECT * FROM `user` WHERE email = :email";
     $query = $db->prepare($sql);
     $query->bindValue(":email", $email, PDO::PARAM_STR);
     $query->execute();
     $verifEmail = $query->fetch();
     var_dump($verifEmail);

//      Si l'adresse mail n'est pas dans la bdd on rentre dans la condition sinon incorrecte
        
      if($verifEmail === false) {

        // Vérification des 2 mots de passe identiques 

        if ($mdp === $mdp2) {
            // Hachage du mot de passe
            $motdepassehash = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparation de la requête
            $requete = 'INSERT INTO user (surname, name, email, password, date_birth) VALUES (:surname, :name, :email, :password, :date_birth)';

            // Création d'un objet PDOStatement
            $query = $db->prepare($requete);

            // Association d'une valeur à un paramètre de l'objet PDOStatement
            $query->bindValue(':surname', $nom, PDO::PARAM_STR);
            $query->bindValue(':name', $prenom, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password', $motdepassehash, PDO::PARAM_STR);
            $query->bindValue(':date_birth', $date, PDO::PARAM_STR);



         // Exécution de la requête
         $query->execute();

         // Fermeture du curseur : la requête peut être de nouveau exécutée
         $query->closeCursor();
        
         // redirection vers la page de co 

         header("Location: index.php");

        } else {
         echo 'Les mots de passe ne correspondent pas. Veuillez réessayer.';
        }
        } else {
        echo "Adresse e-mail incorrecte";
        }

    }


?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body><main>
<?php require("include/header.php")
?>

<form class="inscription"action="" method="POST" class="sign-up">
        
        <h1>Formulaire d'inscription</h1>
    
        <br>

        <div class="centre">
        <label for="surname">Entrer votre nom :</label><br>
        <input class="form" type="text" id="surname" name="userSurname">
        </div>
        
        <br>

        <div class="centre">
        <label for="name">Entrer votre prenom :</label><br>
        <input class="form" type="text" id="name" name="userName">
        </div> 

        <br>

        <div class="centre">
        <label for="email">Entrer votre adresse email :</label><br>
        <input class="form" type="email" name="userEmail">
        </div> 
         
        <br>

        <div class="centre">
        <label for="date">Entrer votre date de naissance :</label><br>
        <input class="form" type="date" name="date">
        </div> 
        <br>
        
    
    
        <div class="centre">
         <label for="password">Entrer votre mot de passe :</label><br>
         <input class="form" type="password" id="password" name="userPassword">
        </div>

        <br>
        
        <div class="centre">
        <label for="password2">Entrer de nouveau votre mot de passe :</label><br>
        <input class="form" type="password" name="userPassword2">
        </div>
        
        <br>
        
        <br>
        
        <div class="space">
         <button id="inscription" type="submit">Inscription </button>
        </div>
        
    
    
    </form> 


<div class="footer">Tous droits réservés à moi.</div>
</main>
</body>
</html>