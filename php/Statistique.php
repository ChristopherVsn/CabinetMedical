<?php
    include("ConnexionBD.php");  
    include("VerificationConnexion.php");
    include("../html/Header.html");
?>
<link rel="stylesheet" href="../css/Affichage.css">
<link rel="stylesheet" href="../css/Form.css">

<html>
    <body>
        <h1>Statistiques</h1>
        <table>
        <thead><tr>
            <td><b>Tranche d'âge</b></td>
            <td><b>Nb Hommes</b></td>
            <td><b>Nb Femmes</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Moins de 25 ans</td>
                <td><?php
                try {
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE civilite = 'Monsieur' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) < 25");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des Moins de 25 ans Homme : " . $e->getMessage();
            }
                ?></td>
                <td><?php
                try{
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE Civilite = 'Madame' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) < 25");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des Moins de 25 ans Femme : " . $e->getMessage();
            }
                ?></td>
            </tr>
            <tr>
                <td>Entre 25 et 50 ans </td>
                <td><?php
                try{
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE  Civilite = 'Monsieur' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) BETWEEN 25 AND 50 ");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des 25 50 ans Homme : " . $e->getMessage();
            }
                ?></td>
                <td><?php
                try{
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE  Civilite = 'Madame' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) BETWEEN 25 AND 50");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des 25 50 ans Femme : " . $e->getMessage();
            }
                ?></td>
            </tr>
            <tr>
                <td>Plus de 50 ans</td>
                <td><?php
                try{
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE Civilite = 'Monsieur' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) > 50");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des plus de 50 ans Homme : " . $e->getMessage();
            }
                ?></td>
                <td><?php
                try{
                    $res = $linkpdo->query("SELECT count(*) AS c FROM client WHERE Civilite = 'Madame' and TIMESTAMPDIFF(YEAR, DateNaissance, CURDATE()) > 50");
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    $count = $row['c'];
                    echo $count." ";
                    } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des plus de 50 ans Femme : " . $e->getMessage();
            }
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
<h1>Resultats</h1>
<table>
    <thead><tr>
            <td><b>Prenom</b></td>
            <td><b>Nom</b></td>
            <td><b>Nombre d'heures</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
            if (isset($_POST['submit'])){
                $nom = !empty($_POST['nom']) ? $_POST['nom'] : '%%';
                $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '%%';
                try {
                    $reqSearch = $linkpdo->prepare("SELECT * FROM medecin WHERE nom LIKE ? and prenom LIKE ?");
                    $reqSearch->execute(array($nom, $prenom));
                } catch (PDOException $reqSearch) {
                    echo "Erreur lors de la recherche du client : " . $e->getMessage();
                } 
            } else {
                try {
                    $reqAllClient = $linkpdo->prepare('SELECT * FROM medecin');
                    $reqAllClient-> execute();
                } catch (PDOException $e) {
                    echo "Erreur lors de la recherche du medecin : " . $e->getMessage();
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
                        echo "Erreur lors de la somme des durée d'un rendez-vous : " . $e->getMessage();
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
                    } catch (PDOException $reqSeae) {
                        echo "Erreur lors de la somme des durée d'un rendez-vous : " . $e->getMessage();
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