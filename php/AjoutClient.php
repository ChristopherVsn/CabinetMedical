<?php
include("ConnexionBD.php");  
include("VerificationConnexion.php");
include("FonctionsUtiles.php");
if (isset($_POST['Ajouter'])) {
    try {
        $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE NumSecuriteSocial = '" . $_POST['numSecu'] . "'");
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $count = $row['c'];
        if ($count == 0) {
            if ($_POST['medecin'] != "" && !empty($_POST['medecin'])) {
                $nomPrenomMedecin = explode(" ", $_POST['medecin']);
                $idMedecin = getMedecinID($nomPrenomMedecin[0], $nomPrenomMedecin[1]);

                $req = $linkpdo->prepare('INSERT INTO client (nom,prenom,adresse,telephone,ville,codePostal,NumSecuriteSocial,civilite,idMedecin,dateNaissance, lieuNaissance) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
                $req->execute(array($_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['telephone'], $_POST['ville'], $_POST['codePostal'], $_POST['numSecu'], $_POST['civilite'], $idMedecin, $_POST['dateNaissance'], $_POST['lieuNaissance']));
            } else {
                $req = $linkpdo->prepare('INSERT INTO client (nom,prenom,adresse,telephone,ville,codePostal,NumSecuriteSocial,civilite,dateNaissance, lieuNaissance) VALUES(?,?,?,?,?,?,?,?,?,?)');
                $req->execute(array($_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['telephone'], $_POST['ville'], $_POST['codePostal'], $_POST['numSecu'], $_POST['civilite'], $_POST['dateNaissance'], $_POST['lieuNaissance']));
            }
            echo "<script>
                alert('Le client a été ajouté.');
                window.location.href = 'AffichageClient.php';
              </script>";
        }
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        echo "<script>alert('Erreur lors de l\'ajout du client.')</script>";
        
    }

}
include("../html/Header.html");
?>
<link rel="stylesheet" href="../css/Form.css">
<link rel="stylesheet" href="../css/styles.css">
</header>

<body>
    <h1>Ajout d'un client</h1>
    <p>Les champs marqués de <b>*</b> sont obligatoires</p>

    <form class="container" action="AjoutClient.php" method="post"><br>
        <label for="nom">Nom *</label> <input type='text' name='nom' id="nom" required="required"><br>
        <label for="prenom">Prénom *</label> <input type='text' name='prenom' id="prenom" required="required"><br>
        <label for="adresse">Adresse </label> <input type='text' name='adresse' id="adresse" required="required"><br>
        <label for="ville">Ville *</label> <input type='text' name='ville' id="ville" required="required"><br>
        <label for="codePostal">Code postal *</label> <input type='text' name='codePostal' id="codePostal" required="required" minlength="5" maxlength="5"><br>
        <label for="telephone">Telephone *</label> <input type='text' name='telephone' id="telephone" required="required" minlength="10" maxlength="10"><br>
        <label for="lieuNaissance">Lieu de naissance *</label> <input type='text' name='lieuNaissance' id="lieuNaissance" required="required"><br>
        <label for="dateNaissance">Date de naissance *</label> <input type='date' name='dateNaissance' id="dateNaissance" required="required"><br>
        <label for="civilite">Civilité *</label>
        <select name="civilite" id="civilite">
            <option value="Monsieur">Monsieur</option>
            <option value="Madame">Madame</option>
        </select><br>
        <label for="numSecu">Numéro de sécurité sociale *</label> <input type='text' name='numSecu' id="numSecu" required="required" minlength="15" maxlength="15"><br>
        <label for="medecin">Medecin traitant :</label>
        
        <select id="medecin" name="medecin">
            <option value="">Medecin traitant</option>
            <?php
            try {
                $reqMedecins = $linkpdo->query("SELECT nom,prenom FROM medecin");
                while ($medecin = $reqMedecins->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $medecin['nom'] . ' ' . $medecin['prenom'] . '">' . $medecin['nom'] . ' ' . $medecin['prenom'] . '</option>';
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la récupération des médecins : " . $e->getMessage();
            }
            ?>
        </select>
        <input type="reset" value="Annuler" name="Annuler">
        <input type="submit" value="Valider" name="Ajouter">
    </form>
</body>
</html>
<script src="../js/resetSession.js"></script>
