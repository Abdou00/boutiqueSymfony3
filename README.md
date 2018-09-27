# Le frameworks Symfony

### Introduction: Qu'est ce qu'un frameworks ?

1. **Avantages à utiliser un frameworks du marché?**
        - Une organistion optimisée
        - Fonctionnnalités communes
        - Services disponibles(routing, sécurité, cache, connexion sécurisée à la bdd, etc...)

2.**Choix du frameworks**

    -  Construire son propre frameworks
    - Les frameworks full-stack(symfony, laravel, zen, etc...)
        - Les mini-frameworks(Silex, Slim, fat-Free, Lumen)
3.**Symfony**

     - Frameworks développé par Sensiolab
     Différentes versions:

        - **Symfony 3.4**

            C'est en gros la version 2.8 avec le retrait de certaines fonctionnalités dépréciées.

        - **Symfony 4**

            C'est la version 3.4 avec le retrait de certaines fonctionnalités dépréciées, ainsi qu'une nouvelle manière de développé avec plus de liberté dans l'architecture:
                - PHP 7.1
                - Flex
                - Bundle-less

### Etape 1: Installation de symfony sous sa version 3.4

1. **Installation de composer**
    - C'est unu outil de gestion de dépendance. Il permet d'instaaller les services(composant/dépendance) et de les mettre à jours. Il relier à notre application par un fichhier composer.json qui contiendra toutes nos composants.
2. **Installer Symfony installer**
    - Dans un terminal entrer la commande suivante:
    ```shell
    php -r "file_put_contents('symfony', file_get_contents('https://symfony.com/installer'));"
    ```
    Puis:
    ```shell
    symfony new nom_de_mon_projet 3.4
    ```
3. **Installation d'une application vierge symfony**
    - Si vous ne pouvez pas utiliser Symfony installer pour une raison quelconque, vous pouvez créer des applications Symfony avec Composer, le gestionnaire de dépendances utilisé par les applications PHP modernes.

        Dans un terminal ce rendre dans le dossier cible:
    ```shell
     cd xampp/htdocs/symfony
    ```
    Si Composer n'est pas installé sur votre ordinateur, commencez par installer Composer globalement. Ensuite, exécutez la commande create-project pour créer une nouvelle application Symfony basée sur sa dernière version stable:
    Ou bien avec composer:
    ```shell
    composer create-project symfony/framework-standard-edition nom_de_mon_projet
    ```
    Ou en spécifiant la version du frameworks:
    ```shell
    composer create-project symfony/framework-standard-edition nom_de_mon_projet "2.8.*"
    ```
