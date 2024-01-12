<?php
include("ConnexionBD.php");

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

$req = $linkpdo->prepare("SELECT medecin.IdMedecin, medecin.Nom AS NomMedecin, medecin.Prenom AS PrenomMedecin FROM client
                LEFT JOIN medecin ON client.IdMedecin = medecin.IDMedecin
                WHERE client.nom LIKE :lastName AND client.prenom LIKE :firstName");
                // le iner join sert à inclure client sans médecin (Ne fonctionne pas sans)
$req->bindValue(':lastName', '%' . $lastName . '%', PDO::PARAM_STR);
$req->bindValue(':firstName', '%' . $firstName . '%', PDO::PARAM_STR);
$req->execute();

$response = $req->fetch(PDO::FETCH_ASSOC);
echo json_encode($response);
?>
