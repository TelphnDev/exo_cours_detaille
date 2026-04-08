<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<?php
include "./bdd/connexion.php";
$bdd = seConnecter();

include "./bdd/requettes.php";

$station_ligne = Get_station_ligne($bdd);


include('fonction_commun/pageWeb.php');

head();

if (isset($_POST['add']) and isset($_POST['station']) and isset($_POST['ligne']) and isset($_POST['critere']) and isset($_POST['satisfaction']) and isset($_POST['commentaire'])) {

    $donnees = [];
    $donnees['numStation'] = $_POST['station'];
    $donnees['numLigne'] = $_POST['ligne'];
    $donnees['numCritere'] = $_POST['critere'];
    $donnees['numSatisfaction'] = $_POST['satisfaction'];
    $donnees['commentaire'] = $_POST['commentaire'];


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
