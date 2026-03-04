<?php
// valeurs a modifer en focntion de votre sql
$hote     = "localhost";      
$nom_bdd  = "timeguessr";    // Nom de la bdd
$user_bdd = "root";          // user mysql
$mdp_bdd  = "adminpw";       // mdp mysql

// creation de la connexion pdo
try {
    $pdo = new PDO(
        "mysql:host=$hote;dbname=$nom_bdd;charset=utf8",
        $user_bdd,
        $mdp_bdd
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // messqge d'erreur si la connexion echoue
    die(
        "<p style='color:red; font-family:Arial; padding:20px;'>" .
        "<strong>Erreur de connexion à la base de données :</strong><br>" .
        htmlspecialchars($e->getMessage()) .
        "<br><br>Vérifiez que MySQL est bien lancé et que la base 'timeguessr' existe." .
        "</p>"
    );
}
?>
