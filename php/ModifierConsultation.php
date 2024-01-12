<?php
include("ConnexionBD.php");
include("FonctionsUtiles.php");
include("VerificationConnexion.php");

if (isset($_GET['client']) && isset($_GET['medecin']) && isset($_GET['dateRdv']) && isset($_GET['heure']) && isset($_GET['duree'])) {
    $vClient = $_GET['client'];
    $vMedecin = $_GET['medecin'];
    $vDateRdv = $_GET['dateRdv'];
    $vHeure = $_GET['heure'];
    $vDuree = $_GET['duree'];
}

if (isset($_POST['daterdv'])) {
    $vDateRdv = $_POST['daterdvA'];
    $vHeure = $_POST['heureA'];
    $vDuree = $_POST['dureeA'];

    $vNouvDateRdv = $_POST['daterdv'];
    $vNouvHeure = $_POST['heure'];
    $vNouvDuree = $_POST['duree'];
    $vClientInfo = explode(" ", $_POST['client']);
    $vMedecinInfo = explode(" ", $_POST['medecin']);
    $vIdClient = getClientID($vClientInfo[0], $vClientInfo[1]);
    $vIdMedecin = getMedecinID($vMedecinInfo[0], $vMedecinInfo[1]);

    try {
        $req = $linkpdo->prepare('UPDATE rendezvous SET DateRDV=:vNouvDateRdv, Heure=:vNouvHeure, Duree=:vNouvDuree WHERE
            DateRDV=:vDateRdv AND Heure=:vHeure AND Duree=:vDuree AND IdClient=:vIdClient AND IdMedecin=:vIdMedecin');
        if ($req == false) {
            throw new Exception("Erreur sur la requête de modification");
        } else {
            $req->execute(array(
                'vNouvDateRdv' => $vNouvDateRdv,
                'vNouvHeure' => $vNouvHeure,
                'vNouvDuree' => $vNouvDuree,

                'vDateRdv' => $vDateRdv,
                'vHeure' => $vHeure,
                'vDuree' => $vDuree,
                'vIdClient' => $vIdClient,
                'vIdMedecin' => $vIdMedecin
            ));
        }
        echo "<script>
        alert('La consultation a été modifiée avec succès.');
        window.location.href = 'AffichageConsultation.php';
      </script>";    } catch (PDOException $e) {
        echo "Erreur lors de la modification de la consultation : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
include("../html/Header.html");
?>
<link rel="stylesheet" href="../css/Form.css">
</header>
<body>
    <h1>Modification d'une consultation</h1>
    <p>Modifier les champs que vous souhaitez puis cliquez sur "modifier"</p>
    <form class="container" action="ModifierConsultation.php" method="post">
        <label for="client">Client :</label>
        <input type="text" id="client" name="client" maxlength="30" readonly value="<?php echo $vClient; ?>">
        <br />

        <label for="medecin">Medecin :</label>
        <input type="text" id="medecin" name="medecin" maxlength="30" readonly value="<?php echo $vMedecin; ?>">
        <br />

        <label for="daterdv">Date RDV :</label>
        <input type="date" id="daterdv" name="daterdv" maxlength="30" value="<?php echo $vDateRdv; ?>">
        <input type="hidden" id="daterdvA" name="daterdvA" value="<?php echo $vDateRdv; ?>">
        <br />

        <label for="heure">Heure :</label>
        <input type="time" id="heure" name="heure" value="<?php echo $vHeure; ?>">
        <input type="hidden" id="heureA" name="heureA" value="<?php echo $vHeure; ?>">
        <br />

        <label for="duree">Duree :</label>
        <input type="text" id="duree" name="duree" value="<?php echo $vDuree; ?>">
        <input type="hidden" id="dureeA" name="dureeA" value="<?php echo $vDuree; ?>">
        <br />

        <input type="submit" name="submit" value="Modifier">
    </form>
    <script src="../js/ResetSession.js"></script>
</body> 
</html>