# Okazyon - Multi-Vendor E-Commerce Platform

Okazyon is a modern multi-vendor e-commerce platform built with Laravel, designed to provide a seamless experience for buyers, sellers, and administrators.

##  Key Features

### For Buyers
- **Fresh Deals & Discounts:** Explore the latest offers and best deals on the home screen.
- **Category Highlights:** Easily find products across various categories.
- **Order Tracking:** Real-time push notifications for order status updates (Processing, Shipped, Delivered, etc.).
- **Favorites:** Save your favorite products for easy access.

###  For Sellers
- **Product Management:** Upload and manage products with multi-image support.
- **Order Handling:** Real-time order management and status tracking.
- **Admin Review:** Products are reviewed and approved by administrators before going live.
- **Secure Onboarding:** OTP-based verification for seller registration.

### For Administrators
- **Dashboard:** Overview of the entire platform's performance.
- **Notification Center:** Send targeted or global push notifications via Firebase Cloud Messaging (FCM).
- **Product Verification:** Review and approve or reject seller products.
- **User Management:** Oversee all platform users and activities.

##  Project Structure

###  1. `app/` (The Core Logic)
- **`Http/Controllers/`**: Orchestrates the request/response flow.
    - `API/`: Endpoints serving the mobile application.
    - `Admin/` & `Seller/`: Controllers for the respective web dashboards.
    - `AdminAuth/` & `SellerAuth/`: Dedicated authentication logic for each role.
- **`Models/`**: Eloquent models representing the database schema (e.g., `User`, `Product`, `Order`, `Banner`).
- **`Services/`**: Encapsulated business logic (e.g., `Firebase/NotificationService`, `OTP/OtpService`).
- **`Utility/Enums/`**: PHP Enums for type-safe status and type management.
- **`Helpers/`**: Global utility functions for localization and formatting.

### 2. `routes/` (URL Routing)
- **`web.php`**: Standard web routes for dashboards and frontend pages.
- **`api/`**: Organized API endpoints:
    - `userApi.php`: Main customer-facing mobile application routes.
    - `adminApi.php`: Backend routes for administrative tasks.
    - `generalApi.php`: Shared public routes (e.g., categories, banners).

### 3. `storage/` (Persistent Files)
- **`app/public/`**: The primary location for user-uploaded media (product images, banners).
- **`logs/`**: Application-level logs for debugging and monitoring.
- **`framework/`**: Internal Laravel cache, sessions, and compiled views.

## 🔗 API & Web Endpoints

###  Public API (Mobile Home)
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/home/banner` | Get home screen banners |
| `GET` | `/api/home/products` | Get home products overview |
| `GET` | `/api/home/featured-deals`| Get featured products |
| `GET` | `/api/home/new-deals` | Get new arrivals |
| `GET` | `/api/home/best-discounts`| Get high-discount items |
| `GET` | `/api/home/category-highlights`| Get category sneak peeks |
| `GET` | `/api/categories` | List all categories |
| `GET` | `/api/products` | Paginated product list |
| `GET` | `/api/products/{id}` | Product details |
| `GET` | `/api/search` | Search products |

###  Auth & Profile
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/sendotp` | Generate registration OTP |
| `POST` | `/api/verifyotp` | Verify registration OTP |
| `POST` | `/api/register` | User registration |
| `POST` | `/api/login` | User login |
| `GET` | `/api/profile` | (Auth) Get profile data |
| `PUT` | `/api/profile` | (Auth) Update profile |
| `POST` | `/api/fcm-token` | (Auth) Register device FCM token |

### 📦 Customer Operations (Authenticated)
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/notifications` | User notification list |
| `GET` | `/api/cart` | Get shopping cart |
| `POST` | `/api/cart` | Add item to cart |
| `GET` | `/api/addresses` | List saved addresses |
| `POST` | `/api/orders` | Place a new order |
| `GET` | `/api/orders` | My order history |
| `POST` | `/api/products/{id}/favorite`| Toggle favorite status |

### Seller Dashboard (Web)
| Endpoint | Description |
| :--- | :--- |
| `/seller/login` | Seller login page |
| `/seller/register`| Seller registration (OTP Required) |
| `/seller/dashboard`| Seller sales overview |
| `/seller/products` | Manage seller products |
| `/seller/orders` | Manage incoming orders |

###  Admin Dashboard (Web)
| Endpoint | Description |
| :--- | :--- |
| `/admin/login` | Admin login page |
| `/admin/dashboard`| Platform overview |
| `/admin/users` | Manage users & bans |
| `/admin/categories` | Manage system categories |
| `/admin/banners` | Manage home banners |
| `/admin/products` | Review & approve products |

###  Admin API (Mobile Management)
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/v1/admin/users`| List platform users |
| `POST` | `/api/v1/admin/users/{id}/alter-ban` | Ban/Unban a user |
| `GET` | `/api/v1/admin/notifications` | List system notifications |
| `POST` | `/api/v1/admin/notifications/{id}/send`| Trigger FCM for a notification |

### General API
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/upload-image` | Upload temporary image |
| `GET` | `/api/locale` | Get current platform language |
| `POST` | `/api/locale` | Change platform language |

##  Technical Stack
- **Framework:** [Laravel 11](https://laravel.com)
- **Database:** SQLite (Local) / Support for MySQL/PostgreSQL
- **Real-time Notifications:** Firebase Cloud Messaging (FCM)
- **Asset Bundling:** Vite + Vanilla CSS
- **Authentication:** Laravel Sanctum + OTP Service

##  Setup & Installation

### 1. Requirements
- PHP 8.2+
- Composer
- Node.js & NPM

### 2. Installation Steps
```bash
# Clone the repository
git clone <repository-url>
cd Okazyon

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed data
php artisan migrate --seed

# Build assets
npm run build
```





