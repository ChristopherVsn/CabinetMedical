<?php
include("ConnexionBD.php");

$query = $_POST['query'];
$req = $linkpdo->prepare("SELECT CONCAT(nom, ' ', prenom) as label FROM medecin WHERE CONCAT(nom, ' ', prenom) LIKE :query");
$req->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
$req->execute();

$results = $req->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>
