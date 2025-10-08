# Authentification avec Cookies HttpOnly dans Laravel 12

## Introduction

Les cookies HttpOnly offrent une sécurité renforcée contre les attaques XSS (Cross-Site Scripting) en empêchant JavaScript d'accéder aux tokens d'authentification. Ce guide détaille l'implémentation complète dans Laravel 12.

## Prérequis

- Laravel 12 installé
- PHP 8.2 ou supérieur
- Composer
- Base de données configurée

## Étape 1 : Configuration de base

### 1.1 Configuration des sessions

Modifiez le fichier `config/session.php` :

```php
return [
    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => 120,
    'expire_on_close' => false,
    
    // Sécurité des cookies
    'secure' => env('SESSION_SECURE_COOKIE', true),
    'http_only' => true, // CRUCIAL : empêche l'accès JavaScript
    'same_site' => 'lax', // Protection CSRF
];
```

### 1.2 Configuration du fichier .env

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
```

## Étape 2 : Installation et configuration de Laravel Sanctum

Laravel Sanctum est idéal pour l'authentification basée sur les cookies.

### 2.1 Installation

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2.2 Configuration de Sanctum

Modifiez `config/sanctum.php` :

```php
return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),

    'guard' => ['web'],

    'expiration' => null,

    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];
```

### 2.3 Middleware

Dans `bootstrap/app.php` (Laravel 11+) ou `app/Http/Kernel.php` :

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(prepend: [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ]);
    
    $middleware->statefulApi();
})
```

## Étape 3 : Configuration CORS

Modifiez `config/cors.php` pour autoriser les credentials :

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000',
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true, // CRUCIAL pour les cookies
];
```

## Étape 4 : Création des contrôleurs d'authentification

### 4.1 Contrôleur d'inscription

```php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        auth()->login($user);

        return response()->json([
            'message' => 'Inscription réussie',
            'user' => $user
        ], 201);
    }
}
```

### 4.2 Contrôleur de connexion

```php
// app/Http/Controllers/Auth/LoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => Auth::user()
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
```

## Étape 5 : Configuration des routes

### 5.1 Routes d'authentification

```php
// routes/api.php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Routes publiques
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/user', [LoginController::class, 'user']);
});
```

### 5.2 Route CSRF

```php
// routes/web.php
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});
```

## Étape 6 : Implémentation côté frontend

### 6.1 Configuration Axios (React/Vue)

```javascript
// src/api/axios.js
import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000',
    withCredentials: true, // CRUCIAL : envoie les cookies
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
});

// Intercepteur pour gérer les erreurs d'authentification
api.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            // Rediriger vers la page de connexion
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

export default api;
```

### 6.2 Fonction de connexion

```javascript
// src/services/auth.js
import api from './axios';

export const authService = {
    // Obtenir le token CSRF avant toute requête authentifiée
    async getCsrfToken() {
        await api.get('/sanctum/csrf-cookie');
    },

    async register(name, email, password, passwordConfirmation) {
        await this.getCsrfToken();
        const response = await api.post('/api/register', {
            name,
            email,
            password,
            password_confirmation: passwordConfirmation
        });
        return response.data;
    },

    async login(email, password, remember = false) {
        await this.getCsrfToken();
        const response = await api.post('/api/login', {
            email,
            password,
            remember
        });
        return response.data;
    },

    async logout() {
        const response = await api.post('/api/logout');
        return response.data;
    },

    async getUser() {
        const response = await api.get('/api/user');
        return response.data;
    }
};
```

### 6.3 Exemple d'utilisation (React)

```javascript
// src/components/Login.jsx
import { useState } from 'react';
import { authService } from '../services/auth';

function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');

        try {
            const data = await authService.login(email, password);
            console.log('Connecté:', data.user);
            // Rediriger ou mettre à jour l'état global
        } catch (err) {
            setError(err.response?.data?.message || 'Erreur de connexion');
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            {error && <div className="error">{error}</div>}
            
            <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Email"
                required
            />
            
            <input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="Mot de passe"
                required
            />
            
            <button type="submit">Se connecter</button>
        </form>
    );
}
```

## Étape 7 : Sécurité avancée

### 7.1 Protection contre les attaques de force brute

```php
// app/Http/Controllers/Auth/LoginController.php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

public function login(Request $request)
{
    $this->ensureIsNotRateLimited($request);

    // ... reste du code de connexion

    RateLimiter::clear($this->throttleKey($request));
}

protected function ensureIsNotRateLimited(Request $request)
{
    if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
        return;
    }

    throw ValidationException::withMessages([
        'email' => ['Trop de tentatives. Réessayez dans quelques minutes.'],
    ]);
}

protected function throttleKey(Request $request)
{
    return strtolower($request->input('email')).'|'.$request->ip();
}
```

### 7.2 Middleware personnalisé pour vérifier l'authentification

```php
// app/Http/Middleware/EnsureUserIsAuthenticated.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Non authentifié'
            ], 401);
        }

        return $next($request);
    }
}
```

## Étape 8 : Tests

### 8.1 Tests d'authentification

```php
// tests/Feature/AuthenticationTest.php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/logout');

        $response->assertStatus(200);
        $this->assertGuest();
    }
}
```

## Étape 9 : Débogage courant

### 9.1 Problèmes de cookies non envoyés

**Symptôme :** Les cookies ne sont pas envoyés avec les requêtes.

**Solutions :**
- Vérifier que `withCredentials: true` est défini côté client
- Vérifier que `supports_credentials: true` dans `config/cors.php`
- Vérifier que le domaine dans `SANCTUM_STATEFUL_DOMAINS` correspond

### 9.2 Erreurs CSRF

**Symptôme :** Erreur 419 "CSRF token mismatch"

**Solutions :**
- Appeler `/sanctum/csrf-cookie` avant chaque première requête
- Vérifier que les cookies sont autorisés dans le navigateur
- Vérifier la configuration CORS

### 9.3 Cookies non persistants

**Symptôme :** L'utilisateur est déconnecté au rafraîchissement

**Solutions :**
- Vérifier `SESSION_SECURE_COOKIE` (doit être `false` en développement HTTP)
- Vérifier `SESSION_DOMAIN` dans le `.env`
- Vérifier que `expire_on_close` est `false`

## Bonnes pratiques

1. **En production :** Toujours utiliser HTTPS avec `SESSION_SECURE_COOKIE=true`
2. **Rotation des tokens :** Régénérer la session après connexion
3. **Expiration :** Définir une durée de session appropriée
4. **SameSite :** Utiliser `lax` ou `strict` selon vos besoins
5. **Surveillance :** Logger les tentatives de connexion échouées
6. **Sessions :** Utiliser `database` ou `redis` plutôt que `file` en production

## Conclusion

Vous disposez maintenant d'un système d'authentification sécurisé avec cookies HttpOnly dans Laravel 12. Cette approche protège contre les attaques XSS tout en maintenant une expérience utilisateur fluide. N'oubliez pas de tester rigoureusement votre implémentation et d'adapter la configuration à vos besoins spécifiques.