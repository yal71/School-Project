<?php
// contient le calcul du score, la vérification de session et la progression

//calcul du score pour une manche 

function calculer_score($annee_reelle, $annee_estimee) {
    // calcul de l'ecart
    $difference = abs($annee_reelle - $annee_estimee);

    // score = 1000 - (écart * 10), mais jamais en dessous de 0
    $score = max(0, 1000 - ($difference * 10));

    return $score;
}


// verifie qu'une session de jeu est active 
function verifier_session() {
    if (!isset($_SESSION['partie_id']) || !isset($_SESSION['images'])) {
        header("Location: /src/home.php");
        exit();
    }
}

// affiche la barre de progression des 5 manches

function afficher_progression($manche_actuelle) {
    echo '<div class="progression">';

    for ($i = 1; $i <= 5; $i++) {
        if ($i < $manche_actuelle) {
            echo '<div class="manche-indicateur terminee">' . $i . '</div>';
        } elseif ($i === $manche_actuelle) {
            echo '<div class="manche-indicateur active">' . $i . '</div>';
        } else {
            echo '<div class="manche-indicateur">' . $i . '</div>';
        }
    }

    echo '</div>';
}
?>
