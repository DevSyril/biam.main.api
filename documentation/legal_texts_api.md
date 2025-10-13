# API de Gestion des Textes Légaux

Ce document fourni une documentation détaillée pour l'API de gestion des textes légaux.

## Composants Associés

- **Modèle** : `app/Models/LegalText.php`
- **Contrôleur** : `app/Http/Controllers/LegalContext/LegalTextController.php`
- **Interface du Repository** : `app/Interfaces/LegalTextInterface.php`
- **Repository** : `app/Repositories/LegalTextRepository.php`
- **Fichier de Routes** : `routes/api.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/LegalContext/LegalTextCreateRequest.php`
    - `app/Http/Requests/LegalContext/LegalTextUpdateRequest.php`

## Structure de Données (Modèle `LegalText`)

Le modèle `LegalText` représente un texte légal dans la base de données.

### Attributs

| Attribut           | Type      | Description                                          | Nullable |
| ------------------ | --------- | ---------------------------------------------------- | -------- |
| `id`               | `uuid`    | Identifiant unique du texte légal (clé primaire).    | Non      |
| `title`            | `string`  | Titre du texte légal.                                | Non      |
| `text_type`        | `string`  | Type de texte (loi, décret, etc.).                   | Non      |
| `official_number`  | `string`  | Numéro officiel du texte.                            | Oui      |
| `promulgation_date`| `Carbon`  | Date de promulgation.                                | Non      |
| `abrogation_date`  | `Carbon`  | Date d'abrogation (si applicable).                   | Oui      |
| `is_in_force`      | `bool`    | Indique si le texte est actuellement en vigueur.     | Oui      |
| `official_source`  | `string`  | Source officielle de publication (journal officiel). | Oui      |
| `version`          | `string`  | Version du texte.                                    | Oui      |
| `applicable_country`| `string` | Pays où le texte est applicable.                     | Oui      |
| `jurisdiction`     | `string`  | Juridiction concernée.                               | Oui      |
| `created_at`       | `Carbon`  | Date de création.                                    | Oui      |
| `updated_at`       | `Carbon`  | Date de dernière modification.                       | Oui      |

### Relations

- **`articles()`**: Relation `hasMany` avec le modèle `Article`. Un texte légal peut avoir plusieurs articles.

## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "errors": {
    "title": [ "The title field is required." ],
    "publication_date": [ "The publication date must be a valid date." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/legal`.

---

### 1. Lister les Textes Légaux

- **Endpoint** : `GET /texts`
- **Description** : Récupère une liste paginée de textes légaux.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.

---

### 2. Créer un Texte Légal

- **Endpoint** : `POST /texts/create`
- **Description** : Crée un nouveau texte légal.

- **Corps de la Requête** (`application/json`):

| Champ              | Type      | Description                                      | Requis |
| ------------------ | --------- | ------------------------------------------------ | ------ |
| `title`            | `string`  | Titre du texte. (max: 255)                       | Oui    |
| `text_type`        | `string`  | Type de texte (loi, décret...). (max: 255)       | Oui    |
| `publication_date` | `string`  | Date de publication. (Format: `YYYY-MM-DD`)      | Oui    |
| `jurisdiction`     | `string`  | Juridiction concernée. (max: 255)                | Oui    |
| `official_number`  | `string`  | Numéro officiel du texte. (max: 255)             | Non    |
| `description`      | `string`  | Description ou résumé du texte.                  | Non    |
| `is_in_force`      | `boolean` | Indique si le texte est en vigueur.              | Non    |
| `source`           | `string`  | Source de publication (ex: Journal Officiel). (max: 255) | Non    |
| `version`          | `string`  | Version du texte. (max: 255)                     | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `LegalText`.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 3. Afficher un Texte Légal Spécifique

- **Endpoint** : `GET /texts/show/{id}`
- **Description** : Récupère les détails d'un texte légal, incluant ses articles.

---

### 4. Mettre à Jour un Texte Légal

- **Endpoint** : `POST /texts/update/{id}`
- **Description** : Met à jour un texte légal existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ              | Type      | Description                                      |
| ------------------ | --------- | ------------------------------------------------ |
| `title`            | `string`  | Titre du texte. (max: 255)                       |
| `text_type`        | `string`  | Type de texte (loi, décret...). (max: 255)       |
| `publication_date` | `string`  | Date de publication. (Format: `YYYY-MM-DD`)      |
| `jurisdiction`     | `string`  | Juridiction concernée. (max: 255)                |
| `official_number`  | `string`  | Numéro officiel du texte. (max: 255)             |
| `description`      | `string`  | Description ou résumé du texte.                  |
| `is_in_force`      | `boolean` | Indique si le texte est en vigueur.              |
| `source`           | `string`  | Source de publication (ex: Journal Officiel). (max: 255) |
| `version`          | `string`  | Version du texte. (max: 255)                     |

- **Réponse de Succès (200)** : Retourne l'objet `LegalText` mis à jour.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 5. Supprimer un Texte Légal

- **Endpoint** : `DELETE /texts/delete/{id}`
- **Description** : Supprime un texte légal.
- **Réponse de Succès (200)** : Retourne un message de succès.

---

### 6. Abroger un Texte Légal

- **Endpoint** : `POST /texts/abrogate/{id}`
- **Description** : Marque un texte légal comme abrogé.
- **Réponse de Succès (200)** : Retourne l'objet `LegalText` mis à jour avec la date d'abrogation.
