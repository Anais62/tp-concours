<?php
session_start();
require('connexionBDD.php'); // Assurez-vous d'inclure votre fichier de connexion à la base de données

if ($_SESSION["admin"] !== 1) {
    header("Location: reglement.php");
    exit(); // Assurez-vous de terminer le script après la redirection
}
if (isset($_POST['confirmer_suppression']) && !empty($_POST['confirmer_suppression'])) {
    $userid = $_POST['confirmer_suppression'];

    // Supprimer la tâche de la base de données
    $sqlDelete = "UPDATE user SET status = status -1 WHERE id = :userid";
    $queryDelete = $db->prepare($sqlDelete);
    $queryDelete->bindValue(":userid", $userid, PDO::PARAM_INT);
    $queryDelete->execute();
    
    $sql = "DELETE FROM  `selected_songs` WHERE `user_id` = :userid";
    $query = $db->prepare($sql);
    $query->bindValue(":userid", $userid, PDO::PARAM_INT);
    $query->execute();
}
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    $useid = $_POST["user_id"];
    $sqlUpdate = "UPDATE user SET status = status +1 WHERE id = :useid";
    $queryUpdate = $db->prepare($sqlUpdate);
    $queryUpdate->bindValue(":useid",$useid, PDO::PARAM_INT);
    $queryUpdate->execute();
}
// POUR LES MINEUR 
else if (isset($_POST['user_id2']) && !empty($_POST['user_id2'])) {
    $useid = $_POST["user_id2"];
    $sqlUpdate = "UPDATE user SET status = 0 WHERE id = :useid";
    $queryUpdate = $db->prepare($sqlUpdate);
    $queryUpdate->bindValue(":useid",$useid, PDO::PARAM_INT);
    $queryUpdate->execute();
    
        
        $sqlUpdate = "UPDATE parental_consent SET status_parent = 1 WHERE id_user = :useid";
        $queryUpdate = $db->prepare($sqlUpdate);
        $queryUpdate->bindValue(":useid",$useid, PDO::PARAM_INT);
        $queryUpdate->execute();
    
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <style>
    body {
    overflow-x: hidden;
  }</style>
<div class="main">
    
    <?php require("include/header.php") ?>
    
    <div class="secretaire">
        <h1>En attente de validation de la chanson</h1>
    </div><div id="motion">
  <img id="motion-object" src="https://lostatsea.neocities.org/assets/fliege.png">
</div>  
    
    <?php
    $sql = "SELECT * FROM user WHERE status = 1;";
    $queryUsers = $db->query($sql);

    // Tableau pour stocker les utilisateurs avec leurs chansons
    $usersArray = [];

    // Récupérer les utilisateurs avec leurs chansons
    while ($user = $queryUsers->fetch(PDO::FETCH_ASSOC)) {
        $sqlBirthYear = "SELECT YEAR(date_birth) as year_of_birth FROM `user` WHERE id = :id";
        $queryBirthYear = $db->prepare($sqlBirthYear);
        $queryBirthYear->bindValue(":id", $user["id"], PDO::PARAM_STR);
        $queryBirthYear->execute();
        $userData = $queryBirthYear->fetch(PDO::FETCH_ASSOC);

        // Récupérer la chanson associée à cet utilisateur
        $sqlSong = "SELECT * FROM selected_songs WHERE user_id = :user_id";
        $querySong = $db->prepare($sqlSong);
        $querySong->bindValue(":user_id", $user["id"], PDO::PARAM_STR);
        $querySong->execute();
        $userSong = $querySong->fetch(PDO::FETCH_ASSOC);

        // Ajouter les données dans le tableau
        $usersArray[] = [
            'Nom' => $user['surname'],
            'Prenom' => $user['name'],
            'Age' => 2024 - $userData['year_of_birth'],
            'Chanson' => $userSong,
            'UserId' => $user['id']
        ];
    }

    // Afficher le tableau
    echo '<table border="1">';
    echo '<tr><th>Nom</th><th>Prenom</th><th>Age</th><th>Chanson</th><th>Artiste</th><th>Valider</th><th>Supprimer</th></tr>';
    foreach ($usersArray as $user) {
        echo '<tr>';
        echo '<td>' . $user['Nom'] . '<span>Nom</span></td>';
        echo '<td>' . $user['Prenom'] . '<span>Prenom</span></td>';
        echo '<td>' . $user['Age'] . '<span>Age</span></td>';
        echo '<td>' . $user['Chanson']['song_title'] . '<span>Titre musique</span></td>';
        echo '<td>' . $user['Chanson']['subtitle'] . '<span>Artiste musique</span></td>';
        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="user_id" value="' . $user['UserId'] . '">';
        echo '<button type="submit" name="valider">Valider</button>';
        echo '</form>';
        echo '</td>';
        echo '<td class="suppbtn">';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="confirmer_suppression" value="' . $user['UserId'] . '">';
        echo '<button id="red" type="submit" name="supprimer">Supprimer</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    ?>

    <br>
    <div class="secretaire">
        <h1>En attente de validation pour le paiement</h1>
    </div>
    <br><br>
    <?php
    $sql = "SELECT * FROM user WHERE status = 2;";
    $queryUsers = $db->query($sql);

    // Tableau pour stocker les utilisateurs avec leurs chansons
    $usersArray = [];

    // Récupérer les utilisateurs avec leurs chansons
    while ($user = $queryUsers->fetch(PDO::FETCH_ASSOC)) {
        $sqlBirthYear = "SELECT YEAR(date_birth) as year_of_birth FROM `user` WHERE id = :id";
        $queryBirthYear = $db->prepare($sqlBirthYear);
        $queryBirthYear->bindValue(":id", $user["id"], PDO::PARAM_STR);
        $queryBirthYear->execute();
        $userData = $queryBirthYear->fetch(PDO::FETCH_ASSOC);

        // Récupérer la chanson associée à cet utilisateur
        $sqlSong = "SELECT * FROM selected_songs WHERE user_id = :user_id";
        $querySong = $db->prepare($sqlSong);
        $querySong->bindValue(":user_id", $user["id"], PDO::PARAM_STR);
        $querySong->execute();
        $userSong = $querySong->fetch(PDO::FETCH_ASSOC);

        // Ajouter les données dans le tableau
        $usersArray[] = [
            'Nom' => $user['surname'],
            'Prenom' => $user['name'],
            'Age' => 2024 - $userData['year_of_birth'],
            'Chanson' => $userSong,
            'UserId' => $user['id']
        ];
    }

    // Afficher le tableau
    // Afficher le tableau
    echo '<table border="1">';
    echo '<tr><th>Nom</th><th>Prenom</th><th>Valider</th><th>Supprimer</th></tr>';
    foreach ($usersArray as $user) {
        echo '<tr>';
        echo '<td>' . $user['Nom'] . '<span>Nom</span></td>';
        echo '<td>' . $user['Prenom'] . '<span>Prenom</span></td>';
        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="user_id" value="' . $user['UserId'] . '">';
        echo '<button type="submit" name="valider">Valider</button>';
        echo '</form>';
        echo '</td>';
        echo '<td class="suppbtn">';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="confirmer_suppression" value="' . $user['UserId'] . '">';
        echo '<button id="red" type="submit" name="supprimer">Supprimer</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    ?>

    <br>

    <div class="secretaire">
        <h1>En attente de validation pour les mineurs</h1>
    </div>
    <br><br>

    
    <?php
    $sql = "SELECT * FROM user WHERE status = -1;";
    $queryUsers = $db->query($sql);

    // Tableau pour stocker les utilisateurs avec leurs chansons
    $usersArray = [];

    // Récupérer les utilisateurs avec leurs chansons
    while ($user = $queryUsers->fetch(PDO::FETCH_ASSOC)) {
        $sqlBirthYear = "SELECT YEAR(date_birth) as year_of_birth FROM `user` WHERE id = :id";
        $queryBirthYear = $db->prepare($sqlBirthYear);
        $queryBirthYear->bindValue(":id", $user["id"], PDO::PARAM_STR);
        $queryBirthYear->execute();
        $userData = $queryBirthYear->fetch(PDO::FETCH_ASSOC);

        // Récupérer la chanson associée à cet utilisateur
        $sqlSong = "SELECT * FROM selected_songs WHERE user_id = :user_id";
        $querySong = $db->prepare($sqlSong);
        $querySong->bindValue(":user_id", $user["id"], PDO::PARAM_STR);
        $querySong->execute();
        $userSong = $querySong->fetch(PDO::FETCH_ASSOC);

        $sqlParental="SELECT * FROM parental_consent WHERE id_user= :id_user";
        $queryParental= $db->prepare($sqlParental);
        $queryParental->bindValue(":id_user", $user["id"], PDO::PARAM_STR);
        $queryParental->execute();
        $userParental = $queryParental->fetch(PDO::FETCH_ASSOC);


        // Ajouter les données dans le tableau
        $usersArray[] = [
            'Nom' => $user['surname'],
            'Prenom' => $user['name'],
            'Age' => 2024 - $userData['year_of_birth'],
            'Chanson' => $userSong,
            'UserId' => $user['id']
        ];
    }

    // Afficher le tableau
    
    echo '<table border="1">';
    echo '<tr><th>Nom</th><th>Prenom</th><th>Age</th><th>Email parent</th><th>Nom parent</th><th>Numero parent</th><th>Valider</th><th>Supprimer</th></tr>';
    foreach ($usersArray as $user) {
        echo '<tr>';
        echo '<td>' . $user['Nom'] . '<span>Nom</span></td>';
        echo '<td>' . $user['Prenom'] . '<span>Prenom</span></td>';
        echo '<td>' . $user['Age'] . '<span>Age</span></td>';
        echo '<td>' . $userParental['email'] . '<span>Email Parent</span></td>';
        echo '<td>' . $userParental['surname'] . '<span>Nom parent</span></td>';
        echo '<td>0' . $userParental['phone_number'] . '<span>Numero de téléphone</span></td>';
        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="user_id2" value="' . $user['UserId'] . '">';
        echo '<button type="submit" name="valider2">Valider</button>';
        echo '</form>';
        echo '</td>';
        echo '<td class="suppbtn">';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="confirmer_suppression" value="' . $user['UserId'] . '">';
        echo '<button id="red" type="submit" name="supprimer">Supprimer</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        
        
    }
    echo '</table>';

    ?>
    <div class="secretaire">
        <h1>LES PARTICIPANTS</h1>
    </div>
    <br><br>

    <?php

    $sql = "SELECT * FROM user WHERE status = 3;";
    $queryUsers = $db->query($sql);

    // Tableau pour stocker les utilisateurs avec leurs chansons
    $usersArray = [];

    // Récupérer les utilisateurs avec leurs chansons
    while ($user = $queryUsers->fetch(PDO::FETCH_ASSOC)) {
        $sqlBirthYear = "SELECT YEAR(date_birth) as year_of_birth FROM `user` WHERE id = :id";
        $queryBirthYear = $db->prepare($sqlBirthYear);
        $queryBirthYear->bindValue(":id", $user["id"], PDO::PARAM_STR);
        $queryBirthYear->execute();
        $userData = $queryBirthYear->fetch(PDO::FETCH_ASSOC);

        $sqlBande = "SELECT * FROM soundtrack WHERE id_user = :id";
        $queryBande = $db->prepare($sqlBande);
        $queryBande->bindValue(":id", $user["id"], PDO::PARAM_INT);
        $queryBande->execute();
        $userBande = $queryBande->fetch(PDO::FETCH_ASSOC);

        // Ajouter les données dans le tableau
        $usersArray[] = [
            'Nom' => $user['surname'],
            'Prenom' => $user['name'],
            'Email' => $user['email'],
            'Age' => 2024 - $userData['year_of_birth'],
            'Bandeson' => $userBande['tape'],
            'UserId' => $user['id']
        ];

    }
    echo '<table border="1">';
    echo '<tr><th>Email</th><th>Nom</th><th>Prenom</th><th>Age</th><th>Bande son</th><th>ID</th>';
    foreach ($usersArray as $user) {
        echo '<tr>';
        
        echo '<td>' . $user['Email'] . '<span>Email</span></td>';
        echo '<td>' . $user['Nom'] . '<span>Nom</span></td>';
        echo '<td>' . $user['Prenom'] . '<span>Prenom</span></td>';
        
        echo '<td>' . $user['Age'] . '<span>Age</span></td>';
        if(empty($user["Bandeson"])) {
            echo '<td> PAS DE BANDE SON </td>';
        }else {
            echo '<td><a href='.$user['Bandeson'].'>' . $user['Bandeson'] . '</a></td>';
        }
        
        echo '<td>' . $user['UserId'] . '<span>ID_USER</span></td>';
        echo '</tr>';
        
        
    }
    echo '</table>';
    ?>

    <br>
    
    
</div>
</body>
</html>
