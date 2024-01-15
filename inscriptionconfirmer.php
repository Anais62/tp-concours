<?php
session_start();
require('connexionBDD.php');

// On recupere les données envoyées par le formulaire


if (!empty($_POST['adresse']) && !empty($_POST['code_postal']) && !empty($_POST['ville']) ) {
   
//     On récupére les infos du formulaire et en les stockants dans des variables 

   $adresse = $_POST['adresse'];
   $code_postal = $_POST['code_postal'];
   $ville = $_POST['ville'];
   

    // Préparation de la requête
    $requete = 'INSERT INTO adress (id_user, adress, postal_code, city) VALUES (:id_user, :adress, :postal_code, :city)';

    // Création d'un objet PDOStatement
    $query = $db->prepare($requete);

    // Association d'une valeur à un paramètre de l'objet PDOStatement
    $query->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_STR);
    $query->bindValue(':adress', $adresse, PDO::PARAM_STR);
    $query->bindValue(':postal_code', $code_postal, PDO::PARAM_STR);
    $query->bindValue(':city', $ville, PDO::PARAM_STR);
   
     // Exécution de la requête
    $query->execute();

    // Fermeture du curseur : la requête peut être de nouveau exécutée
    $query->closeCursor();
    // header("Location: utilisateur.php");
    // exit();

}
//      On verifie si l'adresse est déjà utilisé
    
$sql = "SELECT * FROM `adress` WHERE id_user = :id_user";
$query = $db->prepare($sql);
$query->bindValue(":id_user", $_SESSION['id'], PDO::PARAM_STR);
$query->execute();
$verifAdress = $query->fetch();

//      On verifie si la bande-son  a déjà été envoyer

$sql = "SELECT * FROM `soundtrack` WHERE id_user = :id_user";
$query = $db->prepare($sql);
$query->bindValue(":id_user", $_SESSION['id'], PDO::PARAM_STR);
$query->execute();
$veriftape = $query->fetch();

//      Si l'adresse mail n'est pas dans la bdd on rentre dans la condition sinon incorrecte
if (isset($_POST["editfacture"])) {
    $sql = "DELETE FROM `adress` WHERE `id_user` = :userid";
    $query = $db->prepare($sql);
    $query->bindValue(":userid", $_SESSION["id"], PDO::PARAM_INT);
    $query->execute();
    header("Location: utilisateur.php");
    exit();
}


 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
    <script src="script.js" defer></script>
</head>
<audio class="music" src="audio/tape.mp3"></audio>
<body><main>
<?php require("include/header.php")
?>
<!-- <div class="progress-bar">
        <div class="step active">Étape 1</div>
        <div class="step active">Étape 2</div>
        <div class="step active">Étape 3</div>
        <div class="step active">Étape 4</div>
        
    </div> -->





<div class="enattentefond2">

<div id="progression">
	<span class="etape fait">
		1<div class="desc">Étape 1</div>
	</span><span class="ligne fait">
	</span><span class="etape fait">
		2<div class="desc">Étape 2</div>
	</span><span class="ligne fait">
	</span><span class="etape fait">
		3<div class="desc">Étape 3</div>
	</span><span class="ligne fait">
	</span><span class="etape fait">
		4<div class="desc">Étape 4</div>
	</span>
</div>
   
    <h1>Felicitations <?php echo $_SESSION['name'];?> !</h1>

    <h1>Votre inscription a bien été prise en compte.</h1> 
    <br>
    
    <img class="approuve"src="image/approuve.png">
    <br>
    <?php if($verifAdress === false) {
        echo '
    Entrer votre adresse ici, si vous souhaitez recevoir une facture :
    <br>
    <form action="" method="post">
    <h2>Saisissez votre d\'Adresse</h2>

    <br>

    <label for="adresse">Adresse :</label>
    <input type="text" id="adresse" name="adresse" required>
    
    <br>
    <br>

    <label for="code_postal">Code Postal :</label>
    <input type="text" id="code_postal" name="code_postal" required>
    <br>
    <br>

    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville" required>

    <br>
    <br>

    <button type="submit">Enregistrer Adresse</button>
    </form>
'; }else{
    echo ("<strong>Votre adresse : </strong><br>");
    echo ("<div class='infosfacture'>". $_SESSION["surname"]." ". $_SESSION["name"]."<br>". $verifAdress["adress"]."<br>". $verifAdress["postal_code"]." ".$verifAdress["city"]."<br>
    <form action='' method='post'>
    <div class='editinfo'>
        <a href='genpdf.php'>
            <button class='editfacture green' name='editfacture' >Modifiez les infos<img src='image/edit2.svg' height=25px></button></a>
            </div></div></form>");
    echo "<br> <a href='genpdf.php'><button class='genfacture'>Télécharger ma facture<img src='image/pdf.svg' height=25px></button></a><br>
    ";
    echo '<h3>Si vous souhaitez jouer en attendant le concour : </h3><br>
    <button onclick='.'"'."window.location.href = 'http://178.33.104.137/site1/projet/js_test/morpion/'".'"'.'>Cliquez ici</button>';
}

?>
<br><br>
<?php
if($veriftape === false) {
    echo '<h3>Si vous souhaitez envoyé votre bande son cliquez ici : </h3>
    <button onclick='.'"'."window.location.href = 'upload_bande_son.php'".'"'.'>Cliquez ici</button>
    <h3>Si vous souhaitez jouer en attendant le concour : </h3><br>
    <button onclick='.'"'."window.location.href = 'http://178.33.104.137/site1/projet/js_test/morpion/'".'"'.'>Cliquez ici</button><br>';
}else {
    
    echo "Votre bande-son a bien été envoyée !";
}
    ?>



</div>

<div class="footer">
Tous droits réservés à moi.
</div>

</main>
</body>
</html>