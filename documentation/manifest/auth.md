# Manifeste d'Authentification
## Application de Génération de Documents

---

## 📋 Vue d'ensemble

Ce document définit l'architecture complète du système d'authentification pour une application de génération de documents utilisant React-TypeScript (Frontend) et Laravel 12 (Backend) avec le package `laravel-httponly-authentication`.

### Stack Technique
- **Frontend**: React + TypeScript
- **Backend**: Laravel 12
- **Package d'authentification**: laravel-httponly-authentication
- **Architecture Backend**: Request → Controller → Interface → Repository → Provider

---

## 🎯 Objectifs de Sécurité

1. Authentification multi-méthodes (email/password + OAuth)
2. Validation OTP obligatoire à l'inscription
3. Séparation stricte des rôles (Utilisateurs / Administrateurs)
4. Protection des routes par middlewares
5. Réinitialisation sécurisée par magic link
6. Tokens HttpOnly pour la sécurité maximale

---

## 👥 Types d'Utilisateurs

### Utilisateurs Normaux
- **Authentification**: Email/Password + OAuth (Google, GitHub, etc.)
- **Validation**: Code OTP obligatoire
- **Accès**: Fonctionnalités de génération de documents

### Administrateurs
- **Authentification**: Email/Password uniquement
- **Validation**: Code OTP obligatoire
- **Accès**: Gestion de la plateforme et des utilisateurs

---

## 🔐 Processus d'Authentification

### 1. Inscription des Utilisateurs

#### 1.1 Inscription Standard (Email/Password)

**Flux Backend:**

```
Request (RegisterUserRequest) 
  ↓
Controller (AuthController@register)
  ↓
Interface (IAuthService)
  ↓
Repository (UserRepository)
  ↓
Provider (AuthServiceProvider)
```

**Étapes:**

1. **Validation des données** (RegisterUserRequest)
   - Email unique et valide
   - Password (min 8 caractères, avec majuscule, chiffre, caractère spécial)
   - Nom et prénom requis

2. **Création du compte**
   - Statut: `pending` (en attente de validation OTP)
   - Email non vérifié
   - Hash du password avec Bcrypt
   - Génération d'un code OTP (6 chiffres)
   - Stockage OTP avec expiration (10 minutes)

3. **Envoi du code OTP**
   - Email contenant le code
   - Template personnalisé avec délai d'expiration

4. **Réponse**
   - Message de succès
   - Instructions pour vérifier l'OTP
   - Pas de token à ce stade

#### 1.2 Inscription via OAuth

**Flux:**

1. **Redirection vers le provider OAuth**
   - Route: `GET /auth/oauth/{provider}/redirect`
   - Providers supportés: Google, GitHub, Facebook

2. **Callback OAuth**
   - Route: `GET /auth/oauth/{provider}/callback`
   - Récupération des informations utilisateur
   - Vérification si l'email existe déjà

3. **Création ou liaison du compte**
   - Si nouveau: création avec `email_verified_at` déjà défini
   - Si existant: liaison du provider OAuth
   - Génération du code OTP

4. **Validation OTP obligatoire**
   - Même pour OAuth, validation OTP requise
   - Envoi du code par email

### 2. Validation OTP

**Route:** `POST /auth/verify-otp`

**Données requises:**
- Email
- Code OTP (6 chiffres)

**Processus:**

1. **Validation du code**
   - Vérification de l'existence
   - Vérification de l'expiration (10 minutes)
   - Vérification du code

2. **Activation du compte**
   - Mise à jour du statut: `active`
   - Marquage `email_verified_at`
   - Suppression du code OTP utilisé

3. **Génération des tokens**
   - Token HttpOnly (stocké dans cookie sécurisé)
   - CSRF token
   - Refresh token (optionnel)

4. **Réponse**
   - Données utilisateur (sans informations sensibles)
   - Message de succès

### 3. Connexion (Login)

#### 3.1 Login Standard

**Route:** `POST /auth/login`

**Données requises:**
- Email
- Password

**Processus:**

1. **Validation des credentials**
   - Vérification email/password
   - Vérification que le compte est `active`
   - Vérification que l'email est vérifié

