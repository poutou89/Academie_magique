<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID utilisateur manquant.";
    exit;
}

$id = intval($_GET['id']);

if ($id === 1) {
    echo "Impossible de supprimer l'administrateur.";
    exit;
}
// full delete /!\/!\/!\
$requestDeleteBestiaire = $bdd->prepare("DELETE FROM bestiaire WHERE createur = ?");
$requestDeleteBestiaire->execute([$id]);

$requestDeleteCodex = $bdd->prepare("DELETE FROM codex WHERE id_codex = ?");
$requestDeleteCodex->execute([$id]);

$requestDeleteUser = $bdd->prepare("DELETE FROM user WHERE id_user = ?");
$requestDeleteUser->execute([$id]);

header("Location: user.php");
exit;
?>