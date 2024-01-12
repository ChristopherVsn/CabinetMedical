<?php
    include("ConnexionBD.php");  
    include("VerificationConnexion.php");
    include("../html/Header.html");
?>
<link rel="stylesheet" href="../css/AffichageClient.css">

<html>
    <body>
        <table>
        <thead>
            <tr>
            <th colspan="2">statistiques</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>Tranche d'âge</td>
            <td>Nb Hommes</td>
            <td>Nb Femmes</td>
            </tr>
            <tr>
                <td>Moins de 25 ans</td>
                <td><?php
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE civilite = 'Monsieur' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) < 25");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                ?></td>
                <td><?php
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE Civilite = 'Madame' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) < 25");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                ?></td>
            </tr>
            <tr>
                <td>Entre 25 et 50 ans </td>
                <td><?php
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE  Civilite = 'Monsieur' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) BETWEEN 25 AND 50 ");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                ?></td>
                <td><?php
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE  Civilite = 'Madame' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) BETWEEN 25 AND 50");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                ?></td>
            </tr>
            <tr>
                <td>Plus de 50 ans</td>
                <td><?php
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE Civilite = 'Monsieur' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) > 50");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                ?></td>
                <td><?php
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE Civilite = 'Madame' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) > 50");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                ?></td>
            </tr>
        </tbody>
        </table>
        <link rel="stylesheet" href="../css/Affichage.css">

<form action="Statistique.php" method="post">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" maxlength="30" placeholder="Dupont">
    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" maxlength="30" placeholder="Brice"> 
    <input type="reset" name="reset">
    <input type="submit" name="submit" value="Rechercher">
</form>
<table>
    <thead>
        <tr>
        <th colspan="8">Resultats :</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b>Prenom</b></td>
            <td><b>Nom</b></td>
            <td><b>Nombre d'heures</b></td>
        </tr>
        <?php
            if (isset($_POST['submit'])){
                $nom = !empty($_POST['nom']) ? $_POST['nom'] : '%%';
                $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '%%';
                try {
                    $reqSearch = $linkpdo->prepare("SELECT * FROM medecin WHERE nom LIKE ? and prenom LIKE ?");
                    $reqSearch->execute(array($nom, $prenom));
                } catch (PDOException $e) {
                    echo "Erreur lors de la recherche du client : " . $e->getMessage();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                try {
                    $reqAllClient = $linkpdo->prepare('SELECT * FROM medecin');
                    $reqAllClient-> execute();
                } catch (PDOException $e) {
                    echo "Erreur lors de la recherche du client : " . $e->getMessage();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            if(!(isset($_POST['submit']))){
                while ($row = $reqAllClient->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>'. $row['Prenom']. '</td>';
                    echo '<td>'. $row['Nom']. '</td>';
                    try {
                        $nbHeures = $linkpdo->prepare("SELECT COALESCE(SUM(duree), 0) as nb FROM rendezvous WHERE idMedecin = ".$row['IdMedecin']."");
                        $nbHeures -> execute();
                        $row1 = $nbHeures->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erreur lors de la recherche du client : " . $e->getMessage();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    echo '<td>'.floor($row1['nb']/60)."h:".sprintf('%02d',$row1['nb']%60).' </td>';
                    echo '</tr>';
                }
            } else {
                while ($row = $reqSearch->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>'. $row['Prenom']. '</td>';
                    echo '<td>'. $row['Nom']. '</td>';
                    try {
                        $nbHeures = $linkpdo->prepare("SELECT COALESCE(SUM(duree), 0) as nb FROM rendezvous WHERE idMedecin = ".$row['IdMedecin']."");
                        $nbHeures -> execute();
                        $row1 = $nbHeures->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erreur lors de la recherche du client : " . $e->getMessage();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    echo '<td>'.floor($row1['nb']/60)."h".sprintf('%02d',$row1['nb']%60).' </td>';
                    echo '</tr>';
                }
            }
        
        ?>
    
    </tbody>
</table>
    </body>
</html>
<script src="../js/ResetSession.js"></script>