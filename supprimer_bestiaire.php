<?php
session_start();
include "init.php";

if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID du monstre manquant.";
    exit;
}

$id = intval($_GET['id']);

$requestDelete = $bdd->prepare("DELETE FROM bestiaire WHERE id_bestiaire = ?");
$requestDelete->execute([$id]);

header("Location: bestiaire.php");
exit;
?>