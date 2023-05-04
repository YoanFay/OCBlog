-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 04 Mai 2023 à 07:58
-- Version du serveur :  5.7.11
-- Version de PHP :  7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- Création de la base de données
CREATE DATABASE blog;

-- Sélection de la base de données
USE blog;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `code` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`, `code`) VALUES
(1, 'Tutoriels', 'tuto'),
(2, 'Nouvelles tendances et technologies', 'newTech'),
(3, 'Conseils et astuces', 'tips'),
(4, 'Développement web et design', 'dev'),
(5, 'Carrière et développement personnel', 'job');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `validated_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `validated_at`, `updated_at`, `deleted_at`, `post_id`, `user_id`) VALUES
(1, 'Je tiens à vous remercier pour cet article informatif sur la création d\'un formulaire de contact avec Symfony. Vous avez fourni des instructions claires et concises pour guider les développeurs dans la création de leur formulaire.\r\n\r\nJ\'apprécie particulièrement la façon dont vous avez expliqué la commande "symfony make:form" pour générer un fichier de formulaire avec tous les champs obligatoires. Cette commande est très utile pour les développeurs débutants qui cherchent à créer leur premier formulaire.\r\n\r\nDe plus, votre conseil sur la personnalisation du formulaire en ajoutant des champs tels que des cases à cocher et des menus déroulants est très pertinent. Cela permet aux développeurs d\'ajouter des fonctionnalités supplémentaires à leur formulaire, le rendant ainsi plus convivial pour les utilisateurs finaux.\r\n\r\nEnfin, votre explication sur la configuration du formulaire pour envoyer les données à l\'adresse e-mail de notre choix est également très utile. Cela permet aux développeurs de configurer facilement le formulaire pour qu\'il soit fonctionnel.\r\n\r\nDans l\'ensemble, je trouve que votre article est une excellente ressource pour les développeurs qui cherchent à créer un formulaire de contact avec Symfony. Merci pour votre contribution à la communauté des développeurs Symfony.', '2023-04-20 09:29:14', '2023-04-20 10:07:29', '2023-04-20 10:07:29', NULL, 1, 3),
(2, 'Je voulais vous remercier pour cet article utile et instructif sur l\'intégration d\'un curseur jQuery dans un site web. Les étapes que vous avez fournies sont claires et concises, ce qui est très utile pour les personnes qui débutent dans le domaine du développement web. J\'apprécie également le fait que vous ayez inclus des conseils pour tester le curseur dans différents navigateurs.\r\n\r\nCependant, je pense qu\'il serait bénéfique d\'ajouter quelques exemples de code pour aider les lecteurs à mieux comprendre comment intégrer un curseur jQuery. Cela pourrait également aider à clarifier les instructions étape par étape que vous avez fournies.\r\n\r\nDans l\'ensemble, c\'est un excellent article pour les débutants en développement web, et je vous encourage à continuer à fournir des conseils et des astuces utiles pour les personnes qui cherchent à améliorer l\'apparence et les fonctionnalités de leur site web.', '2023-04-20 09:42:44', NULL, NULL, NULL, 2, 5),
(3, 'Je tiens à vous remercier pour cet article très utile sur l\'optimisation des performances des sites Web. Les conseils que vous avez partagés sont clairs, précis et pertinents pour améliorer l\'expérience utilisateur et la navigation naturelle sur un site Web.\r\n\r\nJe suis d\'accord avec vous sur l\'importance de la compression des images, l\'hébergement fiable, la combinaison des fichiers CSS et JavaScript, l\'utilisation d\'un système de mise en cache et la minimisation du nombre de plugins et de widgets pour améliorer la performance du site Web.\r\n\r\nCes astuces sont très pratiques et faciles à mettre en œuvre pour tout propriétaire de site Web qui souhaite améliorer les performances de son site et offrir une meilleure expérience utilisateur à ses visiteurs.\r\n\r\nEncore une fois, merci pour ce partage très utile et continuez à publier de tels articles pratiques pour aider les propriétaires de sites Web à optimiser leurs performances.', '2023-04-20 09:46:59', NULL, NULL, '2023-04-20 10:07:46', 13, 4);

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `image` text,
  `catch_phrase` text NOT NULL,
  `title` text NOT NULL,
  `cv` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `config`
--

