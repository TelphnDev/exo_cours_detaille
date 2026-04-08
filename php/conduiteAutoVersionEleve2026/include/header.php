<?php
// importation du fichier ./biblioAccesBDD.php qui contient la fonction de connexion a la base de données
include("biblioAccesBDD.php");
// connexion a la base de données via la fonction seConnecter_2() qui est dans le fichier ./biblioAccesBDD.php Ligne 19
$bdd=seConnecter_2();
?>
<!-- Le header est le titre de la page Conduite Auto en fond blanc -->
<header class="bg-light py-5 mb-0">
  <div class="container text-center">
    <h1 class="display-4">Conduite Auto</h1>
  </div>
</header>