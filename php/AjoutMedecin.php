<?php
    include("ConnexionBD.php");   
    include("VerificationConnexion.php");
    if (isset($_POST['valider'])) {
        try {
            $res = $linkpdo->query("SELECT count(*) AS c FROM medecin WHERE nom = '".$_POST['nom']."' and prenom = '".$_POST['prenom']."'");
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $count = $row['c'];
            
            if ($count == 0) {
                $req = $linkpdo->prepare('INSERT INTO medecin (nom, prenom) VALUES (?, ?)');
                $req->execute(array($_POST['nom'], $_POST['prenom']));
                echo "enregistrer";
            } else {
                echo "Medecin déjà enregistré";
            }
            echo "<script>
            alert('Le médecin a été ajouté avec succès.');
                window.location.href = 'affichageMedecin.php';
            </script>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du médecin : " . $e->getMessage();
        }
    }

    include("../html/Header.html");

?>
<link rel="stylesheet" href="../css/Form.css">
<link rel="stylesheet" href="../css/styles.css">
</header>
<body>
    <h1>Ajout d'un médecin</h1>
    <p>Tous les champs doivent être saisis</p>
     <body>
        <form class="container" action="AjoutMedecin.php" method="post"><br>
            <label for="nom">Nom</label>
            <input type='text' id="nom" name='nom' required="required"><br>

            <label for="prenom">Prénom</label>
            <input type='text' id="prenom" name='prenom' required="required"><br>

            <input type="reset" value="Annuler" name="annuler">
            <input type="submit" value="Valider" name="valider">            
        </form>
    </body>
</html>
<script src="../js/ResetSession.js"></script>