2. **Génération des tokens**
   - Token HttpOnly dans cookie sécurisé
   - Durée de vie: 24h (configurable)

3. **Enregistrement de l'activité**
   - Dernière connexion
   - IP address
   - User agent

4. **Réponse**
   - Données utilisateur
   - Permissions/rôles

#### 3.2 Login OAuth

**Même flux que l'inscription OAuth** mais sans création de compte si l'utilisateur existe déjà.

### 4. Inscription et Connexion Admin

**Routes dédiées:**
- `POST /admin/register` (inscription)
- `POST /admin/login` (connexion)

**Différences:**

1. **Pas d'OAuth**
   - Uniquement email/password

2. **Validation renforcée**
   - Email doit appartenir à un domaine autorisé (optionnel)
   - Password plus strict (min 12 caractères)

3. **OTP obligatoire**
   - Même processus que pour les utilisateurs

4. **Rôle automatique**
   - Attribution du rôle `admin` à la validation

5. **Audit logging**
   - Toutes les actions admin sont loguées

---

## 🔄 Réinitialisation de Mot de Passe

### Processus par Magic Link

#### Étape 1: Demande de réinitialisation

**Route:** `POST /auth/forgot-password`

**Données requises:**
- Email

**Processus:**

1. **Vérification de l'email**
   - L'utilisateur existe
   - Le compte est actif

2. **Génération du magic link**
   - Token unique (UUID ou hash sécurisé)
   - Stockage dans table `password_reset_tokens`
   - Expiration: 1 heure

3. **Envoi de l'email**
   - Template avec le magic link
   - Format: `https://app.domain.com/reset-password?token={token}&email={email}`

4. **Réponse**
   - Message générique (sécurité)
   - "Si l'email existe, vous recevrez un lien"

#### Étape 2: Validation du magic link

**Route:** `GET /auth/reset-password/verify`

**Paramètres:**
- token
- email

**Processus:**

1. **Validation du token**
   - Existence
   - Non expiré
   - Correspond à l'email

2. **Réponse**
   - Validation réussie ou échec
   - Redirection vers formulaire de changement

#### Étape 3: Changement du mot de passe

**Route:** `POST /auth/reset-password`

**Données requises:**
- Email
- Token
- Nouveau password
- Confirmation password

**Processus:**

1. **Revalidation du token**
   - Sécurité supplémentaire

2. **Validation du nouveau password**
   - Respect des règles de complexité
   - Différent de l'ancien (optionnel)

3. **Mise à jour**
   - Hash du nouveau password
   - Suppression du token utilisé
   - Révocation de tous les tokens actifs (sécurité)

4. **Notification**
   - Email de confirmation du changement

5. **Réponse**
   - Succès
   - Redirection vers login

---

## 🛡️ Protection des Routes

### Middlewares Laravel

#### 1. AuthMiddleware

**Rôle:** Vérifier l'authentification de base

```php
- Vérifie la présence du token HttpOnly
- Valide le token
- Charge l'utilisateur dans la requête
- Redirige vers login si échec
```

**Application:**
- Toutes les routes protégées

#### 2. VerifiedEmailMiddleware

**Rôle:** S'assurer que l'email est vérifié

```php
- Vérifie email_verified_at
- Redirige vers page de vérification si non vérifié
```

**Application:**
- Routes nécessitant un compte activé

#### 3. RoleMiddleware

**Rôle:** Vérifier les rôles/permissions

```php
- Paramètre: rôle(s) requis
- Vérifie que l'utilisateur possède le rôle
- Retourne 403 si non autorisé
```

**Application:**
- Routes admin: `role:admin`
- Routes spécifiques: `role:editor,manager`

#### 4. AdminMiddleware

**Rôle:** Accès exclusif admin

```php
- Vérifie le rôle admin
- Vérifie le statut actif
- Log de toutes les tentatives d'accès
```

**Application:**
- Toutes les routes `/admin/*`

#### 5. ThrottleMiddleware

**Rôle:** Protection contre les attaques brute force

```php
- Login: 5 tentatives / 1 minute
- Register: 3 tentatives / 10 minutes
- OTP: 5 tentatives / 5 minutes
- Password reset: 3 tentatives / 10 minutes
```