INSERT INTO `config` (`id`, `image`, `catch_phrase`, `title`, `cv`) VALUES
(1, 'photo_Yoan_Fayolle.jpg', 'Pour un site trop bien', 'Blog de Yoan Fayolle', 'cv_Yoan_Fayolle.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(90) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `process` varchar(10) DEFAULT NULL,
  `process_at` datetime DEFAULT NULL,
  `process_by` int(11) DEFAULT NULL,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8,
  `created_at` datetime NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `excerpt` varchar(70) CHARACTER SET utf8 NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `image`, `created_at`, `published_at`, `updated_at`, `deleted_at`, `excerpt`, `category_id`, `user_id`) VALUES
(1, 'Comment créer un formulaire de contact avec Symfony', 'Symfony est un framework de développement Web populaire que les développeurs peuvent utiliser pour créer des applications Web complexes. Cet article vous montrera comment créer un formulaire de contact dans Symfony. Tout d\'abord, vous devez installer Symfony sur votre système. Ensuite, créez une nouvelle classe de formulaire de contact à l\'aide de la commande symfony make:form. Cette commande générera un fichier de formulaire avec tous les champs obligatoires. Vous pouvez ensuite personnaliser le formulaire en ajoutant des champs tels que des cases à cocher et des menus déroulants. Enfin, nous devons configurer le formulaire pour envoyer les données à l\'adresse e-mail de notre choix. Une fois que vous avez créé votre formulaire, vous pouvez l\'intégrer dans votre application web en utilisant le système de routage de Symfony. Vous pouvez également styliser votre formulaire à l\'aide d\'outils tels que Bootstrap et CSS. En résumé, la création d\'un formulaire de contact dans Symfony est une tâche relativement facile qui peut être complétée par ces étapes simples. Avec de la pratique, vous pouvez créer des formulaires plus complexes pour votre application Web.', NULL, '2023-04-08 22:08:36', '2023-04-09 17:08:36', NULL, NULL, 'Symfony est un framework de développement Web populaire que les dév...', 1, 2),
(2, 'Comment intégrer un slider jQuery dans votre site web', 'L\'intégration d\'un curseur jQuery est un excellent moyen d\'améliorer l\'apparence et les fonctionnalités de votre site Web. Tout d\'abord, vous devez intégrer la bibliothèque jQuery dans votre site Web, soit en téléchargeant le fichier, soit en utilisant un CDN. Ensuite, vous pouvez créer le code HTML du curseur à l\'aide des éléments de liste et des images. Une fois configuré, vous pouvez utiliser le code jQuery pour initialiser le curseur et définir des options telles que la vitesse et la navigation. Testez votre curseur dans différents navigateurs pour vous assurer qu\'il fonctionne correctement. Avec ces étapes simples, vous pouvez intégrer un curseur jQuery pour améliorer la convivialité de votre site Web.', NULL, '2023-04-04 22:10:39', '2023-04-05 02:10:39', NULL, NULL, 'L\'intégration d\'un curseur jQuery est un excellent moyen d\'améliore...', 1, 1),
(3, 'Comment utiliser des tables MySQL avec PHP', 'La première étape consiste à se connecter à la base de données à l\'aide de la fonction mysqli_connect(). Vous pouvez ensuite envoyer la requête SQL à la base de données à l\'aide de la fonction mysqli_query() et récupérer les résultats à l\'aide de la fonction mysqli_fetch_array().\r\nPour insérer des données de PHP dans une table MySQL, vous pouvez utiliser la fonction mysqli_query() avec une requête SQL INSERT INTO. De même, vous pouvez mettre à jour ou supprimer des données à l\'aide de requêtes SQL UPDATE ou DELETE.\r\nEn résumé, utiliser les tables MySQL en PHP est simple et efficace grâce à la bibliothèque de fonctions MySQLi.', NULL, '2023-03-12 02:46:44', '2023-03-13 01:46:44', NULL, NULL, 'La première étape consiste à se connecter à la base de données à l\'...', 1, 1),
(4, 'Comment créer un menu de navigation avec CSS', 'Lors de la conception d\'un site Web, un menu de navigation bien conçu est essentiel pour permettre aux utilisateurs de naviguer facilement entre les différentes pages. Pour créer un menu de navigation avec CSS, vous devez d\'abord définir la structure HTML du menu à l\'aide d\'éléments tels que <ul> et <li>. Vous pouvez ensuite styliser le menu à l\'aide de sélecteurs CSS pour modifier la police, la couleur et la mise en page. Vous pouvez également rendre votre menu interactif avec des effets tels que des transitions et des transformations. En suivant ces étapes, vous pouvez facilement créer un menu de navigation professionnel et facile à utiliser pour votre site Web.', NULL, '2023-03-04 14:11:17', '2023-03-05 05:11:17', NULL, NULL, 'Lors de la conception d\'un site Web, un menu de navigation bien con...', 1, 2),
(5, 'Comment ajouter des effets de parallaxe à votre site web', 'L\'ajout d\'un effet de parallaxe à votre site Web rend l\'expérience utilisateur plus immersive et attrayante. La technologie Parallax déplace les images et les éléments sur la page à différentes vitesses pour créer une impression de profondeur et de mouvement. Pour ajouter cet effet à votre site Web, vous pouvez utiliser des bibliothèques de code telles que ScrollMagic et Skrollr pour créer des animations personnalisées à l\'aide de code JavaScript. Il est important de ne pas abuser de l\'effet de parallaxe car il peut distraire les utilisateurs et rendre le site difficile à naviguer. Utilisez-les avec parcimonie et de manière stratégique pour donner à votre site Web un aspect moderne et professionnel.', NULL, '2023-03-23 02:45:00', '2023-03-23 14:45:00', NULL, NULL, 'L\'ajout d\'un effet de parallaxe à votre site Web rend l\'expérience ...', 1, 1),
(6, 'Les tendances de conception web les plus populaires en 2023', 'Les tendances du design Web évoluent constamment pour répondre aux attentes des utilisateurs et des clients. En 2023, il y a une forte tendance vers des designs minimalistes et épurés qui privilégient la lisibilité et la convivialité. Les conceptions respectueuses de l\'environnement telles que les couleurs naturelles et les polices respectueuses de l\'environnement sont également en augmentation. De plus, la réalité virtuelle et augmentée gagne en popularité pour offrir des expériences utilisateur immersives et interactives. Les conceptions 3D sont également à la hausse, permettant aux utilisateurs d\'explorer des objets et des environnements sous tous les angles. Enfin, la personnalisation de l\'expérience utilisateur est devenue une tendance majeure en 2023, les sites Web s\'adaptant aux préférences des utilisateurs en temps réel. Les tendances de la conception Web évoluent et changent pour offrir à vos utilisateurs une excellente expérience en ligne.', NULL, '2023-03-16 12:07:51', '2023-03-16 23:07:51', NULL, NULL, 'Les tendances du design Web évoluent constamment pour répondre aux ...', 2, 2),
(7, 'Les frameworks frontend les plus utilisés en 2023', 'Les frameworks frontaux les plus utilisés en 2023 sont React, Vue.js et Angular. Développé par Facebook, React reste le leader incontesté grâce à sa simplicité, sa grande communauté et ses performances élevées. Vue.js gagne en popularité en raison de sa facilité d\'utilisation, de sa flexibilité et de sa rapidité d\'exécution. Angular, développé par Google, continue également d\'être une option populaire pour les applications volumineuses et complexes, mais nécessite plus de temps et de ressources pour apprendre et mettre en œuvre. Les développeurs continuent d\'adopter ces cadres pour créer des applications Web modernes et interactives, en accordant une attention croissante à l\'accessibilité, à la sécurité et à la compatibilité avec les appareils mobiles.', NULL, '2023-03-15 03:48:44', '2023-03-15 06:48:44', NULL, NULL, 'Les frameworks frontaux les plus utilisés en 2023 sont React, Vue.j...', 2, 2),
(8, 'Les avantages et inconvénients des outils de développement backend les plus populaires', 'Les outils de développement backend sont essentiels pour créer des applications Web robustes et fiables. Cependant, chaque outil a des forces et des faiblesses. Par exemple, Node.js est populaire pour son exécution rapide et sa compatibilité avec de nombreuses bibliothèques de code. Cependant, il est plus difficile à apprendre pour les développeurs inexpérimentés. Django est un autre outil de développement backend populaire connu pour sa facilité d\'utilisation et son architecture bien organisée. Cependant, pour les applications complexes, cela peut être une limitation. Ruby on Rails est également apprécié pour sa rapidité de développement et l\'élégance de sa syntaxe. Cependant, sa complexité peut être intimidante pour les débutants. En résumé, le choix d\'un outil de développement backend dépend des besoins spécifiques de chaque projet et des compétences des développeurs.', NULL, '2023-03-15 19:43:14', '2023-03-16 02:43:14', NULL, NULL, 'Les outils de développement backend sont essentiels pour créer des ...', 2, 2),
(9, 'Les principales méthodologies de développement Agile et comment les utiliser efficacement', 'Les méthodologies de développement agiles sont conçues pour s\'adapter aux changements fréquents dans les projets de développement de logiciels. Les méthodologies Agile les plus importantes sont Scrum, Kanban, Lean et XP. Scrum est le plus populaire, avec des sprints de 2 à 4 semaines et des rôles clés tels que Product Owner et Scrum Master. Kanban se concentre sur la visualisation de l\'avancement du projet à l\'aide de tableaux Kanban. Lean se concentre sur l\'amélioration continue et la réduction des déchets. XP met l\'accent sur la qualité et utilise des pratiques telles que la programmation en binôme. Pour utiliser ces méthodes efficacement, il est important de bien comprendre les bases de chaque méthode et de les adapter aux besoins de votre équipe et de votre projet.', NULL, '2023-04-08 19:22:03', NULL, NULL, NULL, 'Les méthodologies de développement agiles sont conçues pour s\'adapt...', 2, 2),
(10, 'Comment les nouvelles technologies telles que la blockchain et l\'IA affectent le développement web', 'Les nouvelles technologies telles que la blockchain et l\'IA ont un impact énorme sur le développement Web. La blockchain augmente la sécurité et la transparence des transactions en ligne, tandis que l\'IA permet des sites Web plus personnalisés et des expériences utilisateur plus fluides. La blockchain permet aux développeurs de créer des applications décentralisées qui permettent aux utilisateurs de contrôler leurs données et de protéger leur vie privée. Avec l\'aide de l\'IA, nous pouvons analyser le comportement des utilisateurs sur les sites Web et adapter le contenu et les offres aux préférences des utilisateurs. En résumé, ces technologies offrent aux développeurs Web de nouvelles opportunités pour créer des expériences utilisateur plus sûres, plus personnalisées et plus fluides.', NULL, '2023-04-03 21:52:53', '2023-04-04 02:52:53', NULL, NULL, 'Les nouvelles technologies telles que la blockchain et l\'IA ont un ...', 2, 1),
(11, '10 astuces pour améliorer la productivité en développement web', 'Si vous êtes un développeur Web, vous savez à quel point la productivité est importante pour réussir dans ce domaine. Voici 10 conseils pour améliorer votre productivité.\r\nFixez-vous des objectifs clairs et précis. Planifiez votre travail à l\'avance. Suivez l\'avancement avec les outils de gestion de projet. Évitez les distractions en travaillant dans un environnement calme. Faites des pauses régulières pour vous reposer. Gagnez du temps avec les raccourcis clavier. Apprenez à utiliser efficacement les outils de développement. Gagnez du temps avec les modèles et les bibliothèques. Testez régulièrement pour éviter les erreurs. Mettre en place un processus d\'amélioration continue pour une amélioration continue. En appliquant ces conseils, vous pouvez être plus productif dans le développement Web et atteindre vos objectifs plus rapidement.', NULL, '2023-03-10 19:27:02', '2023-03-11 19:27:02', NULL, NULL, 'Si vous êtes un développeur Web, vous savez à quel point la product...', 3, 2),
(12, 'Comment gérer efficacement un projet de développement web avec Symfony', 'Symfony est un framework PHP puissant et populaire pour le développement Web. Gérer efficacement les projets de développement web avec Symfony est essentiel à la réussite du projet. Voici quelques conseils pratiques pour gérer efficacement les projets dans Symfony.\r\nPlanifiez le projet : déterminez les exigences du projet, planifiez les jalons, définissez les échéanciers et les budgets, et définissez les rôles et les responsabilités de chaque membre de l\'équipe. Utilisez un système de contrôle de version : utilisez un système de contrôle de version pour suivre toutes les modifications apportées au code source de votre projet. Cela vous permet de revenir aux versions précédentes si nécessaire. Organisation du code : utilisez une structure de dossiers organisée pour votre code source. Cela facilite la maintenance du projet et permet aux développeurs de trouver rapidement les fichiers dont ils ont besoin. Testez régulièrement : testez votre code régulièrement avec des outils de test automatisés pour trouver les bogues le plus tôt possible. Cela vous fera gagner du temps et de l\'argent à long terme. Collaborez efficacement : utilisez des outils de collaboration tels que GitHub et Bitbucket pour permettre à tous les membres de votre équipe de travailler sur des projets en temps réel. En suivant ces conseils pratiques, vous pouvez utiliser Symfony pour gérer efficacement vos projets de développement web et assurer leur succès.', NULL, '2023-04-06 08:10:45', '2023-04-06 11:10:45', NULL, NULL, 'Symfony est un framework PHP puissant et populaire pour le développ...', 3, 2),
(13, 'Comment optimiser les performances de votre site web', 'L\'optimisation des performances du site Web est importante pour fournir une expérience utilisateur de qualité et améliorer la navigation naturelle. Voici quelques conseils pour y parvenir :\r\nOptimisez les images en compressant et en réduisant leur taille pour des temps de chargement plus rapides. Maximisez la disponibilité du site Web avec un hébergement fiable. Combinez les fichiers CSS et JavaScript pour réduire le nombre de requêtes HTTP. Utilisez un système de mise en cache pour réduire les temps de chargement des pages fréquemment consultées. Minimisez le nombre de plugins et de widgets sur votre site Web pour réduire la charge du serveur. L\'application de ces conseils améliorera considérablement les performances de votre site Web et offrira une expérience utilisateur exceptionnelle.', NULL, '2023-04-10 23:11:01', '2023-04-11 04:11:01', NULL, NULL, 'L\'optimisation des performances du site Web est importante pour fou...', 3, 2),
(14, 'Les meilleures pratiques de sécurité pour votre site web', 'La sécurité du site Web est primordiale pour protéger vos données sensibles et prévenir les attaques potentielles. Les meilleures pratiques pour la sécurité des sites Web incluent :\r\nUtilisez des certificats SSL pour sécuriser la communication entre votre serveur et vos utilisateurs. Mettez régulièrement à jour votre CMS et vos plugins pour éliminer les vulnérabilités de sécurité connues. Utilisez des mots de passe forts et différents pour chaque compte. Restreignez l\'accès aux sites Web à l\'aide d\'outils tels que l\'authentification à deux facteurs et la liste blanche d\'adresses IP. Effectuez des sauvegardes régulières de votre site Web et conservez-les en lieu sûr. En suivant ces meilleures pratiques, vous pouvez réduire considérablement le risque que votre site Web soit compromis.', NULL, '2023-03-19 00:42:52', '2023-03-19 17:42:52', NULL, NULL, 'La sécurité du site Web est primordiale pour protéger vos données s...', 3, 1),
(15, 'Comment utiliser efficacement les outils de développement tels que Git et GitHub', 'L\'utilisation d\'outils de développement tels que Git et GitHub peut considérablement améliorer la productivité et la collaboration des projets. Git est un système de contrôle de version qui suit les modifications du code source et les annule si nécessaire. GitHub, d\'autre part, est une plate-forme d\'hébergement de code source qui permet aux développeurs de collaborer facilement sur des projets. Pour utiliser ces outils efficacement, il est important de comprendre les concepts de base de Git tels que les branches, les commits, les conflits et les fonctionnalités de GitHub telles que les demandes d\'extraction et les problèmes. L\'utilisation cohérente et systématique de Git et GitHub permet aux développeurs de collaborer efficacement, de suivre les modifications du code source, de résoudre rapidement les conflits et de contribuer à un développement de haute qualité.', NULL, '2023-03-17 03:01:16', '2023-03-17 20:01:16', NULL, NULL, 'L\'utilisation d\'outils de développement tels que Git et GitHub peut...', 3, 2),
(16, 'Comment créer un design de site web attractif', 'Créer un site Web attrayant est essentiel pour attirer et retenir l\'attention de vos visiteurs. Pour ce faire, il est important de commencer par refléter la structure et la hiérarchie des informations pour faciliter la navigation. Deuxièmement, votre choix de couleurs, de typographie et d\'images doit être cohérent et correspondre à l\'image de votre marque et au contenu de votre site Web. Le design doit être propre et fonctionnel pour faciliter l\'expérience utilisateur. Enfin, il est important d\'optimiser votre conception pour différentes tailles d\'écran, en particulier les smartphones. En suivant ces quelques règles, vous pouvez créer un design de site Web attrayant et efficace.', NULL, '2023-04-04 04:43:04', '2023-04-04 09:43:04', NULL, NULL, 'Créer un site Web attrayant est essentiel pour attirer et retenir l...', 4, 1),
(17, 'Comment améliorer l\'expérience utilisateur de votre site web', 'L\'expérience utilisateur est l\'un des facteurs clés du succès d\'un site Web. Pour améliorer cette expérience, il est important de rendre votre site Web facile à naviguer et à utiliser. Une interface claire et intuitive permet aux utilisateurs de trouver rapidement ce qu\'ils recherchent et de se sentir à l\'aise lors de leur visite. L\'optimisation du temps de chargement des pages est également importante. Le chargement lent des pages peut décourager les visiteurs et les faire quitter votre site. Par conséquent, nous vous recommandons de compresser vos images, de réduire votre code CSS et JavaScript et d\'utiliser un hébergement rapide et fiable. Enfin, vous devez tenir compte de l\'accessibilité de votre site. Assurez-vous que votre site Web est facilement accessible aux personnes aveugles ou malentendantes, ou qui utilisent des appareils mobiles ou des navigateurs plus anciens. La prise en compte de ces facteurs peut améliorer l\'expérience utilisateur de votre site Web et augmenter son succès.', NULL, '2023-03-25 20:00:35', '2023-03-26 06:00:35', NULL, NULL, 'L\'expérience utilisateur est l\'un des facteurs clés du succès d\'un ...', 4, 1),
(18, 'Comment créer un site web réactif avec Bootstrap', 'Bootstrap est l\'un des frameworks les plus populaires pour la création de sites Web réactifs. Tout d\'abord, téléchargez la dernière version de Bootstrap sur le site officiel. Ensuite, vous devez intégrer les fichiers CSS et JS de Bootstrap dans votre page Web. Pour ce faire, utilisez un lien CDN ou téléchargez le fichier directement sur votre ordinateur. Une fois que vous avez inclus vos fichiers d\'amorçage, vous pouvez utiliser ces classes pour créer de superbes dispositions et composants tels que des menus de navigation, des boutons, des formulaires, des modaux, etc. Bootstrap fournit également des grilles flexibles qui vous permettent d\'organiser votre contenu de manière cohérente sur différents écrans. Bootstrap permet de créer rapidement et facilement des sites Web réactifs sans écrire beaucoup de code personnalisé. Vous pouvez également le personnaliser facilement avec vos propres styles CSS.', NULL, '2023-04-12 15:40:24', '2023-04-21 08:53:16', '2023-04-21 08:53:16', NULL, 'Bootstrap est l\'un des frameworks les plus populaires pour la cré...', 1, 1),
(19, 'Comment utiliser les animations CSS pour améliorer l\'expérience utilisateur', 'Les animations CSS sont un excellent moyen d\'améliorer l\'expérience utilisateur sur votre site Web. Vous pouvez ajouter de l\'interactivité et du dynamisme à vos éléments visuels, rendant la navigation plus amusante et excitante pour vos visiteurs. Les animations CSS peuvent être utilisées pour créer des transitions fluides entre différentes sections de la page, des effets de survol pour les boutons et les liens, des animations de chargement de page et même des effets visuels pour les graphiques et les icônes. L\'utilisation stratégique des animations CSS peut améliorer l\'expérience utilisateur tout en ajoutant de la créativité et de la personnalité à votre site Web.', NULL, '2023-03-30 23:35:31', '2023-03-31 13:35:31', NULL, NULL, 'Les animations CSS sont un excellent moyen d\'améliorer l\'expérience...', 4, 1),
(20, 'Comment améliorer l\'accessibilité de votre site web pour les personnes handicapées', 'L\'accessibilité est un élément important de la conception Web, car elle permet aux personnes handicapées d\'accéder aux informations en ligne. Vous pouvez prendre quelques mesures simples pour améliorer l\'accessibilité de votre site Web. Tout d\'abord, utilisez des couleurs à contraste élevé pour faciliter la lecture des personnes malvoyantes. La seconde consiste à inclure une description textuelle de l\'image pour les malvoyants. Troisièmement, utilisez des polices faciles à lire et des tailles de police suffisamment grandes pour les personnes ayant une déficience visuelle. Enfin, évitez d\'utiliser des vidéos rapides et des articles destinés aux personnes épileptiques. En suivant ces directives, vous pouvez rendre votre site Web plus accessible aux personnes handicapées.', NULL, '2023-03-26 21:58:06', '2023-03-27 01:58:06', NULL, NULL, 'L\'accessibilité est un élément important de la conception Web, car ...', 4, 1),
(21, 'Comment trouver un emploi dans le développement web', 'Trouver un emploi en développement Web peut sembler décourageant, mais avec les bons outils et une approche méthodique, vous pouvez augmenter vos chances de succès. Commencez par créer un portfolio solide qui met en valeur vos compétences et vos projets passés. Ensuite, parcourez les offres d\'emploi en ligne sur des sites comme Indeed, Glassdoor et LinkedIn. Connectez-vous en ligne ou en personne pour rencontrer des experts de l\'industrie et découvrir des opportunités cachées. Assistez à des hackathons et à des événements de l\'industrie pour rencontrer des recruteurs et des employeurs potentiels. Enfin, préparez votre entretien en faisant des recherches sur l\'entreprise et en mettant en pratique vos compétences techniques. Avec de la patience et de la persévérance, vous pouvez trouver votre prochain emploi en développement Web.', NULL, '2023-03-04 14:31:25', '2023-03-05 07:31:25', NULL, NULL, 'Trouver un emploi en développement Web peut sembler décourageant, m...', 5, 1),
(22, 'Les compétences les plus importantes pour réussir en développement web', 'Le développement Web est un domaine en constante évolution et nécessite une variété de compétences pour réussir. Certaines des compétences les plus importantes incluent la maîtrise du langage de programmation, les compétences en résolution de problèmes, la créativité et la collaboration. La connaissance des langages de programmation tels que HTML, CSS et JavaScript est essentielle pour créer des sites Web interactifs et dynamiques. Les compétences en résolution de problèmes sont également importantes pour corriger les erreurs et les bogues qui peuvent survenir au cours du développement. La créativité est une compétence précieuse pour créer des conceptions innovantes et des interfaces utilisateur attrayantes. Enfin, la collaboration est essentielle au travail d\'équipe avec les concepteurs, les chefs de projet et d\'autres développeurs pour atteindre les objectifs de développement. En résumé, les développeurs Web qui réussissent sont ceux qui possèdent un large éventail de compétences techniques et générales pour relever les défis du développement Web.', NULL, '2023-04-12 16:05:37', NULL, NULL, NULL, 'Le développement Web est un domaine en constante évolution et néces...', 5, 2),
(23, 'Comment gérer efficacement le stress en tant que développeur web', 'En tant que développeur Web, le stress peut facilement vous submerger. Les délais serrés, les exigences élevées, les problèmes techniques et les erreurs peuvent rapidement s\'accumuler et devenir difficiles à gérer. Pourtant, en tant que développeur web, il est possible de gérer efficacement son stress. Tout d\'abord, faites des pauses régulières pour recharger et recharger votre batterie. Définissez des priorités claires pour vos tâches et décomposez-les en tâches plus petites et plus gérables. Enfin, si vous vous sentez dépassé, n\'ayez pas peur de demander de l\'aide à vos collègues ou à votre patron. En utilisant ces techniques, vous pouvez mieux gérer votre stress et travailler plus efficacement en tant que développeur Web.', NULL, '2023-04-13 00:27:12', '2023-04-13 12:27:12', NULL, '2023-04-20 11:15:48', 'En tant que développeur Web, le stress peut facilement vous submerg...', 5, 1),
(24, 'Les avantages et les inconvénients du travail à distance en développement web', 'Le travail à distance devient de plus en plus courant dans l\'espace de développement Web. Il présente des avantages tels que la flexibilité, la réduction des coûts et l\'amélioration de la qualité de vie, mais il présente également des inconvénients tels que l\'isolement, les problèmes de communication et le manque de collaboration. Les avantages du travail à distance incluent la possibilité pour les développeurs de travailler à leur propre rythme et de gérer leur temps de manière indépendante. Cela augmente la productivité et l\'efficacité. De plus, les frais de transport et de travail sont réduits. Cependant, le travail à distance présente de sérieux inconvénients : B. Manque d\'interaction humaine, difficulté à communiquer efficacement à distance, perte de dynamique de travail d\'équipe. Par conséquent, il est important pour les employeurs et les employés de peser le pour et le contre du travail à distance afin de déterminer si cette pratique convient à leur façon de travailler.', NULL, '2023-03-16 11:13:23', '2023-03-17 00:13:23', NULL, NULL, 'Le travail à distance devient de plus en plus courant dans l\'espace...', 5, 2),
(25, 'Comment maintenir un équilibre travail-vie personnelle en tant que développeur web.', 'En tant que développeur Web, il est facile de se laisser prendre par son travail et de négliger sa vie personnelle. Cependant, un équilibre entre le travail et la vie personnelle est essentiel pour la santé physique et mentale.\r\nPour cette raison, il est important de clarifier la frontière entre le travail et la vie privée. Fixez-vous des heures de travail régulières et, si possible, évitez de travailler en dehors de ces heures. Vous apprendrez également à déléguer des tâches spécifiques et à refuser des projets qui ne correspondent pas à votre emploi du temps. Enfin, prenez soin de vous en faisant régulièrement de l\'exercice, en participant à des activités récréatives et en passant du temps de qualité avec vos amis et votre famille. En suivant ces conseils simples, vous pouvez maintenir un équilibre sain entre le travail et la vie personnelle en tant que développeur Web.', NULL, '2023-03-05 04:13:25', '2023-03-05 12:13:25', NULL, NULL, 'En tant que développeur Web, il est facile de se laisser prendre pa...', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  `level` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `name`, `code`, `level`) VALUES
(1, 'Super Admin', 'superAdmin', 99),
(2, 'Admin', 'admin', 80),
(3, 'Utilisateur', 'user', 10);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(70) NOT NULL,
  `created_at` datetime NOT NULL,
  `avatar` text NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `login`, `password`, `created_at`, `avatar`, `role_id`) VALUES
