# OneBasket

Hyperlocal fulfillment platform — connect local vendors, consolidate pickups, and deliver in a single package.

Built with **Laravel 13** + **Tailwind CSS v4** (teal-600 accent, dark mode) + **MySQL 8**.

---

## Features

- **7 user roles** — Super Admin, Ops Manager, Vendor, Customer, Pickup Agent, Packing Staff, Delivery Agent
- **Vendor Management** — CRUD, approval workflow, vendor portal with profile editing
- **Product Catalog** — categories, products, variants, vendor inventory *(in progress)*
- **API-first** — Sanctum token auth, versioned API (`/api/v1/`) for mobile app integration
- **Dark mode** — class-based toggle with localStorage persistence

---

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer 2
- MySQL 8.0+
- Node.js 20+ & npm

### Installation

```bash
# Clone & install
git clone https://github.com/amanCodesWeb/OneBasket.git
cd OneBasket
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` to set your database credentials:

```
DB_DATABASE=onebasket
DB_USERNAME=root
DB_PASSWORD=
```

### Database Setup

```bash
# Create the database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS onebasket"

# Run migrations & seeders
php artisan migrate:fresh
php artisan db:seed
```

### Build frontend & serve

```bash
npm run build
# or for development:
npm run dev

php artisan serve
```

---

## Default Credentials

| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@admin.com` | `12345` |
| Vendor | `bakery@onebasket.test` | `password` |
| Vendor | `green-grocer@onebasket.test` | `password` |
| Vendor (pending) | `pharmacy@onebasket.test` | `password` |

---

## Project Structure (key directories)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin CRUD controllers
│   │   ├── Api/            # API v1 controllers (Sanctum)
│   │   ├── Vendor/         # Vendor portal controllers
│   │   └── AuthController.php
│   └── Middleware/
│       └── CheckRole.php   # Role-based access middleware
├── Models/
│   ├── User.php            # HasApiTokens, 7 role constants
│   └── Vendor.php          # Scopes, status constants
database/
├── migrations/
└── seeders/
    ├── AdminUserSeeder.php
    └── VendorSeeder.php
resources/
├── css/app.css             # Tailwind v4 config + theme
├── js/app.js
└── views/
    ├── layouts/            # app, admin, guest layouts
    ├── admin/vendors/      # Admin vendor management views
    ├── vendor/             # Vendor portal views
    └── pages/              # Auth pages (login, register)
routes/
├── web.php                 # Web routes (auth, admin, vendor)
└── api.php                 # API v1 routes (public + Sanctum)
```

---

## Roles & Permissions

| Role | Access |
|---|---|
| `super_admin` | Full admin panel access |
| `ops_manager` | Admin panel (no settings) |
| `vendor` | Vendor portal only |
| `customer` | Customer features *(coming soon)* |
| `pickup_agent` | Pickup workflow *(coming soon)* |
| `packing_staff` | Packing workflow *(coming soon)* |
| `delivery_agent` | Delivery workflow *(coming soon)* |

---

## API Endpoints

All under `/api/v1/`. Public endpoints don't need authentication; authenticated ones require a Sanctum Bearer token.

### Public

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/v1/register` | Create account |
| POST | `/api/v1/login` | Get Sanctum token |
| GET | `/api/v1/vendors` | List active vendors (paginated, searchable) |
| GET | `/api/v1/vendors/{id}` | Get vendor details |

### Authenticated

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/v1/logout` | Revoke current token |
| GET | `/api/v1/user` | Get authenticated user |
| PUT | `/api/v1/vendor/profile` | Update own vendor profile |

---

## Roadmap

- [x] Foundation (Sanctum, roles, layouts, auth, dark mode, admin dashboard)
- [x] Vendor Management (CRUD, approval, portal, API)
- [ ] Product Catalog (categories, products, variants, inventory)
- [ ] Shopping Cart & Checkout
- [ ] Order Management & Fulfillment
- [ ] Pickup Agent App
- [ ] Packing & Hub Operations
- [ ] Delivery & GPS Tracking
- [ ] Customer Portal & Notifications
- [ ] Operations Dashboard & Reporting

---

## Built With

- [Laravel 13](https://laravel.com)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Tailwind CSS v4](https://tailwindcss.com)
- [MySQL 8](https://www.mysql.com)
- [Vite](https://vitejs.dev)
