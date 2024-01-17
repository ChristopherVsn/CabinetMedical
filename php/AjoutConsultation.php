<?php
    include("ConnexionBD.php");
    include("FonctionsUtiles.php");
    include("VerificationConnexion.php");

    if (isset($_POST['Ajouter'])) {
        try {
            $nomPrenomClient = explode(" ", $_POST['client']);
            $client = getClientId($nomPrenomClient[0], $nomPrenomClient[1]);
            $nomPrenomMedecin = explode(" ", $_POST['medecin']);
            $medecin = getMedecinId($nomPrenomMedecin[0], $nomPrenomMedecin[1]);

            insertRendezVous($client, $medecin, $_POST['date'], $_POST['heure'], $_POST['duree']);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo '<script type="text/javascript">
                    alert("Le medecin a déjà un rendez-vous à cette date et heure\n\n Message d\'erreur : '.$msg.'");
                </script>';
        }
        echo "<script>
        alert('Le rendez-vous a été ajouté avec succès.');
            window.location.href = 'affichageConsultation.php';
        </script>";
    }
    include("../html/Header.html");
?>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/Form.css">
    <link rel="stylesheet" href="../css/autocomplete.css">
    <link rel="stylesheet" href="../css/styles.css">
</header>

<body>
    <h1>Ajout d'une consultation</h1>
    <p>Tous les champs doivent être saisis</p>
    <form class="container" action="AjoutConsultation.php" method="post"><br>
        <label for="client" class="form-label">Client </label>
        <input type="text" id="autocomplete" name="client" maxlength="30" class="form-input" required placeholder="Commencez à saisir le nom pour afficher le client">
        <label for="medecin" class="form-label">Medecin </label>
        <input type="text" id="autocompletemedecin" name="medecin" maxlength="30" class="form-input" required placeholder="Commencez à saisir le nom pour afficher le médecin"  >
        <label for="date" class="form-label">DateRDV </label>
        <input type="date" id="date" name="date" class="form-input" required>
        <label for="heure" class="form-label">Heure </label>
        <input type="time" id="heure" name="heure" maxlength="5" placeholder="110000" class="form-input" required>
        <label for="duree" class="form-label">Durée (en minute)</label>
        <input type="number" id="duree" name="duree" placeholder="20" class="form-input" required>
        <input type="reset" value="annuler" name="Annuler" class="form-button">
        <input type="submit" value="valider" name="Ajouter" class="form-button">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../js/Autocomplete.js"></script>
    <script src="../js/AutocompleteMedecin.js"></script>
    <script src="../js/MedecinTraitant.js"></script>
    <script src="../js/ResetSession.js"></script>
</body>

</html>

<?php
    function insertRendezVous($idClient, $idMedecin, $date, $heure, $duree) {
        global $linkpdo;
        $req = $linkpdo->prepare('INSERT INTO rendezvous (IdClient, IdMedecin, DateRDV, Heure, Duree) VALUES (?, ?, ?, ?, ?)');
        $req->execute(array($idClient, $idMedecin, $date, $heure, $duree));
    }
?>
