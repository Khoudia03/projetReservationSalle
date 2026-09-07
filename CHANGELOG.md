## Composer
1 : Quel est le rôle de Composer ? → Composer sert à installer et gérer les dépendances PHP du projet.
2 : Quelle différence existe entre require et require-dev ? → require contient les dépendances nécessaires au fonctionnement de l’application, tandis que require-dev contient celles utilisées seulement pour le développement et les tests.
3 : Pourquoi faut-il versionner composer.lock ? → composer.lock permet à toute l’équipe d’installer exactement les mêmes versions des dépendances.
4 : Pourquoi ne versionne-t-on pas vendor/ ? → Parce que vendor/ contient les dépendances installées par Composer et peut être recréé avec composer install.

## Eloquent
1 : Quel rôle joue Capsule\Manager ? → Capsule\Manager configure et démarre Eloquent sans avoir besoin de Laravel.
2 : Pourquoi Eloquent peut-il fonctionner sans Laravel ? → Parce qu’Eloquent est disponible comme composant indépendant dans illuminate/database.
3 : Où doit se trouver le démarrage de l’ORM ? → Le démarrage de l’ORM doit se faire dans la configuration de l’application, avant d’utiliser les modèles.
4 : Quelle différence existe entre ORM et SQL écrit à la main ? → L’ORM permet de manipuler les données avec des objets et des méthodes PHP au lieu d’écrire directement les requêtes SQL.

## Modèles Eloquent
1 : Quel type de relation Eloquent avez-vous utilisé ? → Nous avons utilisé une relation One-to-Many avec hasMany et belongsTo.
2 : Pourquoi déclarer $fillable ou $guarded ? → Ils permettent de contrôler les champs pouvant être remplis automatiquement avec les données reçues.
3 : Pourquoi convertir active en booléen ? → Pour que la valeur soit manipulée comme un vrai true ou false en PHP.
4 : Pourquoi convertir les dates en objets ? → Pour pouvoir facilement comparer, modifier et manipuler les dates avec les méthodes de PHP.

## Seeder
1 : Quelle différence existe entre migration et seeder ? → Une migration crée ou modifie la structure de la base tandis qu’un seeder insère des données.
2 : Pourquoi les données initiales doivent-elles être reproductibles ? → Pour pouvoir recréer les mêmes données facilement après une nouvelle installation.
3 : Comment empêcher les doublons ? → On peut utiliser des contraintes UNIQUE et vérifier l’existence des données avant de les insérer.

## Validation
1 : Pourquoi séparer la validation syntaxique des règles métier ? → La validation syntaxique vérifie la forme des données tandis que les règles métier vérifient les conditions propres à l’application.
2 : Pourquoi créer une interface de validation ? → Elle impose une même méthode de validation à tous les validateurs.
3 : Pourquoi le validateur ne doit-il pas enregistrer les données ? → Parce que son rôle est seulement de vérifier les données, pas de gérer leur enregistrement.
4 : Comment retourner plusieurs erreurs en une seule fois ? → On stocke les erreurs dans un tableau puis on retourne toutes les erreurs dans ValidationResult.

## DTO
1 : Quelle différence existe entre DTO et modèle Eloquent ? → Le DTO transporte les données tandis que le modèle Eloquent représente et manipule les données de la base.
2 : Pourquoi le DTO ne doit-il pas appeler save() ? → Parce que le DTO ne doit pas gérer l’accès à la base de données.
3 : À quel moment transforme-t-on les chaînes en dates ? → On transforme les chaînes en objets DateTimeImmutable lors de la création du DTO.
4 : Le DTO doit-il contenir la règle de chevauchement ? → Non, la règle de chevauchement appartient au service métier.

## Repository
1 : Eloquent constitue-t-il déjà un accès aux données ? → Oui, Eloquent permet déjà d'interroger et de modifier la base de données.
2 : Pourquoi ajouter un Repository au-dessus d’Eloquent ? → Pour séparer le code métier de la manière dont les données sont stockées ou récupérées.
3 : Cette abstraction est-elle toujours nécessaire ? → Non, elle est surtout utile lorsque le projet devient complexe ou nécessite une meilleure séparation des responsabilités.
4 : Quel avantage apporte-t-elle ? → Elle facilite les tests et permet de remplacer Eloquent par une autre source de données.

## Services
1 : Pourquoi ces règles ne sont-elles pas dans le contrôleur ? → Parce que le contrôleur doit gérer HTTP et déléguer les règles métier au service.
2 : Pourquoi le service dépend-il d’une interface de Repository ? → Pour que le service ne dépende pas directement d’une implémentation particulière comme Eloquent.
3 : Quelle exception doit être levée en cas de conflit ? → SalleIndisponibleException doit être levée.
4 : Comment tester le service sans MySQL ? → On utilise un repository en mémoire comme InMemoryReservationRepository.

## FastRoute
1 : Pourquoi FastRoute ne construit-il pas lui-même le contrôleur ? → FastRoute se contente de trouver quelle route correspond à la requête et retourne son handler.
2 : Quelle différence existe entre 404 et 405 ? → 404 signifie que la route n’existe pas tandis que 405 signifie que la route existe mais que la méthode HTTP n’est pas autorisée.
3 : Pourquoi contraindre {id} avec \d+ ? → Pour accepter uniquement un identifiant composé de chiffres.
4 : Quel composant doit interpréter le handler retourné ? → C’est l’Application qui interprète le handler et demande au conteneur de créer le contrôleur.

## Injection de dépendances / PHP-DI
1 : Quelle différence existe entre injection et conteneur ? → L’injection consiste à fournir une dépendance à une classe tandis que le conteneur automatise la création et la fourniture de ces dépendances.
2 : Qu’est-ce que l’autowiring ? → L’autowiring permet au conteneur de détecter automatiquement les dépendances d’une classe et de les injecter.
3 : Pourquoi les interfaces nécessitent-elles une définition ? → Parce que le conteneur ne sait pas automatiquement quelle classe concrète utiliser pour une interface.
4 : Pourquoi limiter $container->get() au point d’entrée ? → Pour éviter que toutes les classes dépendent directement du conteneur.
5 : Quel anti-pattern apparaît si toutes les classes interrogent le conteneur ? → On obtient le Service Locator, qui crée un fort couplage avec le conteneur.