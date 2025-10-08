# API de Gestion des Documents

Cette documentation décrit l'API pour la gestion des documents.

---

## Lister les documents

-   **Endpoint** : `/api/app/documents`
-   **Méthode** : `GET`
-   **Description** : Récupère une liste paginée de tous les documents disponibles.
-   **Paramètres de la requête** :
    -   `page` (optionnel) : Le numéro de la page à récupérer.
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** :
        ```json
        {
            "data": [
                {
                    "id": "uuid",
                    "name": "Nom du document",
                    "description": "Description du document",
                    "category": "Catégorie du document",
                    "type": "Type de document"
                }
            ],
            "links": {
                "first": "url",
                "last": "url",
                "prev": null,
                "next": "url"
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 5,
                "path": "url",
                "per_page": 10,
                "to": 10,
                "total": 50
            }
        }
        ```
-   **Réponse en cas d'erreur** :
    -   **Code** : `500 Internal Server Error`
    -   **Contenu** :
        ```json
        {
            "message": "Echec de la récupération des documents."
        }
        ```

---

## Créer un document

-   **Endpoint** : `/api/app/documents/create`
-   **Méthode** : `POST`
-   **Description** : Crée un nouveau document.
-   **Corps de la requête** :
    ```json
    {
        "name": "Nom du document",
        "description": "Description du document",
        "category": "Catégorie du document",
        "type": "Type de document"
    }
    ```
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** :
        ```json
        {
            "data": {
                "id": "uuid",
                "name": "Nom du document",
                "description": "Description du document",
                "category": "Catégorie du document",
                "type": "Type de document"
            }
        }
        ```
-   **Réponse en cas d'erreur** :
    -   **Code** : `500 Internal Server Error`
    -   **Contenu** :
        ```json
        {
            "message": "Echec de la création du document."
        }
        ```
    -   **Code** : `422 Unprocessable Entity` (En cas d'échec de validation)

---

## Afficher un document

-   **Endpoint** : `/api/app/documents/show/{id}`
-   **Méthode** : `GET`
-   **Description** : Récupère les détails d'un document spécifique.
-   **Paramètres d'URL** :
    -   `id` (requis) : L'ID du document.
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** :
        ```json
        {
            "data": {
                "id": "uuid",
                "name": "Nom du document",
                "description": "Description du document",
                "category": "Catégorie du document",
                "type": "Type de document"
            }
        }
        ```
-   **Réponse en cas d'erreur** :
    -   **Code** : `404 Not Found`
    -   **Code** : `500 Internal Server Error`

---

## Mettre à jour un document

-   **Endpoint** : `/api/app/documents/update/{id}`
-   **Méthode** : `POST`
-   **Description** : Met à jour un document existant.
-   **Paramètres d'URL** :
    -   `id` (requis) : L'ID du document.
-   **Corps de la requête** :
    ```json
    {
        "name": "Nouveau nom du document",
        "description": "Nouvelle description",
        "category": "Nouvelle catégorie",
        "type": "Nouveau type"
    }
    ```
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** :
        ```json
        {
            "data": {
                "id": "uuid",
                "name": "Nouveau nom du document",
                "description": "Nouvelle description",
                "category": "Nouvelle catégorie",
                "type": "Nouveau type"
            }
        }
        ```
-   **Réponse en cas d'erreur** :
    -   **Code** : `500 Internal Server Error`
    -   **Contenu** :
        ```json
        {
            "message": "Echec de la mise à jour du document."
        }
        ```
    -   **Code** : `422 Unprocessable Entity` (En cas d'échec de validation)
    -   **Code** : `404 Not Found`

---

## Supprimer un document

-   **Endpoint** : `/api/app/documents/delete/{id}`
-   **Méthode** : `DELETE`
-   **Description** : Supprime un document.
-   **Paramètres d'URL** :
    -   `id` (requis) : L'ID du document.
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** :
        ```json
        {
            "message": "Document supprimé avec succès."
        }
        ```
-   **Réponse en cas d'erreur** :
    -   **Code** : `500 Internal Server Error`
    -   **Contenu** :
        ```json
        {
            "message": "Echec de la suppression du document."
        }
        ```
    -   **Code** : `404 Not Found`

---

## Lister les documents par catégorie

-   **Endpoint** : `/api/app/documents/category/{category}`
-   **Méthode** : `GET`
-   **Description** : Récupère une liste paginée de documents filtrés par catégorie.
-   **Paramètres d'URL** :
    -   `category` (requis) : La catégorie des documents à récupérer.
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** : (Similaire à la liste des documents)
-   **Réponse en cas d'erreur** :
    -   **Code** : `500 Internal Server Error`
    -   **Contenu** :
        ```json
        {
            "message": "Echec de la récupération des documents."
        }
        ```

---

## Rechercher des documents

-   **Endpoint** : `/api/app/documents/search`
-   **Méthode** : `GET`
-   **Description** : Recherche des documents en fonction d'un terme de recherche dans le nom, la description ou la catégorie.
-   **Paramètres de la requête** :
    -   `q` (requis) : Le terme de recherche.
-   **Réponse en cas de succès** :
    -   **Code** : `200 OK`
    -   **Contenu** : (Similaire à la liste des documents)
-   **Réponse en cas d'erreur** :
    -   **Code** : `500 Internal Server Error`
    -   **Contenu** :
        ```json
        {
            "message": "Echec de la recherche des documents."
        }
        ```
