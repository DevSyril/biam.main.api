# API de Gestion des Sujets de Droit (Legal Subjects)

Ce document fournit une documentation détaillée pour l'API de gestion des sujets de droit.

## Composants Associés

- **Modèles** : `app/Models/LegalSubject.php`, `app/Models/SubjectArticleLink.php`
- **Contrôleur** : `app/Http/Controllers/LegalContext/LEgalSubjectsController.php`
- **Interface du Repository** : `app/Interfaces/LegalSubjectInterface.php`
- **Repository** : `app/Repositories/LegalSubjectRepository.php`
- **Fichier de Routes** : `routes/api.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/LegalSubjects/LegalSubjectCreateRequest.php`
    - `app/Http/Requests/LegalSubjects/LegalSubjectUpdateRequest.php`

## Structure de l'Objet `LegalSubject` (Réponse API)

L'objet `LegalSubject` retourné par l'API a la structure suivante.

| Attribut      | Type      | Description                                            |
| ------------- | --------- | ------------------------------------------------------ |
| `id`          | `string`  | Identifiant unique du sujet (UUID).                    |
| `label`       | `string`  | Nom ou libellé du sujet.                               |
| `description` | `string`  | Description détaillée du sujet.                        |
| `slug`        | `string`  | Version "slugifiée" du libellé pour les URLs.          |
| `parent_id`   | `string`  | UUID du sujet parent (pour la hiérarchie).             |
| `level`       | `integer` | Niveau du sujet dans la hiérarchie.                    |
| `created_at`  | `string`  | Date de création (Format ISO-8601).                    |
| `updated_at`  | `string`  | Date de dernière modification (Format ISO-8601).       |
| `legal_subject` | `object`| Objet `LegalSubject` parent (si chargé).               |
| `legal_subjects`| `array` | Tableau d'objets `LegalSubject` enfants (si chargé).   |
| `subject_article_links`| `array`| Tableau de liens vers des articles (si chargé).  |

## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "errors": {
    "label": [ "Le champ label est obligatoire." ],
    "slug": [ "Le champ slug doit être unique." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/legal`.

---

### 1. Lister les Sujets de Droit

- **Endpoint** : `GET /subjects`
- **Description** : Récupère une liste paginée de sujets de droit.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `LegalSubject`.

---

### 2. Créer un Sujet de Droit

- **Endpoint** : `POST /subjects/create`
- **Description** : Crée un nouveau sujet de droit.

- **Corps de la Requête** (`application/json`):

| Champ         | Type      | Description                               | Requis |
| ------------- | --------- | ----------------------------------------- | ------ |
| `label`       | `string`  | Libellé du sujet. (max: 255)              | Oui    |
| `slug`        | `string`  | Slug unique pour l'URL. (max: 255)         | Oui    |
| `description` | `string`  | Description du sujet.                     | Non    |
| `parent_id`   | `string`  | UUID du sujet parent (s'il existe).       | Non    |
| `level`       | `integer` | Niveau hiérarchique (min: 0).             | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `LegalSubject`.

---

### 3. Afficher un Sujet de Droit Spécifique

- **Endpoint** : `GET /subjects/show/{id}`
- **Description** : Récupère les détails d'un sujet, incluant ses relations (parent, enfants, articles liés).
- **Réponse de Succès (200)** : Retourne un objet `LegalSubject` complet.

---

### 4. Mettre à Jour un Sujet de Droit

- **Endpoint** : `POST /subjects/update/{id}`
- **Description** : Met à jour un sujet existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ         | Type      | Description                               |
| ------------- | --------- | ----------------------------------------- |
| `label`       | `string`  | Libellé du sujet. (max: 255)              |
| `slug`        | `string`  | Slug unique pour l'URL. (max: 255)         |
| `description` | `string`  | Description du sujet.                     |
| `parent_id`   | `string`  | UUID du sujet parent (s'il existe).       |
| `level`       | `integer` | Niveau hiérarchique (min: 0).             |

- **Réponse de Succès (200)** : Retourne l'objet `LegalSubject` mis à jour.

---

### 5. Lier un Article à un Sujet

- **Endpoint** : `POST /subjects/link-article-to-subject`
- **Description** : Crée une nouvelle liaison entre un `LegalSubject` et un `Article`.

- **Corps de la Requête** (`application/json`):

| Champ                | Type      | Description                                  | Requis |
| -------------------- | --------- | -------------------------------------------- | ------ |
| `subject_id`         | `string`  | UUID du `LegalSubject`.                      | Oui    |
| `article_id`         | `string`  | UUID de l' `Article`.                        | Oui    |
| `relevance`          | `integer` | Score de pertinence du lien.                 | Non    |
| `context_commentary` | `string`  | Commentaire sur le contexte du lien.         | Non    |
| `usage_example`      | `string`  | Exemple d'utilisation.                      | Non    |

- **Réponse de Succès (200)** : Retourne le nouvel objet `SubjectArticleLink` créé.

---

### 6. Supprimer un Sujet de Droit

- **Endpoint** : `DELETE /subjects/delete/{id}`
- **Description** : Supprime un sujet de droit.
- **Réponse de Succès (200)** : Retourne un message de succès.
