<?php


// premiere fonction pour se connecter a la base de donnees pas appeler
function seConnecter()
{// port 3306 si mysql et 3307 si mariadb
    $serveur = 'mysql:host=localhost;port=3306';
    $bdd = 'dbname=auto_ecole';
    $user = 'root';
    $mdp = '';
    try {
        $pdo = new PDO($serveur . ';' . $bdd . ';charset=UTF8', $user, $mdp);
    } catch (PDOException $e) {
        echo('Erreur : ' . $e->getMessage());
    }
    return $pdo;
}

// deuxieme fonction pour se connecter a la base de donnees appeler dans ./include/header.php ligne 5
function seConnecter_2()
{// port 3306 si mysql et 3307 si mariadb
    $serveur = 'mysql:host=localhost;port=3306';
    $bdd = 'dbname=auto_ecole';
    $user = 'conduiteauto';
    $mdp = 'P@ssw0rd';
    try {
        $pdo = new PDO($serveur . ';' . $bdd . ';charset=UTF8', $user, $mdp);
    } catch (PDOException $e) {
        echo('Erreur : ' . $e->getMessage());
    }
    return $pdo;
}

// recupere les eleves de la base de donnees appeler dans ./eleves.php ligne 18
function getLesEleves($bdd)
{
    // enregistrement de la requette sql
    $req = "
    /* selectionne tout les champs de la table eleve et crée une colonne age */
    /* Décomposition de age
    
    - NOW() : retourne la date et l’heure actuelles.
    - dateNaissance : la date de naissance de la personne.
    
    - DATEDIFF(NOW(), dateNaissance) : calcule le nombre de jours entre aujourd’hui et la date de naissance.
    - FROM_DAYS(...) : transforme ce nombre de jours en une date “fictive” correspondante.
    - DATE_FORMAT(..., '%Y') : extrait l’année de cette date fictive.
    - + 0 : convertit le résultat en nombre entier au lieu d’une chaîne de caractères.
    - AS age : donne le nom age à la colonne calculée. */
    
    SELECT *, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), dateNaissance)), '%Y') + 0 AS age
    FROM eleve
    
    /* trie par date d'inscription décroissante */
    order by dateInscription desc;";
    // execution de la requette
    $res = $bdd->query($req);
    // recuperation des lignes
    $lesLignes = $res->fetchAll();
    // retour des lignes
    return $lesLignes;
}

// recupere le nombre d'eleves de la base de donnees appeler dans ./eleves.php ligne 22
function getNbrEleves($bdd)
{
    // requette sql pour compter le nombre d'eleve
    $req_nbr = "
    /* compter le nombre d'eleve enregistré dans la table eleve via la donnée code (lors de suppression d'utilisateur il peut avoir a force des code elevé par rapport au nombre réelle enregistré seul le nombre enregistré est compté et pas le code eleve) */
    select count(code) from eleve";
    // execution de la requette
    $res_nbr = $bdd->query($req_nbr);
    // recuperation des lignes
    $lesLignes_nbr = $res_nbr->fetchAll();
    // retour du nombre d'eleve via le parametre 0 de la table
    return $lesLignes_nbr[0][0];
}

// recupere un eleve de la base de donnees appeler dans ./lecons.php ligne 39
function getUnEleve($bdd, $code)
{
    // requette sql pour recuperer un eleve
    $req = "
    /* recuperer les donnée d'un eleve via son code */
    /* le code est récupéré en php via l'url */
    Select * from eleve where code='$code'";
    // execution de la requette
    $res = $bdd->query($req);
    // recuperation de la ligne
    $lesLignes = $res->fetch();
    // retour de la ligne
    return $lesLignes;
}

// recupere les lecons d'un eleve de la base de donnees appeler dans ./lecons.php ligne 42
function getLesLeconsUnEleve($bdd, $code)
{
    // requette sql pour recuperer les lecons d'un eleve'
    $req = "
    /* recupère les lecons d'un eleve via son code */
    /* le code est récupéré en php via l'url */
    Select * from lecon where codeEleve='$code'";
    // execution de la requette
    $res = $bdd->query($req);
    // recuperation des lignes
    $lesLignes = $res->fetchAll();
    // retour des lignes
    return $lesLignes;

}

// ajoute un eleve a la base de donnees appeler dans ./ajouterEleve.php ligne 42
function addEleve($bdd, $nom, $prenom, $dateNaissance, $dateInscription, $rue, $codePostal, $ville, $nombre_heure)
{
    try {
        $req = "Insert into eleve (nom, prenom, dateNaissance, dateInscription, adresseRue, codePostal, ville, nbHeuresConduite) values ('$nom', '$prenom', '$dateNaissance', '$dateInscription', '$rue', '$codePostal', '$ville', '$nombre_heure')";
        $res = $bdd->query($req);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}


// supprime un eleve de la base de donnees appeler dans ./supprimerLecon.php ligne 66
function deleteLecon($bdd, $date, $codeEleve)
{
    try {
        $req = "Delete from lecon where dateLecon='$date' and codeEleve='$codeEleve'";
        $res = $bdd->query($req);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}