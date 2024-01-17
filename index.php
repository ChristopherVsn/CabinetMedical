<?php
    include("php/ConnexionBD.php");
    if(isset($_POST['valider'])){ 
    	$reqSearch = $linkpdo->prepare("SELECT count(*) as c FROM utilisateur WHERE Nom = ? ");
        $reqSearch->execute(array($_POST['nom']));
        $row = $reqSearch->fetch(PDO::FETCH_ASSOC);
        $count = $row['c'];
        if($count == 1){
        	try{
        	$reqVerifMDP = $linkpdo->prepare("SELECT count(*) as cs FROM utilisateur WHERE Nom = ? and MotDePasse  = ?");
	        $reqVerifMDP->execute(array($_POST['nom'],$_POST['mdp']));
	        $row1 = $reqVerifMDP->fetch(PDO::FETCH_ASSOC);
	        $count1 = $row1['cs'];
	        if($count1 == 1){
                if(empty(session_id()) && !headers_sent()){
                    session_start();
                }
                $_SESSION['username'] = $_POST['nom'];
			    $_SESSION['timeout'] = time() + 60; // 5 min
	        	$delai=0.3; // Délai en secondes
				$url='php/AffichageClient.php'; 
				header('Refresh: '.$delai.';url='.$url);
	        } else {
	        	echo '<script type="text/javascript">
					alert("Mot de passe incorrect");
				</script>';
	        }
	        }catch(PDOException $e) {
                        echo "Erreur lors dans le requete de connexion : " . $e->getMessage();
             }
        } else {
			echo '<script type="text/javascript">
				alert("Utilisateur inexistant");
			</script>';
		}
	}
?>
<html>
<link rel="stylesheet" href="css/index.css">
	<body>
		<form action="index.php" method="post">
			<label> Connexion </label>
			Votre login <input type='text' name='nom' required value='<?php if(!empty($_SESSION['nom'])){echo $_SESSION['nom'];}?>'>
			Votre mot de passe <input type='password' name='mdp' required value='<?php if(!empty($_SESSION['mdp'])){echo $_SESSION['mdp'];}?>'>
			<input type="submit" value="Connexion" name="valider"><br>
			<input type="reset" value="Annuler" name="Annuler">
		</form>
	</body>
</html>