4. **Arborecence et nature des dossiers/fichiers**
    -**Le repertoire app/**
        Ce répertoire contient tout ce qui concerne le site Internet… sauf son code source. Ce sont des fichiers qui concernent l'entièreté du site, contrairement aux fichiers de code source qui seront découpés par fonctionnalité du site. Dans Symfony, un projet de site Internet est une application, simple question de vocabulaire. Le répertoire /app est donc le raccourci pour « application ».
    - **Le repertoire bin/**
        Ce répertoire contient tous les exécutable dont nous allons nous servir pendant le développement. Par exécutable, on entends les commandes PHP.
    - **Le repertoire src/**
        Le répertoire dans lequel on mettra le code source. Dans ce répertoire, nous organiserons notre code en bundles, des briques de notre application, dont nous verrons la définition plus loin.
    - **Le répertoire tests/**
        Ce répertoire contient tous les tests de l'application. Les tests étant un pan entier du développement et indépendant de Symfony. Ils sont important pour bien développer.

    - **Le répertoire var/**
        Il contient tout ce que Symfony va écrire durant son process : les logs, le cache, et d'autres fichiers nécessaires à son bon fonctionnement. Nous n'écrirons jamais dedans nous même.

    - **Le répertoire vendor/**
        Ce répertoire contient toutes les bibliothèques externes à notre application. Dans ces bibliothèques externes, inclus Symfony ! Dans ce répertoire on y trouvera des bibliothèques comme Doctrine, Twig, SwiftMailer, etc.

        Une bibliothèque est une sorte de boîte noire qui remplit une fonction bien précise, et dont on peut se servir dans notre code. Par exemple, la bibliothèque SwiftMailer permet d'envoyer des e-mails. On ne sait pas comment elle fonctionne (principe de la boîte noire), mais on sait comment s'en servir : on pourra donc envoyer des e-mails très facilement, juste en apprenant rapidement à utiliser la bibliothèque.

    - **Le répertoire web/**
        Ce répertoire contient tous les fichiers destinés aux visiteurs: images, fichiers CSS et JavaScript, etc. Il contient également le contrôleur frontal (app.php).

        En fait, c'est le seul répertoire qui devrait être accessible aux visiteurs. Les autres répertoires ne sont pas censés être accessibles (ce sont les fichiers de code source), c'est pourquoi vous y trouverez des fichiers .htaccess interdisant l'accès depuis l'extérieur. On utilisera donc toujours des URL du type localhost/Symfony/web/… au lieu de simplement localhost/Symfony/… .

5.**Lancement de notre application**

    - A ce stade il y 2 manières de lancer l'application:
        1. En ce rendant à l'url: localhost/symfony/nom_de_mon_projet/web/app.php
        2. ```shell
            cd nom_de_mon_projet
            php bin/console server:run
            ```

    - Les fichiers qui sont lancés sont les suivants:
        - web/app.php(en production)
        - web/app_dev.php(en mode développement)
        En production on ne voit pas les erreurs, pour cause puisque que cette version est destinée aux internautes. Mais on peut les voir dans var/logs/prod.log
6.**Fonctionnement des urls**

    - Nos controlleurs frontaux(app.php & app_dev.php) reçoivent la requête(url) et demande au Kernel de charger un controller et une fonction. Pour chaque fonction on definira une route pour que le Kernel s'y retrouve(voir fichier src\AppBundle\Controller\DefaultController.php)

### Etape 2: Les bundles(organisation de nos fichiers)

1. **Les Bundles sont en quelques sorte les "briques" de notre application:**

    - ProduitBundle: Controllers/Routes: boutique, categorie, produit, etc...
    - MembreBundle: Controllers/Routes: Inscription, connexion, profil, etc...

    - Base bundle: Controllers/Routes: Home, mentions_legales, contact, a propos, etc...

mais avec le temps , on estime plus propre de réunnir tous les bundles dans un seul et même bundle.

    - AppBundlde: Tous les controllers & routes.
       -  Un bundle ce compose de:
            - Controller/:
                - Contient les controleurs
            - DependencyInjection/
                - Contient les informations sur le bundle(config)
            - Entity/
                - Contient les classes( classe modèle, POPO)
            - Form/
                - Contient les formulaires(classes qui permettent de construire nos formulaires)
            - Ressources/
                - config/
                    Config du bundle(route par exemple YAML(.yml), etc..)
                - public/
                    Contient les fichiers publiques du bundle(css, js, img, etc..)
                - view/
                    Contient les templates(vues) du bundle

2.**Création d'un bundle**

    ```shell
    php bin/console generate:bundle nom_du_bundle
    ```
    On choisi un nom pour le bundle (ex: POLES\TestBundle), nomme le bundle(ex: POLESTestBundle), choisi la destination des dossier(ex: src/), choisi le format des config(ex: annotation) enfin on enregistre notre namespace dans composer.json > ps-4
    On lance met à jour le projet
    ```shell
    composer update
    ```
    On lance la home de notre site et nous devrions voir "Hello World!!"
    */!\ ATTENTION: Dans cette version; le chemin des vues(dans la fonction render) ne s'écrivent pas de la même manière.*
        - 'POLES:TestBundle:Default:index.html.twig'

        - '@POLESTest/Default/index.html.twig'
Par défaut tous les noouveaux bundles sont enregistrés dans les fichiers "/app/Kernel.php" et "/app/config/routing.yml"

### Etape 3: Les routes et les controllers

1. **Création routes**
    - Route '/' => simple rendu de vue
    - Route '/' => sans paramètre & sans vue
    - Route '/hello/{response}' => sans paramètre avec une response
    - Route 'hola/{response}' => avec paramètre & vue en twig
