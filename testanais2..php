$sql = "SELECT * FROM `selected_songs` ";
$query = $db->prepare($sql);
$query->execute();
$parent_consent = $query->fetch(PDO::FETCH_ASSOC);

<?php
session_start();
require('connexionBDD.php');

// Récupération des données envoyées en POST
$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['userId'];
$chosenSong = $data['chosenSong'];

// Extraction du titre et du sous-titre
list($title, $subtitle) = explode(' - ', $chosenSong);

// Insertion des données dans la base de données
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
?>