<?php
session_start();

try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("Refresh: 5; url=../index.php");
        exit();
    }

    if (isset($_SESSION['timeout']) && $_SESSION['timeout'] < time()) {
        session_unset();
        session_destroy();
        header("Refresh: 5; url=../index.php");
        exit();
    }

    $_SESSION['timeout'] = time() + 600;
} catch (Exception $e) {
    echo "Erreur lors de l'initialisation : " . $e->getMessage();
}
?>