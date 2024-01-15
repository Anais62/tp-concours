    <?php
    require('connexionBDD.php');
    session_start();
    $sql = "SELECT * FROM `user` WHERE id = :id";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $_SESSION['id'], PDO::PARAM_STR);
    $query->execute();
    $verifEmail = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION["status"] = $verifEmail["status"];
    $statu = $_SESSION["status"];

    $id = $_SESSION['id'];
    $prenom = $_SESSION["name"];
    $anneeActuelle = 2024;
    $age = $anneeActuelle - $_SESSION["age"];

    $sql = "SELECT * FROM `parental_consent` WHERE id_user = :id";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $_SESSION['id'], PDO::PARAM_STR);
    $query->execute();
    $parent_consent = $query->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM `song` WHERE id_user = :id";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $_SESSION['id'], PDO::PARAM_STR);
    $query->execute();
    $song = $query->fetch(PDO::FETCH_ASSOC);

    if ($age < 16) {

        $sql2 = "UPDATE `user` SET `status`=-100 WHERE `id`=:userId";
        $query = $db->prepare($sql2);
        $query->bindValue(":userId", $id, PDO::PARAM_INT);
        $query->execute();
        $_SESSION["status"] = -100;
        header("Location: Banni.php");
    }
    if ($age >= 16 && $age < 18) {
        if ($parent_consent["status_parent"] == 1) {
        } else {
            $sql2 = "UPDATE `user` SET `status`=-1 WHERE `id`=:userId";
            $query = $db->prepare($sql2);
            $query->bindValue(":userId", $id, PDO::PARAM_INT);
            $query->execute();
            $_SESSION["status"] = -1;
            header("Location: mineur.php");
        }
    }

    if ($statu == 1) {
        header("Location: enattente.php");
    } elseif ($statu == -1) {
        header("Location: mineur.php");
    } else if ($statu == 2) {
        header("Location: paiement.php");
    } elseif ($statu == 3) {
        header("Location: inscriptionconfirmer.php");
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
        <main>

            <?php require("include/header.php"); ?>

          
    <div class="maincentre">

    
            <div class="chanson">

            <div id="progression">
	<span class="etape fait">
		1<div class="desc">Étape 1</div>
	</span><span class="ligne">
	</span><span class="etape">
		2<div class="desc">Étape 2</div>
	</span><span class="ligne">
	</span><span class="etape">
		3<div class="desc">Étape 3</div>
	</span><span class="ligne">
	</span><span class="etape">
		4<div class="desc">Étape 4</div>
	</span>
</div>
                
                    <label for="chanson">
                        <h1>Veuillez choisir votre chanson pour participer au concours :</h1>
                    </label>
                    <br>
                    <div class="textsong">
                        <input type="text" class="search form green" id="chosenSong" placeholder="Entrez votre musique, titre, artiste" autofocus>
                        <button id="musiquesearch" class="seachartist green">Chercher votre musique !!</button><br><br><br>
                    </div>
                    <div class="songselect">
                        <select id="chanson" name="chanson">
                            <option value="none" selected>Choisissez votre chanson !!</option>
                            <!-- Les options seront ajoutées dynamiquement ici -->
                        </select>
                        <form action="" method="post">
                            <button class="green" type="submit" onclick="saveSelectedSong()">Valider votre choix</button>
                        </form>
                    
                </div>
                <div class="test">
                    <div class="test2"></div>
                </div>
                <?php 
                if ($song['statu']===2) {
                    echo'<span class="redd">Erreur son déja choisi</span>';
                    header("Location: musique_choisi.php");
                }
                ?>
            </div>
    </div>
            

        </main>

        <script>
            let serchtext = document.querySelector('.search');
            let boutton = document.querySelector('.seachartist');
            let selectElement = document.getElementById('chanson');
            let testDiv = document.querySelector('.test2');
            let audioPlayer = document.getElementById('audioPlayer');
            let audioPreview = document.getElementById('audioPreview');

            


            const options = {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': '9bbcd9bb3amsh50354b461de6f3bp158ad8jsnf8e789b397f7',
                    'X-RapidAPI-Host': 'shazam.p.rapidapi.com'
                }
            };
            let valueInput;

            boutton.addEventListener('click', function () {
                valueInput = serchtext.value.replaceAll(' ', '%20');
                console.log(valueInput);
                testDiv.style.display = "flex"
                getData();


            });

            async function getData() {
                try {
                    
                    selectElement.innerHTML = '';
                    const url = 'https://shazam.p.rapidapi.com/search?term=' + valueInput + '&locale=en-US&offset=0&limit=5';
                    const response = await fetch(url, options);
                    const result = await response.json();
                    console.log(result);
                    for (let index = 0; index < result.tracks.hits.length; index++) {
                        const track = result.tracks.hits[index].track;
                        const option = document.createElement('option');
                        option.value = track.title + ' - ' + track.subtitle;
                        option.text = track.title + ' - ' + track.subtitle;
                        option.setAttribute('data-track', JSON.stringify(track));
                        option.setAttribute('data-audio-url', track.preview);
                        selectElement.appendChild(option);
                    
                    }
                    displayImage(result.tracks.hits[0].track.images.coverart, result.tracks.hits[0].track.title, result.tracks.hits[0].track.subtitle, result.tracks.hits[0].track.url);
                } catch (error) {
                    console.error(error);
                }
            }

            function saveSelectedSong() {
                const selectedOption = document.getElementById('chanson');
                const chosenSong = selectedOption.value;
                const subtitle = selectedOption.options[selectedOption.selectedIndex].getAttribute('data-subtitle');
                const userId = <?php echo $id; ?>;


                // Envoi des données à PHP pour traitement et insertion dans la base de données
                fetch('save_selected_song.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            userId: userId,
                            chosenSong: chosenSong,
                            subtitle: subtitle,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }

            function displayImage(imageUrl, title, subtitle, urlo) {
                testDiv.innerHTML = "<img class='imgselect' src='" + imageUrl + "' alt='Image de la chanson' height='200px'>";
                testDiv.innerHTML += "<h2>"+ title +"</h2>";
                testDiv.innerHTML += "<h3>"+ subtitle +"</h3>";
                // Ajouter une balise audio pour la prévisualisation audio
                testDiv.innerHTML += "<audio controls id='audioPreview' >Votre navigateur ne supporte pas l'élément audio.</audio>";

                testDiv.innerHTML += "<button controls class='green' onclick='urlopen(\"" + urlo + "\")'>Visiter le site</button>";
                testDiv.innerHTML += "<img src='image/fleche-droite.png'' id='previous' onclick='previous()'> ";
                testDiv.innerHTML += "<img src='image/fleche-droite.png' id='next' onclick='next()'> ";

            }
            function previous() {
    let selectedIndex = selectElement.selectedIndex;
    // Pour pas que sa fasse d'erreur si on est a la premiere musique
    let previousIndex = (selectedIndex - 1 + selectElement.options.length) % selectElement.options.length;
    selectElement.selectedIndex = previousIndex;
    
    // Récupérez les informations de la piste sélectionnée
    let selectedOption = selectElement.options[previousIndex];
    let track = JSON.parse(selectedOption.getAttribute('data-track'));
    
    // Affichez les détails de la nouvelle piste
    displayImage(track.images.coverart, track.title, track.subtitle, track.url);
}


    function next() {
        let selectedIndex = selectElement.selectedIndex;
        //Pareil que en haut
        let nextIndex = (selectedIndex + 1) % selectElement.options.length;
        selectElement.selectedIndex = nextIndex;
        
        // Récupérez les informations de la piste sélectionnée
        let selectedOption = selectElement.options[nextIndex];
        let track = JSON.parse(selectedOption.getAttribute('data-track'));
        
        // Affichez les détails de la nouvelle piste
        displayImage(track.images.coverart, track.title, track.subtitle, track.url);
    }
            
            // if (audioPreview !== null) {
            //     audioPreview.addEventListener("click", function () {
            //         urlopen()
            //     })
            // }


            function urlopen(urlmusique) {
                console.log(urlmusique);
                console.log("test");
                open(urlmusique)
                    }        
            selectElement.addEventListener('change', function () {
                let selectedOption = selectElement.options[selectElement.selectedIndex];
                let track = JSON.parse(selectedOption.getAttribute('data-track'));
                displayImage(track.images.background, track.title, track.subtitle, track.url);
            });
        </script>
    </body>

    </html>
