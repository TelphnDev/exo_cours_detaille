
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // importation du fichier ./include/head.php qui contient le code HTML et les balises dans le <head>
    include('include/head.php');
    ?>
</head>

<?php
// Mme.Meckes a mis sa il faut le laisser
// c'est des parametres de configuration pour afficher les erreurs
// active l’affichage des erreurs directement dans la page.
ini_set('display_errors', 'On');
// demande à PHP de signaler toutes les erreurs, avertissements et notices.
error_reporting(E_ALL);




// importation du fichier ./include/header.php qui contient le code HTML et les balises dans le <header> et la connexion a la base de données
include('include/header.php');
// importation du fichier ./include/nav.php qui contient le code HTML et les balises dans le <nav>
include('include/nav.php');

// verification de la presence du parametre code dans l'url
if (!isset($_GET['code'])) {
    // si code n'existe pas on redirige vers la page eleves.php
    header('Location: eleves.php');
    // coupure de l'execution du script
    exit;
}




// utilisation de la variable code pour recuperer le code de l'eleve
// l'utilisation se fais sans erreur car le code est dans l'url et sinon on redirige vers la page eleves.php
$code = $_GET['code'];

// recuperation des informations de l'eleve et de ses lecons dans ./include/biblioAccesBDD.php ligne 80
$infoEleve = getUnEleve($bdd, $code);

// recuperation des informations de ses lecons dans ./include/biblioAccesBDD.php ligne 96
$infoLecon = getLesLeconsUnEleve($bdd, $code);





// partie lors de suppression d'une leçon vaut mieux regarder d'abord le code supprimerLecon.php pour mieux comprendre

// verification de la session
if (session_status() == PHP_SESSION_NONE or session_status() == PHP_SESSION_DISABLED) {
    // si la session n'existe pas on l'ouvre
    ob_start();
    session_start();
}

// si la session existe et que l'élève a été ajouté
if (isset($_SESSION['supprimer']) and $_SESSION['supprimer'] == true) {
    // affiche un message de succès avec la date déjà enregistrer dans la session avant
    echo "<div class='alert alert-success' role='alert'>La leçon du $_SESSION[date] a été supprimé</div>";

    // on supprime les variables de session pour ne pas les afficher sur la page
    session_unset();
}

?>

<!--affiche le nom de l'eleve-->
<div style="padding-bottom: 20vh; background-color: #e9ecef">
    <?php echo $infoEleve['nom'] . " " . $infoEleve['prenom']; ?>
</div>

<!--affiche la liste des lecons selon la date, l'heure et la duree-->
<table class="table table-dark table-striped">
    <tr>
        <th>Date</th>
        <th>Heure</th>
        <th>Duree</th>
    </tr>
    <?php
    // initialise la variable duree_totale a 0 pour ensuite calculer la somme des durees
    $duree_totale = 0;
    // boucle pour afficher colonne par colonne les informations de chaque lecon
    // le foreach permet de parcourir les tableaux automatiquement peut importe sa taille et sa structure
    // Le foreach demande la variable $infoLecon qui est un tableau de tableaux et renvoie colone par colone dans $lecon
    foreach ($infoLecon as $lecon) { ?>
        <!-- tr est pour une colone-->
        <tr>
            <!--th est pour une ligne -->
            <th><?php echo $lecon['dateLecon']; ?></th>
            <th><?php echo $lecon['heureDebut']; ?></th>
            <th><?php echo $lecon['duree']; ?></th>
            <!-- le href="#" permet de faire pointer sur la même page avec /# donc crée un lien servant a rien -->
            <th><a href="#">modifier</a></th>
            <th>
                <!-- crée un lien avec les infos dateLecon et code pour le mettre en methode GET a supprimerLecon.php -->
                <a href="supprimerLecon.php?date=<?php echo $lecon['dateLecon'] ?>&codeEleve=<?php echo $_GET['code'] ?>">suprimer</a>
            </th>
        </tr>
        <?php
        // additionne la duree de chaque lecon pour ensuite calculer la somme des durees
        $duree_totale += $lecon['duree'];
    } ?>
</table>

<div>
    <!-- affiche le nombre d'heures restant a programmer -->
    <p>nombre d'heures restant à programmer : <?php echo $infoEleve['nbHeuresConduite'] - $duree_totale ?></p>
</div>

<?php

// affiche les informations du bas de page
include('include/footer.php'); ?>

</body>

</html>


