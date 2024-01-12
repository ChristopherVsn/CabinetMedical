<?php
include("ConnexionBD.php");
include("VerificationConnexion.php");

$vPrenom = $_GET['prenom'];
$vNom = $_GET['nom'];

if (isset($_POST['nom'])) {
    $vPrenom = $_POST['prenomA'];
    $vNom = $_POST['nomA'];
    $vNouvPrenom = $_POST['prenom'];
    $vNouvNom = $_POST['nom'];

    try {
        $req = $linkpdo->prepare('UPDATE medecin SET nom=:nouvNom, prenom=:nouvPrenom WHERE Prenom=:vPrenom AND Nom=:vNom');
        if ($req == false) {
            throw new Exception("Erreur sur la requête de modification");
        } else {
            $req->execute(array(
                'nouvPrenom' => $vNouvPrenom,
                'nouvNom' => $vNouvNom,
                'vPrenom' => $vPrenom,
                'vNom' => $vNom,
            ));
        }
        echo "<script>
                alert('Le médecin a été modifié avec succès.');
                window.location.href = 'AffichageMedecin.php';
              </script>";    } catch (PDOException $e) {
        echo "Erreur lors de la modification du médecin : " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
include("../html/Header.html");

?>

<link rel="stylesheet" href="../css/Form.css">
</header>
<body>
    <form class="container" action="ModifierMedecin.php" method="post">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" maxlength="30" value="<?php echo $vPrenom; ?>">
        <input type="hidden" id="prenomA" name="prenomA" value="<?php echo $vPrenom; ?>">
        <br /> 

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" maxlength="30" value="<?php echo $vNom; ?>">
        <input type="hidden" id="nomA" name="nomA" value="<?php echo $vNom; ?>">
        <br />

        <input type="submit" name="submit" value="Modifier">
    </form>
    <script src="../js/ResetSession.js"></script>
</body> 
</html>