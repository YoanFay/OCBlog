<?php

require_once('src/Core/Bdd.php');
require_once('src/Core/Upload.php');
require_once('src/Service/UploadService.php');

use App\Src\Core\Bdd;
use App\Src\Service\UploadService;

$bdd = new Bdd();
$upload = new UploadService();

//Création Admin

$reqRole = "INSERT INTO role VALUES (NULL, :name, :code, :level)";
$reqUser = 'INSERT INTO user VALUES(NULL, :lastname, :firstname, :login, :password, :created, :avatar, :role)';

$infoRole = [
    'name' => "Super Admin",
    'code' => "superAdmin",
    'level' => 99,
];

$bdd->query($reqRole, $infoRole);
$idRole = $bdd->lastInsert();

$infoAdmin = [
    'lastname' => "Fayolle",
    'firstname' => "Yoan",
    'login' => "yF-OcBlog",
    'password' => password_hash("mDp@dmin", PASSWORD_BCRYPT),
    'created' => date_format(new DateTime(), 'Y-m-d H:i:s'),
    'role' => $idRole,
    "avatar" => $upload->uploadDefaultUser("Yoan", "Fayolle")
];

$bdd->query($reqUser, $infoAdmin);
$idSuperAdmin = $bdd->lastInsert();

$infoRole = [
    'name' => "Admin",
    'code' => "admin",
    'level' => 80,
];

$bdd->query($reqRole, $infoRole);
$idRole = $bdd->lastInsert();

$infoAdmin = [
    'lastname' => "Fayolle",
    'firstname' => "Mute",
    'login' => "mF-LeCh@t",
    'password' => password_hash("mDpCh@t", PASSWORD_BCRYPT),
    'created' => date_format(new DateTime(), 'Y-m-d H:i:s'),
    'role' => $idRole,
    "avatar" => $upload->uploadDefaultUser("Mute", "Fayolle")
];

$bdd->query($reqUser, $infoAdmin);
$idAdmin = $bdd->lastInsert();

//Création Utilisateur

$infoRole = [
    'name' => "Utilisateur",
    'code' => "user",
    'level' => 10,
];

$bdd->query($reqRole, $infoRole);
$idRole = $bdd->lastInsert();

$startdate = '01 March 2023';
$enddate = '14 April 2023';

