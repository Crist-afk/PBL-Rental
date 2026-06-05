# CosRent - PBL Rental

CosRent is a Laravel-based costume rental web application for the PBL-Rental project. It supports customer browsing and booking, payment proof uploads, admin payment validation, return recording, rental history, invoices, customer profiles, and a community forum.

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL or MariaDB
- Blade templates
- Vite
- Tailwind CSS
- JavaScript
- Laravel filesystem public disk for uploaded images
- Laravel mail for forgot-password reset links

## Main Features

- Customer authentication: register, login, remember me, forgot password, logout
- Role-based customer/admin redirects and admin middleware
- Customer profile: name, phone, bio, avatar, cover photo, password change, account deactivation
- Product catalog: listing, detail page, categories, search, size and stock display
- Booking: selected costume size, rental date validation, total price calculation, pending payment status
- Payment proof upload for customer transactions
- Admin payment validation: approve/reject pending payments
- Return management: record returns, restore stock, calculate late fines
- Rental history and invoice pages
- Forum: posts, categories, comments, replies, moderation delete actions
- Admin management: dashboard, costume/category management, user management, profile settings

## Installation

1. Clone the project and enter the project directory.

```bash
git clone <repository-url>
cd PBL-Rental
```

2. Install PHP dependencies.

```bash
composer install
```

3. Install frontend dependencies and build assets.

```bash
npm install
npm run build
```

4. Create the environment file.

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

5. Generate the Laravel application key.

```bash
php artisan key:generate
```

## Database Setup

1. Create a MySQL database for the project, for example:

```sql
CREATE DATABASE cosrent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Update `.env` with your local database credentials.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cosrent
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

3. Run migrations and seeders.

```bash
php artisan migrate --seed
```

The default seeder creates development/demo users and sample costume data. Review `database/seeders/DatabaseSeeder.php` for the current seeded admin account and change seeded credentials before any public deployment.

## File Uploads

CosRent stores avatars, cover photos, costume images, forum images, and payment proof images on Laravel's public disk. Create the public storage symlink after setup:

```bash
php artisan storage:link
```

Make sure the server can write to:

- `storage/`
- `bootstrap/cache/`

Uploaded files are served through `public/storage`, so the web server must expose the Laravel `public` directory.

## Mail Setup

Forgot-password reset links require mail configuration. Production should use SMTP or another real mail provider.

Example production-style settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

For local development, you may set `MAIL_MAILER=log` to write reset links to the Laravel log instead of sending email.

## Local Run

Start the Laravel development server:

```bash
php artisan serve
```

If you are actively editing frontend assets, run Vite in another terminal:

```bash
npm run dev
```

Then open:

```text
http://127.0.0.1:8000
```

## Deployment Notes

- Set the web server document root to the Laravel `public` directory.
- Copy `.env.example` to `.env` and fill in production values.
- Set `APP_ENV=production`.
- Set `APP_DEBUG=false`.
- Set a real `APP_URL`.
- Use a secure database user and password.
- Configure a real mail provider for password reset emails.
- Set `FILESYSTEM_DISK=public`.
- Run `php artisan storage:link`.
- Run `composer install --no-dev --optimize-autoloader`.
- Run `npm install` and `npm run build`, or build assets in CI and deploy the built files.
- Run `php artisan migrate --force` on deployment. Use `php artisan migrate --seed` only when intentionally seeding demo/default data.
- Cache production configuration after `.env` is final:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

- If using `database` session, cache, or queue drivers, make sure migrations have been run.
- Ensure `storage/` and `bootstrap/cache/` are writable by the web server user.
- Do not commit real `.env` files, production passwords, API keys, SMTP passwords, or database credentials.

## Useful Commands

```bash
php artisan migrate
php artisan migrate --seed
php artisan storage:link
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan test
```
