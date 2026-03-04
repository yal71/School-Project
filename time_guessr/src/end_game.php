<?php
// fin de partie affiche le score totale et permet de recommencer une partie

session_start();
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/fonctions.php';

// verifier que la session est active
verifier_session();

// verifier que les 5 manches ont bien été jouées
if (count($_SESSION['scores']) < 5) {
    header("Location: /src/home.php");
    exit();
}

// Calculer le score total de la partie
$score_total = 0;
foreach ($_SESSION['scores'] as $score_manche) {
    $score_total += $score_manche['score'];
}

// save le score total dans la base de données
$requete = $pdo->prepare("UPDATE parties SET score_total = ? WHERE id = ?");
$requete->execute([$score_total, $_SESSION['partie_id']]);

// clear quand la partie est finie
unset($_SESSION['partie_id']);
unset($_SESSION['images']);
unset($_SESSION['scores']);
unset($_SESSION['manche_actuelle']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr - Résultat Final</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<header>
    <h1>TimeGuessr</h1>
    <p>Résultat Final</p>
</header>

<main>

    <?php afficher_progression(6); ?>

    <h2>Partie terminée</h2>

    <div class="bloc-score-final">
        <p>Votre score total</p>
        <span class="score-total"><?= $score_total ?> <small>/ 5 000</small></span>
    </div>

    <br>

    <div class="centre">
        <a href="/src/home.php" class="bouton">Rejouer une partie</a>
    </div>

</main>


</body>
</html>
