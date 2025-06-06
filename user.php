<?php session_start(); ?>
<?php include "init.php"; ?>

<?php 
    $requestSELECT = $bdd->prepare('SELECT user.id_user, user.nom, user.role, user.element, element.element AS nom_element
                                    FROM user
                                    INNER JOIN element ON user.element = element.id_element');
    $requestSELECT->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include "header.php"; ?>
    <main>
        <div class="container" id="user">
            <?php while ($data = $requestSELECT->fetch()) {
                echo '<div class="container">';
                echo '<h2>' . htmlspecialchars($data['nom']) . '</h2>';

                if ($data['id_user'] == 1) {
                    echo '<p>Description : Directrice</p>';
                } else {
                    echo '<p>Élément : ' . htmlspecialchars($data['nom_element']) . '</p>';
                }

                if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1) {
                    echo '<a href="modifier_user.php?id=' . $data['id_user'] . '">Modifier</a> | ';
                    echo '<a href="supprimer_user.php?id=' . $data['id_user'] . '" onclick="return confirm(\'Êtes-vous sûr ?\')">Supprimer</a>';
                }

                echo '</div>';
            } ?>
        </div>
    </main>
</body>
</html>