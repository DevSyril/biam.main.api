# API de Gestion des Templates, Sections et Champs

Cette documentation décrit l'API pour la gestion des templates, des sections de template, des champs de formulaire et de leurs associations.

---

## Templates

### Lister les templates

-   **Endpoint** : `/api/app/templates`
-   **Méthode** : `GET`
-   **Description** : Récupère une liste paginée de tous les templates.
-   **Réponse** : `200 OK` avec une liste paginée de templates.

### Créer un template

-   **Endpoint** : `/api/app/templates/create`
-   **Méthode** : `POST`
-   **Description** : Crée un nouveau template.
-   **Corps de la requête** (Exemple) :
    ```json
    {
        "title": "Mon nouveau template",
        "description": "Description du template",
        "category": "Catégorie",
        "type": "Type",
        "content": {},
        "document_id": "uuid-du-document-associe"
    }
    ```
-   **Réponse** : `201 Created` avec le template créé.

### Afficher un template

-   **Endpoint** : `/api/app/templates/show/{id}`
-   **Méthode** : `GET`
-   **Description** : Récupère les détails d'un template spécifique, y compris ses sections et champs.
-   **Réponse** : `200 OK` avec l'objet template détaillé.

### Mettre à jour un template

-   **Endpoint** : `/api/app/templates/update/{id}`
-   **Méthode** : `POST`
-   **Description** : Met à jour un template existant.
-   **Réponse** : `200 OK` avec le template mis à jour.

### Supprimer un template

-   **Endpoint** : `/api/app/templates/delete/{id}`
-   **Méthode** : `DELETE`
-   **Description** : Supprime un template.
-   **Réponse** : `200 OK` avec un message de succès.

### Lister les templates d'un document

-   **Endpoint** : `/api/app/templates/perdocuments/{documentId}`
-   **Méthode** : `GET`
-   **Description** : Récupère tous les templates associés à un document spécifique.
-   **Réponse** : `200 OK` avec une liste de templates.

---

## Sections de Template

### Lister les sections

-   **Endpoint** : `/api/app/templates/sections`
-   **Méthode** : `GET`
-   **Description** : Récupère toutes les sections de template.
-   **Réponse** : `200 OK` avec une liste de sections.

### Créer une section

-   **Endpoint** : `/api/app/templates/sections/create`
-   **Méthode** : `POST`
-   **Description** : Crée une nouvelle section pour un template.
-   **Corps de la requête** (Exemple) :
    ```json
    {
        "template_id": "uuid-du-template",
        "title": "Titre de la section",
        "section_order": 1,
        "content": {}
    }
    ```
-   **Réponse** : `201 Created` avec la section créée.

### Afficher une section

-   **Endpoint** : `/api/app/templates/sections/show/{id}`
-   **Méthode** : `GET`
-   **Description** : Récupère les détails d'une section, y compris ses champs.
-   **Réponse** : `200 OK` avec l'objet section.

### Mettre à jour une section

-   **Endpoint** : `/api/app/templates/sections/update/{id}`
-   **Méthode** : `POST`
-   **Description** : Met à jour une section existante.
-   **Réponse** : `200 OK` avec la section mise à jour.

### Supprimer une section

-   **Endpoint** : `/api/app/templates/sections/delete/{id}`
-   **Méthode** : `DELETE`
-   **Description** : Supprime une section.
-   **Réponse** : `200 OK` avec un message de succès.

### Lister les sections d'un template

-   **Endpoint** : `/api/app/templates/sections/template/{templateId}`
-   **Méthode** : `GET`
-   **Description** : Récupère toutes les sections d'un template spécifique.
-   **Réponse** : `200 OK` avec une liste de sections.

---

## Champs de Formulaire (Fields)

### Lister les champs

-   **Endpoint** : `/api/app/fields`
-   **Méthode** : `GET`
-   **Description** : Récupère une liste paginée de tous les champs de formulaire disponibles.
-   **Réponse** : `200 OK` avec une liste paginée de champs.

### Créer un champ

-   **Endpoint** : `/api/app/fields/create`
-   **Méthode** : `POST`
-   **Description** : Crée un nouveau champ de formulaire réutilisable.
-   **Corps de la requête** (Exemple) :
    ```json
    {
        "label": "Nom du champ",
        "type": "text",
        "validation_rules": {"required": true, "min": 3}
    }
    ```
-   **Réponse** : `201 Created` avec le champ créé.

### Afficher un champ

-   **Endpoint** : `/api/app/fields/show/{id}`
-   **Méthode** : `GET`
-   **Description** : Récupère les détails d'un champ spécifique.
-   **Réponse** : `200 OK` avec l'objet champ.

### Mettre à jour un champ

-   **Endpoint** : `/api/app/fields/update/{id}`
-   **Méthode** : `POST`
-   **Description** : Met à jour un champ existant.
-   **Réponse** : `200 OK` avec le champ mis à jour.

### Supprimer un champ

-   **Endpoint** : `/api/app/fields/delete/{id}`
-   **Méthode** : `DELETE`
-   **Description** : Supprime un champ.
-   **Réponse** : `200 OK` avec un message de succès.

---

## Champs de Template (Association)

### Lister les champs de template

-   **Endpoint** : `/api/app/fields/template-fields`
-   **Méthode** : `GET`
-   **Description** : Récupère une liste paginée de toutes les associations entre templates et champs.
-   **Réponse** : `200 OK` avec une liste paginée.

### Créer une association

-   **Endpoint** : `/api/app/fields/template-fields/create`
-   **Méthode** : `POST`
-   **Description** : Associe un champ de formulaire à un template (et éventuellement à une section).
-   **Corps de la requête** (Exemple) :
    ```json
    {
        "template_id": "uuid-du-template",
        "section_id": "uuid-de-la-section",
        "field_id": "uuid-du-champ",
        "field_order": 1,
        "is_required": true
    }
    ```
-   **Réponse** : `201 Created` avec l'objet d'association créé.

### Afficher une association

-   **Endpoint** : `/api/app/fields/template-fields/show/{id}`
-   **Méthode** : `GET`
-   **Description** : Récupère les détails d'une association spécifique.
-   **Réponse** : `200 OK` avec l'objet d'association.

### Mettre à jour une association

-   **Endpoint** : `/api/app/fields/template-fields/update/{id}`
-   **Méthode** : `POST`
-   **Description** : Met à jour une association existante.
-   **Réponse** : `200 OK` avec l'objet d'association mis à jour.

### Supprimer une association

-   **Endpoint** : `/api/app/fields/template-fields/delete/{id}`
-   **Méthode** : `DELETE`
-   **Description** : Supprime une association entre un template et un champ.
-   **Réponse** : `200 OK` avec un message de succès.
