<?php
session_start();
include "init.php";

if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID utilisateur manquant.";
    exit;
}

$id_user = intval($_GET['id']);

$stmtUser = $bdd->prepare("SELECT * FROM user WHERE id_user = ?");
$stmtUser->execute([$id_user]);
$user = $stmtUser->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}

$elements = $bdd->query("SELECT * FROM element")->fetchAll(PDO::FETCH_ASSOC);

$stmtUserElements = $bdd->prepare("SELECT id_element FROM user_element WHERE id_user = ?");
$stmtUserElements->execute([$id_user]);
$userElementIds = $stmtUserElements->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $role = $_POST['role'];
    $selectedElements = isset($_POST['elements']) ? $_POST['elements'] : [];

    $stmtUpdate = $bdd->prepare("UPDATE user SET nom = ?, role = ? WHERE id_user = ?");
    $stmtUpdate->execute([$nom, $role, $id_user]);

    $bdd->prepare("DELETE FROM user_element WHERE id_user = ?")->execute([$id_user]);

    $stmtInsert = $bdd->prepare("INSERT INTO user_element (id_user, id_element) VALUES (?, ?)");
    foreach ($selectedElements as $id_element) {
        $stmtInsert->execute([$id_user, $id_element]);
    }

    header("Location: user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container">
        <h1>Modifier l'utilisateur</h1>
        <form method="post">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

            <label>Rôle :</label>
            <input type="text" name="role" value="<?= htmlspecialchars($user['role']) ?>">

            <label>Éléments :</label><br>
            <?php foreach ($elements as $element): ?>
                <label>
                    <input type="checkbox" name="elements[]" value="<?= $element['id_element'] ?>"
                        <?= in_array($element['id_element'], $userElementIds) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($element['element']) ?>
                </label><br>
            <?php endforeach; ?>

            <button type="submit">Modifier</button>
        </form>
    </div>
</main>
</body>
</html>