### Groupes de Routes

```php
// Routes publiques
/auth/register
/auth/login
/auth/forgot-password

// Routes authentifiées
middleware(['auth:api'])
  /user/profile
  /documents/*

// Routes admin
middleware(['auth:api', 'admin'])
  /admin/*
  /admin/users
  /admin/logs

// Routes avec email vérifié
middleware(['auth:api', 'verified'])
  /documents/create
  /documents/export
```

---

## 📊 Structure de la Base de Données

### Table: users

```sql
- id (bigint, primary key)
- name (string)
- email (string, unique, indexed)
- email_verified_at (timestamp, nullable)
- password (string, nullable) // nullable pour OAuth
- role (enum: user, admin)
- status (enum: pending, active, suspended, deleted)
- last_login_at (timestamp, nullable)
- last_login_ip (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Table: oauth_providers

```sql
- id (bigint, primary key)
- user_id (foreign key → users)
- provider (string) // google, github, facebook
- provider_id (string) // ID chez le provider
- provider_token (text, encrypted)
- provider_refresh_token (text, encrypted, nullable)
- created_at (timestamp)
- updated_at (timestamp)

// Index unique: user_id + provider
```

### Table: otp_codes

```sql
- id (bigint, primary key)
- email (string, indexed)
- code (string, 6 digits)
- expires_at (timestamp)
- used_at (timestamp, nullable)
- created_at (timestamp)

// Index: email + expires_at
```

### Table: password_reset_tokens

```sql
- email (string, primary key)
- token (string, indexed)
- created_at (timestamp)

// Laravel standard table
```

### Table: personal_access_tokens (Laravel Sanctum/Passport)

```sql
// Structure standard Laravel
// Utilisé pour les refresh tokens si nécessaire
```

### Table: activity_logs (optionnel mais recommandé)

```sql
- id (bigint, primary key)
- user_id (foreign key → users, nullable)
- action (string) // login, logout, password_reset, etc.
- ip_address (string)
- user_agent (text)
- metadata (json, nullable)
- created_at (timestamp)

// Index: user_id, action, created_at
```

---

## 🔒 Sécurité et Bonnes Pratiques

### 1. Tokens HttpOnly

**Configuration:**
```php
- Cookie httpOnly: true
- Cookie secure: true (HTTPS only)
- Cookie sameSite: 'lax' ou 'strict'
- Domain: .yourdomain.com
- Path: /
```

### 2. Validation des Données

**Règles strictes:**
- Email: format valide, unique, lowercase
- Password: 8+ caractères, majuscule, minuscule, chiffre, caractère spécial
- OTP: exactement 6 chiffres
- Sanitization de toutes les entrées

### 3. Rate Limiting

**Configuration recommandée:**
```php
- Login: 5/minute par IP
- Register: 3/10 minutes par IP
- OTP: 5/5 minutes par email
- Password reset: 3/10 minutes par IP
- API endpoints: 60/minute par utilisateur
```

### 4. CORS

**Configuration:**
```php
- Origins: Liste blanche des domaines autorisés
- Credentials: true (pour HttpOnly cookies)
- Methods: GET, POST, PUT, DELETE, OPTIONS
- Headers: Content-Type, Authorization, X-CSRF-Token
```

### 5. CSRF Protection

**Implémentation:**
- Token CSRF dans cookie
- Validation sur toutes les mutations
- Rotation du token après authentification

### 6. Logging et Audit

**Événements à logger:**
- Toutes les authentifications (succès/échec)
- Changements de password
- Validations OTP
- Accès admin
- Actions critiques

### 7. Expiration et Révocation

**Tokens:**
- Access token: 24h (configurable)
- Refresh token: 30 jours (si implémenté)
- OTP: 10 minutes
- Magic link: 1 heure

**Révocation:**
- Logout: révocation immédiate
- Changement de password: révocation de tous les tokens
- Détection d'activité suspecte: révocation automatique

---

## 🚀 Implémentation Backend (Laravel)

### Architecture des Dossiers

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── AuthController.php
│   │   │   ├── AdminAuthController.php
│   │   │   ├── OAuthController.php
│   │   │   └── PasswordResetController.php
│   │   └── ...
│   ├── Requests/
│   │   ├── Auth/
│   │   │   ├── RegisterUserRequest.php
│   │   │   ├── LoginRequest.php
│   │   │   ├── VerifyOtpRequest.php
│   │   │   └── ResetPasswordRequest.php
│   │   └── ...
│   ├── Middleware/
│   │   ├── Authenticate.php
│   │   ├── VerifiedEmail.php
│   │   ├── RoleMiddleware.php
│   │   └── AdminMiddleware.php
│   └── ...
├── Services/
│   ├── Interfaces/
│   │   ├── IAuthService.php
│   │   ├── IOtpService.php
│   │   └── IPasswordResetService.php
│   └── Implementations/
│       ├── AuthService.php
│       ├── OtpService.php
│       └── PasswordResetService.php
├── Repositories/
│   ├── Interfaces/
│   │   ├── IUserRepository.php
│   │   └── IOtpRepository.php
│   └── Eloquent/
│       ├── UserRepository.php
│       └── OtpRepository.php
├── Providers/
│   ├── AuthServiceProvider.php
│   └── RepositoryServiceProvider.php
├── Models/
│   ├── User.php
│   ├── OtpCode.php
│   └── OAuthProvider.php
├── Mail/
│   ├── OtpVerificationMail.php
│   └── PasswordResetMail.php
└── Events/
    ├── UserRegistered.php
    └── PasswordReset.php
```

