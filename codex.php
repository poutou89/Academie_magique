<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
$requestCodex = $bdd->prepare('
    SELECT codex.id_codex, codex.nom, codex.element, element.element AS nom_element, images.nom_fichier
    FROM codex
    INNER JOIN element ON codex.element = element.id_element
    LEFT JOIN images ON codex.id_codex = images.id_codex
');
$requestCodex->execute();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Codex</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include "header.php"; ?>
    <main>
        <div class="container">
            <h3>
                <?php if (isset($_SESSION['id_user'])): ?>
                    <a class="btn-add" href="createcodex.php">Ajouter un nouveau sort</a>
                <?php endif; ?>
            </h3>
        </div>
        <div class="container" id="sort">
            <?php while ($data = $requestCodex->fetch()): ?>
                <div class="container">
                <h2><?= html_entity_decode($data['nom']) ?></h2>
                
                <?php if (!empty($data['nom_fichier']) && file_exists("assets/img/sorts/" . $data['nom_fichier'])): ?>
                    <img src="assets/img/sorts/<?= htmlspecialchars($data['nom_fichier']) ?>" style="max-width:200px;">
                    <?php endif; ?>
                <p>Élément : <?= htmlspecialchars($data['nom_element']) ?></p>

                <?php if (
                    isset($_SESSION['id_user']) &&
                    ($_SESSION['id_user'] == 1 || $_SESSION['id_user'] == $data['createur'])
                ) {
                    echo '<a href="modifier_codex.php?id=' . $data['id_codex'] . '">Modifier</a> | ';
                    echo '<a href="supprimer_codex.php?id=' . $data['id_codex'] . '" onclick="return confirm(\'Êtes-vous sûr ?\')">Supprimer</a>';
                }

                ?></div>
            <?php endwhile; ?>
        </div>
    </main>
</body>

</html>