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

// la fonction getLesEleves() est dans le fichier ./include/biblioAccesBDD.php Ligne 35
// recupère tout les eleve et tri par date d'inscription décroissante
$lesEleves = getLesEleves($bdd);

// la fonction getNbrEleves() est dans le fichier ./include/biblioAccesBDD.php Ligne 65
// la fonction compte le nombre d'eleve enregistré
$nbrEleves = getNbrEleves($bdd);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // importation du fichier ./include/head.php qui contient le code HTML et les balises dans le <head>
    include('include/head.php');
    ?>
</head>

<body>

<?php
// partie lors d'ajout d'un eleve a regarder après avoir lu le code ajouterEleve.php pour mieux comprendre

// verification de la session
if (session_status() == PHP_SESSION_NONE or session_status() == PHP_SESSION_DISABLED) {
    // si la session n'existe pas on l'ouvre
    ob_start();
    session_start();
}

// si la session existe et que l'élève a été ajouté
if (isset($_SESSION['eleve_ajoute']) and $_SESSION['eleve_ajoute'] == true) {
    // affiche un message de succès avec nom et prénom
    echo "<div class='alert alert-success' role='alert'>L'élève $_SESSION[nom] $_SESSION[prenom] a été ajouté avec succès</div>";

    // on supprime les variables de session pour ne pas les afficher sur la page
    session_unset();
}
?>


<!-- div principale contenant le contenu de la page-->
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">

        <section>
            <!-- information a part des cards eleves -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- récupère le nombre d'élèves -->
                <h1>Liste des élèves <?php echo $nbrEleves ?></h1>
                <!-- bouton avec le lien pour aller sur la page ajouterEleve.php -->
                <!-- a permet de rediriger vers une autre page-->
                <a href="ajouterEleve.php">
                    <!-- le boutton permet d'avoir le style bootstrap des boutons -->
                    <button type="button" class="btn btn-primary">Ajouter un élève</button>
                </a>
            </div>
            <!-- permet d'afficher les cards des eleves avec la disposition environ 3 par ligne selon la taille de l'ecran-->
            <div class="row">

                <?php
                // boucle qui permet de recupere colone par colone les informations de chaque eleve pour les afficher dans les cards
                // le foreach permet de parcourir les tableaux automatiquement peut importe sa taille et sa structure
                // Le foreach demande la variable $LesEleves qui est un tableau de tableaux et renvoie colone par colone dans $unEleve
                foreach ($lesEleves as $unEleve) {
                    // on récupère les informations de chaque eleve enregistre dans la table eleve
                    $nom = $unEleve['nom'];
                    $prenom = $unEleve['prenom'];
                    $adresse = $unEleve['adresseRue'];
                    $ville = $unEleve['codePostal'] . ' ' . $unEleve['ville'];
                    $age = $unEleve['age'];

                    // on crée un lien pour aller sur la page lecons.php de l'eleve avec son code qui est son ID
                    // son ID est dans la variable "code" dans l'url c'est une methode GET
                    $code = 'lecons.php?code=' . $unEleve['code'];

                    ?>
                    <!-- affiche la card de l'eleve avec les informations recuperees répéter par le nombre d'eleve qu'il y a -->
                    <article class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <!-- affiche les informations de l'eleve -->
                                <h5 class="card-title"><?php echo $nom . " " . $prenom ?></h5>
                                <p class="card-text"><?php echo $age ?> ans</p>
                                <p class="card-text"><?php echo $adresse ?></p>
                                <p class="card-text"><?php echo $ville ?></p>

                                <!-- lien vers la page des lecons de l'eleve -->
                                <a href="<?php echo $code ?>" class="card-link">Voir les leçons</a>
                            </div>
                        </div>

                        <br>
                    </article>
                    <!-- fin de la card et de la boucle -->
                <?php } ?>
            </div>
        </section>
    </div>
</div>


<?php

// affiche les informations du bas de page
include('include/footer.php'); ?>

</body>

</html>