### Checklist d'Implémentation

#### Phase 1: Configuration de Base
- [ ] Installation de laravel-httponly-authentication
- [ ] Configuration des variables d'environnement
- [ ] Migration de la base de données
- [ ] Configuration CORS
- [ ] Configuration des cookies HttpOnly

#### Phase 2: Authentification Standard
- [ ] Création des Request Validators
- [ ] Implémentation des Repositories
- [ ] Implémentation des Services
- [ ] Création des Controllers
- [ ] Définition des routes
- [ ] Tests unitaires

#### Phase 3: Système OTP
- [ ] Service de génération OTP
- [ ] Repository OTP
- [ ] Templates email
- [ ] Endpoint de vérification
- [ ] Gestion de l'expiration
- [ ] Tests

#### Phase 4: OAuth
- [ ] Configuration des providers (Google, GitHub)
- [ ] Routes OAuth
- [ ] Controller OAuth
- [ ] Gestion des callbacks
- [ ] Liaison des comptes
- [ ] Tests

#### Phase 5: Réinitialisation Password
- [ ] Service de magic link
- [ ] Templates email
- [ ] Routes de réinitialisation
- [ ] Validation des tokens
- [ ] Tests

#### Phase 6: Middlewares
- [ ] AuthMiddleware
- [ ] VerifiedEmailMiddleware
- [ ] RoleMiddleware
- [ ] AdminMiddleware
- [ ] ThrottleMiddleware
- [ ] Tests

#### Phase 7: Admin
- [ ] Routes admin dédiées
- [ ] Controller admin
- [ ] Validation renforcée
- [ ] Audit logging
- [ ] Tests

#### Phase 8: Sécurité
- [ ] Rate limiting
- [ ] CSRF protection
- [ ] Logging complet
- [ ] Révocation des tokens
- [ ] Tests de sécurité

---

## 💻 Implémentation Frontend (React-TypeScript)

### Architecture des Dossiers

```
src/
├── features/
│   └── auth/
│       ├── components/
│       │   ├── LoginForm.tsx
│       │   ├── RegisterForm.tsx
│       │   ├── OtpVerification.tsx
│       │   ├── PasswordReset.tsx
│       │   └── OAuthButtons.tsx
│       ├── hooks/
│       │   ├── useAuth.ts
│       │   ├── useOtp.ts
│       │   └── usePasswordReset.ts
│       ├── services/
│       │   └── authService.ts
│       ├── types/
│       │   └── auth.types.ts
│       └── store/
│           └── authSlice.ts (Redux/Zustand)
├── shared/
│   ├── components/
│   │   ├── ProtectedRoute.tsx
│   │   └── AdminRoute.tsx
│   ├── utils/
│   │   ├── api.ts
│   │   └── validators.ts
│   └── hooks/
│       └── useApi.ts
└── ...
```

