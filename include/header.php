<?php
session_start();

echo '<div class="navbar">
    <div class="zone1">
        <div id="logo"><img src="image/notess.png"></div>
        
        <div class="item"><a href="index.php">
        <img src="image/bouton-daccueil.png">
        Accueil</a>
        </div>
        
        <div class="item"><a href="presentation.php">
        <img src="image/presentation.png">
        Présentation</a>
        </div>
        
        <div class="item"> <a href="reglement.php"> 
        <img src="image/badge.png">
        Règlement</a>
        </div>';

// Vérifiez si l'utilisateur est administrateur avant d'afficher l'onglet "Admin"
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo '
        <div class="item"><a href="admin.php">
        <img src="image/policier.png">
        Admin</a>
        </div>
        ';
}else{
    echo '
        <div class="item"><a href="contact.php">
        <img src="image/edit2.svg">
        Contact</a>
        </div>
        ';
}

echo '</div>'; // Fermez la première partie de votre div .zone1

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    // Utilisateur connecté, afficher le bouton de déconnexion et son espace
    echo '<div class="disconnect">
           
            
            <form method="post" action="utilisateur.php" class="">
            <button id="monespace" type="submit">Mon espace</button>
            </form>
            
            <form method="post" action="deconnect.php" class="disconnect bg-burgundy">
            <form action="deconnexion.php" method="post">
            <button id="deconnexion" type="submit">Déconnexion</button>
            </form>
            </form>

        </div>';
}

echo '</div>'; // Fermez le div .navbar
?>
