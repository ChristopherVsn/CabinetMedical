<?php
include("ConnexionBD.php");  
include("VerificationConnexion.php");
include("FonctionsUtiles.php");
include("../html/Header.html");
?>
    <link rel="stylesheet" href="../css/Affichage.css">
</header>  
<body> 
    <h1>Affichage et Recherche de Clients</h1>
    <p>Entrer la ou les informations que vous souhaitez chercher.</p>

    <form action="AffichageClient.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" maxlength="30" placeholder="Arnault">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" maxlength="30" placeholder="Brice">
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" maxlength="30" placeholder="Toulouse">
        <label for="codepostal">Code Postal :</label>
        <input type="text" id="codepostal" name="codepostal" maxlength="5" placeholder="31400">
        <label for="lieunaissance">Lieu de naissance :</label>
        <input type="text" id="lieunaissance" name="lieunaissance" maxlength="30" placeholder="Toulouse">
        <label for="numsecuritesocial">Numéro de sécurité sociale :</label>
        <input type="text" id="numsecuritesocial" name="numsecuritesocial" maxlength="15" placeholder="010425451245632">
        <input type="reset" name="reset">
        <input type="submit" name="submit" value="Rechercher">
    </form>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Numéro de Sécurité Social</th>
                <th>Civilité</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Ville</th>
                <th>Code Postal</th>
                <th>Adresse</th>
                <th>Date de Naissance</th>
                <th>Lieu de Naissance</th>
                <th>Téléphone</th>
                <th>Medecin traitant</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                if (isset($_POST['submit'])) {
                    $codePostal = !empty($_POST['codepostal']) ? $_POST['codepostal'] : '%%';
                    $nom = !empty($_POST['nom']) ? $_POST['nom'] : '%%';
                    $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '%%';
                    $ville = !empty($_POST['ville']) ? $_POST['ville'] : '%%';
                    $lieuNaissance = !empty($_POST['lieunaissance']) ? $_POST['lieunaissance'] : '%%';
                    $numSecuriteSocial = !empty($_POST['numsecuritesocial']) ? $_POST['numsecuritesocial'] : '%%';

                    $reqSearch = $linkpdo->prepare("SELECT * FROM client WHERE nom LIKE ? and prenom LIKE ? and ville LIKE ? and CodePostal LIKE ? and LieuNaissance LIKE ?  and NumSecuriteSocial LIKE ?");
                    $reqSearch->execute(array('%'.$nom.'%', '%'.$prenom.'%', '%'.$ville.'%', '%'.$codePostal.'%', '%'.$lieuNaissance.'%', '%'.$numSecuriteSocial.'%'));
                    
                } else {
                    $reqAllClient = $linkpdo->prepare('SELECT * FROM client');
                    $reqAllClient->execute();
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la recherche des clients : " . $e->getMessage();
            }

            try {
                if (!(isset($_POST['submit']))) {
                    while ($row = $reqAllClient->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>'. $row['NumSecuriteSocial']. '</td>';
                        echo '<td>'. $row['Civilite']. '</td>';
                        echo '<td>'. $row['Prenom']. '</td>';
                        echo '<td>'. $row['Nom']. '</td>';
                        echo '<td>'. $row['Ville']. '</td>';
                        echo '<td>'. $row['CodePostal']. '</td>';
                        echo '<td>'. $row['Adresse']. '</td>';
                        $formattedDate = date('d-m-Y', strtotime($row['DateNaissance']));
                        echo '<td>'. $formattedDate. '</td>';
                        echo '<td>'. $row['LieuNaissance']. '</td>';
                        echo '<td>'. $row['Telephone']. '</td>';
                        echo '<td>'. getNomPrenomMedecin($row['IdMedecin']). '</td>';
                        
                        if ($row['IdMedecin']==NULL){
                            echo '<td><a href="ModifierClient.php?numSecuriteSocial='.$row['NumSecuriteSocial'].'&civilite='.$row['Civilite'].'&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'&ville='.$row['Ville'].'&codePostal='.$row['CodePostal'].'&adresse='.$row['Adresse'].'&dateNaissance='.$row['DateNaissance'].'&lieuNaissance='.$row['LieuNaissance'].'&telephone='.$row['Telephone'].'">Modifier</a></td>';
                        } else{
                            echo '<td><a href="ModifierClient.php?numSecuriteSocial='.$row['NumSecuriteSocial'].'&civilite='.$row['Civilite'].'&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'&ville='.$row['Ville'].'&codePostal='.$row['CodePostal'].'&adresse='.$row['Adresse'].'&dateNaissance='.$row['DateNaissance'].'&lieuNaissance='.$row['LieuNaissance'].'&telephone='.$row['Telephone'].'&idMedecin='.$row['IdMedecin'].'">Modifier</a></td>';
                        }                        echo '<td><a class="delete-button" data-nom="'.$row['Nom'].'" data-prenom="'.$row['Prenom'].'" href="SupprimerClient.php?numSecuriteSocial='.$row['NumSecuriteSocial'].'&civilite='.$row['Civilite'].'&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'&ville='.$row['Ville'].'&codePostal='.$row['CodePostal'].'&adresse='.$row['Adresse'].'&dateNaissance='.$row['DateNaissance'].'&lieuNaissance='.$row['LieuNaissance'].'&telephone='.$row['Telephone'].'">Supprimer</a></td>';
                        echo '</tr>';
                    }
                } else {
                    while ($row = $reqSearch->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>'. $row['NumSecuriteSocial']. '</td>';
                        echo '<td>'. $row['Civilite']. '</td>';
                        echo '<td>'. $row['Prenom']. '</td>';
                        echo '<td>'. $row['Nom']. '</td>';
                        echo '<td>'. $row['Ville']. '</td>';
                        echo '<td>'. $row['CodePostal']. '</td>';
                        echo '<td>'. $row['Adresse']. '</td>';
                        $formattedDate = date('d-m-Y', strtotime($row['DateNaissance']));
                        echo '<td>'. $formattedDate. '</td>';
                        echo '<td>'. $row['LieuNaissance']. '</td>';
                        echo '<td>'. $row['Telephone']. '</td>';
                        echo '<td>'. getNomPrenomMedecin($row['IdMedecin']). '</td>';
          
                        if ($row['IdMedecin']==NULL){
                            echo '<td><a href="ModifierClient.php?numSecuriteSocial='.$row['NumSecuriteSocial'].'&civilite='.$row['Civilite'].'&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'&ville='.$row['Ville'].'&codePostal='.$row['CodePostal'].'&adresse='.$row['Adresse'].'&dateNaissance='.$row['DateNaissance'].'&lieuNaissance='.$row['LieuNaissance'].'&telephone='.$row['Telephone'].'">Modifier</a></td>';
                        } else{
                            echo '<td><a href="ModifierClient.php?numSecuriteSocial='.$row['NumSecuriteSocial'].'&civilite='.$row['Civilite'].'&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'&ville='.$row['Ville'].'&codePostal='.$row['CodePostal'].'&adresse='.$row['Adresse'].'&dateNaissance='.$row['DateNaissance'].'&lieuNaissance='.$row['LieuNaissance'].'&telephone='.$row['Telephone'].'&idMedecin='.$row['IdMedecin'].'">Modifier</a></td>';
                        }
                        echo '<td><a class="delete-button" data-nom="'.$row['Nom'].'" data-prenom="'.$row['Prenom'].'" href="SupprimerClient.php?numSecuriteSocial='.$row['NumSecuriteSocial'].'&civilite='.$row['Civilite'].'&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'&ville='.$row['Ville'].'&codePostal='.$row['CodePostal'].'&adresse='.$row['Adresse'].'&dateNaissance='.$row['DateNaissance'].'&lieuNaissance='.$row['LieuNaissance'].'&telephone='.$row['Telephone'].'">Supprimer</a></td>';
                        echo '</tr>';
                    }
                }
            } catch (PDOException $e) {
                echo "Erreur lors de l'affichage des résultats : " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
<script src="../js/ConfirmationSuppression.js"></script>
<script src="../js/ResetSession.js"></script>
</body>
</html>
