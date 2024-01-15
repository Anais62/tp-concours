    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
        <style>
            body {
                background-color: black;
                color: #00E700;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                overflow: hidden; /* Pour éviter le défilement horizontal */
                margin: 0; /* Supprime la marge par défaut du body */
            }

            h1 {
                font-size: 90px;
                background-color: rgba(149, 165, 166, 0.8);
                z-index: 2;
                border-radius: 20px;
            }

            .hack {
                position: absolute;
                font-size: 26px;
                animation: moveHack 3s linear infinite; /* Ajout de l'animation */
            }
            #motion{
                z-index: 10;
            }
            #motion img{
                height: 280px;
                width: 280px;
                border-radius:60%;
            }

            @keyframes moveHack {
                0% {
                    transform: translateX(-10%); /* Départ à gauche de l'écran */
                }
                50% {
                    transform: translateX(10%); /* Fin à droite de l'écran */
                }
                100%{
                    transform: translateX(-10%);
                }
            }
        </style>
    </head>
    <body><div id="motion">
  <img id="motion-object" src="image/axel.png">
</div>  
        <div class="hack">
            <?php
                for ($i=0; $i < 702; $i++) { 
                    if ($i %22 === 0) {
                        echo "<br>";
                    }
                    echo "Hackbyfabfab";
                }
            ?>
        </div>
        <h1>Hack by fabrice</h1>
    </body>
    </html>
