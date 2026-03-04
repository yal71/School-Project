<?php
//page d'acceuil

session_start();
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/fonctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    unset($_SESSION['partie_id']);
    unset($_SESSION['images']);
    unset($_SESSION['scores']);
    unset($_SESSION['manche_actuelle']);

    $requete = $pdo->prepare("INSERT INTO parties (date_creation) VALUES (NOW())");
    $requete->execute();
    $partie_id = $pdo->lastInsertId();

    $requete = $pdo->query("SELECT * FROM images ORDER BY RAND() LIMIT 5");
    $images  = $requete->fetchAll(PDO::FETCH_ASSOC);

    if (count($images) < 5) {
        die("Erreur : il faut au moins 5 images dans la base de données.");
    }

    for ($i = 0; $i < 5; $i++) {
        $requete = $pdo->prepare(
            "INSERT INTO manches (partie_id, image_id, numero_manche) VALUES (?, ?, ?)"
        );
        $requete->execute([$partie_id, $images[$i]['id'], $i + 1]);
    }

    $_SESSION['partie_id']       = $partie_id;
    $_SESSION['images']          = $images;
    $_SESSION['scores']          = [];
    $_SESSION['manche_actuelle'] = 1;

    header("Location: /src/round.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<main class="accueil-centre">
    <h1 class="titre-accueil">TimeGuessr</h1>
    <form method="POST" action="/src/home.php">
        <button type="submit" class="bouton">Démarrer une partie</button>
    </form>
</main>

</body>
</html>