2. **Objet Request**
    - Dans une requête http il y a toujours une requête et une réponse à cette requête. L'objet Requset va stocker toutes les informations de la requête http, pour pouvoir l'utilisé il faut au préalamble renseigner son utilisation en haut de page de notre bundle comme suit:
    ```php
    use Symfony\Component\HttpFoundation\Request;
    $request -> query -> get('param_en_get');
    $request -> request ->get('param_en_post');
    $request -> cookies -> get('param_en_cookie');
    $request -> server -> get('param_du_serveur');
    $request -> attributes -> get('param_d-url');
    ```
    - Route '/hi/{prenom}' avec paramètre url, paramètre GET & vue en twig.

    - Si request trouve un paramètre qui n'existe pas, il retourne une réponse vide. Pour vérifier si on récupère du $_POST, on peut faire:

    ```php
    if($request -> isMethod('POST'));
    // Pour récupèrer des informations dans une session
    // Methode 1
    $session = $request -> getSession();
    $session -> get('id_membre');
    $session -> set('id_membre', 12);
    // Méthode 2
    $request -> request get('id_membre');
    $request -> session -> get('id_membre', 12);
3. **Objet Respponse**
    - Comme pour l'objet Request il est primordial de préciser son utilisation en haut de fichier:
    ```php
    use Symfony\Component\HttpFoundation\Response;

    ```
Route 'bonjour' test d'une Response
Toutes actions va retourner une Response, le simple fait de faire un render() est déja une utilisation de l'objet Response

```php

$this -> render();
// Est une version racourcci de:
$this -> getTemplating() -> renderResponse();

