<?php session_start(); ?>
<?php
include "init.php";

if (!isset($_SESSION['id_user']) && ($_SESSION['id_user'] !== 1 || $_SESSION['id_user'] !== $data['createur'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID du monstre manquant.";
    exit;
}

$id = intval($_GET['id']);

$requestMonstre = $bdd->prepare("SELECT * FROM bestiaire WHERE id_bestiaire = ?");
$requestMonstre->execute([$id]);
$monstre = $requestMonstre->fetch();

if (!$monstre) {
    echo "Monstre introuvable.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $type = htmlspecialchars($_POST['type']);

    $update = $bdd->prepare("UPDATE bestiaire SET nom = ?, description = ?, type = ? WHERE id_bestiaire = ?");
    $update->execute([$nom, $description, $type, $id]);

    header("Location: bestiaire.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un sort</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container">
        <form method="post">
            <input type="text" name="nom" value="<?= htmlspecialchars($monstre['nom']) ?>" required>
            <textarea name="description"><?= htmlspecialchars($monstre['description']) ?></textarea>
            <input type="text" name="type" value="<?= htmlspecialchars($monstre['type']) ?>">
            <button type="submit">Modifier le monstre</button>
        </form>
    </div>
</main>
</body>