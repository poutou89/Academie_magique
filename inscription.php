<?php session_start() ?>
<?php 
    include "init.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        include "header.php";
    ?>
    <div class="container">
        <a href="index.php">Retour à la page d'accueil</a>
        <h1>INSCRIPTION</h1>
    </div>
    
    <div class="container">
        <form action="inscription.php" method="post" required enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="mdp" placeholder="Mot de passe" required>
        
        <legend>Veuillez choisir votre magie :</legend>
            <input type="checkbox" name="element[]" id="1" value="1">
            <label for="lux">Lumière</label>
            <input type="checkbox" name="element[]" id="2" value="2">
            <label for="feu">Feu</label>
            <input type="checkbox" name="element[]" id="3" value="3">
            <label for="air">air</label>
            <input type="checkbox" name="element[]" id="4" value="4">
            <label for="eau">eau</label>
        <button>Valider mon inscription</button></div>

        <?php if (!isset($_POST['element']) || $_POST['element'] === 'NULL') {
            echo '<h4>Les moldus ne sont pas accepté dans cette école</h4>';
        
        } else if (count($_POST['element']) > 2) {
            echo '<h4>La nature ne nous dote que de 2 éléments maximum à notre naissance</h4>';

        } else if (!empty($_POST['nom']) && !empty($_POST['mdp'] && !empty(['element']))){
            $nom = htmlspecialchars($_POST['nom']);
            $mdp = htmlspecialchars(sha1(sha1($_POST['mdp']).'erqbf8295'));
            $elements = $_POST['element'];
            sort($elements);
            $element = implode('', $elements);

            $role = 'utilisateur';

            $requestCreate = $bdd->prepare('INSERT INTO user(nom,mdp,element,role)
                                    VALUES (:nom,:mdp,:element,:role)');

            $requestCreate->execute([
                'nom'=>$nom,
                'mdp'=>$mdp,
                'element'=>$element,
                'role'=>$role
            ]);
            header("Location:index.php");

        } else {
            header("Location:index.php");
        }
        
    ?>
    </form>
</body>
</html>