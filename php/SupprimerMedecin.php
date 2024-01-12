<?php
    include("ConnexionBD.php");
    include("FonctionsUtiles.php");

    $vPrenom=$_GET['prenom'];
    $vNom=$_GET['nom'];
    $idMedecin=getMedecinID($vNom,$vPrenom);

    try {
        $reqClient = $linkpdo->prepare('SELECT * FROM client WHERE IdMedecin=:idMedecin');
        $reqClient->execute(array(
            'idMedecin' => $idMedecin
        ));
        while ($row = $reqClient->fetch(PDO::FETCH_ASSOC)) {
            $idClient = $row['IdClient'];
            $reqModifierClient = $linkpdo->prepare('UPDATE client SET IdMedecin=:idMedecin WHERE IdClient=:idClient');
            $reqModifierClient->execute(array(
                'idMedecin' => NULL,
                'idClient' => $idClient
            ));
        
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la modification du client : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    try {
        $reqSupprimerRDV = $linkpdo->prepare('DELETE FROM rendezvous WHERE IdMedecin=:idMedecin');
        $reqSupprimerRDV->execute(array(
            'idMedecin' => $idMedecin
        ));
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du rendez-vous : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    try{
        $req = $linkpdo->prepare('DELETE FROM medecin 
                            WHERE Prenom=:vPrenom AND Nom=:vNom'); 
     
        $req->execute(array(
            'vPrenom' => $vPrenom,
            'vNom' => $vNom,
        ));

        header("Location: AffichageMedecin.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du médecin : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>