(1, 'Fayolle', 'Yoan', 'yF-OcBlog', '$2y$10$I7uSGZ44kaznv5BEG3F62OUuuLlvaHpT.FGIzS42IcM8EIDFGJ0nu', '2023-04-20 09:20:56', 'user_644103f89b2e9.png', 1),
(2, 'Fayolle', 'Mute', 'mF-LeCh@t', '$2y$10$s3aYxWU0MtZ0xCuN6JMrROfpYlh1ds2AgRPlzbCGbD9z9c6tAfaFe', '2023-04-20 09:20:56', 'user_644103f919a18.png', 2),
(3, 'Dubois', 'Émilie', 'edubois92', '$2y$10$LfrB1JncmidajSWdHLMsb..S0Xjh5b0sU8B2HA.Xxiu3sq2YGNxPm', '2023-04-02 02:07:29', 'user_644103f952398.png', 3),
(4, 'Garcia', 'Samuel', 'sgarcia13', '$2y$10$1E.vDfVovsS1rNLxeTeOSuVamyrszLncuz83Ojb2ZcBg26IvqhNtq', '2023-03-30 05:41:08', 'user_644103f9852b8.png', 3),
(5, 'Nguyen', 'Kim', 'knguyen_84', '$2y$10$snuoxlKHtHRmd/2X90aHSu7Ktw01x17xlYVeWSLYwPFbOU3xCrJO.', '2023-03-28 17:53:53', 'user_644103f9ebbf6.png', 3),
(6, 'Dupont', 'Nicolas', 'ndupont22', '$2y$10$S3ljIuo3vhIoEtipmzC2gOXTiM9hOx8/IAW0bBtfm3lTThcalcz/S', '2023-04-01 22:19:26', 'user_644103fa61dd4.png', 3),
(7, 'Martinez', 'Carmen', 'cmartinez_78', '$2y$10$kOFdB4WP5itS9Jtrrle6/eCZW.TwhPJ4NUb4982H9RCZJrjsO6G8u', '2023-04-10 06:47:36', 'user_644103fa961e8.png', 3),
(8, 'Smith', 'Michael', 'msmith_16', '$2y$10$DMPdehGcyDtC7OYEcW9qm.wpqlsuR2N7WXuiwJJav3IYSrd3Y8EgK', '2023-03-15 13:56:48', 'user_644103fad70c8.png', 3),
(9, 'Rousseau', 'Sophie', 'srousseau_91', '$2y$10$qZfCiX2Pl8jRnQuel5J6euYddV3fxpMeXDnQX97QK3dNQgjvg3nhu', '2023-03-21 07:17:06', 'user_644103fb247a8.png', 3),
(10, 'Lee', 'Kevin', 'klee_07', '$2y$10$xRXvPgIRcXJTAKu2MdZ0DeejJHz8UoZJjZBO5F2WPHcaqFKd8J15O', '2023-03-06 14:41:31', 'user_644103fb5c390.png', 3),
(11, 'Garcia', 'Ana', 'agarcia_23', '$2y$10$cQ7rVG/wtzsMHDtl.NdGBO4Yx91L2yP59IMG.RMY5DpVjsW2TvFlS', '2023-03-09 11:49:18', 'user_644103fbb8bf0.png', 3),
(12, 'Martin', 'Jean', 'jmartin_69', '$2y$10$diXRPniB8lnR40yhHD79HesI3AUKhajq2xNk0p3sXE7dh/WG8BjBO', '2023-03-11 09:36:30', 'user_644103fc5d561.png', 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`post_id`,`user_id`),
  ADD KEY `fk_comment_post_idx` (`post_id`),
  ADD KEY `fk_comment_user1_idx` (`user_id`);

--
-- Index pour la table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contact_process_by` (`process_by`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`,`category_id`,`user_id`),
  ADD KEY `fk_post_category1_idx` (`category_id`),
  ADD KEY `fk_post_user1_idx` (`user_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`role_id`),
  ADD KEY `fk_user_role1_idx` (`role_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_contact_process_by` FOREIGN KEY (`process_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
