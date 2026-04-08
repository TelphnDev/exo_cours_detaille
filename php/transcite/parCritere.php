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

// envoie la connexion et retourne le ./bdd/requettes.php Ligne 140
$lesCriteres = criteres($bdd);

// si critere existe alors on l'affiche sinon on affiche le select choisi sinon on affiche le select vide
if (isset($_POST['critere'])) {
    // recupere le critere choisi
    $critereChoisi = $_POST['critere'];
} else {
    // on le laisse a null pour mettre le select vide car la value est vide
    $critereChoisi = null;
}
?>
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <section>
                <!-- titre avec un visuel du nombre de ligne -->
                <div class="d-flex justify-content-between align-items-center">
                    <!--
                    $lignes[0]['Count'] est le nombre de ligne
                    c'est le nombre de ligne dans la table ligne un nombre
                    par defaut il y a toujours la table 0 sauf si il est vide
                    on peut nomé la clé du tableau mais on peut quand même acceder par les index exemple 0
                    -->
                    <h1>Liste des Statistiques de fréquence des bus par critère</h1>
                </div>
                <div style="margin-bottom: 1vh; border: 1px solid black">
                    <!--
                    le formulaire permet de choisir le critere
                    l'action est le fichier ou est rediriger le formulaire
                    le method est le type de requete post (cacher les données) get (l'afficher dans l'url)
                     -->
                    <form action="parCritere.php" method="post" style="display: flex; gap: 1vh; margin: 1%">
                        <!-- le select permet de choisir le critere il a required pour le rendre obligatoire critere est le nom de la variable-->

                        <select class="form-select" name="critere" style="max-width: 15vw" required>
                            <!--
                            option est une option possible dans le select la value permet de recuperer la valeur que l'on veut elle sera dans critere
                            disabled permet de ne pas pouvoir le selectionner et l'afficher que au débutpour dire ce qu'il faut faire ou a quoi sa sert
                            !$critereChoisi ? 'selected' : '' permet de selectionner ou pas l'option pour l'afficher en premmier mais d'abords il faut remplir au moins une fois le formulaire
                            -->
                            <option value="" disabled <?php echo $critereChoisi == null ? 'selected' : '' ?>>
                                Choisissez le critère
                            </option>

                            <!-- boucle sur les citeres réuperé de la BDD (sous forme de tableau) pour les afficher dans le select -->
                            <!-- ici il y a pas de besion de récupérer le nom de la clés -->
                            <?php foreach ($lesCriteres as $critere): ?>
                                <!-- crée l'option avec la valeur de l'id et le libelle pour l'afficher dans le tableau lors de la selection -->
                                <option value="<?php echo $critere['id'] ?>"
                                        <!-- fais un echo pour mettre ke resultat dans le select -->
                                        <!-- $critereChoisi == $critere['id'] ? 'selected' : '' fais la verification si c'est la bonne valeur pour le mettre en select sinon rien -->
                                        <?php echo $critereChoisi == $critere['id'] ? 'selected' : '' ?>
                                    <!-- afficher le libelle -->
                                    <?php echo $critere['libelle'] ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                        <!-- bouton pour valider le formulaire -->
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>

                <!-- fais appelle a la fonction qui affiche le critere choisi -->
                <!-- si critereChoisi est choisi sa affiche le tableau le concernant sinon sa affiche rien -->
                <?php if ($critereChoisi): ?>
                    <?php
                    $critereChoisi = (int)$critereChoisi;

                    if ($critereChoisi === 1) {
                        // appel de la fonction pour afficher les statistiques de ce fichier ligne 144
                        afficherStatistiques($bdd);
                    } elseif ($critereChoisi === 2) {
                        // appel de la fonction pour afficher les itineraires de ce fichier ligne 179
                        afficherItineraires($bdd);
                    } elseif ($critereChoisi === 3) {
                        // appel de la fonction pour afficher les trafics de ce fichier ligne 192
                        afficherInfoTrafic($bdd);
                    } elseif ($critereChoisi === 4) {
                        // appel de la fonction pour afficher les points de vente de ce fichier ligne 205
                        afficherPointsVente($bdd);
                    }
                    ?>
                <?php endif; ?>

            </section>
        </div>
    </div>