$infoUsers = [
    [
        "lastname" => "Dubois",
        "firstname" => "Émilie",
        "login" => "edubois92",
        "password" => password_hash("xB8!tZmKw3", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Émilie", "Dubois")
    ],
    [
        "lastname" => "Garcia",
        "firstname" => "Samuel",
        "login" => "sgarcia13",
        "password" => password_hash("mD9#sQfLh7", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Samuel", "Garcia")
    ],
    [
        "lastname" => "Nguyen",
        "firstname" => "Kim",
        "login" => "knguyen_84",
        "password" => password_hash("pJ6@wHnFz5", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Kim", "Nguyen")
    ],
    [
        "lastname" => "Dupont",
        "firstname" => "Nicolas",
        "login" => "ndupont22",
        "password" => password_hash("rN3bVdEg8", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Nicolas", "Dupont")
    ],
    [
        "lastname" => "Martinez",
        "firstname" => "Carmen",
        "login" => "cmartinez_78",
        "password" => password_hash("kH5%mPnXu2", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Carmen", "Martinez")
    ],
    [
        "lastname" => "Smith",
        "firstname" => "Michael",
        "login" => "msmith_16",
        "password" => password_hash("tJ7^rVbQf6", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Michael", "Smith")
    ],
    [
        "lastname" => "Rousseau",
        "firstname" => "Sophie",
        "login" => "srousseau_91",
        "password" => password_hash("fR4!cNpSd9", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Sophie", "Rousseau")
    ],
    [
        "lastname" => "Lee",
        "firstname" => "Kevin",
        "login" => "klee_07",
        "password" => password_hash("zD2#gTlMh5", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Kevin", "Lee")
    ],
    [
        "lastname" => "Garcia",
        "firstname" => "Ana",
        "login" => "agarcia_23",
        "password" => password_hash("yE8@nWfBm6", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Ana", "Garcia")
    ],
    [
        "lastname" => "Martin",
        "firstname" => "Jean",
        "login" => "jmartin_69",
        "password" => password_hash("bK4%pTqLs9", PASSWORD_BCRYPT),
        "created" => date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate))),
        "role" => $idRole,
        "avatar" => $upload->uploadDefaultUser("Jean", "Martin")
    ]
];

foreach ($infoUsers as $infoUser) {
    $bdd->query($reqUser, $infoUser);
}

//Création config

$config = [
    'image' => "photo_Yoan_Fayolle.jpg",
    'phrase' => "Pour un site trop bien",
    'cv' => "cv_Yoan_Fayolle.pdf",
    'title' => "Blog de Yoan Fayolle",
];

$req = 'INSERT INTO config VALUES(NULL, :image, :phrase, :title, :cv)';

$bdd->query($req, $config);

//Création catégories

$categoryTuto = [
    'name' => "Tutoriels",
    'code' => "tuto",
];

$categoryNewTech = [
    'name' => "Nouvelles tendances et technologies",
    'code' => "newTech",
];

$categoryTips = [
    'name' => "Conseils et astuces",
    'code' => "tips",
];

$categoryDev = [
    'name' => "Développement web et design",
    'code' => "dev",
];

$categoryJob = [
    'name' => "Carrière et développement personnel",
    'code' => "job",
];

$req = 'INSERT INTO category VALUES(NULL, :name, :code)';

$bdd->query($req, $categoryTuto);
$idTuto = $bdd->lastInsert();
$bdd->query($req, $categoryNewTech);
$idNewTech = $bdd->lastInsert();
$bdd->query($req, $categoryTips);
$idTips = $bdd->lastInsert();
$bdd->query($req, $categoryDev);
$idDev = $bdd->lastInsert();
$bdd->query($req, $categoryJob);
$idJob = $bdd->lastInsert();

//Création Post

$postTabs = [
    [
        'title' => 'Comment créer un formulaire de contact avec Symfony',
        'content' => "Symfony est un framework de développement Web populaire que les développeurs peuvent utiliser pour créer des applications Web complexes. Cet article vous montrera comment créer un formulaire de contact dans Symfony. Tout d'abord, vous devez installer Symfony sur votre système. Ensuite, créez une nouvelle classe de formulaire de contact à l'aide de la commande symfony make:form. Cette commande générera un fichier de formulaire avec tous les champs obligatoires. Vous pouvez ensuite personnaliser le formulaire en ajoutant des champs tels que des cases à cocher et des menus déroulants. Enfin, nous devons configurer le formulaire pour envoyer les données à l'adresse e-mail de notre choix. Une fois que vous avez créé votre formulaire, vous pouvez l'intégrer dans votre application web en utilisant le système de routage de Symfony. Vous pouvez également styliser votre formulaire à l'aide d'outils tels que Bootstrap et CSS. En résumé, la création d'un formulaire de contact dans Symfony est une tâche relativement facile qui peut être complétée par ces étapes simples. Avec de la pratique, vous pouvez créer des formulaires plus complexes pour votre application Web.",
        'category' => $idTuto
    ],
    [
        'title' => 'Comment intégrer un slider jQuery dans votre site web',
        'content' => "L'intégration d'un curseur jQuery est un excellent moyen d'améliorer l'apparence et les fonctionnalités de votre site Web. Tout d'abord, vous devez intégrer la bibliothèque jQuery dans votre site Web, soit en téléchargeant le fichier, soit en utilisant un CDN. Ensuite, vous pouvez créer le code HTML du curseur à l'aide des éléments de liste et des images. Une fois configuré, vous pouvez utiliser le code jQuery pour initialiser le curseur et définir des options telles que la vitesse et la navigation. Testez votre curseur dans différents navigateurs pour vous assurer qu'il fonctionne correctement. Avec ces étapes simples, vous pouvez intégrer un curseur jQuery pour améliorer la convivialité de votre site Web.",
        'category' => $idTuto
    ],
    [
        'title' => 'Comment utiliser des tables MySQL avec PHP',
        'content' => "La première étape consiste à se connecter à la base de données à l'aide de la fonction mysqli_connect(). Vous pouvez ensuite envoyer la requête SQL à la base de données à l'aide de la fonction mysqli_query() et récupérer les résultats à l'aide de la fonction mysqli_fetch_array().
Pour insérer des données de PHP dans une table MySQL, vous pouvez utiliser la fonction mysqli_query() avec une requête SQL INSERT INTO. De même, vous pouvez mettre à jour ou supprimer des données à l'aide de requêtes SQL UPDATE ou DELETE.
En résumé, utiliser les tables MySQL en PHP est simple et efficace grâce à la bibliothèque de fonctions MySQLi.",
        'category' => $idTuto
    ],
    [
        'title' => 'Comment créer un menu de navigation avec CSS',
        'content' => "Lors de la conception d'un site Web, un menu de navigation bien conçu est essentiel pour permettre aux utilisateurs de naviguer facilement entre les différentes pages. Pour créer un menu de navigation avec CSS, vous devez d'abord définir la structure HTML du menu à l'aide d'éléments tels que <ul> et <li>. Vous pouvez ensuite styliser le menu à l'aide de sélecteurs CSS pour modifier la police, la couleur et la mise en page. Vous pouvez également rendre votre menu interactif avec des effets tels que des transitions et des transformations. En suivant ces étapes, vous pouvez facilement créer un menu de navigation professionnel et facile à utiliser pour votre site Web.",
        'category' => $idTuto
    ],
    [
        'title' => 'Comment ajouter des effets de parallaxe à votre site web',
        'content' => "L'ajout d'un effet de parallaxe à votre site Web rend l'expérience utilisateur plus immersive et attrayante. La technologie Parallax déplace les images et les éléments sur la page à différentes vitesses pour créer une impression de profondeur et de mouvement. Pour ajouter cet effet à votre site Web, vous pouvez utiliser des bibliothèques de code telles que ScrollMagic et Skrollr pour créer des animations personnalisées à l'aide de code JavaScript. Il est important de ne pas abuser de l'effet de parallaxe car il peut distraire les utilisateurs et rendre le site difficile à naviguer. Utilisez-les avec parcimonie et de manière stratégique pour donner à votre site Web un aspect moderne et professionnel.",
        'category' => $idTuto
    ],
    [
        'title' => 'Les tendances de conception web les plus populaires en 2023',
        'content' => "Les tendances du design Web évoluent constamment pour répondre aux attentes des utilisateurs et des clients. En 2023, il y a une forte tendance vers des designs minimalistes et épurés qui privilégient la lisibilité et la convivialité. Les conceptions respectueuses de l'environnement telles que les couleurs naturelles et les polices respectueuses de l'environnement sont également en augmentation. De plus, la réalité virtuelle et augmentée gagne en popularité pour offrir des expériences utilisateur immersives et interactives. Les conceptions 3D sont également à la hausse, permettant aux utilisateurs d'explorer des objets et des environnements sous tous les angles. Enfin, la personnalisation de l'expérience utilisateur est devenue une tendance majeure en 2023, les sites Web s'adaptant aux préférences des utilisateurs en temps réel. Les tendances de la conception Web évoluent et changent pour offrir à vos utilisateurs une excellente expérience en ligne.",
        'category' => $idNewTech
    ],
    [
        'title' => 'Les frameworks frontend les plus utilisés en 2023',
        'content' => "Les frameworks frontaux les plus utilisés en 2023 sont React, Vue.js et Angular. Développé par Facebook, React reste le leader incontesté grâce à sa simplicité, sa grande communauté et ses performances élevées. Vue.js gagne en popularité en raison de sa facilité d'utilisation, de sa flexibilité et de sa rapidité d'exécution. Angular, développé par Google, continue également d'être une option populaire pour les applications volumineuses et complexes, mais nécessite plus de temps et de ressources pour apprendre et mettre en œuvre. Les développeurs continuent d'adopter ces cadres pour créer des applications Web modernes et interactives, en accordant une attention croissante à l'accessibilité, à la sécurité et à la compatibilité avec les appareils mobiles.",
        'category' => $idNewTech
    ],
    [
        'title' => 'Les avantages et inconvénients des outils de développement backend les plus populaires',
        'content' => "Les outils de développement backend sont essentiels pour créer des applications Web robustes et fiables. Cependant, chaque outil a des forces et des faiblesses. Par exemple, Node.js est populaire pour son exécution rapide et sa compatibilité avec de nombreuses bibliothèques de code. Cependant, il est plus difficile à apprendre pour les développeurs inexpérimentés. Django est un autre outil de développement backend populaire connu pour sa facilité d'utilisation et son architecture bien organisée. Cependant, pour les applications complexes, cela peut être une limitation. Ruby on Rails est également apprécié pour sa rapidité de développement et l'élégance de sa syntaxe. Cependant, sa complexité peut être intimidante pour les débutants. En résumé, le choix d'un outil de développement backend dépend des besoins spécifiques de chaque projet et des compétences des développeurs.",
        'category' => $idNewTech
    ],
    [
        'title' => 'Les principales méthodologies de développement Agile et comment les utiliser efficacement',
        'content' => "Les méthodologies de développement agiles sont conçues pour s'adapter aux changements fréquents dans les projets de développement de logiciels. Les méthodologies Agile les plus importantes sont Scrum, Kanban, Lean et XP. Scrum est le plus populaire, avec des sprints de 2 à 4 semaines et des rôles clés tels que Product Owner et Scrum Master. Kanban se concentre sur la visualisation de l'avancement du projet à l'aide de tableaux Kanban. Lean se concentre sur l'amélioration continue et la réduction des déchets. XP met l'accent sur la qualité et utilise des pratiques telles que la programmation en binôme. Pour utiliser ces méthodes efficacement, il est important de bien comprendre les bases de chaque méthode et de les adapter aux besoins de votre équipe et de votre projet.",
        'category' => $idNewTech
    ],
    [
        'title' => "Comment les nouvelles technologies telles que la blockchain et l'IA affectent le développement web",
        'content' => "Les nouvelles technologies telles que la blockchain et l'IA ont un impact énorme sur le développement Web. La blockchain augmente la sécurité et la transparence des transactions en ligne, tandis que l'IA permet des sites Web plus personnalisés et des expériences utilisateur plus fluides. La blockchain permet aux développeurs de créer des applications décentralisées qui permettent aux utilisateurs de contrôler leurs données et de protéger leur vie privée. Avec l'aide de l'IA, nous pouvons analyser le comportement des utilisateurs sur les sites Web et adapter le contenu et les offres aux préférences des utilisateurs. En résumé, ces technologies offrent aux développeurs Web de nouvelles opportunités pour créer des expériences utilisateur plus sûres, plus personnalisées et plus fluides.",
        'category' => $idNewTech
    ],
    [
        'title' => '10 astuces pour améliorer la productivité en développement web',
        'content' => "Si vous êtes un développeur Web, vous savez à quel point la productivité est importante pour réussir dans ce domaine. Voici 10 conseils pour améliorer votre productivité.
Fixez-vous des objectifs clairs et précis. Planifiez votre travail à l'avance. Suivez l'avancement avec les outils de gestion de projet. Évitez les distractions en travaillant dans un environnement calme. Faites des pauses régulières pour vous reposer. Gagnez du temps avec les raccourcis clavier. Apprenez à utiliser efficacement les outils de développement. Gagnez du temps avec les modèles et les bibliothèques. Testez régulièrement pour éviter les erreurs. Mettre en place un processus d'amélioration continue pour une amélioration continue. En appliquant ces conseils, vous pouvez être plus productif dans le développement Web et atteindre vos objectifs plus rapidement.",
        'category' => $idTips
    ],
    [
        'title' => 'Comment gérer efficacement un projet de développement web avec Symfony',
        'content' => "Symfony est un framework PHP puissant et populaire pour le développement Web. Gérer efficacement les projets de développement web avec Symfony est essentiel à la réussite du projet. Voici quelques conseils pratiques pour gérer efficacement les projets dans Symfony.
Planifiez le projet : déterminez les exigences du projet, planifiez les jalons, définissez les échéanciers et les budgets, et définissez les rôles et les responsabilités de chaque membre de l'équipe. Utilisez un système de contrôle de version : utilisez un système de contrôle de version pour suivre toutes les modifications apportées au code source de votre projet. Cela vous permet de revenir aux versions précédentes si nécessaire. Organisation du code : utilisez une structure de dossiers organisée pour votre code source. Cela facilite la maintenance du projet et permet aux développeurs de trouver rapidement les fichiers dont ils ont besoin. Testez régulièrement : testez votre code régulièrement avec des outils de test automatisés pour trouver les bogues le plus tôt possible. Cela vous fera gagner du temps et de l'argent à long terme. Collaborez efficacement : utilisez des outils de collaboration tels que GitHub et Bitbucket pour permettre à tous les membres de votre équipe de travailler sur des projets en temps réel. En suivant ces conseils pratiques, vous pouvez utiliser Symfony pour gérer efficacement vos projets de développement web et assurer leur succès.",
        'category' => $idTips
    ],
    [
        'title' => 'Comment optimiser les performances de votre site web',
        'content' => "L'optimisation des performances du site Web est importante pour fournir une expérience utilisateur de qualité et améliorer la navigation naturelle. Voici quelques conseils pour y parvenir :
Optimisez les images en compressant et en réduisant leur taille pour des temps de chargement plus rapides. Maximisez la disponibilité du site Web avec un hébergement fiable. Combinez les fichiers CSS et JavaScript pour réduire le nombre de requêtes HTTP. Utilisez un système de mise en cache pour réduire les temps de chargement des pages fréquemment consultées. Minimisez le nombre de plugins et de widgets sur votre site Web pour réduire la charge du serveur. L'application de ces conseils améliorera considérablement les performances de votre site Web et offrira une expérience utilisateur exceptionnelle.",
        'category' => $idTips
    ],
    [
        'title' => 'Les meilleures pratiques de sécurité pour votre site web',
        'content' => "La sécurité du site Web est primordiale pour protéger vos données sensibles et prévenir les attaques potentielles. Les meilleures pratiques pour la sécurité des sites Web incluent :
Utilisez des certificats SSL pour sécuriser la communication entre votre serveur et vos utilisateurs. Mettez régulièrement à jour votre CMS et vos plugins pour éliminer les vulnérabilités de sécurité connues. Utilisez des mots de passe forts et différents pour chaque compte. Restreignez l'accès aux sites Web à l'aide d'outils tels que l'authentification à deux facteurs et la liste blanche d'adresses IP. Effectuez des sauvegardes régulières de votre site Web et conservez-les en lieu sûr. En suivant ces meilleures pratiques, vous pouvez réduire considérablement le risque que votre site Web soit compromis.",
        'category' => $idTips
    ],
    [
        'title' => 'Comment utiliser efficacement les outils de développement tels que Git et GitHub',
        'content' => "L'utilisation d'outils de développement tels que Git et GitHub peut considérablement améliorer la productivité et la collaboration des projets. Git est un système de contrôle de version qui suit les modifications du code source et les annule si nécessaire. GitHub, d'autre part, est une plate-forme d'hébergement de code source qui permet aux développeurs de collaborer facilement sur des projets. Pour utiliser ces outils efficacement, il est important de comprendre les concepts de base de Git tels que les branches, les commits, les conflits et les fonctionnalités de GitHub telles que les demandes d'extraction et les problèmes. L'utilisation cohérente et systématique de Git et GitHub permet aux développeurs de collaborer efficacement, de suivre les modifications du code source, de résoudre rapidement les conflits et de contribuer à un développement de haute qualité.",
        'category' => $idTips
    ],
    [
        'title' => 'Comment créer un design de site web attractif',
        'content' => "Créer un site Web attrayant est essentiel pour attirer et retenir l'attention de vos visiteurs. Pour ce faire, il est important de commencer par refléter la structure et la hiérarchie des informations pour faciliter la navigation. Deuxièmement, votre choix de couleurs, de typographie et d'images doit être cohérent et correspondre à l'image de votre marque et au contenu de votre site Web. Le design doit être propre et fonctionnel pour faciliter l'expérience utilisateur. Enfin, il est important d'optimiser votre conception pour différentes tailles d'écran, en particulier les smartphones. En suivant ces quelques règles, vous pouvez créer un design de site Web attrayant et efficace.",
        'category' => $idDev
    ],
    [
        'title' => "Comment améliorer l'expérience utilisateur de votre site web",
        'content' => "L'expérience utilisateur est l'un des facteurs clés du succès d'un site Web. Pour améliorer cette expérience, il est important de rendre votre site Web facile à naviguer et à utiliser. Une interface claire et intuitive permet aux utilisateurs de trouver rapidement ce qu'ils recherchent et de se sentir à l'aise lors de leur visite. L'optimisation du temps de chargement des pages est également importante. Le chargement lent des pages peut décourager les visiteurs et les faire quitter votre site. Par conséquent, nous vous recommandons de compresser vos images, de réduire votre code CSS et JavaScript et d'utiliser un hébergement rapide et fiable. Enfin, vous devez tenir compte de l'accessibilité de votre site. Assurez-vous que votre site Web est facilement accessible aux personnes aveugles ou malentendantes, ou qui utilisent des appareils mobiles ou des navigateurs plus anciens. La prise en compte de ces facteurs peut améliorer l'expérience utilisateur de votre site Web et augmenter son succès.",
        'category' => $idDev
    ],
    [
        'title' => 'Comment créer un site web réactif avec Bootstrap',
        'content' => "Bootstrap est l'un des frameworks les plus populaires pour la création de sites Web réactifs. Tout d'abord, téléchargez la dernière version de Bootstrap sur le site officiel. Ensuite, vous devez intégrer les fichiers CSS et JS de Bootstrap dans votre page Web. Pour ce faire, utilisez un lien CDN ou téléchargez le fichier directement sur votre ordinateur. Une fois que vous avez inclus vos fichiers d'amorçage, vous pouvez utiliser ces classes pour créer de superbes dispositions et composants tels que des menus de navigation, des boutons, des formulaires, des modaux, etc. Bootstrap fournit également des grilles flexibles qui vous permettent d'organiser votre contenu de manière cohérente sur différents écrans. Bootstrap permet de créer rapidement et facilement des sites Web réactifs sans écrire beaucoup de code personnalisé. Vous pouvez également le personnaliser facilement avec vos propres styles CSS.",
        'category' => $idDev
    ],
    [
        'title' => "Comment utiliser les animations CSS pour améliorer l'expérience utilisateur",
        'content' => "Les animations CSS sont un excellent moyen d'améliorer l'expérience utilisateur sur votre site Web. Vous pouvez ajouter de l'interactivité et du dynamisme à vos éléments visuels, rendant la navigation plus amusante et excitante pour vos visiteurs. Les animations CSS peuvent être utilisées pour créer des transitions fluides entre différentes sections de la page, des effets de survol pour les boutons et les liens, des animations de chargement de page et même des effets visuels pour les graphiques et les icônes. L'utilisation stratégique des animations CSS peut améliorer l'expérience utilisateur tout en ajoutant de la créativité et de la personnalité à votre site Web.",
        'category' => $idDev
    ],
    [
        'title' => "Comment améliorer l'accessibilité de votre site web pour les personnes handicapées",
        'content' => "L'accessibilité est un élément important de la conception Web, car elle permet aux personnes handicapées d'accéder aux informations en ligne. Vous pouvez prendre quelques mesures simples pour améliorer l'accessibilité de votre site Web. Tout d'abord, utilisez des couleurs à contraste élevé pour faciliter la lecture des personnes malvoyantes. La seconde consiste à inclure une description textuelle de l'image pour les malvoyants. Troisièmement, utilisez des polices faciles à lire et des tailles de police suffisamment grandes pour les personnes ayant une déficience visuelle. Enfin, évitez d'utiliser des vidéos rapides et des articles destinés aux personnes épileptiques. En suivant ces directives, vous pouvez rendre votre site Web plus accessible aux personnes handicapées.",
        'category' => $idDev
    ],
    [
        'title' => 'Comment trouver un emploi dans le développement web',
        'content' => "Trouver un emploi en développement Web peut sembler décourageant, mais avec les bons outils et une approche méthodique, vous pouvez augmenter vos chances de succès. Commencez par créer un portfolio solide qui met en valeur vos compétences et vos projets passés. Ensuite, parcourez les offres d'emploi en ligne sur des sites comme Indeed, Glassdoor et LinkedIn. Connectez-vous en ligne ou en personne pour rencontrer des experts de l'industrie et découvrir des opportunités cachées. Assistez à des hackathons et à des événements de l'industrie pour rencontrer des recruteurs et des employeurs potentiels. Enfin, préparez votre entretien en faisant des recherches sur l'entreprise et en mettant en pratique vos compétences techniques. Avec de la patience et de la persévérance, vous pouvez trouver votre prochain emploi en développement Web.",
        'category' => $idJob
    ],
    [
        'title' => 'Les compétences les plus importantes pour réussir en développement web',
        'content' => "Le développement Web est un domaine en constante évolution et nécessite une variété de compétences pour réussir. Certaines des compétences les plus importantes incluent la maîtrise du langage de programmation, les compétences en résolution de problèmes, la créativité et la collaboration. La connaissance des langages de programmation tels que HTML, CSS et JavaScript est essentielle pour créer des sites Web interactifs et dynamiques. Les compétences en résolution de problèmes sont également importantes pour corriger les erreurs et les bogues qui peuvent survenir au cours du développement. La créativité est une compétence précieuse pour créer des conceptions innovantes et des interfaces utilisateur attrayantes. Enfin, la collaboration est essentielle au travail d'équipe avec les concepteurs, les chefs de projet et d'autres développeurs pour atteindre les objectifs de développement. En résumé, les développeurs Web qui réussissent sont ceux qui possèdent un large éventail de compétences techniques et générales pour relever les défis du développement Web.",
        'category' => $idJob
    ],
    [
        'title' => 'Comment gérer efficacement le stress en tant que développeur web',
        'content' => "En tant que développeur Web, le stress peut facilement vous submerger. Les délais serrés, les exigences élevées, les problèmes techniques et les erreurs peuvent rapidement s'accumuler et devenir difficiles à gérer. Pourtant, en tant que développeur web, il est possible de gérer efficacement son stress. Tout d'abord, faites des pauses régulières pour recharger et recharger votre batterie. Définissez des priorités claires pour vos tâches et décomposez-les en tâches plus petites et plus gérables. Enfin, si vous vous sentez dépassé, n'ayez pas peur de demander de l'aide à vos collègues ou à votre patron. En utilisant ces techniques, vous pouvez mieux gérer votre stress et travailler plus efficacement en tant que développeur Web.",
        'category' => $idJob
    ],
    [
        'title' => 'Les avantages et les inconvénients du travail à distance en développement web',
        'content' => "Le travail à distance devient de plus en plus courant dans l'espace de développement Web. Il présente des avantages tels que la flexibilité, la réduction des coûts et l'amélioration de la qualité de vie, mais il présente également des inconvénients tels que l'isolement, les problèmes de communication et le manque de collaboration. Les avantages du travail à distance incluent la possibilité pour les développeurs de travailler à leur propre rythme et de gérer leur temps de manière indépendante. Cela augmente la productivité et l'efficacité. De plus, les frais de transport et de travail sont réduits. Cependant, le travail à distance présente de sérieux inconvénients : B. Manque d'interaction humaine, difficulté à communiquer efficacement à distance, perte de dynamique de travail d'équipe. Par conséquent, il est important pour les employeurs et les employés de peser le pour et le contre du travail à distance afin de déterminer si cette pratique convient à leur façon de travailler.",
        'category' => $idJob
    ],
    [
        'title' => 'Comment maintenir un équilibre travail-vie personnelle en tant que développeur web.',
        'content' => "En tant que développeur Web, il est facile de se laisser prendre par son travail et de négliger sa vie personnelle. Cependant, un équilibre entre le travail et la vie personnelle est essentiel pour la santé physique et mentale.
Pour cette raison, il est important de clarifier la frontière entre le travail et la vie privée. Fixez-vous des heures de travail régulières et, si possible, évitez de travailler en dehors de ces heures. Vous apprendrez également à déléguer des tâches spécifiques et à refuser des projets qui ne correspondent pas à votre emploi du temps. Enfin, prenez soin de vous en faisant régulièrement de l'exercice, en participant à des activités récréatives et en passant du temps de qualité avec vos amis et votre famille. En suivant ces conseils simples, vous pouvez maintenir un équilibre sain entre le travail et la vie personnelle en tant que développeur Web.",
        'category' => $idJob
    ]
];

$req = 'INSERT INTO post VALUES(null, :title, :content, null, :created, :published, null, null, :excerpt, :category, :user)';

foreach ($postTabs as $postTab) {

    $created = date('Y-m-d H:i:s', rand(strtotime($startdate), strtotime($enddate)));
    $published = date('Y-m-d H:i:s', strtotime($created." + ".rand(1, 24)." hours"));

    $user = [
        $idSuperAdmin,
        $idAdmin
    ];

    $infoPost = [
        'title' => $postTab['title'],
        'content' => $postTab['content'],
        'created' => $created,
        'published' => $published,
        'excerpt' => mb_substr($postTab['content'], 0, 67)."...",
        'category' => $postTab['category'],
        'user' => $user[array_rand($user)]
    ];

    $bdd->query($req, $infoPost);
}
