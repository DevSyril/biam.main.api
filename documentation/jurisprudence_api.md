# API de Gestion de la Jurisprudence

Ce document fournit une documentation détaillée pour l'API de gestion de la jurisprudence.

## Composants Associés

- **Modèle** : `app/Models/Jurisprudence.php`
- **Contrôleur** : `app/Http/Controllers/LegalContext/JurisprudenceController.php`
- **Interface du Repository** : `app/Interfaces/JurisprudenceInterface.php`
- **Repository** : `app/Repositories/JurisprudenceRepository.php`
- **Fichier de Routes** : `routes/api.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/Jurisprudence/JurisprudenceCreateRequest.php`
    - `app/Http/Requests/Jurisprudence/JurisprudenceUpdateRequest.php`
- **Ressource API** : `app/Http/Resources/Jurisprudence/JurisprudenceResource.php`

## Structure de l'Objet `Jurisprudence` (Réponse API)

L'objet `Jurisprudence` retourné par l'API a la structure suivante.

| Attribut            | Type      | Description                                          |
| ------------------- | --------- | ---------------------------------------------------- |
| `id`                | `string`  | Identifiant unique de la jurisprudence (UUID).       |
| `reference`         | `string`  | Référence unique de la décision.                     |
| `summary`           | `string`  | Résumé de la décision.                               |
| `official_link`     | `string`  | Lien officiel vers la décision.                      |
| `linked_article_id` | `string`  | UUID de l'article de loi lié (si applicable).        |
| `linked_subject_id` | `string`  | UUID du sujet de droit lié (si applicable).          |
| `created_at`        | `string`  | Date de création (Format ISO-8601).                  |
| `updated_at`        | `string`  | Date de dernière modification (Format ISO-8601).     |
| `article`           | `object`  | Objet `Article` lié (si chargé).                     |
| `legal_subject`     | `object`  | Objet `LegalSubject` lié (si chargé).                |

## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "errors": {
    "reference": [ "The reference field is required." ],
    "official_link": [ "The official link must be a valid URL." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/legal`.

---

### 1. Lister les Jurisprudences

- **Endpoint** : `GET /jurisprudences`
- **Description** : Récupère une liste paginée de jurisprudences.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `Jurisprudence` (voir [Structure de l'Objet `Jurisprudence`](#structure-de-lobjet-jurisprudence-réponse-api)).

---

### 2. Créer une Jurisprudence

- **Endpoint** : `POST /jurisprudences/create`
- **Description** : Crée une nouvelle jurisprudence.

- **Corps de la Requête** (`application/json`):

| Champ               | Type      | Description                                          | Requis |
| ------------------- | --------- | ---------------------------------------------------- | ------ |
| `reference`         | `string`  | Référence unique de la décision. (max: 255)          | Oui    |
| `summary`           | `string`  | Résumé de la décision.                               | Oui    |
| `official_link`     | `string`  | Lien officiel vers la décision. (URL valide)         | Non    |
| `linked_article_id` | `string`  | UUID de l'article de loi lié. (UUID valide, doit exister) | Non    |
| `linked_subject_id` | `string`  | UUID du sujet de droit lié. (UUID valide, doit exister) | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `Jurisprudence` (voir [Structure de l'Objet `Jurisprudence`](#structure-de-lobjet-jurisprudence-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 3. Afficher une Jurisprudence Spécifique

- **Endpoint** : `GET /jurisprudences/show/{id}`
- **Description** : Récupère les détails d'une jurisprudence, incluant ses relations (`article`, `legal_subject`).
- **Réponse de Succès (200)** : Retourne un objet `Jurisprudence` complet (voir [Structure de l'Objet `Jurisprudence`](#structure-de-lobjet-jurisprudence-réponse-api)).

---

### 4. Mettre à Jour une Jurisprudence

- **Endpoint** : `POST /jurisprudences/update/{id}`
- **Description** : Met à jour une jurisprudence existante. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ               | Type      | Description                                          |
| ------------------- | --------- | ---------------------------------------------------- |
| `reference`         | `string`  | Référence unique de la décision. (max: 255)          |
| `summary`           | `string`  | Résumé de la décision.                               |
| `official_link`     | `string`  | Lien officiel vers la décision. (URL valide)         |
| `linked_article_id` | `string`  | UUID de l'article de loi lié. (UUID valide, doit exister) |
| `linked_subject_id` | `string`  | UUID du sujet de droit lié. (UUID valide, doit exister) |

- **Réponse de Succès (200)** : Retourne l'objet `Jurisprudence` mis à jour (voir [Structure de l'Objet `Jurisprudence`](#structure-de-lobjet-jurisprudence-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 5. Supprimer une Jurisprudence

- **Endpoint** : `DELETE /jurisprudences/delete/{id}`
- **Description** : Supprime une jurisprudence.
- **Réponse de Succès (200)** : Retourne un message de succès.
