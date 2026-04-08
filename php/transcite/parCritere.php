<!-- ajout de bootstrap -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<?php
// page principale

// import des fonctions communes
include('./fonction_commun/pageWeb.php');

// affichage du header de ./fonction_commun/pageWeb.php Ligne 2
head();

// import des fonctions de la BDD
include('./bdd/connexion.php');
include('./bdd/requettes.php');

// connexion à la base de données ./bdd/connexion.php Ligne 8
// recupere la connexion
$bdd = seConnecter();

// recupere la liste des stations et lignes dans requettes.php ligne 28
$station_ligne = Get_station_ligne($bdd);

// verifie toute les variables du post
if (isset($_POST['add']) and isset($_POST['station']) and isset($_POST['ligne']) and isset($_POST['critere']) and isset($_POST['satisfaction']) and isset($_POST['commentaire'])) {
    // creation du tableau pour tout enregistrer
    $donnees = [];
    $donnees['numStation'] = $_POST['station'];
    $donnees['numLigne'] = $_POST['ligne'];
    $donnees['numCritere'] = $_POST['critere'];
    $donnees['numSatisfaction'] = $_POST['satisfaction'];
    $donnees['commentaire'] = $_POST['commentaire'];

    // verifie si les données son bien mis via la fonction insert_com() dans requettes.php ligne 50
    if (insert_com($bdd, $donnees)) { ?>
        <div class="alert alert-success" role="alert">
            Commentaire ajouté avec succès !
        </div>
        <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">
            Une erreur est survenue lors de l'ajout du commentaire.
        </div>
        <?php
    }
    // si aucune une ou plusieurs variables n'est pas set alors on affiche le formulaire
} else { ?>
    <h2 style="text-align: center;">Ajouter un commentaire</h2>
<?php }

?>
<form action="ajout_com.php" method="post"
      style="margin: 4vh auto; max-width: 400px; border: 1px solid #ccc; padding: 20px; border-radius: 8px;">

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="station">Station:</label>


        <select name="station" id="station" class="form-control" required>
            <option value="0" disabled selected>--Please choose an option--</option>
            <?php
            // boucle pour afficher les stations en tant que options
            foreach ($station_ligne['stations'] as $station) {
                echo "<option value='" . $station['id'] . "'>" . $station['nomStation'] . "</option>";
            }
            ?>
        </select>
    </div>


    <div class="form-group" style="margin-bottom: 20px;">
        <label for="ligne">Ligne:</label>
        <select name="ligne" id="ligne" class="form-control" required>
            <option value="0" disabled selected>--Please choose an option--</option>
            <!-- boucle pour afficher les lignes en tant que options -->
            <?php
            foreach ($station_ligne['lignes'] as $ligne) {
                echo "<option value='" . $ligne['id'] . "'>" . $ligne['communeDepart'] . " - " . $ligne['communeArrivee'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="critere">critere souhaiter:</label>
        <select name="critere" id="critere" class="form-control" required>
            <option value="0" disabled selected>--Please choose an option--</option>
            <option value="1">Très satisfait</option>
            <option value="2">Satisfait</option>
            <option value="3">Réservé</option>
            <option value="4">Insatifait</option>
        </select>
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="satisfaction">satisfaction:</label>
        <select name="satisfaction" id="satisfaction" class="form-control" required>
            <option value="0" disabled selected>--Please choose an option--</option>
            <option value="1">Très satisfait</option>
            <option value="2">Satisfait</option>
            <option value="3">Réservé</option>
            <option value="4">Insatifait</option>
        </select>
    </div>

    <input type="text" required name="commentaire" class="form-control" placeholder="Commentaire"
           style="margin-bottom: 20px;" required>

    <button type="submit" class="btn btn-primary" name="add">Submit</button>
</form>
