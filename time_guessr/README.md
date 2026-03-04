# TimeGuessr

## Lancement


Dans le bash 

cd C:\...\time_guessr

Créer la base de données ->

mysql -u root -p < sql/schema.sql

Insérer les images ->

mysql -u root -p timeguessr < sql/donnees_test.sql


Lancer le serveur ->


php -S localhost:8000

Ouvrir dans le navigateur ->


http://localhost:8000

## ATTENTION 

Si besoin, modifier les identifiants dans `src/connexion.php` pour mysql

Verifier aussi si dans php.ini souvent dans C:/php/php.ini verifier que 

;extension_dir = "ext" est écris comme ça extension_dir = "ext"
;extension=pdo_mysql est écris comme ça extension=pdo_mysql
;extension=mysqli est écris comme ça extension=mysqli

