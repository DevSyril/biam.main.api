# API de Gestion des Champs Simples (Form Fields)

Ce document fournit une documentation détaillée pour l'API de gestion des champs de formulaire simples (`FormField`). Ces champs sont des définitions réutilisables qui peuvent être associées à des `TemplateField`s.

## Composants Associés

- **Modèle** : `app/Models/FormField.php`
- **Contrôleur** : `app/Http/Controllers/Fields/FieldController.php`
- **Interface du Repository** : `app/Interfaces/FieldInterface.php`
- **Repository** : `app/Repositories/FieldRepository.php`
- **Fichier de Routes** : `routes/api.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/Fields/FieldCreateRequest.php`
    - `app/Http/Requests/Fields/FieldUpdateteRequest.php`
- **Ressource API** : `app/Http/Resources/Fields/FieldResource.php`

## Structure de l'Objet `FormField` (Réponse API)

L'objet `FormField` retourné par l'API a la structure suivante.

| Attribut           | Type      | Description                                          |
| ------------------ | --------- | ---------------------------------------------------- |
| `id`               | `string`  | Identifiant unique du champ (UUID).                  |
| `label`            | `string`  | Libellé affiché du champ.                            |
| `type`             | `string`  | Type de champ (ex: `text`, `number`, `select`, `textarea`). |
| `default_value`    | `string`  | Valeur par défaut du champ.                          |
| `options`          | `object`  | Options pour les champs de type `select` ou `radio` (JSON). |
| `description`      | `string`  | Description ou aide pour le champ.                   |
| `validation_rules` | `object`  | Règles de validation spécifiques au champ (JSON).    |
| `placeholder`      | `string`  | Texte d'exemple affiché dans le champ.              |
| `help_text`        | `string`  | Texte d'aide supplémentaire.                        |
| `is_active`        | `boolean` | Indique si le champ est actif.                       |
| `created_at`       | `string`  | Date de création (Format ISO-8601).                  |
| `updated_at`       | `string`  | Date de dernière modification (Format ISO-8601).     |

## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "errors": {
    "label": [ "The field label is required." ],
    "type": [ "The field type is required." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/app`.

---

### 1. Lister les Champs Simples

- **Endpoint** : `GET /fields`
- **Description** : Récupère une liste paginée de tous les champs de formulaire simples.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'éléments par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `FormField` (voir [Structure de l'Objet `FormField`](#structure-de-lobjet-formfield-réponse-api)).

---

### 2. Créer un Champ Simple

- **Endpoint** : `POST /fields/create`
- **Description** : Crée un nouveau champ de formulaire simple.

- **Corps de la Requête** (`application/json`):

| Champ              | Type      | Description                                          | Requis |
| ------------------ | --------- | ---------------------------------------------------- | ------ |
| `label`            | `string`  | Libellé affiché du champ. (max: 255)                 | Oui    |
| `type`             | `string`  | Type de champ (ex: `text`, `number`). (max: 100)     | Oui    |
| `default_value`    | `string`  | Valeur par défaut du champ.                          | Non    |
| `description`      | `string`  | Description ou aide pour le champ.                   | Non    |
| `validation_rules` | `object`  | Règles de validation spécifiques au champ (JSON).    | Non    |
| `options`          | `array`   | Options pour les champs `select` ou `radio` (JSON array de strings). | Non    |
| `placeholder`      | `string`  | Texte d'exemple affiché.                            | Non    |
| `help_text`        | `string`  | Texte d'aide supplémentaire.                        | Non    |
| `is_active`        | `boolean` | Indique si le champ est actif.                       | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `FormField` (voir [Structure de l'Objet `FormField`](#structure-de-lobjet-formfield-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 3. Afficher un Champ Simple Spécifique

- **Endpoint** : `GET /fields/show/{id}`
- **Description** : Récupère les détails d'un champ de formulaire simple.
- **Réponse de Succès (200)** : Retourne un objet `FormField` complet (voir [Structure de l'Objet `FormField`](#structure-de-lobjet-formfield-réponse-api)).

---

### 4. Mettre à Jour un Champ Simple

- **Endpoint** : `POST /fields/update/{id}`
- **Description** : Met à jour un champ de formulaire simple existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ              | Type      | Description                                          |
| ------------------ | --------- | ---------------------------------------------------- |
| `label`            | `string`  | Libellé affiché du champ. (max: 255)                 |
| `type`             | `string`  | Type de champ (ex: `text`, `number`). (max: 100)     |
| `default_value`    | `string`  | Valeur par défaut du champ.                          |
| `description`      | `string`  | Description ou aide pour le champ.                   |
| `validation_rules` | `object`  | Règles de validation spécifiques au champ (JSON).    |
| `options`          | `array`   | Options pour les champs `select` ou `radio` (JSON array de strings). |
| `placeholder`      | `string`  | Texte d'exemple affiché.                            |
| `help_text`        | `string`  | Texte d'aide supplémentaire.                        |
| `is_active`        | `boolean` | Indique si le champ est actif.                       |

- **Réponse de Succès (200)** : Retourne l'objet `FormField` mis à jour (voir [Structure de l'Objet `FormField`](#structure-de-lobjet-formfield-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 5. Supprimer un Champ Simple

- **Endpoint** : `DELETE /fields/delete/{id}`
- **Description** : Supprime un champ de formulaire simple.
- **Réponse de Succès (200)** : Retourne un message de succès.
