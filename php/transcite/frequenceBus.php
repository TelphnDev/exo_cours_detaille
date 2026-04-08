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

// envoie la connexion et retourne le resultat de la requette Get_stat_bus ./bdd/requettes.php Ligne 7
// sa permet de récuperer un tableau près pour faire les statistiques et l'afficher
$lesbus = Get_stat_bus($bdd);

// envoie le tableau de la requette Get_stat_bus et retourne un tableau avec les statistiques dans ce fichier ligne 105
$lesStats = Stat_bus($lesbus);
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
                <h1>Liste des Statistiques de fréquence des bus</h1>
            </div>
            <!-- création d'un tableau -->
            <table class="table table-dark table-striped">
                <!-- texte de titre -->
                <!-- tr correspond à une ligne du tableau -->
                <tr>
                    <!-- th correspond à une colonne du tableau -->
                    <th>Nombre de commentaires selon le degré de satisfaction et le critère visé</th>
                    <th>Fréquence des bus</th>
                    <th>%</th>
                </tr>
                <?php
                /*
                 * boucle sur les lignes actualise la vaible $uneLigne a chaque fois qu'il reboucle pour faire ligne par ligne
                 * ici il y a besion de récupérer le nom de la clés
                 * la boucle récupère $lesStats a chaque boucle elle initialise le nom de la clé dans $cle et initialise la valeur de ce tableau dans $uneStat
                 */
                $total_bus = $lesStats['total'];
                foreach ($lesStats as $cle => $uneStat) {
                    $frequence = $uneStat;

                    // verification si le nom de la clé est total pour ne pas executer l'affichage de la ligne et l'afficher manuelement a la fin
                    if ($cle == 'total') continue;

                    // appel de la fonction pour calculer le pourcentage ./fonction_commun/liste_stat_bus.php Ligne 2
                    $pourcentage = Pourcentage_total($lesStats, $cle);
                    ?>
                    <!-- on crée une colonne pour chaque boucle -->
                    <tr>
                        <!-- le echo permet d'implementer le contenu de la variable dans le html et pouvoir l'afficher -->
                        <td><?php echo $cle ?></td>
                        <td><?php echo $frequence ?></td>
                        <td><?php echo $pourcentage ?>%</td>
                    </tr>
                <?php } ?>
                <!-- affichage du total manuelle pour être sur de ou sera afficher-->
                <tr>
                    <th>total</th>
                    <th><?php echo $total_bus ?></th>
                    <th>100</th>
                </tr>
            </table>


    </div>
    </section>
</div>
</div>


<?php

// calcul du pourcentage selon un tableaux complet (de la requettes de la base de données) et la clef pour savoir quel donnée a besion d'être calculer
// il est utiliser dans ce fichier ligne 66
function Pourcentage_total($total, $cles)
{
    $pourcentage = ($total[$cles] * 100 / $total['total']);
    return $pourcentage;
}

/*
 * recupère le tableau du résultat de la requette Get_stat_bus et retourne un tableau avec les statistiques
 * il est utiliser dans ce fichier ligne 23
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




// affichage du footer de ./fonction_commun/pageWeb.php Ligne 50
footer();