### Gestion des États

**États globaux (Redux/Zustand):**
```typescript
interface AuthState {
  user: User | null;
  isAuthenticated: boolean;
  isLoading: boolean;
  error: string | null;
}
```

### Routes Protégées

**Composant ProtectedRoute:**
```typescript
- Vérification de l'authentification
- Redirection vers login si non authentifié
- Vérification de l'email
- Redirection vers vérification OTP si nécessaire
```

**Composant AdminRoute:**
```typescript
- Vérification du rôle admin
- Redirection vers accueil si non autorisé
```

### Checklist Frontend

- [ ] Configuration Axios avec credentials
- [ ] Service d'authentification
- [ ] Hooks personnalisés
- [ ] Composants de formulaires
- [ ] Validation côté client
- [ ] Gestion des erreurs
- [ ] Loading states
- [ ] Routes protégées
- [ ] Gestion du CSRF token
- [ ] Persistance de l'état (optionnel)
- [ ] Tests E2E

---

## 📝 Flux Complets

### Flux 1: Inscription Utilisateur Standard

```
1. User → Frontend: Remplit formulaire inscription
2. Frontend: Validation locale
3. Frontend → Backend: POST /auth/register
4. Backend: Valide données (RegisterUserRequest)
5. Backend: Crée user (status: pending)
6. Backend: Génère OTP (6 chiffres)
7. Backend: Envoie email avec OTP
8. Backend → Frontend: Succès (sans token)
9. Frontend: Affiche formulaire OTP
10. User → Frontend: Entre le code OTP
11. Frontend → Backend: POST /auth/verify-otp
12. Backend: Valide OTP
13. Backend: Active le compte (status: active)
14. Backend: Génère token HttpOnly
15. Backend → Frontend: Succès + données user
16. Frontend: Redirection vers dashboard
```

### Flux 2: Inscription OAuth

```
1. User → Frontend: Clic "Connexion avec Google"
2. Frontend → Backend: GET /auth/oauth/google/redirect
3. Backend → Frontend: URL de redirection Google
4. Frontend → Google: Redirection
5. Google: User autorise l'application
6. Google → Backend: GET /auth/oauth/google/callback
7. Backend: Récupère infos user de Google
8. Backend: Crée/lie le compte (status: pending)
9. Backend: Génère OTP
10. Backend: Envoie email avec OTP
11. Backend → Frontend: Redirection vers vérification OTP
12. User → Frontend: Entre le code OTP
13-16. (Même processus que flux 1, étapes 11-16)
```

### Flux 3: Connexion Standard

```
1. User → Frontend: Remplit formulaire login
2. Frontend: Validation locale
3. Frontend → Backend: POST /auth/login
4. Backend: Valide credentials (LoginRequest)
5. Backend: Vérifie status = active et email vérifié
6. Backend: Génère token HttpOnly
7. Backend: Enregistre activité (last_login)
8. Backend → Frontend: Succès + données user
9. Frontend: Stocke état authentifié
10. Frontend: Redirection vers dashboard
```

### Flux 4: Réinitialisation Password

```
1. User → Frontend: Clic "Mot de passe oublié"
2. Frontend: Affiche formulaire email
3. User → Frontend: Entre son email
4. Frontend → Backend: POST /auth/forgot-password
5. Backend: Vérifie email existe
6. Backend: Génère magic link (token unique)
7. Backend: Envoie email avec lien
8. Backend → Frontend: Message générique
9. User: Ouvre l'email
10. User → Backend: Clic sur magic link
11. Backend: GET /auth/reset-password/verify
12. Backend: Valide le token
13. Backend → Frontend: Redirection avec token
14. Frontend: Affiche formulaire nouveau password
15. User → Frontend: Entre nouveau password
16. Frontend → Backend: POST /auth/reset-password
17. Backend: Valide token + nouveau password
18. Backend: Met à jour password
19. Backend: Révoque tous les tokens actifs
20. Backend: Envoie email de confirmation
21. Backend → Frontend: Succès
22. Frontend: Redirection vers login
```

