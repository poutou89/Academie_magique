<?php session_start(); ?>
<?php include "init.php"; ?>

<?php 
$requestSELECT = $bdd->prepare('SELECT id_user, nom, role, mdp FROM user');
$requestSELECT->execute([]);

if (!empty($_POST['nom']) && !empty($_POST['mdp'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $mdp = htmlspecialchars(sha1(sha1($_POST['mdp']) . 'erqbf8295'));

    $requestLOG = $bdd->prepare('SELECT id_user, nom, role, mdp FROM user WHERE nom = ?');
    $requestLOG->execute([$nom]);
    $data = $requestLOG->fetch();

    if ($data && $mdp === $data['mdp']) {
        $_SESSION['nom'] = $data['nom'];
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['role'] = $data['role'];

        $stmtElem = $bdd->prepare('SELECT id_element FROM user_element WHERE id_user = ?');
        $stmtElem->execute([$data['id_user']]);
        $_SESSION['elements'] = $stmtElem->fetchAll(PDO::FETCH_COLUMN);
    }
}

$userElements = [];

if (!empty($_SESSION['elements'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['elements']), '?'));
    $stmt = $bdd->prepare("SELECT element FROM element WHERE id_element IN ($placeholders)");
    $stmt->execute($_SESSION['elements']);
    $userElements = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1) {
    if (isset($_POST['add_element'])) {
        $elementName = htmlspecialchars($_POST['element_name']);
        $insert = $bdd->prepare("INSERT INTO element (element) VALUES (?)");
        $insert->execute([$elementName]);
    }

    if (!empty($_POST['update_element'])) {
        $elementId = intval($_POST['element_id']);
        $elementName = htmlspecialchars($_POST['element_name']);
        $update = $bdd->prepare("UPDATE element SET element = ? WHERE id_element = ?");
        $update->execute([$elementName, $elementId]);
    }

    if (!empty($_POST['delete_element'])) {
        $elementId = intval($_POST['element_id']);
        $delete = $bdd->prepare("DELETE FROM element WHERE id_element = ?");
        $delete->execute([$elementId]);
    }

    $elements = $bdd->query("SELECT id_element, element FROM element")->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Académie</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container" id="login">
        <?php if (!isset($_SESSION['nom'])): ?>
            <a class="btn-add" href="inscription.php">S'inscrire</a>
            <form action="" method="post">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="mdp" placeholder="Mot de passe" required>
                <button>Connexion</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_SESSION['id_user'])): ?>
            <h2>Bien le bonjour, <br> <?= htmlspecialchars($_SESSION['nom']) ?></h2>
        <?php endif; ?>

        <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != 1): ?>
            <h2>Vos éléments :</h2>
            <h2>
            <?= !empty($userElements)
            ? htmlspecialchars(implode(', ', $userElements))
            : 'Aucun élément associé.' ?>
            </h2>
        <?php endif; ?>
        <?php if (isset($_SESSION['id_user'])): ?>
            <a class="btn-add" href="unlog.php">Déconnexion</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1): ?>
            <h2>Option Administrateur : Gestion des éléments</h2>

            <h3>Ajouter un élément</h3>
            <form method="post">
                <input type="text" name="element_name" placeholder="Nom de l'élément" required>
                <button type="submit" name="add_element">Ajouter</button>
            </form>
            <h3>Éléments existants</h3>
            <?php foreach ($elements as $el): ?>
                <form method="post" style="margin-bottom: 10px;">
                    <input type="hidden" name="element_id" value="<?= $el['id_element'] ?>">
                    <input type="text" name="element_name" value="<?= htmlspecialchars($el['element']) ?>">
                    <button name="update_element">Modifier</button>
                    <button name="delete_element" onclick="return confirm('Supprimer cet élément ?')">Supprimer</button>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>