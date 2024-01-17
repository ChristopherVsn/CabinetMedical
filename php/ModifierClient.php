<?php
include("ConnexionBD.php");   
include("VerificationConnexion.php");
include("FonctionsUtiles.php");

$vNumSecuriteSocial = $_GET['numSecuriteSocial'];
$vCivilite = $_GET['civilite'];
$vPrenom = $_GET['prenom'];
$vNom = $_GET['nom'];
$vVille = $_GET['ville'];
$vCodePostal = $_GET['codePostal'];
$vAdresse = $_GET['adresse'];
$vDateNaissance = $_GET['dateNaissance'];
$vLieuNaissance = $_GET['lieuNaissance'];
$vTelephone = $_GET['telephone'];
if (isset($_GET['idMedecin'])) {
    $vIdMedecin = $_GET['idMedecin'];
} else {
    $vIdMedecin = NULL;
}

if (isset($_POST['numSecuriteSocial'])) {
    $vPrenom = $_POST['prenomA'];
    $vNom = $_POST['nomA'];

    $vNouvNumSecuriteSocial = $_POST['numSecuriteSocial'];
    $vNouvCivilite = $_POST['civilite'];
    $vNouvPrenom = $_POST['prenom'];
    $vNouvNom = $_POST['nom'];
    $vNouvVille = $_POST['ville'];
    $vNouvCodePostal = $_POST['codePostal'];
    $vNouvAdresse = $_POST['adresse'];
    $vNouvDateNaissance = $_POST['dateNaissance'];
    $vNouvLieuNaissance = $_POST['lieuNaissance'];
    $vNouvTelephone = $_POST['telephone'];

try {
    $vIdClient=getClientID($vNom,$vPrenom);
    $req = $linkpdo->prepare('UPDATE client SET NumSecuriteSocial=:nouvNumSecuriteSocial, Civilite=:nouvCivilite,
        Prenom=:nouvPrenom, Nom=:nouvNom, Ville=:nouvVille, CodePostal=:nouvCodePostal, Adresse=:nouvAdresse, DateNaissance=:nouvDateNaissance, LieuNaissance=:nouvLieuNaissance, Telephone=:nouvTelephone, IdMedecin=:nouvIdMedecin WHERE
        IdClient=:vIdClient');
    if ($req == false) {
        throw new Exception("Erreur sur la requête de modification");
    } else {

        if ($_POST['medecin'] == "") {
            $vNouvIdMedecin = NULL;
        } else {
            $nomMedecin = explode(" ", $_POST['medecin'])[0];
            $prenomMedecin = explode(" ", $_POST['medecin'])[1];
            $vNouvIdMedecin = getMedecinID($nomMedecin, $prenomMedecin);
        }
        $req->execute(array(
            'nouvNumSecuriteSocial' => $vNouvNumSecuriteSocial,
            'nouvCivilite' => $vNouvCivilite,
            'nouvPrenom' => $vNouvPrenom,
            'nouvNom' => $vNouvNom,
            'nouvVille' => $vNouvVille,
            'nouvCodePostal' => $vNouvCodePostal,
            'nouvAdresse' => $vNouvAdresse,
            'nouvDateNaissance' => $vNouvDateNaissance,
            'nouvLieuNaissance' => $vNouvLieuNaissance,
            'nouvTelephone' => $vNouvTelephone,
            'nouvIdMedecin' => $vNouvIdMedecin,
            'vIdClient' => $vIdClient,
        ));
    }
        echo "<script>
                alert('Le client a été modifié avec succès.');
                window.location.href = 'AffichageClient.php';
              </script>";
        } catch (PDOException $e) {
        echo "Erreur lors de la modification du client : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
include("../html/Header.html"); // On doit include le header ici car sinon l'html empêche le header(Location :AffichageClient)
?>

<link rel="stylesheet" href="../css/Form.css">
<link rel="stylesheet" href="../css/autocomplete.css">
</header>
<body>
    <h1>Modification du client</h1>
    <p>Modifier les champs que vous souhaitez puis cliquez sur "modifier"</p>
    <form class="container" action="ModifierClient.php" method="post">
        <label for="numSecuriteSocial">Numéro sécurité sociale :</label>
        <input type="text" id="numSecuriteSocial" name="numSecuriteSocial" maxlength="30" value="<?php echo $vNumSecuriteSocial; ?>">
        <input type="hidden" id="numSecuriteSocialA" name="numSecuriteSocialA" value="<?php echo $vNumSecuriteSocial; ?>">
        <br />

        <label for="civilite">Civilité :</label>
        <input type="text" id="civilite" name="civilite" maxlength="30" value="<?php echo $vCivilite; ?>">
        <input type="hidden" id="civiliteA" name="civiliteA" value="<?php echo $vCivilite; ?>">
        <br />

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" maxlength="30" value="<?php echo $vPrenom; ?>">
        <input type="hidden" id="prenomA" name="prenomA" value="<?php echo $vPrenom; ?>">
        <br />

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" maxlength="30" value="<?php echo $vNom; ?>">
        <input type="hidden" id="nomA" name="nomA" value="<?php echo $vNom; ?>">
        <br />

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" maxlength="30" value="<?php echo $vVille; ?>">
        <input type="hidden" id="villeA" name="villeA" value="<?php echo $vVille; ?>">
        <br />

        <label for="codePostal">Code postal :</label>
        <input type="number" id="codePostal" name="codePostal" maxlength="5" value="<?php echo $vCodePostal; ?>">
        <input type="hidden" id="codePostalA" name="codePostalA" value="<?php echo $vCodePostal; ?>">
        <br />

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo $vAdresse; ?>">
        <input type="hidden" id="adresseA" name="adresseA" value="<?php echo $vAdresse; ?>">
        <br />

        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo $vDateNaissance; ?>">
        <input type="hidden" id="dateNaissanceA" name="dateNaissanceA" value="<?php echo $vDateNaissance; ?>">
        <br />

        <label for="lieuNaissance">Lieu de naissance :</label>
        <input type="text" id="lieuNaissance" name="lieuNaissance" value="<?php echo $vLieuNaissance; ?>">
        <input type="hidden" id="lieuNaissanceA" name="lieuNaissanceA" value="<?php echo $vLieuNaissance; ?>">
        <br />

        <label for="telephone">Téléphone :</label>
        <input type="number" id="telephone" name="telephone" maxlength="10" value="<?php echo $vTelephone; ?>">
        <input type="hidden" id="telephoneA" name="telephoneA" value="<?php echo $vTelephone; ?>">
        <br>
        <?php
        $medecinValue = ($vIdMedecin !== null) ? getNomPrenomMedecin($vIdMedecin) : "";
        ?>
        <label for="medecin">Medecin traitant</label>
        <input type="text" id="autocompletemedecin" name="medecin" value="<?php echo $medecinValue; ?>">
        <input type="hidden" id="medecinA" name="medecinA" value="<?php echo $medecinValue; ?>">
        <br>
        <input type="submit" name="submit" value="Modifier">
    </form>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../js/ResetSession.js"></script>
    <script src="../js/AutocompleteMedecin.js"></script>
</body>
</html>