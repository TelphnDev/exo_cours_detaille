<?php

/*
 * la fonction permet de recuperer les statistiques de la satisfaction des bus
 * elle est utiliser dans ./frequenceBus.php ligne 20 et ./parCritere.php ligne 146
 */
function Get_stat_bus($bdd)
{
    $req = "
    # secltionne le degré et crée total qui est la somme de tous les commentaires de la satisfaction
    SELECT s.degre, COUNT(*) AS total
    FROM Commentaire c
        # le join permet de verifier si id satisfaction correspond a numSatisfaction dans commentaire
        # ce qui permet de ne prendre que les commentaires qui ont une satisfaction précise pour pouvoir faire le count
        JOIN Satisfaction s ON s.id = c.numSatisfaction
    # le group by permet de pouvoir afficher tout les resultats de la requette par ligne sinon voir image_1.png pour voir le resultat avec le group by voir image_2.png
    GROUP BY s.degre;
    ";
    $res = $bdd->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

/*
 * la fonction permet de recuperer les lignes et les stations
 * elle est utiliser dans ./ajout_com.php ligne 10
 */
function Get_station_ligne($bdd)
{
    $req = "SELECT * FROM ligne";
    $res = $bdd->query($req);
    $lesLignes = $res->fetchAll();

    $req = "SELECT * FROM station";
    $res = $bdd->query($req);
    $lesStations = $res->fetchAll();

    $donnees = [
        "lignes" => $lesLignes,
        "stations" => $lesStations
    ];
    return $donnees;
}


/*
 * fonction permet d'insérer un commentaire dans la base de données
 * elle est utiliser dans ./ajout_com.php ligne 27
 */
function insert_com($bdd, $donnees)
{
    try {
        $req = "
        INSERT INTO commentaire (numCritere, numLigne, numStation, numSatisfaction, commentaire)
        VALUES ('{$donnees['numCritere']}', '{$donnees['numLigne']}', '{$donnees['numStation']}', '{$donnees['numSatisfaction']}', '{$donnees['commentaire']}');
        ";
        $bdd->exec($req);
        return true;
    } catch (PDOException $e) {
        echo("Erreur lors de l'insertion : " . $e->getMessage());
        return false;
    }
}


/*
 * fonction recupère la connexion et ensuite retourne toutes les données de la table ligne
 * la fonction est appellé dans ./leslignes.php ligne 23
 */
function leslignes($bdd)
{
    /*
     * selectionne tout les champs de la table ligne et
     * ajoute une colonne "Count" qui est le nombre de ligne dans la table ligne
     * OVER() permet de calculer le total sans regrouper les lignes ce qui permet de faire un select * et un count en même temps
     * chaque ligne aura un count qui est le nombre de ligne dans la table ligne ce nombre est le même partout
     * exemple sans OVER() image_3.png et avec OVER() image_4.png
     */
    $req = "SELECT *, COUNT(*) OVER() AS Count FROM ligne;";
    $res = $bdd->query($req);
    $result = $res->fetchAll();
    return $result;
}


/*
 * requette recevant la connexion et retourne toutes les lignes qui n'ont pas de gichet automatique
 * la fonction est utliser dans ./sasnGA.php ligne 19
 */
function sansGichetAutomatique($bdd)
{
    $req = "
    # selection toute les lignes compte les sation sans point de vente

    /*
        Explication du SUM(COUNT(st.pointDeVente)) OVER() AS Total
    
        count permet de compter le nombre de station qui ont pas point de vente
        sum permet de faire la somme de tous les nombre de ligne qui ont un point de vente
        over permet de faire l'execution en paralèle ce qui permet de faire la somme de tous les nombre de ligne qui ont un point de vente et pas refaire nbGichetAutomatique
    */
    SELECT ln.*, COUNT(st.pointDeVente) AS nbGichetAutomatique, SUM(COUNT(st.pointDeVente)) OVER() AS Total
    FROM ligne ln
             # verifie si l'id se_situer correspond a la clés etranger de numLigne
             JOIN se_situer ss ON ln.id = ss.numLigne
             # verifie si l'id de station correspond a numStation se_situer
             JOIN station st ON ss.numStation = st.id
    
             # les join permettent de trouver le nom de la station tout en étant dans la table ligne
             # exemple ligne == 1 donne STA11, STA12, STA14, STA15, STA25
             # ensuite chaque sation est vérifier pour savoir si elle a un point de vente ou non (1 elle en a et 0 elle n'en a pas)
    # fais la verifications pour enlever les lignes qui ont un point de vente et laisser les lignes sans point de vente
    WHERE st.pointDeVente = 0
    # regroupe tout les résultats par ligne sinon voir image_1.png pour voir le resultat avec le group by voir image_2.png
    GROUP BY ln.id;
    ";
    $res = $bdd->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

/*
 * récupere tout les critères existants
 * la fonction est utiliser dans ./parCritere.php ligne 19
 */
function criteres($bdd)
{
    $req = "SELECT * FROM critere";
    $res = $bdd->query($req);
    $lesCriteres = $res->fetchAll();
    return $lesCriteres;
}



/*
 * récupere tout les critères existants
 * la fonction est utiliser dans ./parCritere.php ligne 182
 */
function criteres_satisfaction($bdd)
{
    $req = "
    select st.nomStation, ln.communeDepart, ln.communeArrivee, ln.id AS ID
    from station st
        join se_situer ss on st.id = ss.numStation
        join ligne ln on ss.numLigne = ln.id;
    ";
    $res = $bdd->query($req);
    $lesCriteres = $res->fetchAll();
    return $lesCriteres;
}


/*
 * récupere les point de vente
 * la fonction est utiliser dans ./parCritere.php ligne 208
 */
function point_vente_requette($bdd)
{
    $req = "
    select st.nomStation, ln.id as ID
    from station st
         join se_situer ss on st.id = ss.numStation
         join ligne ln on ss.numLigne = ln.id
    where st.pointDeVente = 1;
    ";
    $res = $bdd->query($req);
    $lesCriteres = $res->fetchAll();
    return $lesCriteres;
}


/*
 * récupere les informations de trafic
 * la fonction est utiliser dans ./parCritere.php ligne 195
 */
function info_trafic_requette($bdd)
{
    $req = "
    select com.commentaire   as commentaire,
       cr.libelle        as libelle,
       ln.communeDepart  as communeDepart,
       ln.communeArrivee as communeArrivee,
       sa.degre          as degre
    from commentaire com
         join critere cr on cr.id = com.numCritere
         join ligne ln on com.numLigne = ln.id
         join station st on com.numStation = st.id
         join satisfaction sa on com.numSatisfaction = sa.id
    ";
    $res = $bdd->query($req);
    $lesCriteres = $res->fetchAll();
    return $lesCriteres;
}
