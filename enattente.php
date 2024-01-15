<?php
session_start();

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

<div class="enattentefond">
<div id="progression">
	<span class="etape fait">
		1<div class="desc">Étape 1</div>
	</span><span class="ligne fait">
	</span><span class="etape fait">
		2<div class="desc">Étape 2</div>
	</span><span class="ligne">
	</span><span class="etape">
		3<div class="desc">Étape 3</div>
	</span><span class="ligne">
	</span><span class="etape">
		4<div class="desc">Étape 4</div>
	</span>
</div>
    <h1>EN ATTENTE de validation de la chanson par la secretaire</h1> 
    <br>
<img class="taper"src="image/taper-clavier-test.gif">

</div>


</main>
</body>
</html>