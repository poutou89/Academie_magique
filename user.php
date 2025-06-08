<?php session_start(); ?>
<?php include "init.php"; ?>

<?php 
$requestUsers = $bdd->query('SELECT id_user, nom, role FROM user');
$users = $requestUsers->fetchAll(PDO::FETCH_ASSOC);

$userElementsStmt = $bdd->query('
    SELECT ue.id_user, e.element 
    FROM user_element ue
    INNER JOIN element e ON ue.id_element = e.id_element
');
$userElementsRaw = $userElementsStmt->fetchAll(PDO::FETCH_ASSOC);

$userElements = [];
foreach ($userElementsRaw as $row) {
    $userElements[$row['id_user']][] = $row['element'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container" id="user">
        <?php foreach ($users as $data): ?>
            <div class="container">
                <h2><?= htmlspecialchars($data['nom']) ?></h2>

                <?php if ($data['id_user'] == 1): ?>
                    <p>Description : Directrice</p>
                <?php else: ?>
                    <p>Éléments :
                        <?= isset($userElements[$data['id_user']])
                            ? htmlspecialchars(implode(', ', $userElements[$data['id_user']]))
                            : 'Aucun' ?>
                    </p>
                <?php endif; ?>

                <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1): ?>
                    <a href="modifier_user.php?id=<?= $data['id_user'] ?>">Modifier</a> |
                    <a href="supprimer_user.php?id=<?= $data['id_user'] ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>