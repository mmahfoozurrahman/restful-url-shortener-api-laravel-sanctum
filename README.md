# 🔗 Restful URL Shortener API (Laravel Sanctum)

A robust and secure URL shortener API built with **Laravel 12** and **Sanctum**. This project allows users to create, manage, and track shortened links while ensuring secure access through token-based authentication.

---

## 🚀 Features

### 🔐 Authentication & Profile
- **User Registration & Login**: Securely register and authenticate users via Laravel Sanctum.
- **Token-based Security**: Protected routes ensure only authorized users can manage their URLs.
- **Profile Management**: View and update user profile details (name, email).
- **Account Deletion**: Safely delete accounts with cascading deletion of all associated short links.

### ✂️ URL Shortening & Management
- **Automatic Shortening**: Generates a unique 10-character code for every long URL.
- **URL Validation**: Ensures only valid URL formats are shortened.
- **Expiration Dates**: Set optional expiry for links (default: 1 week). Expired links are automatically handled.
- **Full CRUD Support**: List (paginated), view, update (original URL or expiry), and delete your own shortened links.

### 📈 Redirection & Analytics
- **Seamless Redirection**: Instantly redirects short codes to the target long URL.
- **Click Tracking**: Automatically increments a click counter every time a link is visited.
- **Status Codes**: 
  - `302 Found` for successful redirection.
  - `410 Gone` for expired links.
  - `404 Not Found` for invalid short codes.

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 11](https://laravel.com/)
- **Authentication**: [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum)
- **Database**: MySQL / PostgreSQL / SQLite
- **Tools**: PHP 8.2+, Composer

---

## 💻 Local Setup & Installation

Follow these steps to get the project running on your local machine:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/mmahfoozurrahman/restful-url-shortener-api-laravel-sanctum.git
   cd restful-url-shortener-api-laravel-sanctum
   ```

2. **Quick Setup (Recommended)**:
   This project includes a handy shortcut that installs dependencies, sets up the environment, and runs migrations automatically:
   ```bash
   composer setup
   ```
   *Note: Ensure your database details in `.env` are correct before running migrations.*

3. **Alternative Manual Setup**:
   - **Install Dependencies**: `composer install`
   - **Environment File**: `cp .env.example .env` (Update your database credentials in `.env`)
   - **App Key**: `php artisan key:generate`
   - **Migrations**: `php artisan migrate`

4. **Serve the Application**:
   ```bash
   php artisan serve
   ```
   The API will be available at `http://127.0.0.1:8000`.

---

## 📡 API Endpoints

### Public Routes
- `POST /api/register` - Create a new account.
- `POST /api/login` - Authenticate and get a Bearer token.
- `GET /{code}` - Redirect to the original URL using the short code.

### Protected Routes (Requires Bearer Token)
- `GET /api/me` - Get current authenticated user details.
- `POST /api/logout` - Revoke the current access token.
- `GET /api/user` - View profile information.
- `PUT /api/user` - Update profile information.
- `DELETE /api/user` - Delete account and all data.

#### URL Management (`/api/urls`)
- `GET /api/urls` - List all urls belonging to the user (Paginated).
- `POST /api/urls` - Shorten a new URL.
- `GET /api/urls/{id}` - View details of a specific shortened URL.
- `PUT /api/urls/{id}` - Update a URL or its expiration date.
- `DELETE /api/urls/{id}` - Delete a shortened URL.

---

## 🧪 Testing with Postman
1. Use the **Register** endpoint to create a user.
2. Use the **Login** endpoint to get your token.
3. Add the token to the **Authorization header** as `Bearer <your_token>` for all protected routes.

---

## 📜 License
This project is open-sourced software licensed under the [MIT license](LICENSE).