```

4.**Redirection**

    - Comme pour l'objet Response il est primordial de préciser son utilisation en haut de fichier:
    ```php
    use Symfony\Component\HttpFoundation\RedirectResponse;

    ```
    Route '/redirect' redireige vers une autre route
    La redirection necessite de nommée les différentes routes de notre application(ex: @Route("/bonjour", name="bonjour"))
5.**Message**
    La variable app(test3.html.twig) est une variable globale qui contient des informations générale sur l'application(ex: app.sesion; app.user).

### Etape 4: Création de la boutique

1. **Créé un nouveau projet symfony boutique3.4(cf: Etape 1)**
2. **Créer & enregistrer le bundle BoutiqueBundle**
    ```shell
    php bin/console generate:bundle
    -> no
    -> BoutiqueBundle
    -> src/
    -> annotation
    ```
    puis ensuite on ajoute le nouveau bundle dans le fichierr composer.json
    ```json
     "autoload": {
        "psr-4": {
            "AppBundle\\": "src/AppBundle",
            "BoutiqueBundle\\": "src/BoutiqueBundle"
        },
    ````
3. **Update de l'app**
    ```shell
    composer update
    ```
4. **Réorganisation du bundle**
    Renommage du DefaultController par ProduitController à la fois pour le nom du fichier et la classe.
    Création des répertoires Commande, Membre, Produit dans le répertoire des vues.
5. **Création des premières routes**
    Création des routes pour la page d'accueil(@Route("/" ) => index.html.twig), de la page des catégories(@Route("/categorie/{categorie}") => index.html.twig), et enfin de la page produit(@Route("/produit/{id}") => produit.html.twig)

/!\ A ce stade il es possible qu'il y est des erreurs. L'échange avec la bdd se faisant avec Doctrine, on simule de la data avec les array produits et categorie.

### Etape 5: Les vues avec Twig

1. **Créer un layout**
    Un layout est la structure de page prête à recevoir des vues (bloc d'html), en déclarant des zones (fenêtre) exemple {% block content %}.
2. **L'héritage Twig**
    Au même titre que l'héritage en PHP, l'héritage TWIG permet de dire à un fichier qu'il dépend d'un parent.  Pour TWIG, en réalité l'héritage est matérialisé par le fait que l'on crée des blocks dans le parents (fênetres ouvertes), dans lesquels les vues peuvent afficher du contenu html
3.**Modification des vues**
Dans un premier temps on récupère boutique.html de notre mini-framework et on fait :

    1. On créé le fichier index.html.twig (parce que indexAction rend ce fichier )
    2. On lui dit d'hériter de notre layout
        ```twig
        {% extends 'layout.html.twig' %}
        ```
    3. On insère le contenu dans le block content
    4. On modifie les boucles
        ```php
        <?php foreach ($a as $x) :?>`
        ```
        devient :
        ```twig
        {% for x in a  %}
        ```
    5. On modifie les variables :
        ```php
        <?= $x['y'] ?>
        ou <?= $x -> getY() ?>
        ```
        deviennent :
        ```twig
        {{x.y}}
        ```
4.**Documentation**
    [Ici](https://twig.symfony.com/doc/2.x/) ce trouve la documentation complète de twig.
5.**Exercice:**
Créer la route Categorie, qui affiche les produits d'une categorie

    - Récupérer les arrays créés dans Accueil
    - Vous passez toutes les infos en parametres enb render
    - Vous passer la vue à afficher dans render
    - test /categorie/pull (afficher tous les produits)
Créer la route produit qui affiche la page d'un produit

    - Créer un array produit dans la foncriob produitAction()
    - Vous passez toutes les infos en parametres de render
    - Vous passez la vue produit.hml.twig à render
    - Vous créez le fichier produit.html.twig sur la base de produit.html (mini-framework)
    - Mofifier produit.html.twig (héritage, boucle, et variables).
    - Test url /produit/id (affiche la page d'un produit)

### Etape 6: Les Entités

1. **Doctrine ORM & le concept des entités**
    Les entités correspondent à la partie Model de la structure MVC. Elles nous permettront de ne plus faiire de SQL et (normalement) ne plus avoir besoin de mettre le nez dans phpmyadmin.
    On créé des entités(nos POPO, classes, plans de fabrication) des objets qui vont être manipulés dans l'application.
    Doctrine ORM(Object Relation Mapping), grâce à des annotations va comprendre toutes les interactions qu'il existe entre les objets et donc reprendre la main. Par exemple nous ne ferons plus de requête INSERT pour enregistrer une entrée, mais nous utiliseront des fonctions de Doctrine pour cette action(On dit persister).
2. **Créé des entités**
    - On créé un dossier Entity dans notre bundle
    - On créé un fichier par entité(produit.php, commande.php, membre.php)
    - On créé les propriétes, les getters et les setters

    Dans un premier temps on créé à la main l'entité produit.

3. **Les annotations**
    - Encore une fois les annotations vont être interprêtés et nous rendent un grand service. Elle permettent à notre ORM de comprendre les interactions entre les objets et la bdd, ainsi qu'entre les objets eux-même. C'est ce qu'on appelle le "**mapping**".
    On défini l'utilisation de Doctrine ORM
    ```php
    use Doctrine\ORM\\Mapping as ORM;
    ```

    Puis on defini les information pour chaque propriété
    ```php
     /**
     * @var int
     * @ORM\Column(name="id_produit", type="integer", length="3")
     * @ORM\Id
     * @ORM\GenerateValue(strategy="AUTO")
    */
    private $id_produit;

    /**
     * @var string
     * @ORM\Column(name="reference", type="string", length="20")
     */
    private $reference;
    ...
    ```
    Pour en savoir plus sur le mapping basique: [Ici](www.doctrine-project.org/projects/doctrine-orm/en/current/reference/basic-mapping.html#basic-mapping)

    Pour en savoir plus sur les associations mapping: [Ici](www.doctrine-project.org/projects/doctrine-orm/en/current/reference/association-mapping.html#association-mapping)

4. **Générer des tables**
    1. Régler les paramètre de la connexion à la bdd dans le fichier app/config/parameters.yml
    2. Générer la bdd avec la console
        ```shell
        php bin/console doctrine:database:create
        ```
    3. Créé noss entités dans src/BoutiqueBundle/Entity
        ```shell
        php bin/console doctrine:schema:update --dump-sql
        php bin/console doctrine:schema:update --force
        ```
5. **Créé des entités avec la console**
    - Méthode 1: Création d'une entité depuis la console
        ```shell
        php bin/console doctrine:generate:entity
        ```
        Suivre les différentes étape renseigné, cela nous génère l'entité ainsi que le répertoire(Repository) correspondant

    - Méthode 2: Génération d'entité depuis la bdd
        ```shell
        php bin/console doctrine:mapping:import App\\Entity annotation --path=src/BoutiqueBundle/Entity
        ```
        /!\ Attention: Cette commande renvoi une erreur si une des tables que l'on importe contient des champs de type ENUM.

        Enfin pour compléter les entités(getter/setter/repository) on complète le ligne @Entity:
        ```php
        @ORM\Entity(repositoryClass="BoutiqueBundle\Repository\MembreRepository")
        @ORM\Entity(repositoryClass="BoutiqueBundle\Repository\CommandeRepository")
        @ORM\Entity(repositoryClass="BoutiqueBundle\Repository\DetailsCommandeRepository")
        @ORM\Entity(repositoryClass="BoutiqueBundle\Repository\ProduitRepository")
        ```
        Ensuite on lance:
        ```shell
        php bin/console doctrine:generate:entities BoutiqueBundle
        ```

### Etape 7: Doctrine - DQL

1. Le service Doctrine
    Doctrine est un outil puissant qui est utilisé dans Symfony, mais également dans d'autres frameworks(zend, cake, laravel). Il ce compose de 2 éléments.
    - ORM(Object Relation Mapping) lie la bdd à des objets PHP
    - DBAL(DataBase Abstract Layer(DQL)) simplifie les requête SQL en utilisant des fonctions PHP(DQL(Doctrine Query Language)) en lieu et place du SQL

2. Accéder au service Doctrine depuis les controllers
    ```php
    $repository = $this -> getDoctrine() -> getRepository(nom de lentité dont on veut récupérer le repository);
    // Ou
    $repository = $this -> getDoctrine() -> getRepository(nom de lentité dont on veut récupérer le repository);
    ```

3. Requete "SELECT * FROM"
    ```php
    $repository = $this -> getDoctrine() -> getRepository(Produit::class);
     // Ici on stocke les données dans la variable $produits
    $produits = $repository->findAll();
    ```
4. Requete "SELECT * FROM...WHERE id="
    ```php
     // Méthode 1
    $repository = $this -> getDoctrine() -> getRepository(Produit::class);
    $produit = $repository -> find($id);

    // Méthode 2
    $em = $this -> getDoctrine() -> getManager();
    $produit = $em -> find(Produit::class, $id);
    ```

5. Requete "SELECT * FROM... WHERE...=..."
    ```php
    $repository = $this -> getDoctrine() -> getRepository(Entity::class);
    // Retourne tous les résultats
    $produits = $repository -> findBy(['categorie' => $category]);
    // Paramètre multiple(condition)
    $produits = $repository -> findBy(['categorie' => $category, 'prix' => 15]);
    // Paramètre avec option
    $produits = $repository -> findBy(['categorie' => $category], ['prix' => 'DESC']);
    // Pour retourner une seul entrée(de préférence sur un champ unique)
     $produit = $repository -> findOneBy(['slug' => 'pseudo']);
    ```

6. Requete INSERT/UPDATE
- INSERT:
    Pour insérer une nouvelle entrée, on instancie un objet de l'entité :
    ```php
    $membre = new Membre;
    ```
    On définie les propriétés :
    ````php
    $membre  -> setPrenom('lePrenom');
     ````
    On récupère le manager :
    ````php
     $em = $this -> getDoctrine() -> getManager();
     ````
    On persiste, afin de préparer l'insertion, puis on flush pour rendre l'enregistrement effectif :
    ````php
    $em -> persist($membre);
    $em -> flush();
     ````

- UPDATE :
    Pour modifier un entrée (enregistrement) on le récupère, on modifie les propriétés à modifier, on la persist et on la flush.

    ````php
    $em = $this -> getDoctrine() -> getManager();
    $membre = $em -> find(Membre::class, $id);

    $membre -> setPrenom('nouveau_prenom');

    $em -> persist($membre);
    $em -> flush();
     ````
    cf MembreController, route membre/update/$id

7.Requete DELETE
    Doctrine manipule les pbjets liés à nos entités, aussi pour supprimer une entrée on doit d'abord la récupérer. Ensiute la fonction remove() de notre EntityManager($em), permet de préparer la suppression, la fonction flush la rend effective.

8.Create Query & Query Builder
    Doctrine permet de facilement manipuler des enregistrement dans la bdd grâce aux entités(find, findBy, findOneBy, findAll, remove, persist). Cela dit on peut être amener à vouloir des requêtes plus complexe, pour ce faire on dispose de 2 outils:
    - Create Query
    Permet d'écrire des requêtes en SQL(DQL)
    cf: route "/" dans ProduitController(requête DISTINCT)
    Pour en savoir plus [Ici](Lien : www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/dql-doctrine-query-language.html)

    - Query Builder
    Permet d'écrire des requêtes en PHP
    cf: route "/produit/{id}" dans ProduitController
    Pour en savoir plus [Ici](www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html)

### Etape 8: Les formulaires

- Le fonctionnement des formulaire
    Symfony lie un formulaire à une entité, cela dit il est possible de créé un formulaire lié à aucune entité. Chaque type de champs est gérer par une classe(TextType, NumberType, ChoiceType, etc)

- Création d'un formulaire
    Voir la route "/register" dans MembreController
    FormBuilder est un "constructeur" de formulaire fournit par symfony qui permet de paramètrer des formulaires.
    ```php
    $formBuilder = $this -> get('form.factory') -> createBuilder(FormType::class, $membre);
    // Ou
    $frombuilder = $this -> createFormBuilder($membre);
    ```
    On ajoute ensuite les champs attendus dans le formulaire avec la méthode add()
    ```php
    -> add('pseudo', TextType::class)
    -> add('mdp', PasswordType)
    ...
    ```
   */!\Attention: les TypeClass pour être fonctionnel doivent être appeler en haut de fichier avec la méthode "use".*
    On créé le formulaire
    ```php
    $form = $formBuilder -> getForm();
    ```
    On récupère la vue du formulaire qui sera ensuite transmis à la vue via $params
    ```php
    $formView = $form -> createView();
    $params = array(
        'membreForm' => $formView
    );
    ```
    On affiche le formulaire
    ```twig
    {{form(membreForm)}}
    ```
- Les classes Type
    En savoir plus [consulter la documentation](symfony.com/doc/current/reference/forms/types.html)

- Récupérer les données du formulaire
    ```php
    $form -> handleRequest($request)
    ```
    C'est à cet instant que notre objet $membre lié au formulaire contient les données entrées dans le formulaire. Ensuite on vérifie la validité du formulaire
    ```php
    if($form -> isSubmitted() && $form -> isValid()){

    }
    ```
    */!\ On verra plus tard les options de validité*
    Puis on enregistre les données
    ````php
    $em = $this -> getDoctrine() -> getManager();
    $em -> persist($membre);
    $em -> flush();
    ````
- Personnaliser avec Bootstrap
    Il existe 2 façons, soit en jouant le lien dans le fichier app/config/config.yml
    ```yaml
    twig:
        ...
        form_themes: ['bootstrap_4_layout.html.twig']
    ```

- Création de Type personnalisé(AbstractType)
    ````shell
    php bin/console doctrine:generate:form BoutiqueBundle:Membre
    ````
- Update une entrée

- Champs file(photo produit)

### Etape 9: Validation des données

### Etape 10: Sécurité et Utilisateur

### Etape 11: Les services

### Etape 12: Les événementts

### Etape 13: Les assets

Le composant asset de symfony permet de gérer les ressources(images, js, css, liens etc...), et de les appeler de manière absolu.

1. Inclusion de la dépendance "symfony/asset" dans le fichier composer.json
    ```json
    "require":{
        ...
        "symfony/asset": "^3.4"
    }
    ```

    ou via la commande

    ```shell
    composer require symfony/asset
    ```

2. Mise à jour des dépendances

    ```shell
    composer update
    ```

3. Modification des vues(asset & path) + ajout répertoire photo
    - Layout
         ```html
        href="../../../web/css/style.css"
         ```

        ```twig
         href="{{asset('css/style.css')}}"
        ```

         ```html
         href="index.php"
        ```

         ```twig
         href="{{path('accueil')}}"
         ```

    - Dans les vues
        ```html
        href="../../../web/photo/<?= $pdt['phpto'] ?>"
        ```
        ```twig
        href="{{asset('photo/~pdt.photo')}}"
        ```

         ```html
        href="fiche_produit.php?id=<?= $pdt['id_produit'] ?>"
         ```

         ```twig
        href="{{ path('produit', { 'id'  : pdt.id_produit} ) }}"
         ```

        où produit égal au nom de la route à exécuter, id est égal au  nom du paramètre attendu par la route, pdt.id_produit est égal à la valeur de l'id du produit en cours.

### Etape 14: Symfony 4
