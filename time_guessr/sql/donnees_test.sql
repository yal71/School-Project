

USE timeguessr;

-- desactive les verif de clé entrangere
-- pour vider les tables sans erreur
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE manches;
TRUNCATE TABLE parties;
TRUNCATE TABLE images;

-- reactive les verifs
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO images (chemin, annee, description) VALUES

(
    'https://media.vanityfair.fr/photos/6492c4cb5fe54544cc504384/16:9/w_2240,c_limit/gettyimages-76214611-vertical.jpg',
    1987,
    'Lady Diana'
),

(
    'https://www.revuedesdeuxmondes.fr/wp-content/uploads/2015/11/dr-martin-luther-king-1.jpg',
    1963,
    'Discours de Martin Luther King'
),

(
    'https://www.geekzone.fr/wp-content/uploads/2017/01/LiveAid1985_03.jpg',
    1985,
    'Queen au Live Aid'
),

(
    'https://www.franceinfo.fr/pictures/TF6hFUMALK-Y7tEjL-LcRxuIpHY/0x0:3747x2106/1328x747/filters:format(avif):quality(50)/2019/11/05/phpHF0DoV.jpg',
    1989,
    'Chute du mur de Berlin'
),

(
    'https://www.francebleu.fr/pikapi/images/02b1726f-906e-441b-8445-9cdd594e89d0/1200x680',
    2004,
    'Premier mariage homosexuel'
);
