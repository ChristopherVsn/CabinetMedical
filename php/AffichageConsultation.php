<?php
include("ConnexionBD.php");  
include("VerificationConnexion.php");
include("FonctionsUtiles.php");
include("../html/Header.html");

?>
<link rel="stylesheet" href="../css/Affichage.css">
</header>
<body>
<h1>Affichage des consultations</h1>
<form action="AffichageConsultation.php" method="post">
    <label for="medecinFiltre">Filtrer par médecin :</label>
    <select id="medecinFiltre" name="medecinFiltre">
        <option value="">Tous les médecins</option>
        <?php
        try {
            $reqMedecinsAvecRDV = $linkpdo->prepare("SELECT DISTINCT m.nom, m.prenom FROM medecin m INNER JOIN rendezvous r ON m.IdMedecin = r.IdMedecin");
            $reqMedecinsAvecRDV->execute();
            //  Le inner join permet d'obtenir les medecins qui ont un rendez vous, inutile de filtrer par medecin qui n'a pas de rendezvous
            while ($medecin = $reqMedecinsAvecRDV->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$medecin['nom'].' '.$medecin['prenom'].'">'.$medecin['nom'].' '.$medecin['prenom'].'</option>';
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des médecins : " . $e->getMessage();
        }
        ?>
    </select>
    <input type="submit" value="Filtrer">
</form>
<hr>
<table>
    <thead>
        <tr>
        <th>Client</th>
        <th>Médecin</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Durée</th>
        <th>Modifier</th>
        <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
    <?php
    try {
        if (isset($_POST['medecinFiltre']) && ($_POST['medecinFiltre'] != "")) {
            $nomPrenomMedecin = explode(" ", $_POST['medecinFiltre']);
            $medecin = getMedecinId($nomPrenomMedecin[0], $nomPrenomMedecin[1]);
            $reqConsultation = $linkpdo->prepare("SELECT * FROM rendezvous WHERE IdMedecin = :idMedecin ORDER BY DateRDV DESC");
            $reqConsultation->bindParam(':idMedecin', $medecin);
            $reqConsultation->execute();

        } else{
            $reqConsultation = $linkpdo->prepare("SELECT * FROM rendezvous ORDER BY DateRDV DESC");
            $reqConsultation->execute();
        }
        while ($row = $reqConsultation->fetch(PDO::FETCH_ASSOC)) {
            $reqNomClient = $linkpdo->prepare("SELECT nom, prenom FROM client WHERE IdClient = :idClient");
            $reqNomClient->bindParam(':idClient', $row['IdClient']);
            $reqNomClient->execute();
            $client = $reqNomClient->fetch(PDO::FETCH_ASSOC);

            $reqNomMedecin = $linkpdo->prepare("SELECT nom, prenom FROM medecin WHERE IdMedecin = :idMedecin");
            $reqNomMedecin->bindParam(':idMedecin', $row['IdMedecin']);
            $reqNomMedecin->execute();
            $medecin = $reqNomMedecin->fetch(PDO::FETCH_ASSOC);

            echo '<tr>';
            echo '<td>'. $client['nom']." ".$client['prenom']. '</td>';
            echo '<td>'. $medecin['nom']." ".$medecin['prenom']. '</td>';
            $formattedDate = date('d-m-Y', strtotime($row['DateRDV']));
            echo '<td>'. $formattedDate. '</td>';           
            echo '<td>'. $row['Heure']. '</td>';
            echo '<td>'. $row['Duree']. '</td>';
            echo '<td><a href="ModifierConsultation.php?client='.$client['nom'].' '.$client['prenom'].'&medecin='.$medecin['nom'].' '.$medecin['prenom'].'&dateRdv='.$row['DateRDV'].'&heure='.$row['Heure'].'&duree='.$row['Duree'].'">Modifier</a></td>';
            echo '<td><a class="delete-button" data-client="'.$client['nom'].' '.$client['prenom'].'" data-medecin="'.$medecin['nom'].' '.$medecin['prenom'].'" href="SupprimerConsultation.php?client='.$client['nom'].' '.$client['prenom'].'&medecin='.$medecin['nom'].' '.$medecin['prenom'].'&dateRdv='.$row['DateRDV'].'&heure='.$row['Heure'].'&duree='.$row['Duree'].'">Supprimer</a></td>';
            echo '</tr>';
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'affichage des consultations : " . $e->getMessage();
    }
    ?>
    </tbody>
</table>
<script src="../js/ResetSession.js"></script>
<script src="../js/ConfirmationSuppressionConsultation.js"></script>
</body>
</html>