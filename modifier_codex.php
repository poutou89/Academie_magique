<?php session_start(); ?>
<?php
include "init.php";

// Accès uniquement pour l'admin
if (!isset($_SESSION['id_user']) && ($_SESSION['id_user'] !== 1 || $_SESSION['id_user'] !== $data['createur'])) {
    header('Location: index.php');
    exit;
}

// Vérifie la présence de l’ID
if (!isset($_GET['id'])) {
    echo "ID du sort manquant.";
    exit;
}

$id = intval($_GET['id']);

// Récupération du sort
$requestCodex = $bdd->prepare("SELECT * FROM codex WHERE id_codex = ?");
$requestCodex->execute([$id]);
$sort = $requestCodex->fetch();

if (!$sort) {
    echo "Sort introuvable.";
    exit;
}

// Récupère les éléments pour la liste déroulante
$elements = $bdd->query("SELECT * FROM element")->fetchAll();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $element = $_POST['element'];

    // Mise à jour de la base
    $stmt = $bdd->prepare("UPDATE codex SET nom = ?, element = ? WHERE id_codex = ?");
    $stmt->execute([$nom, $element, $id]);

    // Si une image a été envoyée
    if (!empty($_FILES['image']['name'])) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imagePath = 'assets/img/sorts/codex_' . $id . '.' . $extension;

        // Supprime l'ancienne image si elle existe
        foreach (glob("assets/img/sorts/codex_$id.*") as $oldImage) {
            unlink($oldImage);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    header("Location: codex.php");
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
        <h2>Modifier le sort</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($sort['nom']) ?>" required>

            <label for="element">Élément :</label>
            <select name="element">
                <?php foreach ($elements as $el): ?>
                    <option value="<?= $el['id_element'] ?>" <?= $sort['element'] == $el['id_element'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($el['element']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="image">Image :</label>
            <input type="file" name="image" accept="image/*">

            <?php
            foreach (['jpg', 'png', 'webp'] as $ext) {
                $imageFile = "assets/img/sorts/codex_$id.$ext";
                if (file_exists($imageFile)) {
                    echo '<p><img src="' . $imageFile . '" alt="Image actuelle" style="max-width:200px;"></p>';
                    break;
                }
            }
            ?>

            <button type="submit">Modifier le sort</button>
        </form>
    </div>
</main>
</body>
</html>