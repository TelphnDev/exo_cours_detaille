<?php
// Mme.Meckes a mis sa il faut le laisser

// active l’affichage des erreurs directement dans la page.
ini_set('display_errors', 'On');
// demande à PHP de signaler toutes les erreurs, avertissements et notices.
error_reporting(E_ALL);
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <?php
        // importation du fichier ./include/head.php qui contient le code HTML et les balises dans le <head>
        include('include/head.php');
        ?>
    </head>


<?php

// verification de la session
if (session_status() == PHP_SESSION_NONE or session_status() == PHP_SESSION_DISABLED) {
    // si la session n'existe pas on l'ouvre
    ob_start();
    session_start();
}


// importation du fichier ./include/header.php qui contient le code HTML et les balises dans le <header> et la connexion a la base de données
include('include/header.php');
// importation du fichier ./include/nav.php qui contient le code HTML et les balises dans le <nav>
include('include/nav.php');

// verification de la presence des parametres codeEleve et date dans l'url'
if (isset($_GET['date']) && isset($_GET['codeEleve'])) {

    $_SESSION['date'] = $_GET['date'];
    $_SESSION['codeEleve'] = $_GET['codeEleve'];


    ?>


    <div style="height: 60vh;">
        <div style="margin: 10vh auto; width: fit-content; border: 1px solid black; padding: 2vh; border-radius: 10px;">
            <h2>Voulez vous supprimer ce cours ?</h2>
            <div style="display: flex; justify-content: space-around; margin-top: 5vh;">
                <form action="supprimerLecon.php" method="post">
                    <button ype="submit" name="supprimer" value="1" class="btn btn-primary">Oui</button>
                    <button type="submit" name="supprimer" value="0" class="btn btn-danger">Non</button>
                </form>
            </div>


        </div>

    </div>
    <?php
} else {
    // sinon verifie si les session son enregistré et que la variable post a le bouton supprimer
    if (isset($_SESSION['date']) && isset($_SESSION['codeEleve']) && isset($_POST['supprimer'])) {
        // si on clique sur oui on supprime le cours
        if ($_POST['supprimer'] == 1) {
            // appelle la fonction deleteLecon() dans le fichier ./include/biblioAccesBDD.php ligne 126
            $result = deleteLecon($bdd, $_SESSION['date'], $_SESSION['codeEleve']);
            // si la suppression est bon on redirige vers la page lecons.php de l'eleve'
            if ($result === true) {
                $_SESSION['supprimer'] = true;
                header('Location: lecons.php?code=' . $_SESSION['codeEleve']);
            } else  // sinon on affiche un message d'erreur'
            { ?>
                <div class="alert alert-danger" role="alert">
                    Une erreur est survenue <?= $result ?>
                </div>
                <?php
            }
        } // sinon on redirige vers la page lecons.php de l'eleve
        else {
            header('Location: lecons.php?code=' . $_SESSION['codeEleve']);
            exit;
        }
    }
}