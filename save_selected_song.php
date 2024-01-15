<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require('connexionBDD.php');

// Récupération des données envoyées en POST
$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['userId'];
$chosenSong = $data['chosenSong'];

// Extraction du titre et du sous-titre
list($title, $subtitle) = explode(' - ', $chosenSong);

$sql = "SELECT * FROM `selected_songs` WHERE `song_title` = :title AND `subtitle` = :subtitle ";
$query = $db->prepare($sql);
$query->bindValue(":title", $title, PDO::PARAM_STR);
$query->bindValue(":subtitle", $subtitle, PDO::PARAM_STR);
$query->execute();
$verifMusique = $query->fetch(PDO::FETCH_ASSOC);
// if ($verifMusique !== false) {
// header("Location: contact.php");
// }

// Insertion des données dans la base de données
if ($verifMusique === false) {
    $sql = "INSERT INTO selected_songs (user_id, song_title, subtitle) VALUES (:userId, :title, :subtitle)";
$query = $db->prepare($sql);
$query->bindValue(":userId", $userId, PDO::PARAM_INT);
$query->bindValue(":title", $title, PDO::PARAM_STR);
$query->bindValue(":subtitle", $subtitle, PDO::PARAM_STR);
$query->execute();

$sql2 = "UPDATE `user` SET `status`=1 WHERE `id`=:userId";
$query = $db->prepare($sql2);
$query->bindValue(":userId", $userId, PDO::PARAM_INT);
$query->execute();

// Réponse à la requête AJAX
echo json_encode(['success' => true]);
}else {
    $sql = "INSERT INTO song (id_user, name_song, artist, statu) VALUES (:userId, :title, :subtitle, :statu)";
    $query = $db->prepare($sql);
    $query->bindValue(":userId", $userId, PDO::PARAM_INT);
    $query->bindValue(":title", $title, PDO::PARAM_STR);
    $query->bindValue(":subtitle", $subtitle, PDO::PARAM_STR);
    $query->bindValue(":statu", 2, PDO::PARAM_INT);
    $query->execute();
    header('Location: contact.php');
}

?>