# API de Gestion des Modèles, Sections et Champs de Modèles

Ce document fournit une documentation détaillée pour les APIs de gestion des modèles, de leurs sections et des champs associés. L'objectif est de permettre la création complète d'un modèle structuré depuis le frontend.

## Architecture Générale

L'architecture repose sur trois entités principales :
1.  **`Template`** : Le modèle principal, représentant un document ou un formulaire réutilisable.
2.  **`TemplateSection`** : Des sous-parties d'un `Template`, permettant d'organiser le contenu.
3.  **`TemplateField`** : Des champs spécifiques contenus dans les `TemplateSection`s, qui collectent des données.

Ces entités sont liées hiérarchiquement : un `Template` contient plusieurs `TemplateSection`s, et chaque `TemplateSection` contient plusieurs `TemplateField`s.

## Composants Associés

### Pour les Modèles (`Template`)
- **Modèle** : `app/Models/Template.php`
- **Contrôleur** : `app/Http/Controllers/Documents/TemplateController.php`
- **Interface du Repository** : `app/Interfaces/TemplateInterface.php`
- **Repository** : `app/Repositories/TemplateRepository.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/Documents/TemplateCreateRequest.php`
    - `app/Http/Requests/Documents/TemplateUpdateRequest.php`
- **Ressource API** : `app/Http/Resources/Documents/TemplateResources.php`

### Pour les Sections de Modèles (`TemplateSection`)
- **Modèle** : `app/Models/TemplateSection.php`
- **Contrôleur** : `app/Http/Controllers/Documents/TemplateSectionController.php`
- **Interface du Repository** : `app/Interfaces/TemplateSectionInterface.php`
- **Repository** : `app/Repositories/TemplateSectionRepository.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/Documents/TemplateSectionCreateRequest.php`
    - `app/Http/Requests/Documents/TemplateSectionUpdateRequest.php`
- **Ressource API** : `app/Http/Resources/Documents/TemplateSectionResources.php`

### Pour les Champs de Modèles (`TemplateField`)
- **Modèle** : `app/Models/TemplateField.php`
- **Contrôleur** : `app/Http/Controllers/Fields/TemplateFieldController.php`
- **Interface du Repository** : `app/Interfaces/TemplateFieldInterface.php`
- **Repository** : `app/Repositories/TemplateFieldRepository.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/Fields/TemplateFieldCreateRequest.php`
    - `app/Http/Requests/Fields/TemplateFieldUpdateRequest.php`
- **Ressource API** : `app/Http/Resources/Fields/TemplateFieldResources.php`

## Fichier de Routes
- `routes/api.php`

## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "data": {
    "title": [ "Le titre est requis." ],
    "template_id": [ "L'ID du modèle est requis." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/app`.

---

## API de Gestion des Modèles (`Template`)

### Structure de l'Objet `Template` (Réponse API)

| Attribut                 | Type      | Description                                          |
| ------------------------ | --------- | ---------------------------------------------------- |
| `id`                     | `string`  | Identifiant unique du modèle (UUID).                 |
| `title`                  | `string`  | Titre du modèle.                                     |
| `description`            | `string`  | Description du modèle.                               |
| `category`               | `string`  | Catégorie du modèle.                                 |
| `type`                   | `string`  | Type de modèle.                                      |
| `content`                | `object`  | Contenu JSON du modèle.                              |
| `version`                | `integer` | Version du modèle.                                   |
| `is_premium`             | `boolean` | Indique si le modèle est premium.                    |
| `is_active`              | `boolean` | Indique si le modèle est actif.                      |
| `is_public`              | `boolean` | Indique si le modèle est public.                     |
| `author_id`              | `string`  | UUID de l'auteur.                                    |
| `language`               | `string`  | Langue du modèle.                                    |
| `preview_url`            | `string`  | URL de prévisualisation.                             |
| `estimated_time_minutes` | `integer` | Temps estimé en minutes.                             |
| `usage_count`            | `integer` | Nombre d'utilisations.                               |
| `created_at`             | `string`  | Date de création (Format ISO-8601).                  |
| `updated_at`             | `string`  | Date de dernière modification (Format ISO-8601).     |
| `document_id`            | `string`  | UUID du document associé.                            |
| `template_sections`      | `array`   | Tableau d'objets `TemplateSection` liés (si chargé). |

### 1. Lister les Modèles

- **Endpoint** : `GET /templates`
- **Description** : Récupère une liste paginée de tous les modèles.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `Template`.

### 2. Créer un Modèle

- **Endpoint** : `POST /templates/create`
- **Description** : Crée un nouveau modèle.

- **Corps de la Requête** (`application/json`):

| Champ                    | Type      | Description                                          | Requis |
| ------------------------ | --------- | ---------------------------------------------------- | ------ |
| `title`                  | `string`  | Titre du modèle. (max: 255)                          | Oui    |
| `category`               | `string`  | Catégorie du modèle. (max: 100)                      | Oui    |
| `type`                   | `string`  | Type de modèle. (max: 100)                           | Oui    |
| `document_id`            | `string`  | UUID du document associé.                            | Oui    |
| `description`            | `string`  | Description du modèle. (max: 1000)                   | Non    |
| `content`                | `object`  | Contenu JSON du modèle.                              | Non    |
| `version`                | `integer` | Version du modèle.                                   | Non    |
| `is_premium`             | `boolean` | Indique si le modèle est premium.                    | Non    |
| `is_active`              | `boolean` | Indique si le modèle est actif.                      | Non    |
| `is_public`              | `boolean` | Indique si le modèle est public.                     | Non    |
| `author_id`              | `string`  | UUID de l'auteur.                                    | Non    |
| `language`               | `string`  | Langue du modèle.                                    | Non    |
| `estimated_time_minutes` | `integer` | Temps estimé en minutes.                             | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `Template`.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

### 3. Afficher un Modèle Spécifique

- **Endpoint** : `GET /templates/show/{id}`
- **Description** : Récupère les détails d'un modèle, incluant ses sections.
- **Réponse de Succès (200)** : Retourne un objet `Template` complet.

### 4. Mettre à Jour un Modèle

- **Endpoint** : `POST /templates/update/{id}`
- **Description** : Met à jour un modèle existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ                    | Type      | Description                                          |
| ------------------------ | --------- | ---------------------------------------------------- |
| `title`                  | `string`  | Titre du modèle. (max: 255)                          |
| `category`               | `string`  | Catégorie du modèle. (max: 100)                      |
| `type`                   | `string`  | Type de modèle. (max: 100)                           |
| `document_id`            | `string`  | UUID du document associé.                            |
| `description`            | `string`  | Description du modèle. (max: 1000)                   |
| `content`                | `object`  | Contenu JSON du modèle.                              |
| `version`                | `float`   | Version du modèle.                                   |
| `is_premium`             | `boolean` | Indique si le modèle est premium.                    |
| `is_active`              | `boolean` | Indique si le modèle est actif.                      |
| `is_public`              | `boolean` | Indique si le modèle est public.                     |
| `author_id`              | `string`  | UUID de l'auteur.                                    |
| `language`               | `string`  | Langue du modèle.                                    |
| `estimated_time_minutes` | `integer` | Temps estimé en minutes.                             |

- **Réponse de Succès (200)** : Retourne l'objet `Template` mis à jour.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

### 5. Supprimer un Modèle

- **Endpoint** : `DELETE /templates/delete/{id}`
- **Description** : Supprime un modèle.
- **Réponse de Succès (200)** : Retourne un message de succès.

### 6. Récupérer les Modèles d'un Document

- **Endpoint** : `GET /templates/perdocuments/{documentId}`
- **Description** : Récupère tous les modèles associés à un document spécifique.
- **Paramètres d'URL** :
  - `documentId` (requis, `string`) : L'UUID du document.
- **Réponse de Succès (200)** : Retourne une collection de modèles.

---

## API de Gestion des Sections de Modèles (`TemplateSection`)

### Structure de l'Objet `TemplateSection` (Réponse API)

| Attribut        | Type      | Description                                          |
| --------------- | --------- | ---------------------------------------------------- |
| `id`            | `string`  | Identifiant unique de la section (UUID).             |
| `template_id`   | `string`  | UUID du modèle parent.                               |
| `title`         | `string`  | Titre de la section.                                 |
| `description`   | `string`  | Description de la section.                           |
| `section_order` | `integer` | Ordre d'affichage de la section.                     |
| `legal_slug`    | `string`  | Slug légal associé à la section.                     |
| `is_required`   | `boolean` | Indique si la section est requise.                   |
| `is_repeatable` | `boolean` | Indique si la section est répétable.                 |
| `created_at`    | `string`  | Date de création (Format ISO-8601).                  |
| `updated_at`    | `string`  | Date de dernière modification (Format ISO-8601).     |
| `template_fields`| `array`  | Tableau d'objets `TemplateField` liés (si chargé).   |

### 1. Lister les Sections de Modèles

- **Endpoint** : `GET /templates/sections`
- **Description** : Récupère toutes les sections de modèles.
- **Réponse de Succès (200)** : Retourne une collection d'objets `TemplateSection`.

### 2. Créer une Section de Modèle

- **Endpoint** : `POST /templates/sections/create`
- **Description** : Crée une nouvelle section pour un modèle.

- **Corps de la Requête** (`application/json`):

| Champ           | Type      | Description                                          | Requis |
| --------------- | --------- | ---------------------------------------------------- | ------ |
| `template_id`   | `string`  | UUID du modèle parent.                               | Oui    |
| `title`         | `string`  | Titre de la section. (max: 255, unique)              | Oui    |
| `section_order` | `integer` | Ordre d'affichage de la section.                     | Oui    |
| `content`       | `object`  | Contenu JSON de la section.                          | Oui    |
| `description`   | `string`  | Description de la section.                           | Non    |
| `is_required`   | `boolean` | Indique si la section est requise.                   | Non    |
| `is_repeatable` | `boolean` | Indique si la section est répétable.                 | Non    |
| `legal_slug`    | `string`  | Slug légal associé à la section. (max: 100)          | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `TemplateSection`.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

### 3. Afficher une Section de Modèle Spécifique

- **Endpoint** : `GET /templates/sections/show/{id}`
- **Description** : Récupère les détails d'une section de modèle, incluant ses champs.
- **Réponse de Succès (200)** : Retourne un objet `TemplateSection` complet.

### 4. Mettre à Jour une Section de Modèle

- **Endpoint** : `POST /templates/sections/update/{id}`
- **Description** : Met à jour une section de modèle existante. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ           | Type      | Description                                          |
| --------------- | --------- | ---------------------------------------------------- |
| `template_id`   | `string`  | UUID du modèle parent.                               |
| `title`         | `string`  | Titre de la section. (max: 255)                      |
| `section_order` | `integer` | Ordre d'affichage de la section.                     |
| `content`       | `object`  | Contenu JSON de la section.                          |
| `description`   | `string`  | Description de la section.                           |
| `is_required`   | `boolean` | Indique si la section est requise.                   |
| `is_repeatable` | `boolean` | Indique si la section est répétable.                 |
| `legal_slug`    | `string`  | Slug légal associé à la section. (max: 100)          |

- **Réponse de Succès (200)** : Retourne l'objet `TemplateSection` mis à jour.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

### 5. Supprimer une Section de Modèle

- **Endpoint** : `DELETE /templates/sections/delete/{id}`
- **Description** : Supprime une section de modèle.
- **Réponse de Succès (200)** : Retourne un message de succès.

### 6. Récupérer les Sections d'un Modèle

- **Endpoint** : `GET /templates/sections/template/{templateId}`
- **Description** : Récupère toutes les sections associées à un modèle spécifique.
- **Paramètres d'URL** :
  - `templateId` (requis, `string`) : L'UUID du modèle.
- **Réponse de Succès (200)** : Retourne une collection de sections de modèles.

---

## API de Gestion des Champs de Modèles (`TemplateField`)

### Structure de l'Objet `TemplateField` (Réponse API)

| Attribut            | Type      | Description                                          |
| ------------------- | --------- | ---------------------------------------------------- |
| `id`                | `string`  | Identifiant unique du champ (UUID).                  |
| `template_id`       | `string`  | UUID du modèle parent.                               |
| `section_id`        | `string`  | UUID de la section parente.                          |
| `field_id`          | `string`  | UUID du champ de formulaire (`FormField`) associé.   |
| `field_order`       | `integer` | Ordre d'affichage du champ.                          |
| `is_required`       | `boolean` | Indique si le champ est requis.                      |
| `is_editable`       | `boolean` | Indique si le champ est éditable.                    |
| `legal_slug`        | `string`  | Slug légal associé au champ.                         |
| `visibility_rules`  | `object`  | Règles de visibilité (JSON).                         |
| `validation_schema` | `object`  | Schéma de validation (JSON).                         |
| `conditional_logic` | `object`  | Logique conditionnelle (JSON).                       |
| `created_at`        | `string`  | Date de création (Format ISO-8601).                  |
| `template`          | `object`  | Objet `Template` lié (si chargé).                    |
| `template_section`  | `object`  | Objet `TemplateSection` lié (si chargé).             |
| `form_field`        | `object`  | Objet `FormField` lié (si chargé).                   |

### 1. Lister les Champs de Modèles

- **Endpoint** : `GET /fields/template-fields`
- **Description** : Récupère une liste paginée de tous les champs de modèles.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `TemplateField`.

### 2. Créer un Champ de Modèle

- **Endpoint** : `POST /fields/template-fields/create`
- **Description** : Crée un nouveau champ pour un modèle ou une section de modèle.

- **Corps de la Requête** (`application/json`):

| Champ               | Type      | Description                                          | Requis |
| ------------------- | --------- | ---------------------------------------------------- | ------ |
| `template_id`       | `string`  | UUID du modèle parent.                               | Oui    |
| `field_id`          | `string`  | UUID du champ de formulaire (`FormField`) associé.   | Oui    |
| `field_order`       | `integer` | Ordre d'affichage du champ. (min: 1)                 | Oui    |
| `section_id`        | `string`  | UUID de la section parente.                          | Non    |
| `is_required`       | `boolean` | Indique si le champ est requis.                      | Non    |
| `is_editable`       | `boolean` | Indique si le champ est éditable.                    | Non    |
| `legal_slug`        | `string`  | Slug légal associé au champ. (max: 255)              | Non    |
| `visibility_rules`  | `array`   | Règles de visibilité (JSON).                         | Non    |
| `validation_schema` | `array`   | Schéma de validation (JSON).                         | Non    |
| `conditional_logic` | `array`   | Logique conditionnelle (JSON).                       | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `TemplateField`.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

### 3. Afficher un Champ de Modèle Spécifique

- **Endpoint** : `GET /fields/template-fields/show/{id}`
- **Description** : Récupère les détails d'un champ de modèle.
- **Réponse de Succès (200)** : Retourne un objet `TemplateField` complet.

### 4. Mettre à Jour un Champ de Modèle

- **Endpoint** : `POST /fields/template-fields/update/{id}`
- **Description** : Met à jour un champ de modèle existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ               | Type      | Description                                          |
| ------------------- | --------- | ---------------------------------------------------- |
| `template_id`       | `string`  | UUID du modèle parent.                               |
| `field_id`          | `string`  | UUID du champ de formulaire (`FormField`) associé.   |
| `field_order`       | `integer` | Ordre d'affichage du champ. (min: 1)                 |
| `section_id`        | `string`  | UUID de la section parente.                          |
| `is_required`       | `boolean` | Indique si le champ est requis.                      |
| `is_editable`       | `boolean` | Indique si le champ est éditable.                    |
| `legal_slug`        | `string`  | Slug légal associé au champ. (max: 255)              |
| `visibility_rules`  | `array`   | Règles de visibilité (JSON).                         |
| `validation_schema` | `array`   | Schéma de validation (JSON).                         |
| `conditional_logic` | `array`   | Logique conditionnelle (JSON).                       |

- **Réponse de Succès (200)** : Retourne l'objet `TemplateField` mis à jour.
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

### 5. Supprimer un Champ de Modèle

- **Endpoint** : `DELETE /fields/template-fields/delete/{id}`
- **Description** : Supprime un champ de modèle.
- **Réponse de Succès (200)** : Retourne un message de succès.
