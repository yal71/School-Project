<?php
// résultat d'une manche
// affiche le score obtenu et permet de continuer


session_start();
require_once __DIR__ . '/fonctions.php';

verifier_session();

// recupérer le numéro de manche depuis l'URL et le convertir en entier pour la securite
$numero_manche = isset($_GET['manche']) ? intval($_GET['manche']) : 0;

// verification du numéro de manche
if ($numero_manche < 1 || $numero_manche > 5) {
    header("Location: /src/home.php");
    exit();
}

if (!isset($_SESSION['scores'][$numero_manche])) {
    header("Location: /src/round.php");
    exit();
}

// recuperation des données
$resultat = $_SESSION['scores'][$numero_manche];
$image    = $_SESSION['images'][$numero_manche - 1];

// calcul de lecart
$ecart = abs($resultat['annee_reelle'] - $resultat['annee_estimee']);

// calcule cumuler du score
$score_cumule = 0;
foreach ($_SESSION['scores'] as $score_manche) {
    $score_cumule += $score_manche['score'];
}

// determiner la next page
if ($numero_manche < 5) {
    $page_suivante = "/src/round.php";
    $texte_bouton  = "Manche " . ($numero_manche + 1);
} else {
    $page_suivante = "/src/end_game.php";
    $texte_bouton  = "Voir le résultat final";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr - Résultat Manche <?= $numero_manche ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<header>
    <h1>TimeGuessr</h1>
    <p>Résultat - Manche <?= $numero_manche ?> sur 5</p>
</header>

<main>

    <?php afficher_progression($numero_manche + 1); ?>

    <h2>Résultat de la manche <?= $numero_manche ?></h2>

    <img src="<?= htmlspecialchars($image['chemin']) ?>"
         alt="Photo de la manche <?= $numero_manche ?>"
         class="image-jeu">

    <div class="score-box">
        <p>Votre estimation : <strong><?= htmlspecialchars($resultat['annee_estimee']) ?></strong></p>
        <p>Année réelle : <strong><?= htmlspecialchars($resultat['annee_reelle']) ?></strong></p>
        <p>Écart : <strong><?= $ecart ?> an<?= $ecart > 1 ? 's' : '' ?></strong></p>
        <br>
        <p>Points gagnés :</p>
        <p><span class="score-points"><?= $resultat['score'] ?> pts</span></p>
    </div>

    <?php if (!empty($image['description'])): ?>
        <p><em>Photo : <?= htmlspecialchars($image['description']) ?></em></p>
    <?php endif; ?>

    <br>

    <p>Score cumulé après <?= $numero_manche ?> manche<?= $numero_manche > 1 ? 's' : '' ?> :
       <strong><?= $score_cumule ?> pts</strong>
    </p>

    <br>

    <a href="<?= htmlspecialchars($page_suivante) ?>" class="bouton">
        <?= $texte_bouton ?>
    </a>

</main>


</body>
</html>
