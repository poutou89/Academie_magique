<?php session_start() ?>
<?php 
    include "init.php";
?>
<?php 
    $requestSELECT = $bdd->prepare('SELECT id_user, nom, role, element, mdp FROM user');
    $requestSELECT->execute([]);
    if(!empty($_POST['nom']) && !empty($_POST['mdp'])){
    $nom = htmlspecialchars($_POST['nom']);
    $mdp = htmlspecialchars(sha1(sha1($_POST['mdp']).'erqbf8295'));

    $requestLOG = $bdd->prepare('SELECT id_user, nom, role, element, mdp FROM user WHERE nom=?');

    $requestLOG->execute([$nom]);
    $data = $requestLOG->fetch();

    if($mdp === $data['mdp']){
            $_SESSION['nom'] = $data['nom'];
            $_SESSION['id_user'] = $data[0];
            $_SESSION['element'] = $data[3];
        }
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Académie</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php 
    include "header.php";
    ?>
    <main>
        <div class="container" id="login">
            <?php if(!isset($_SESSION['nom'])): ?>
            <a class="btn-add" href="inscription.php">S'inscrire</a>
            <form action="" method="post">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="mdp" placeholder="Mot de passe" required>
                <button>Connexion</button>
            </form>
                <?php endif; ?>
             <?php if (isset($_SESSION['id_user'])): ?>
               <h2> Coucou <? $_SESSION['nom']?> </h2>
               <?php endif; ?>
                
                
            <?php if(isset($_SESSION['nom'])): ?>
                <a href="unlog.php">Déconnexion</a>
                <?php endif; ?>
        </div>
    </main>
</body>
</html>