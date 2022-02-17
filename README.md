## Exercice 1 - Mise en plase CRUD panel d'administration.

Pour qu'un CRUD d'une entité soit complète, il va falloir 4 pages :
- La page index, qui liste toutes les données en base de l'entité
- Une page de création
- Une page d'édition
- Une page de détails

Dans cet exercice on va mettre en place le CRUD des entités suivante :
- User
- Category
- Product

### Récupérer le layout twig de l'administration de l'ancien projet

Nom du fichier dans le dossier templates : `admin_layout.html.twig`
Ce fichier utilise un partial : `sidebar.html.twig`, il est aussi à récupérer dans le dossier partials de l'ancien projet

### Commençons par l'entité User
User :
- [ ] L'index : `/admin/users`
- [ ] La création : `/admin/users/new`, nécessite la création d'un form UserType
- [ ] L'édition : `/admin/users/{id}/edit`, utilise le form UserType.
- [ ] La page détails : `/admin/users/{id}`

### L'entité Category
Category :
- [ ] L'index : `/admin/categories`
- [ ] La création : `/admin/categories/new`, nécessite la création d'un form CategoryType
- [ ] L'édition : `/admin/categories/{id}/edit`, utilise le form CategoryType.
- [ ] La page détails : `/admin/categories/{id}` 

### L'entité Product
Category :
- [ ] L'index : `/admin/products`
- [ ] La création : `/admin/products/new`, nécessite la création d'un form ProductType
- [ ] L'édition : `/admin/products/{id}/edit`, utilise le form ProductType.
- [ ] La page détails : `/admin/products/{id}`

### Validation des formulaires via les contraintes

Pour que nos entités soit composées de données valides nous allons utiliser des contraintes pour les valider.

Ajouter les contraintes suivantes à vos entités:

___
**User**

Email:
- [ ] UniqueEntity
- [ ] NotBlank
- [ ] Email

Lastname:
- [ ] NotBlank

Firstname:
- [ ] NotBlank

Password:
- [ ] NotBlank
- [ ] Length (min 6 caractères)
___
**Category**

Name:
- [ ] UniqueEntity
- [ ] NotBlank
___
**Product**

Name:
- [ ] UniqueEntity
- [ ] NotBlank

Description:
- [ ] Length

Price:
- [ ] GreaterThan (0)
- [ ] Positive
___
**Review**

Content:
- [ ] NotBlank
- [ ] Length

Note:
- [ ] NotBlank
- [ ] Range (0 à 5)
___

### La page panier et l'ajout au panier

Notre boutique n'a pas encore sa page panier et n'offre pas non plus la possibilité d'ajouter au panier

Commençons par ajouter sur la page détails d'un produit côté boutique un formulaire pour l'ajout d'un produit au panier.

Le formulaire sera nommé AddToCartType, il sera composé d'un champ Number pour la quantité que l'on souhaite ajouter au panier.

Ce formulaire sera traité dans le controller de la page détails d'un produit. L'objectif est qu'une fois le formulaire soumis, on récupère la quantité et on crée un CartProduct avec la quantité et le produit courant que l'on ajoute au panier de l'utilisateur connecté.

***Attention cela veut dire que l'on ne soit pas pouvoir voir le formulaire sur le template si l'on n'est pas connecté !***

Enfin on peut enchainer avec le CartController qui affichera le contenu du panier de l'utilisateur actuellement connecté.

Dans notre application on ne peut accéder à la page panier que si l'on est connecté, indice: une annotation/attribut is_granted est disponible pour les routes


## Exercice 2 : Statistiques

Nous allons afficher sur la page d'accueil de l'administration quelques statistiques de notre site.

Pour rendre les requêtes un peu plus intéressantes, nous allons rajouter des dates sur nos entités :

- Ajouter un champs postedAt sur l'entité Review
- Ajouter un champs createdAt sur l'entité Product

Pensez à mettre à jour vos CRUD et fixtures pour prendre en compte ces nouveaux champs

Une fois cela fait, si vous n'en disposez pas déjà d'un, créez un HomeController pour l'administration.

Tout le travail peut être fait dans sur la route `/`.

Voici les requêtes de Repository personnalisées à implémenter et à afficher pour faire ces statistiques :

1. Dans le `ProductRepository`, ajouter une méthode `findLastCreated()` qui renvoi les 3 derniers produits créés.
2. Dans le `ReviewRepository`, ajouter une méthode `findLastPosted()` qui renvoi les 5 derniers avis postés.
3. Dans le `UserRepository`, ajouter une méthode `findTopReviewers()`, qui renvoi les 3 utilisateurs ayant posté le plus de reviews.
4. Dans le `ProductRepository`, ajouter une méthode `findTopReviewed()` qui renvoi les 3 produits les plus/mieux notés.
5. Dans le `ReviewRepository`, ajouter une méthode `findAllWithWord(string $word)`, qui renvoi les reviews contenant le mot passé en paramètre.
6. Dans le `ReviewRepository` ou le `ProductRepository`, ajouter une méthode `findReviewsBetweenDates(DateTime $startDate, DateTime $endDate)` qui renvoi les reviews/produits créés ou postées entre les deux dates passées en paramètre (dates de type DateTime !) 