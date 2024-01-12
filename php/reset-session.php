<?php
session_start();

// Réinitialiser le temps de session à 10 minutes
$_SESSION['timeout'] = time() + 600;

// Répondre à la requête
echo "Session reset successful";
?>
