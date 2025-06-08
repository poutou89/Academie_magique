<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if ($id_user == 1) {
    $elements = $bdd->query("SELECT * FROM element")->fetchAll();
} else {
    $stmt = $bdd->prepare("SELECT element.id_element, element.element 
                           FROM element 
                           INNER JOIN user_element ON element.id_element = user_element.id_element 
                           WHERE user_element.id_user = ?");
    $stmt->execute([$id_user]);
    $elements = $stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $element = intval($_POST['element']);

    $requestCreate = $bdd->prepare('INSERT INTO codex(nom, element, id_createur) VALUES (?, ?, ?)');
    $requestCreate->execute([$nom, $element, $id_user]);
    $id_codex = $bdd->lastInsertId();

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

            <select name="element" required>
                <?php foreach ($elements as $el): ?>
                    <option value="<?= $el['id_element'] ?>"><?= htmlspecialchars($el['element']) ?></option>
                <?php endforeach; ?>
            </select>

            <input type="file" name="image" accept="image/*">
            <button type="submit">Valider</button>
        </form>
    </div>
</main>
</body>
</html>