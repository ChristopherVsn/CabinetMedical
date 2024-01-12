<?php

function getMedecinID($nom, $prenom) {
    global $linkpdo;

    try {
        $reqIdMedecin = $linkpdo->prepare("SELECT IdMedecin FROM medecin WHERE nom = :nom AND prenom = :prenom");
        $reqIdMedecin->bindParam(':nom', $nom);
        $reqIdMedecin->bindParam(':prenom', $prenom);
        $reqIdMedecin->execute();
        $medecin = $reqIdMedecin->fetch(PDO::FETCH_ASSOC);

        return $medecin['IdMedecin'];
    } catch (PDOException $e) {
        echo "Erreur lors de la recherche d'IdMedecin : " . $e->getMessage();
        exit;
    }
}

function getClientID($nom, $prenom) {
    global $linkpdo;

    try {
        $reqIdClient = $linkpdo->prepare("SELECT IdClient FROM client WHERE nom = :nom AND prenom = :prenom");
        $reqIdClient->bindParam(':nom', $nom);
        $reqIdClient->bindParam(':prenom', $prenom);
        $reqIdClient->execute();
        $client = $reqIdClient->fetch(PDO::FETCH_ASSOC);

        return $client['IdClient'];
    } catch (PDOException $e) {
        echo "Erreur lors de la recherche d'IdClient : " . $e->getMessage();
        exit;
    }
}
function getNomPrenomMedecin($idMedecin){
    global $linkpdo;
    try {
        $reqNomPrenomMedecin = $linkpdo->prepare("SELECT nom, prenom FROM medecin WHERE IdMedecin = :idMedecin");
        $reqNomPrenomMedecin->bindParam(':idMedecin', $idMedecin);
        $reqNomPrenomMedecin->execute();

        if ($reqNomPrenomMedecin->rowCount() > 0) {
            $medecin = $reqNomPrenomMedecin->fetch(PDO::FETCH_ASSOC);
            return $medecin['nom']." ".$medecin['prenom'];
        } else {
            return "";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la recherche du nom et prénom du médecin : " . $e->getMessage();
        exit;
    }
}

?>
