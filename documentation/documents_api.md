# API de Gestion des Documents

Ce document fournit une documentation détaillée pour l'API de gestion des documents disponibles.

## Composants Associés

- **Modèle** : `app/Models/AvailableDocument.php`
- **Contrôleur** : `app/Http/Controllers/Documents/DocumentController.php`
- **Interface du Repository** : `app/Interfaces/DocumentsInterface.php`
- **Repository** : `app/Repositories/DocumentsRepository.php`
- **Fichier de Routes** : `routes/api.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/Documents/DocumentCreateRequest.php`
    - `app/Http/Requests/Documents/DocumentUpdateRequest.php`
- **Ressource API** : `app/Http/Resources/Documents/DocumentsResources.php`

## Structure de l'Objet `AvailableDocument` (Réponse API)

L'objet `AvailableDocument` retourné par l'API a la structure suivante.

| Attribut      | Type      | Description                                          |
| ------------- | --------- | ---------------------------------------------------- |
| `id`          | `string`  | Identifiant unique du document (UUID).               |
| `name`        | `string`  | Nom du document.                                     |
| `description` | `string`  | Description du document.                             |
| `category`    | `string`  | Catégorie du document.                               |
| `type`        | `string`  | Type de document (ex: "PDF", "Word").                |
| `created_at`  | `string`  | Date de création (Format ISO-8601).                  |
| `updated_at`  | `string`  | Date de dernière modification (Format ISO-8601).     |
| `templates`   | `array`   | Tableau d'objets `Template` liés (si chargé).        |
| `tags`        | `array`   | Tableau d'objets `Tag` liés (si chargé).             |

## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "data": {
    "name": [ "Le nom du document est requis." ],
    "category": [ "La catégorie du document est requise." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/app`.

---

### 1. Lister les Documents

- **Endpoint** : `GET /documents`
- **Description** : Récupère une liste paginée de tous les documents disponibles.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `AvailableDocument` (voir [Structure de l'Objet `AvailableDocument`](#structure-de-lobjet-availabledocument-réponse-api)).

---

### 2. Créer un Document

- **Endpoint** : `POST /documents/create`
- **Description** : Crée un nouveau document disponible.

- **Corps de la Requête** (`application/json`):

| Champ         | Type      | Description                                          | Requis |
| ------------- | --------- | ---------------------------------------------------- | ------ |
| `name`        | `string`  | Nom unique du document. (max: 300)                   | Oui    |
| `category`    | `string`  | Catégorie du document. (max: 100)                    | Oui    |
| `type`        | `string`  | Type de document (ex: "PDF", "Word"). (max: 100)   | Oui    |
| `description` | `string`  | Description du document. (max: 1000)                 | Non    |

- **Réponse de Succès (200)** : Retourne le nouvel objet `AvailableDocument` (voir [Structure de l'Objet `AvailableDocument`](#structure-de-lobjet-availabledocument-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 3. Afficher un Document Spécifique

- **Endpoint** : `GET /documents/show/{id}`
- **Description** : Récupère les détails d'un document spécifique.
- **Réponse de Succès (200)** : Retourne un objet `AvailableDocument` complet (voir [Structure de l'Objet `AvailableDocument`](#structure-de-lobjet-availabledocument-réponse-api)).

---

### 4. Mettre à Jour un Document

- **Endpoint** : `POST /documents/update/{id}`
- **Description** : Met à jour un document existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ         | Type      | Description                                          |
| ------------- | --------- | ---------------------------------------------------- |
| `name`        | `string`  | Nom unique du document. (max: 300)                   |
| `category`    | `string`  | Catégorie du document. (max: 100)                    |
| `type`        | `string`  | Type de document (ex: "PDF", "Word"). (max: 100)   |
| `description` | `string`  | Description du document. (max: 1000)                 |

- **Réponse de Succès (200)** : Retourne l'objet `AvailableDocument` mis à jour (voir [Structure de l'Objet `AvailableDocument`](#structure-de-lobjet-availabledocument-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 5. Supprimer un Document

- **Endpoint** : `DELETE /documents/delete/{id}`
- **Description** : Supprime un document.
- **Réponse de Succès (200)** : Retourne un message de succès.

---

### 6. Récupérer les Documents par Catégorie

- **Endpoint** : `GET /documents/category/{category}`
- **Description** : Récupère une liste paginée de documents appartenant à une catégorie spécifique.
- **Paramètres d'URL** :
  - `category` (requis, `string`) : La catégorie des documents à récupérer.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `AvailableDocument`.

---

### 7. Rechercher des Documents

- **Endpoint** : `GET /documents/search/`
- **Description** : Recherche des documents par nom, catégorie ou description.
- **Paramètres de Requête** :
  - `q` (optionnel, `string`, défaut: `''`) : Le terme de recherche.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `AvailableDocument`.
