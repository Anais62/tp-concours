<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use Dompdf\Dompdf; 
require_once 'include/dompdf/autoload.inc.php';
require 'connexionBDD.php';
session_start();

$dompdf = new Dompdf();
$sql ="SELECT * FROM `adress` WHERE id_user = :id_user" ;
$query = $db->prepare($sql);
$query->bindValue(':id_user', $_SESSION["id"], PDO::PARAM_STR);
$query->execute();
$adress = $query->fetch(PDO::FETCH_ASSOC);
$query->closeCursor();

$sql2 ="SELECT * FROM `user` WHERE id = :id_user" ;
$query2 = $db->prepare($sql2);
$query2->bindValue(':id_user', $_SESSION["id"], PDO::PARAM_STR);
$query2->execute();
$utilisateur = $query2->fetch(PDO::FETCH_ASSOC);
$query2->closeCursor();

$imagePath = 'image/notess.png';

// Lire le contenu de l'image
$imageData = file_get_contents($imagePath);

// Encoder en base64
$base64 = base64_encode($imageData);

// Créer la balise image directement dans le code HTML du PDF
$test = '<img src="data:image/png;base64,' . $base64 . '" style="float: right; margin: 10px; height: 100px">';

$test .= "Nom : ".$utilisateur["surname"]." ". $utilisateur["name"]."<br>
Adresse : ".$adress["adress"]."<br>"."       " .$adress["postal_code"] ." ".$adress["city"]."<br><br><br><br><br><center><h1>FACTURE</h1></center><br><br><br>";

// Ajoutez un tableau avec les détails de la facture
$test .= '<table border="1" style="width:100%;text-align:center;">
            <tr>
                <th>Description</th>
                <th>Montant</th>
            </tr>
            <tr>
                <td>Frais d\'inscription au concours de chant</td>
                <td>50,00 €</td>
            </tr>
        </table>';

// Ajoutez un espace supplémentaire
$test .= '<br>';

// Ajoutez "Fait à Longuenesse" avec la date du jour
$test .= '<div style="text-align:right;">Fait à Longuenesse, le ' . date('Y-m-d') . '</div>';   

$html = '<html><body>' . $test . '</body></html>';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

try {
    $dompdf->render();
} catch (\Exception $e) {
    echo 'Une erreur s\'est produite lors du rendu : ' . $e->getMessage();
}

try {
    $dompdf->stream('Facture_'.$utilisateur["surname"]."_". $utilisateur["name"].'.pdf');
} catch (\Exception $e) {
    echo 'Une erreur s\'est produite : ' . $e->getMessage();
}
?>
