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

// envoie la connexion et retourne le resultat de la requette sansGichetAutomatique ./bdd/requettes.php Ligne 90
$lignes = sansGichetAutomatique($bdd);
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
                <h1>Liste des Lignes sans gichet automatique <?php echo $lignes[0]['Total'] ?></h1>
            </div>
            <div class="row">

                <?php
                /*
                 * boucle sur les lignes actualise la vaible $uneLigne a chaque fois qu'il reboucle pour faire ligne par ligne
                 * ici il y a pas de besion de récupérer le nom de la clés
                 */
                foreach ($lignes as $uneLigne) {
                    // récupère les valeurs de chaque ligne
                    $id = $uneLigne['id'];
                    $depart = $uneLigne['communeDepart'];
                    $arrivee = $uneLigne['communeArrivee'];
                    $giche = $uneLigne['nbGichetAutomatique'];
                    ?>
                    <!-- crée une case par ligne avec les valeurs lui correspondant -->
                    <article class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <!-- le echo permet d'implementer le contenu de la variable dans le html et pouvoir l'afficher -->
                                <h5 class="card-title">Ligne : <?php echo $id ?></h5>
                                <p class="card-text">Départ : <?php echo $depart ?></p>
                                <p class="card-text">Arriver : <?php echo $arrivee ?></p>
                                <p class="card-text">Nombre sans giché automatique : <?php echo $giche ?></p>
                            </div>
                        </div>

                        <br>
                    </article>
                <?php } ?>
            </div>
        </section>
    </div>
</div>


<?php

// affichage du footer de ./fonction_commun/pageWeb.php Ligne 50
footer();