<?php session_start(); ?>
<?php
include "init.php";

if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID du sort manquant.";
    exit;
}

$id = intval($_GET['id']);

$requestDelete = $bdd->prepare("DELETE FROM codex WHERE id_codex = ?");
$requestDelete->execute([$id]);

header("Location: codex.php");
exit;
?>