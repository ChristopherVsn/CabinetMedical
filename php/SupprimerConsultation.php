<?php
    include("ConnexionBD.php");
    include("FonctionsUtiles.php");
    $vClient = $_GET['client'];
    $vMedecin = $_GET['medecin'];
    $vDateRdv = $_GET['dateRdv'];
    $vHeure = $_GET['heure'];
    $vDuree = $_GET['duree'];

    $vClientInfo = explode(" ", $_GET['client']);  
    $vMedecinInfo = explode(" ", $_GET['medecin']);
    $vIdClient = getClientId($vClientInfo[0], $vClientInfo[1]);
    $vIdMedecin = getMedecinId($vMedecinInfo[0], $vMedecinInfo[1]);
   
    try {
        $req = $linkpdo->prepare('DELETE FROM rendezvous 
                            WHERE IdMedecin=:IdMedecin AND IdClient=:IdClient AND DateRDV=:DateRDV AND Heure=:Heure AND Duree=:Duree');

        $req->execute(array(
            'IdMedecin' => $vIdMedecin,
            'IdClient' => $vIdClient,
            'DateRDV' => $vDateRdv,
            'Heure' => $vHeure,
            'Duree' => $vDuree
        ));
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de la consultation : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
        header("Location: AffichageConsultation.php");
        exit;
    
?>
