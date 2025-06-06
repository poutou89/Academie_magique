<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
$elements = $bdd->query("SELECT * FROM element")->fetchAll();

if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID utilisateur manquant.";
    exit;
}

$id = intval($_GET['id']);


$requestUser = $bdd->prepare("SELECT * FROM user WHERE id_user = ?");
$requestUser->execute([$id]);
$user = $requestUser->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $element = intval($_POST['element']);
    $role = htmlspecialchars($_POST['role']);

    if (!empty($_POST['mdp'])) {
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $update = $bdd->prepare("UPDATE user SET nom = ?, element = ?, role = ?, mdp = ? WHERE id_user = ?");
        $update->execute([$nom, $element, $role, $mdp, $id]);
    } else {
        $update = $bdd->prepare("UPDATE user SET nom = ?, element = ?, role = ? WHERE id_user = ?");
        $update->execute([$nom, $element, $role, $id]);
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
            <h2>Modifier l'utilisateur</h2>
            <form method="post">
                <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                <input type="text" name="role" value="<?= htmlspecialchars($user['role']) ?>">
                <input type="password" name="mdp" placeholder="Laisser vide pour ne pas changer">
                <label for="element">Élément :</label>
                <select name="element" required>
                    <?php foreach ($elements as $el): ?>
                    <option value="<?= $el['id_element'] ?>" <?= $user['element'] == $el['id_element'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($el['element']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Modifier</button>
            </form>
        </div>
    </main>
</body>
</html>