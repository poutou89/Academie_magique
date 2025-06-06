<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$element_user = $_SESSION['element'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $element = $id_user == 1 ? intval($_POST['element']) : $element_user;

    // Insertion du sort
    $requestCreate = $bdd->prepare('INSERT INTO codex(nom, element) VALUES (?, ?)');
    $requestCreate->execute([$nom, $element]);
    $id_codex = $bdd->lastInsertId();

    // Traitement image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "assets/img/sorts/";
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $extension;
        $targetFile = $targetDir . $filename;

        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

        $insertImage = $bdd->prepare('INSERT INTO images(nom_fichier, id_codex) VALUES (?, ?)');
        $insertImage->execute([$filename, $id_codex]);
    }

    header("Location: codex.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un sort</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container">
        <h2>Ajouter un sort</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom du sort" required>
            
            <?php if ($id_user == 1): ?>
                <select name="element" required>
                    <option value="1">Lumière</option>
                    <option value="2">Feu</option>
                    <option value="3">Air</option>
                    <option value="4">Eau</option>
                </select>
            <?php else: ?>
                <input type="hidden" name="element" value="<?= htmlspecialchars($element_user) ?>">
            <?php endif; ?>

            <input type="file" name="image" accept="image/*">
            <button type="submit">Valider</button>
        </form>
    </div>
</main>
</body>
</html>