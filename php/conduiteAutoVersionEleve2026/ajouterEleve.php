
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

// verifie si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // ajoute les valeur post dans les variables
    $nom = $_POST['txtNom'];
    $prenom = $_POST['txtPrenom'];
    $dateNaissance = $_POST['txtDateNaiss'];
    $dateInscription = $_POST['txtDateInsc'];
    $rue = $_POST['txtRue'];
    $codePostal = $_POST['txtCP'];
    $ville = $_POST['txtVille'];
    $nombre_heure = $_POST['txtNbHeures'];

    // appelle la fonction addEleve() dans le fichier ./include/biblioAccesBDD.php ligne 113
    // elle récupère tout les champs + la connexion pour ensuite faire l'insertion dans la table eleve et retourne true si c'est bon'
    $result = addEleve($bdd, $nom, $prenom, $dateNaissance, $dateInscription, $rue, $codePostal, $ville, $nombre_heure);

    // si l'insertion est bon on redirige vers la page eleves.php'
    if ($result === true) {
        if (session_status() == PHP_SESSION_NONE or session_status() == PHP_SESSION_DISABLED) {
            ob_start();
            session_start();
        }
        // initialisation des variables de session pour afficher un message de succès
        $_SESSION['eleve_ajoute'] = true;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;

        // redirection vers la page eleves.php
        header('Location: eleves.php');
        // coupure de l'execution du script
        exit();
    } else {
        // si l'insertion n'est pas bon on affiche un message d'erreur
        echo "<div class='alert alert-danger' role='alert'>Erreur lors de l'ajout de l'élève : <?php $result ?></div>" ;
    }
}
?>


<!-- formulaire -->
<div class="mt-4 d-flex">
    <div>
        <h3>Ajout d'un élève</h3>
    </div>
    <div class="w-75" style="margin-left: 2vw">
        <!-- l'action pointe le fichier de redirection de traitement la methode post (cache les informations) la get (l'affiche dans l'url) -->
        <form action="ajouterEleve.php" method="post">
            <div class="form-group">
                <label for="txtNom">Nom :</label>
                <input type="text" class="form-control w-100" id="txtNom" name="txtNom" required>
            </div>
            <div class="form-group">
                <label for="txtPrenom">Prénom :</label>
                <input type="text" class="form-control w-100" id="txtPrenom" name="txtPrenom" required>
            </div>
            <div class="form-group">
                <label for="txtDateInsc">Date d'inscription :</label>
                <input type="date" class="form-control w-100" id="txtDateInsc" name="txtDateInsc" required>
            </div>
            <div class="form-group">
                <label for="txtDateNaiss">Date de naissance :</label>
                <input type="date" class="form-control w-100" id="txtDateNaiss" name="txtDateNaiss" required>
            </div>
            <div class="form-group">
                <label for="txtRue">Rue :</label>
                <input type="text" class="form-control w-100" id="txtRue" name="txtRue">
            </div>
            <div class="form-group">
                <label for="txtCP">Code postal :</label>
                <input type="number" class="form-control w-100" id="txtCP" name="txtCP" pattern="[0-9]{5}" required>
            </div>
            <div class="form-group">
                <label for="txtVille">Ville :</label>
                <input type="text" class="form-control w-100" id="txtVille" name="txtVille" required>
            </div>
            <div class="form-group">
                <label for="txtNbHeures">Nombre heures de conduite :</label>
                <input type="number" class="form-control w-100" id="txtNbHeures" name="txtNbHeures" required>
            </div>

            <!-- nomme le boutton pour valider que le remplissage est bien fais via les conditions plus haut ligne 29 -->
            <button type="submit" class="btn btn-primary" name="submit">Valider</button>
        </form>
    </div>
</div>

