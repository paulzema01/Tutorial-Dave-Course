# Tutorial Dave Course — Laravel + MySQL

A server-rendered Laravel website backed by MySQL. It is being built in phases. Planned features: login, logout, forgot password, password reset, change password, and a protected dashboard.

## Status

| Phase | Status |
|---|---|
| 1. Project inspection and environment setup | Done |
| 2. Authentication foundation (login, logout, route protection) | Done |
| 3. Responsive user dashboard | Done |
| Forgot/reset password, change password | Scaffolded by Breeze; not yet verified (later phases) |

Authentication uses [Laravel Breeze](https://github.com/laravel/breeze) (Blade stack). Email verification, password confirmation and account deletion were removed because they are outside the project scope.

## Stack

| Component | Version | Notes |
|---|---|---|
| Laravel | 13.x | |
| PHP | 8.5 (MAMP PRO) | Laravel 13 requires PHP 8.3+ |
| MySQL | 5.7 (MAMP PRO) | Supported by Laravel 13, but end of life upstream. See "Known risks" |
| Composer | 2.x | |
| Node.js / npm | Node 26 LTS / npm 11 | |
| Frontend | Blade, Tailwind CSS 3, Alpine.js, Vite | Installed by Breeze |
| Bootstrap | 5.3 (components only) | Compiled from Sass alongside Tailwind. See "Using Bootstrap" |
| Auth scaffolding | Laravel Breeze 2.x (Blade) | Dev dependency |
| Tests | PHPUnit 12 | Uses in-memory SQLite (see `phpunit.xml`) |

## Prerequisites

- PHP 8.3+ with these extensions: `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_mysql`, `pdo_sqlite`, `session`, `tokenizer`, `xml`
- Composer 2
- Node.js 20+ and npm
- A MySQL 5.7+ server (this machine uses MAMP PRO's MySQL on port 3306)

### Local machine notes (Windows + MAMP PRO)

MAMP's command-line PHP loads no `php.ini` by default, which leaves `openssl`, `mbstring` and `pdo_mysql` disabled. The user environment is set up as follows:

- `PATH` includes `C:\MAMP\bin\php\php8.5.12`, `C:\MAMP\bin\mysql\bin`, and `%USERPROFILE%\tools\composer`
- `PHPRC` points at MAMP PRO's active ini: `C:\Users\Public\Documents\Appsolute\MAMPPRO\conf\php8.5.12.ini`
- Composer is at `%USERPROFILE%\tools\composer\composer.phar`, with a `composer.bat` launcher

Open a new terminal (or restart VS Code) after changing these. If you switch MAMP to a different PHP version, update both `PATH` and `PHPRC` to match.

Check the setup with:

```sh
php -v
php -m        # should list pdo_mysql, openssl, mbstring
composer -V
node -v
```

## Installation

```sh
composer install
cp .env.example .env          # Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate      # new environments only; never regenerate an existing key
npm install
npm run build
```

## Environment configuration

All environment-specific settings live in `.env`, which Git ignores. `.env.example` holds safe placeholders only. Never commit real credentials.

### MySQL setup

1. Create an empty database, for example in MAMP's phpMyAdmin or with the MySQL client:

   ```sql
   CREATE DATABASE dave_tutorial CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Set the connection in `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dave_tutorial
   DB_USERNAME=<your MySQL user>
   DB_PASSWORD=<your MySQL password>
   ```

3. Test the connection without changing anything:

   ```sh
   php artisan db:show
   ```

### Database migrations

```sh
php artisan migrate
```

This creates Laravel's default tables (`users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`). Sessions and cache are stored in the database, so pages return an error until migrations have run.

Never run `migrate:fresh`, `migrate:reset` or `db:wipe` against a database that holds data you want to keep.

## Running the application

```sh
php artisan serve        # http://localhost:8000
npm run dev              # in a second terminal, for live asset reloading
```

## Using Bootstrap

Bootstrap 5.3 is installed alongside Tailwind. It's compiled from [resources/scss/bootstrap.scss](resources/scss/bootstrap.scss) and loaded on every page through `resources/js/app.js`.

- **Available:** Bootstrap components such as `btn`, `card`, `navbar`, `nav`, `dropdown`, `modal`, `alert`, `badge`, `form-control`, `table`, `container`/`row`/`col-*` and `list-group`. Their JavaScript works through `data-bs-*` attributes, and `window.bootstrap` is available for scripts.
- **Not included:** Bootstrap's utility classes (`mt-4`, `p-3`, `d-flex`, `text-center` and the rest), Reboot, and the typography classes (`.h1`, `.lead`, `.display-*`). Tailwind uses many of the same utility names with different sizes, so use Tailwind classes for spacing, layout and text.
- Changing which Bootstrap parts are included means editing `resources/scss/bootstrap.scss` and running `npm run build`.

## Routes and features

| Route | Method | Access | Purpose |
|---|---|---|---|
| `/login` | GET, POST | Guests | Log in with email and password |
| `/logout` | POST | Logged-in users | Log out (CSRF protected, never GET) |
| `/register` | GET, POST | Guests | Create an account |
| `/dashboard` | GET | Logged-in users | Dashboard: welcome, profile summary, account security, workspace panel |
| `/profile` | GET, PATCH | Logged-in users | Profile and password settings (verified in a later phase) |
| `/forgot-password`, `/reset-password/{token}` | GET, POST | Guests | Password recovery (verified in a later phase) |

Login behaviour:
- Wrong email and wrong password show the same message, so the form doesn't reveal which emails have accounts.
- After 5 failed attempts for the same email and IP, login is blocked for about a minute.
- The session ID is regenerated on login. On logout the session is invalidated and the CSRF token is regenerated.
- Guests who open a protected page are redirected to `/login`.

Logged-in pages use a sidebar layout ([layouts/app.blade.php](resources/views/layouts/app.blade.php)). On screens narrower than 1024px the sidebar becomes a slide-in drawer, opened from the menu button and closed with ✕, Escape or a tap outside. Reusable building blocks for new pages: `<x-card>`, `<x-empty-state>`, `<x-sidebar-link>` and `<x-user-avatar>`.

To create a user without the sign-up page:

```sh
php artisan tinker
>>> App\Models\User::create(['name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'a-strong-password']);
```

The `User` model hashes the password automatically.

## Running tests

```sh
php artisan test
```

Tests use an in-memory SQLite database (configured in `phpunit.xml`), so they never touch the MySQL database.

## Email configuration

`MAIL_MAILER=log` is the local default: outgoing mail is written to `storage/logs/laravel.log` and not delivered. Mail delivery will be set up and verified in the password-recovery phase.

## Troubleshooting

| Problem | Cause and fix |
|---|---|
| `could not find driver` or missing `openssl` | PHP is running without MAMP's ini. Check that `PHPRC` is set and open a new terminal. |
| `SQLSTATE[HY000] [1045] Access denied` | Wrong `DB_USERNAME` or `DB_PASSWORD` in `.env`. |
| `SQLSTATE[HY000] [1049] Unknown database` | Create the database (see MySQL setup). |
| `SQLSTATE[HY000] [2002]` | MySQL isn't running. Start it in MAMP PRO. |
| HTTP 500 on every page with `Table 'sessions' doesn't exist` | Run `php artisan migrate`. |
| `Vite manifest not found` | Run `npm run build`, or keep `npm run dev` running. |

## Known risks

- **MySQL 5.7 is end of life** (no security updates since October 2023). Laravel 13 still supports it. For production, use MySQL 8.0+ or MariaDB 10.6+.

## Production deployment

This section will be completed once features are implemented. Minimum requirements so far: `APP_ENV=production`, `APP_DEBUG=false`, HTTPS, `SESSION_SECURE_COOKIE=true`, and a real mail provider.
