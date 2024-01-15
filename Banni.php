<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <audio class="pleure" src="audio/bebe_qui_pleure.mp3"></audio>
   <center> <h1>BAN vous êtes trop petit</h1>
    
    <img class="bb" src="image/bebe.gif">
        <h1>Cliquez sur le bébé si vous n'en êtes plus un !</h1><center>
        <?php 
        for ($i=0; $i <100 ; $i++) { 
            if ($i % 3 == 0) {
                echo "<br>";
            } 
            echo $_SESSION["name"] ." EST UN BB ";  
            
        }
        
        
        
        ?>
<script>
            let bb = document.querySelector(".bb")
let pleure = document.querySelector(".pleure")

bb.addEventListener('click',function () {
    pleure.play();
    console.log("MUSIQUE");
    
})

</script>
</body>
</html>