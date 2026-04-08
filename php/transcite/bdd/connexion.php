<?php
/*
 * connexion a la base de donnee
 * ! faut modifier les parametres de connexion (le nom de la base de donnee, l'utilisateur, le mot de passe) le port peut être changer selon le SGBDR utilisé
 *
 * il est utiliser partout donc pas besion de dire ou il est utiliser
 */
function seConnecter()
{
    $serveur = 'mysql:host=localhost;port=3306';
    $bdd = 'dbname=transcite';
    $user = 'root';
    $mdp = '';

    // essaye la connexion
    try {
        // crée la connexion et récupère l'instance PDO qui est la connexion pour les requettes
        $pdo = new PDO($serveur . ';' . $bdd . ';charset=UTF8', $user, $mdp);
    // si sa fonctionne pas affiche un message d'erreur'
    } catch (PDOException $e) {
        // afficher le message d'erreur
        echo('Erreur : ' . $e->getMessage());
    }
    return $pdo;
}