### Flux 5: Accès Route Protégée

```
1. User → Frontend: Navigation vers route protégée
2. Frontend: ProtectedRoute vérifie authentification
3. SI non authentifié:
   → Redirection vers login
4. SI authentifié:
   → Frontend → Backend: Request avec cookie HttpOnly
   → Backend: AuthMiddleware valide token
   → Backend: Charge user dans request
   → Backend: Vérifie permissions (RoleMiddleware si nécessaire)
   → Backend: Retourne données
   → Frontend: Affiche contenu protégé
```

---

## 🧪 Tests

### Tests Backend

#### 1. Tests Unitaires
- Services (AuthService, OtpService, etc.)
- Repositories
- Validators
- Helpers

#### 2. Tests d'Intégration
- Controllers
- Middlewares
- Routes complètes

#### 3. Tests de Sécurité
- Rate limiting
- CSRF protection
- Token expiration
- SQL injection
- XSS

### Tests Frontend

#### 1. Tests de Composants
- Formulaires
- Validation
- États de chargement
- Affichage des erreurs

#### 2. Tests d'Intégration
- Flux complets
- Routes protégées
- Gestion des erreurs API

#### 3. Tests E2E (Cypress/Playwright)
- Inscription complète
- Connexion/Déconnexion
- Réinitialisation password
- OAuth flow
- Navigation entre routes protégées

---

## 📈 Monitoring et Logs

### Métriques à Suivre

1. **Authentification**
   - Nombre de tentatives de connexion (succès/échec)
   - Taux de conversion inscription → activation
   - Temps moyen de validation OTP

2. **Sécurité**
   - Tentatives de brute force détectées
   - Tokens révoqués
   - Erreurs d'authentification par IP

3. **Performance**
   - Temps de réponse des endpoints auth
   - Charge sur les endpoints de login/register

### Alertes

- Tentatives de brute force (> 10/minute par IP)
- Taux d'échec de connexion élevé (> 30%)
- Erreurs serveur sur endpoints auth
- Emails OTP non délivrés

---

## 🔄 Maintenance

### Tâches Récurrentes

#### Quotidiennes
- Nettoyage des OTP expirés
- Nettoyage des tokens de reset password expirés

#### Hebdomadaires
- Révision des logs de sécurité
- Analyse des tentatives d'accès non autorisées

#### Mensuelles
- Audit des comptes inactifs
- Révision des permissions
- Mise à jour des dépendances

---

## 📚 Documentation Complémentaire

### Endpoints API

Documentation complète avec exemples de requêtes/réponses à créer avec:
- OpenAPI/Swagger
- Postman Collection

### Guide Développeur

- Comment ajouter un nouveau provider OAuth
- Comment ajouter un nouveau rôle
- Comment personnaliser les emails
- Comment étendre les middlewares

### Guide Utilisateur

- Comment s'inscrire
- Comment utiliser OAuth
- Comment réinitialiser son mot de passe
- FAQ sécurité

---

## ✅ Checklist de Déploiement

### Avant Production

- [ ] Toutes les variables d'environnement configurées
- [ ] HTTPS activé et certificat valide
- [ ] CORS correctement configuré
- [ ] Rate limiting activé
- [ ] Logging configuré
- [ ] Monitoring configuré
- [ ] Backups de la DB configurés
- [ ] Tests de charge effectués
- [ ] Tests de sécurité (OWASP) effectués
- [ ] Documentation complète
- [ ] Rollback plan défini

### Après Déploiement

- [ ] Vérification des endpoints
- [ ] Test du flux complet d'inscription
- [ ] Test du flux de connexion
- [ ] Test OAuth
- [ ] Test réinitialisation password
- [ ] Vérification des emails
- [ ] Monitoring actif
- [ ] Alertes configurées

---

## 📞 Support et Contact

En cas de problème ou de question:
- Documentation technique: [lien]
- Logs d'erreur: [localisation]
- Contact équipe dev: [email/slack]

---

**Version:** 1.0  
**Dernière mise à jour:** 2025-10-08  
**Auteur:** Équipe Développement  
**Statut:** Document vivant - à mettre à jour régulièrement