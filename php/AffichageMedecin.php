<?php
    include("ConnexionBD.php");  
    include("VerificationConnexion.php");
    include("../html/Header.html");
?>

<link rel="stylesheet" href="../css/Affichage.css">
</header>
<body>
    <h1>Affichage et Recherche de medecins</h1>
    <p>Entrer la ou les informations que vous souhaitez chercher.</p>

    <form action="AffichageMedecin.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" maxlength="30" placeholder="Dupont">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" maxlength="30" placeholder="Max"> 
        <input type="reset" name="reset">
        <input type="submit" name="submit" value="Rechercher">
    </form>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    if (isset($_POST['submit'])){
                        $nom = !empty($_POST['nom']) ? $_POST['nom'] : '%%';
                        $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '%%';

                        $reqSearch = $linkpdo->prepare("SELECT * FROM medecin WHERE nom LIKE ? and prenom LIKE ?");
                        $reqSearch->execute(array($nom, $prenom));
                    } else {
                        $reqAllClient = $linkpdo->prepare('SELECT * FROM medecin');
                        $reqAllClient->execute();
                    }

                    if(!(isset($_POST['submit']))){
                        while ($row = $reqAllClient->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>'. $row['Prenom']. '</td>';
                            echo '<td>'. $row['Nom']. '</td>';
                            echo '<td><a href="ModifierMedecin.php?&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'">Modifier</a></td>';
                            echo '<td><a class="delete-button" data-nom="'.$row['Nom'].'" data-prenom="'.$row['Prenom'].'" href="SupprimerMedecin.php?&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'">Supprimer</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        while ($row = $reqSearch->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>'. $row['Prenom']. '</td>';
                            echo '<td>'. $row['Nom']. '</td>';
                            echo '<td><a href="ModifierMedecin.php?&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'">Modifier</a></td>';
                            echo '<td><a class="delete-button" data-nom="'.$row['Nom'].'" data-prenom="'.$row['Prenom'].'" href="SupprimerMedecin.php?&prenom='.$row['Prenom'].'&nom='.$row['Nom'].'">Supprimer</a></td>';
                            echo '</tr>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "Erreur SQL : " . $e->getMessage();
                }
            ?>
        </tbody>
    </table>
    <script src="../js/ConfirmationSuppression.js"></script>
    <script src="../js/ResetSession.js"></script>
</body>
</html>