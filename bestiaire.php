<?php session_start(); ?>
<?php include "init.php"; ?>

<?php
$requestBestiaire = $bdd->prepare('
    SELECT bestiaire.id_bestiaire, bestiaire.nom, bestiaire.description, images.nom_fichier
    FROM bestiaire
    LEFT JOIN images ON bestiaire.id_bestiaire = images.id_bestiaire
');
$requestBestiaire->execute();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bestiaire</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "header.php"; ?>
<main>
    <div class="container">
        <h3>
            <?php if (isset($_SESSION['id_user'])): ?>
                <a class="btn-add" href="createbestiaire.php">Ajouter un nouveau monstre</a>
            <?php endif; ?>
        </h3>
    </div>
    <div class="container" id="list">
        <?php while ($data = $requestBestiaire->fetch()): ?>
            <div class="container">
            <h2><?= html_entity_decode($data['nom']) ?></h2>
            <?php if (!empty($data['nom_fichier']) && file_exists("assets/img/monstres/" . $data['nom_fichier'])): ?>
                <img src="assets/img/monstres/<?= htmlspecialchars($data['nom_fichier']) ?>" style="max-width:200px;">
            <?php endif; ?>
            <p><?= html_entity_decode($data['description']) ?></p>


            <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1): ?>
                <p>
                    <a href="modifier_bestiaire.php?id=<?= $data['id_bestiaire'] ?>">Modifier</a> |
                    <a href="supprimer_bestiaire.php?id=<?= $data['id_bestiaire'] ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                </p>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
</main>
</body>
</html>