<!-- affichage du footer de ./fonction_commun/pageWeb.php Ligne 48 -->
<?php footer(); ?>

<?php
/*
 * affiche le tableau generale
 * la fonction est appelé dans ce fichier ligne 174, 183 et 192
 *
 * $headers liste des titres des colonnes (affichés dans l'en-tête du tableau)
 * $rows tableau contenant les données (chaque élément = une ligne)
 * $keys liste des clés utilisées pour afficher les valeurs de chaque ligne
 */
function afficherTableau($headers, $rows, $keys): void
{ ?>
    <table class="table table-dark table-striped">

        <tr>
            <?php foreach ($headers as $titre): ?>
                <th><?= $titre ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach ($rows as $ligne): ?>
            <tr>
                <?php foreach ($keys as $cle): ?>
                    <td><?= $ligne[$cle] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>

    </table>
<?php }

/*
 * affiche le tableau des statistiques
 * la fonction est appelé dans ce fichier ligne 88
 */
function afficherStatistiques($bdd): void
{
    $lesStats = Stat_bus(Get_stat_bus($bdd));
    $total = $lesStats['total'];
    ?>
    <table class="table table-dark table-striped">
        <tr>
            <th>Degré de satisfaction</th>
            <th>Fréquence</th>
            <th>%</th>
        </tr>

        <?php foreach ($lesStats as $degre => $frequence): ?>
            <?php if ($degre === 'total') continue; ?>
            <tr>
                <td><?= $degre ?></td>
                <td><?= $frequence ?></td>
                <td><?= Pourcentage_total($lesStats, $degre) ?>%</td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <th>Total</th>
            <th><?= $total ?></th>
            <th>100</th>
        </tr>
    </table>
    <?php
}



/*
 * envoie les informations des itineraires a afficherTableau() dans ce fichier 91
 */
function afficherItineraires($bdd): void
{
    $titres = ['Nom des stations', 'Commune départ', 'Commune arrivée'];
    $donnees = criteres_satisfaction($bdd);
    $cles = ['nomStation', 'communeDepart', 'communeArrivee'];

    afficherTableau($titres, $donnees, $cles);
}


/*
 * envoie les informations des trafics a afficherTableau() dans ce fichier 94
 */
function afficherInfoTrafic($bdd): void
{
    $titres = ['Libellé', 'Commune départ', 'Commune arrivée', 'Degré', 'Commentaire'];
    $donnees = info_trafic_requette($bdd);
    $cles = ['libelle', 'communeDepart', 'communeArrivee', 'degre', 'commentaire'];

    afficherTableau($titres, $donnees, $cles);
}


/*
 * envoie les informations des Points de ventes a afficherTableau() dans ce fichier 97
 */
function afficherPointsVente($bdd): void
{
    $titres = ['Nom de ligne', 'Nom station'];
    $donnees = point_vente_requette($bdd);
    $cles = ['nomStation', 'ID'];

    afficherTableau($titres, $donnees, $cles);
}


// calcul du pourcentage selon un tableaux complet (de la requettes de la base de données) et la clef pour savoir quel donnée a besion d'être calculer
// il est utiliser dans ce fichier ligne 161 et 217
function Pourcentage_total($total, $cles)
{
    $pourcentage = ($total[$cles] * 100 / $total['total']);
    return $pourcentage;
}


/*
 * recupère le tableau du résultat de la requette Get_stat_bus et retourne un tableau avec les statistiques
 * il est utiliser dans ce fichier ligne 232 et 233
 */
 function Stat_bus($les_stats_bus)
{
    $total = [];
    $total['total'] = 0;
    foreach ($les_stats_bus as $stat_bus) {
        $total[$stat_bus['degre']] = $stat_bus['total'];
        $total['total'] += $stat_bus['total'];

    }
    return $total;
}