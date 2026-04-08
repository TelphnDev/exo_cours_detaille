<?php
function head()
{
    $adresse = $_SERVER['PHP_SELF'];
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>Transcite</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
              crossorigin="anonymous">
    </head>
    <body style="min-height: 100vh; display: flex; flex-direction: column;">

    <header class="bg-light py-5 mb-0">
        <div class="container text-center">
            <h1 class="display-4">Transcité</h1>
        </div>
    </header>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Travaux pratique Transcité : </a>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item" style="display: flex">
                    <a class="<?= ($adresse == "/leslignes.php") ? "navbar-brand" : "nav-link"; ?>"
                       href="../leslignes.php">Les lignes</a>
                    <a class="<?= ($adresse == "/sasnGA.php") ? "navbar-brand" : "nav-link"; ?>" href="../sasnGA.php">Sans
                        GA</a>
                    <a class="<?= ($adresse == "/frequenceBus.php") ? "navbar-brand" : "nav-link"; ?>"
                       href="../frequenceBus.php">Fréquence bus</a>
                    <a class="<?= ($adresse == "/parCritere.php") ? "navbar-brand" : "nav-link"; ?>"
                       href="../parCritere.php">Par critère</a>
                    <a class="<?= ($adresse == "/ajout_com.php") ? "navbar-brand" : "nav-link"; ?>"
                       href="../ajout_com.php">Ajout commentaire</a>
                </li>
            </ul>
        </div>
    </nav>
    <main style="flex: 1;">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <?php
}

function footer()
{
    ?>
    </main>
    <footer class="bg-light py-4">
        <div class="container text-center">
            <p class="mb-0">Site créé dans le cadre des ateliers professionnels</p>
        </div>
    </footer>

    </body>
    </html>
    <?php
}