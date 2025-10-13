# API de Gestion des Articles de Loi

Ce document fournit une documentation détaillée pour l'API de gestion des articles de loi.

## Composants Associés

- **Modèle** : `app/Models/Article.php`
- **Contrôleur** : `app/Http/Controllers/LegalContext/ArticleController.php`
- **Interface du Repository** : `app/Interfaces/ArticleInterface.php`
- **Repository** : `app/Repositories/ArticleRepository.php`
- **Fichier de Routes** : `routes/api.php`
- **Requêtes de Validation** :
    - `app/Http/Requests/LegalArticleCreateRequest.php`
    - `app/Http/Requests/LegalArticleUpdateRequest.php`

## Structure de l'Objet Article (Réponse API)

L'objet `Article` retourné par l'API a la structure suivante.

| Attribut           | Type      | Description                                          |
| ------------------ | --------- | ---------------------------------------------------- |
| `id`               | `string`  | Identifiant unique de l'article (UUID).             |
| `legal_text_id`    | `string`  | UUID du `LegalText` parent.                          |
| `article_number`   | `string`  | Numéro de l'article (ex: "Article 1").              |
| `article_title`    | `string`  | Titre de l'article.                                  |
| `content`          | `string`  | Contenu complet de l'article.                        |
| `is_modified`      | `boolean` | Indique si l'article a été modifié.                  |
| `is_abrogated`     | `boolean` | Indique si l'article a été abrogé.                   |
| `commentary`       | `string`  | Commentaire ou note sur l'article.                   |
| `display_order`    | `integer` | Ordre d'affichage de l'article dans son texte.       |
| `created_at`       | `string`  | Date de création (Format ISO-8601).                  |
| `updated_at`       | `string`  | Date de dernière modification (Format ISO-8601).     |
| `legal_text`       | `object`  | Objet `LegalText` associé (si chargé).               |
| `jurisprudences`   | `array`   | Tableau d'objets `Jurisprudence` (si chargé).        |


## Gestion des Erreurs

### Erreurs de Validation (Code 422)

Si les données fournies ne respectent pas les règles de validation, l'API retournera une erreur `422`.

**Exemple de Réponse :**
```json
{
  "success": false,
  "message": "Validation errors",
  "errors": {
    "legal_text_id": [ "Le legal_text_id spécifié n'existe pas." ],
    "content": [ "Le champ content est obligatoire." ]
  }
}
```

## Points d'Accès de l'API (Endpoints)

Toutes les routes sont préfixées par `/api/legal`.

---

### 1. Lister les Articles

- **Endpoint** : `GET /articles`
- **Description** : Récupère une liste paginée d'articles.
- **Paramètres de Requête** :
  - `items` (optionnel, `integer`, défaut: 10) : Nombre d'articles par page.
- **Réponse de Succès (200)** : Retourne un objet de pagination avec une liste d'objets `Article` (voir [Structure de l'Objet Article](#structure-de-lobjet-article-réponse-api)).

---

### 2. Créer un Article

- **Endpoint** : `POST /articles/create`
- **Description** : Crée un nouvel article de loi.

- **Corps de la Requête** (`application/json`):

| Champ              | Type      | Description                                      | Requis |
| ------------------ | --------- | ------------------------------------------------ | ------ |
| `legal_text_id`    | `string`  | UUID du `LegalText` parent.                      | Oui    |
| `article_number`   | `string`  | Numéro de l'article. (max: 255)                  | Oui    |
| `article_title`    | `string`  | Titre de l'article. (max: 255)                   | Oui    |
| `content`          | `string`  | Contenu de l'article.                            | Oui    |
| `display_order`    | `integer` | Ordre d'affichage.                               | Oui    |
| `is_modified`      | `boolean` | L'article a-t-il été modifié ?                   | Non    |
| `is_abrogated`     | `boolean` | L'article est-il abrogé ?                        | Non    |
| `commentary`       | `string`  | Commentaire additionnel.                         | Non    |

- **Réponse de Succès (201)** : Retourne le nouvel objet `Article` (voir [Structure de l'Objet Article](#structure-de-lobjet-article-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 3. Afficher un Article Spécifique

- **Endpoint** : `GET /articles/show/{id}`
- **Description** : Récupère les détails d'un article, incluant ses relations (`legal_text`, `jurisprudences`, etc.).
- **Réponse de Succès (200)** : Retourne un objet `Article` complet (voir [Structure de l'Objet Article](#structure-de-lobjet-article-réponse-api)).

---

### 4. Mettre à Jour un Article

- **Endpoint** : `POST /articles/update/{id}`
- **Description** : Met à jour un article existant. Tous les champs sont optionnels.

- **Corps de la Requête** (`application/json`):

| Champ              | Type      | Description                                      |
| ------------------ | --------- | ------------------------------------------------ |
| `legal_text_id`    | `string`  | UUID du `LegalText` parent.                      |
| `article_number`   | `string`  | Numéro de l'article. (max: 255)                  |
| `article_title`    | `string`  | Titre de l'article. (max: 255)                   |
| `content`          | `string`  | Contenu de l'article.                            |
| `display_order`    | `integer` | Ordre d'affichage.                               |
| `is_modified`      | `boolean` | L'article a-t-il été modifié ?                   |
| `is_abrogated`     | `boolean` | L'article est-il abrogé ?                        |
| `commentary`       | `string`  | Commentaire additionnel.                         |

- **Réponse de Succès (200)** : Retourne l'objet `Article` mis à jour (voir [Structure de l'Objet Article](#structure-de-lobjet-article-réponse-api)).
- **Réponse d'Erreur** : Voir la section [Gestion des Erreurs](#gestion-des-erreurs).

---

### 5. Supprimer un Article

- **Endpoint** : `DELETE /articles/delete/{id}`
- **Description** : Supprime un article.
- **Réponse de Succès (200)** : Retourne un message de succès.