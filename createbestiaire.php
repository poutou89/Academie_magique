<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $type = htmlspecialchars($_POST['type']);
    $createur = isset($_SESSION['id_user']);

    $requestCreate = $bdd->prepare('INSERT INTO bestiaire(nom, description, type, createur) VALUES (?, ?, ?, ?)');
    $requestCreate->execute([$nom, $description, $type, $createur]);
    $id_bestiaire = $bdd->lastInsertId();
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "assets/img/monstres/";
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $extension;
        $targetFile = $targetDir . $filename;

        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

        $insertImage = $bdd->prepare('INSERT INTO images(nom_fichier, id_bestiaire) VALUES (?, ?)');
        $insertImage->execute([$filename, $id_bestiaire]);
    }

    header("Location: bestiaire.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un monstre</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container">
        <h2>Ajouter un monstre</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom du monstre" required>
            <input type="text" name="type" placeholder="Type" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Valider</button>
        </form>
    </div>
</main>
</body>
</html>