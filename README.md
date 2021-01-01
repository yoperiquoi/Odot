# Odot

###Site web consistant en la gestion d'une To Do list grâce à PHP réalisé par Emrick Pesce et Yoann PERIQUOI en 2A de DUT Informatique à Clermont-Ferrand.

---

**Répartition :**

Yoann : Vue (Principalement Php), Modèle (Modèle mètier), DAL (Gateways), Controleurs (Départ,fonctions basiques), FrontControleur (création de la classe avec Emrick), Images, Documentation, BDD, JavaScript (fonction ajax avec jQuery) , Remodélisation des gateways pour la séparation Tache/Liste/Utilisateur.

Emrick : Vue (Principalement Bootstrap, affiche des erreurs dans les pages, séparation en plusieurs pages), Modèle (Modèle Persistance), DAL (Corrections), Controleurs (Gestion Erreur, appel modèle), 
FrontControleur (création de la classe avc Yoann, séparation du premier contrôleur en 2 controleurs pour les invités et les connectés), config (Autoload,config), Validation, Modele, aide pour le JavaScript

---

**Ajouts non demandés :**

- Page d'inscription qui permet de créer de nouveaux utilisateurs
- Les cases cochées sont gérées via un appel ajax, qui évite de recharger la page à chaque coche
- Ajout d'un logo
- Quand on est connecté notre pseudo est affiché
- On peut passer des listes privées aux listes publiques et inversement sans avoir à se déconnecter/reconnecter
- Le logo avec le nom en haut à gauche permet de revenir sur la page principale
- Quand il y a plus de 3 listes, elles sont séparées en différentes pages. Quand il y a trop de pages, elles ne sont pas toutes affichées sur la barre de navigation (des points viennent à la place). 
  Cela peut être mis en évidence en baissant le nombre de listes par page à 1 via la variable $nbListesPages dans le FrontControleur

---

**Utilisation du site web :**

La base de données du site à charger se trouve dans le dossier config.
Des tâches ont été misent de base dans la partie publique, on peut alors navigué entre les différentes pages pour voir toutes les listes, on peut alors ajouter, supprimer et cocher les taches.
Un utilisateur avec comme identifiant mail yoann_63115@hotmail.fr et le mot de passe "lephpcestbien" a été ajouté afin de voir la connection en place. L'inscription et l'ajout d'un utilisateur reste par ailleurs totalement possible.
On retrouve les même interactions du côté privée.

