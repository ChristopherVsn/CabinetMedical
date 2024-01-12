<?php
    include("ConnexionBD.php");
    include("FonctionsUtiles.php");
    $vNumSecuriteSocial=$_GET['numSecuriteSocial'];
    $vCivilite=$_GET['civilite'];
    $vPrenom=$_GET['prenom'];
    $vNom=$_GET['nom'];
    $vVille=$_GET['ville'];
    $vCodePostal=$_GET['codePostal'];
    $vAdresse=$_GET['adresse'];
    $vDateNaissance=$_GET['dateNaissance'];
    $vLieuNaissance=$_GET['lieuNaissance'];
    $vTelephone=$_GET['telephone'];
    try {
        $idClient=getClientID($vNom,$vPrenom);
        $reqSupprimerRDV = $linkpdo->prepare('DELETE FROM rendezvous WHERE IdClient=:idClient');
        $reqSupprimerRDV->execute(array(
            'idClient' => $idClient
        ));
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du rendez-vous : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    try {
        $req = $linkpdo->prepare('DELETE FROM client 
                                WHERE NumSecuriteSocial=:vNumSecuriteSocial AND Civilite=:vCivilite AND Prenom=:vPrenom AND Nom=:vNom
                                AND Ville=:vVille AND CodePostal=:vCodePostal AND Adresse=:vAdresse AND DateNaissance=:vDateNaissance AND LieuNaissance=:vLieuNaissance AND Telephone=:vTelephone');
        $req->execute(array(
            'vNumSecuriteSocial' => $vNumSecuriteSocial,
            'vCivilite' => $vCivilite,
            'vPrenom' => $vPrenom,
            'vNom' => $vNom,
            'vVille' => $vVille,
            'vCodePostal' => $vCodePostal,
            'vAdresse' => $vAdresse,
            'vDateNaissance' => $vDateNaissance,
            'vLieuNaissance' => $vLieuNaissance,
            'vTelephone' => $vTelephone
        ));
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du client : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
        header("Location: AffichageClient.php");
        exit;
?>
