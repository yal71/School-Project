<?php
// page de manche, unique pour chanque manche grace a la session

session_start();
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/fonctions.php';

// verif de la session
verifier_session();

// permet de savoir la manche actuel si aucune manche active on commence a la manche 1
if (!isset($_SESSION['manche_actuelle'])) {
    $_SESSION['manche_actuelle'] = 1;
}

$numero_manche = $_SESSION['manche_actuelle'];

// si 5 manche deja faites on va à la fin
if ($numero_manche > 5) {
    header("Location: /src/end_game.php");
    exit();
}

// récupérer l'image en focntion de la manche
$image = $_SESSION['images'][$numero_manche - 1];

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // recuperer l'année saisie et la convertir en entier
    $annee_saisie = isset($_POST['annee']) ? intval($_POST['annee']) : 0;

    // validation des données pour eviter les eerreurs
    if ($annee_saisie < 1826 || $annee_saisie > (int)date('Y')) {
        $erreur = "⚠️ Veuillez entrer une année valide entre 1826 et " . date('Y') . ".";
    } else {
        //calcul du score
        $score_manche = calculer_score($image['annee'], $annee_saisie);

        //sauve le resultats dans la sessions
        $_SESSION['scores'][$numero_manche] = [
            'annee_estimee' => $annee_saisie,
            'annee_reelle'  => $image['annee'],
            'score'         => $score_manche
        ];

        $requete = $pdo->prepare(
            "UPDATE manches SET annee_estimee = ?, score = ?
             WHERE partie_id = ? AND numero_manche = ?"
        );
        $requete->execute([
            $annee_saisie,
            $score_manche,
            $_SESSION['partie_id'],
            $numero_manche
        ]);

        // +1 pour la prochaine manche
        $_SESSION['manche_actuelle'] = $numero_manche + 1;

        header("Location: /src/round_res.php?manche=" . $numero_manche);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr - Manche <?= $numero_manche ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<header>
    <h1>TimeGuessr</h1>
    <p>Manche <?= $numero_manche ?> sur 5</p>
</header>

<main>

    <?php afficher_progression($numero_manche); ?>

    <h2>Manche <?= $numero_manche ?> / 5</h2>

        <img src="<?= htmlspecialchars($image['chemin']) ?>"
         alt="Photo historique à deviner"
         class="image-jeu">

    <!-- affichage d'erreur si année invalide -->
    <?php if ($erreur !== ""): ?>
        <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <!-- Formulaire pour lestimation de l'année  -->
    <form method="POST" action="/src/round.php" class="formulaire-annee">

        <label for="annee">Votre estimation de l'année :</label>

        <input type="number"
               id="annee"
               name="annee"
               min="1826"
               max="<?= (int)date('Y') ?>"
               placeholder="Ex: 1945"
               required>

        <button type="submit" class="bouton">Valider mon estimation</button>
    </form>

</main>


</body>
</html>
