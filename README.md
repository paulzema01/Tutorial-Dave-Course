<div align="center">

# Tutorial Dave Course

**A secure, responsive Laravel + MySQL website with user accounts and a personal dashboard.**

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?logo=tailwindcss&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Tests](https://img.shields.io/badge/tests-PHPUnit-6C9A3B)

</div>

---

## Table of contents

- [About](#about)
- [Features](#features)
- [Project status](#project-status)
- [Tech stack](#tech-stack)
- [Getting started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [MySQL setup](#mysql-setup)
  - [Running the app](#running-the-app)
- [Configuration](#configuration)
- [Usage](#usage)
- [Routes](#routes)
- [Project structure](#project-structure)
- [Frontend](#frontend)
- [Testing](#testing)
- [Security](#security)
- [Troubleshooting](#troubleshooting)
- [Deploying to production](#deploying-to-production)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [License](#license)

---

## About

Tutorial Dave Course is a server-rendered web application built with Laravel and MySQL. Visitors can create an account, log in, and reach a protected dashboard that shows their own account details. It's built in phases: each phase is implemented, tested and documented before the next begins.

Authentication uses [Laravel Breeze](https://github.com/laravel/breeze) (Blade stack), Laravel's official starter kit, rather than custom code.

## Features

**Available now**

- **Sign up:** registration form with live password-strength meter, a "passwords match / don't match" indicator, and show/hide password toggles.
- **Log in and log out:**
  - Session ID regenerated on login.
  - Session invalidated on logout.
  - Logout works only through a POST request.
- **Brute-force protection:** after 5 failed logins for the same email and IP address, login is locked for about a minute.
- **Protected dashboard:** shows only the logged-in user's real name, email, avatar initials and join date. It has no invented metrics.
- **Responsive layout:**
  - Desktop: a sidebar.
  - Phones and tablets: a slide-in drawer that closes with ✕, Escape or a tap outside.
- **Profile settings:** update your name and email.
- **Accessibility:** skip-to-content link, labelled form controls, visible keyboard focus, screen-reader announcements for password matching.

**In progress** (code is scaffolded by Breeze but hasn't been verified in its own phase yet)

- Forgot password and reset by email link.
- Dedicated change-password page. Today, password changes happen in the profile page's password section.

## Project status

| Phase | Scope | Status |
|---|---|---|
| 1 | Project inspection and environment setup | ✅ Done |
| 2 | Authentication foundation: login, logout, registration, route protection | ✅ Done |
| 3 | Responsive user dashboard | ✅ Done |
| Next | Forgot/reset password, change password, mail delivery | ⏳ Planned |

Email verification, password confirmation and account deletion were removed on purpose because they're outside the project's scope.

## Tech stack

| Layer | Technology | Notes |
|---|---|---|
| Framework | Laravel 13 | |
| Language | PHP 8.5 (8.3+ required) | |
| Database | MySQL 5.7+ | 5.7 works locally but is end of life. Use 8.0+ in production |
| Auth scaffolding | Laravel Breeze 2 (Blade) | Dev dependency |
| Templates | Blade components | |
| Styling | Tailwind CSS 3 + Bootstrap 5.3 (components only) | See [Frontend](#frontend) |
| JavaScript | Alpine.js | |
| Build tool | Vite | |
| Tests | PHPUnit 12 | In-memory SQLite |
| Code style | Laravel Pint | |

## Getting started

### Prerequisites

| Tool | Version | Check with |
|---|---|---|
| PHP | 8.3 or newer | `php -v` |
| PHP extensions | `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_mysql`, `pdo_sqlite`, `session`, `tokenizer`, `xml` | `php -m` |
| Composer | 2.x | `composer -V` |
| Node.js and npm | Node 20+ | `node -v` |
| MySQL | 5.7+ (8.0+ recommended) | |
| Git | any recent version | `git --version` |

<details>
<summary><strong>Windows with MAMP PRO: extra setup</strong></summary>

MAMP's command-line PHP loads no `php.ini` by default, so `openssl`, `mbstring` and `pdo_mysql` are disabled. Set these user environment variables:

- Add to `PATH`:
  - `C:\MAMP\bin\php\php8.5.12`
  - `C:\MAMP\bin\mysql\bin`
  - the folder that holds Composer (here, `%USERPROFILE%\tools\composer`, with a `composer.bat` launcher)
- Set `PHPRC` to MAMP PRO's active ini, e.g. `C:\Users\Public\Documents\Appsolute\MAMPPRO\conf\php8.5.12.ini`

Open a new terminal (or restart VS Code) after changing them. If you switch MAMP to another PHP version, update both `PATH` and `PHPRC`.

</details>

### Installation

```sh
# 1. Get the code
git clone https://github.com/paulzema01/Tutorial-Dave-Course.git
cd Tutorial-Dave-Course

# 2. Install PHP and JavaScript dependencies
composer install
npm install

# 3. Create your environment file and app key
cp .env.example .env          # Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate      # new installs only: never regenerate an existing key

# 4. Build the frontend assets
npm run build
```

Then set up the database (next section) and run the migrations.

> [!WARNING]
> `composer setup` exists, but it always runs `key:generate` and `migrate --force`. Don't use it on an install that already has an app key or data. Regenerating the key logs everyone out and makes existing encrypted data unreadable.

### MySQL setup

1. Create an empty database, for example in phpMyAdmin or the MySQL client:

   ```sql
   CREATE DATABASE dave_tutorial CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Give it a dedicated user rather than `root` (pick your own strong password):

   ```sql
   CREATE USER 'dave_app'@'localhost' IDENTIFIED BY 'choose-a-strong-password';
   GRANT ALL PRIVILEGES ON dave_tutorial.* TO 'dave_app'@'localhost';
   ```

3. Put the connection details in `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dave_tutorial
   DB_USERNAME=dave_app
   DB_PASSWORD=choose-a-strong-password
   ```

4. Test the connection (read-only), then create the tables:

   ```sh
   php artisan db:show
   php artisan migrate
   ```

`migrate` creates Laravel's standard tables: `users`, `password_reset_tokens`, `sessions`, `cache` and `jobs`. Sessions and cache live in the database, so every page returns an error until migrations have run.

> [!CAUTION]
> `migrate:fresh`, `migrate:reset` and `db:wipe` delete all data. Never run them against a database you want to keep.

### Running the app

```sh
php artisan serve        # http://127.0.0.1:8000
npm run dev              # optional, in a second terminal: live reload while editing views/CSS/JS
```

Open <http://127.0.0.1:8000>, click **Register**, and you'll land on your dashboard.

## Configuration

All environment-specific settings live in `.env`, which Git ignores. [.env.example](.env.example) is a safe template with placeholders only. **Never commit real credentials.**

| Variable | Default | Purpose |
|---|---|---|
| `APP_NAME` | `Laravel` | Name shown in the header, sidebar and page titles. Change it to your site's name |
| `APP_ENV` / `APP_DEBUG` | `local` / `true` | Use `production` / `false` on a live server |
| `APP_URL` | `http://localhost` | Base URL used in generated links, including password-reset emails |
| `DB_*` | — | MySQL connection (see [MySQL setup](#mysql-setup)) |
| `SESSION_DRIVER` | `database` | Sessions are stored in the `sessions` table |
| `SESSION_LIFETIME` | `120` | Minutes of inactivity before a session expires |
| `MAIL_MAILER` | `log` | Local default: emails are written to `storage/logs/laravel.log` and **not delivered** |

Real mail delivery (SMTP or a provider) will be configured and verified in the password-recovery phase.

## Usage

**Create an account** at `/register`, or from the command line:

```sh
php artisan tinker
>>> App\Models\User::create(['name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'a-strong-password']);
```

The `User` model hashes the password automatically, so passwords are never stored as plain text.

**Log in** at `/login`. Wrong email and wrong password show the same message, so the form doesn't reveal which emails have accounts.

**Dashboard:** after logging in you'll see three cards: your profile, account security, and your workspace. The workspace shows an empty state until features are added. Use the sidebar (or the ☰ menu on mobile) and the account menu (top right) to move around or log out.

## Routes

| URI | Method | Name | Access | Purpose |
|---|---|---|---|---|
| `/` | GET | — | Everyone | Welcome page |
| `/register` | GET, POST | `register` | Guests | Create an account |
| `/login` | GET, POST | `login` | Guests | Log in |
| `/logout` | POST | `logout` | Logged in | Log out (CSRF protected, never GET) |
| `/dashboard` | GET | `dashboard` | Logged in | Personal dashboard |
| `/profile` | GET, PATCH | `profile.edit`, `profile.update` | Logged in | Profile settings |
| `/password` | PUT | `password.update` | Logged in | Change password *(verified in a later phase)* |
| `/forgot-password` | GET, POST | `password.request`, `password.email` | Guests | Request a reset link *(later phase)* |
| `/reset-password/{token}` | GET | `password.reset` | Guests | Show the new-password form *(later phase)* |
| `/reset-password` | POST | `password.store` | Guests | Save the new password *(later phase)* |

Guests who open a protected page are redirected to `/login`. Logged-in users who open `/login` or `/register` are sent to the dashboard. Run `php artisan route:list` for the full list.

## Project structure

Only the parts of the standard Laravel layout that this project adds or changes:

```text
app/
├── Http/Controllers/
│   ├── Auth/                    # Breeze auth controllers (login, register, password)
│   ├── DashboardController.php  # Passes the logged-in user to the dashboard
│   └── ProfileController.php
└── View/Components/             # AppLayout, GuestLayout (supports a "wide" card)
resources/
├── css/app.css                  # Tailwind entry point
├── scss/bootstrap.scss          # Chooses which Bootstrap components are compiled
├── js/
│   ├── app.js                   # Loads Bootstrap + Alpine
│   └── register-form.js         # Password strength and match logic
└── views/
    ├── layouts/                 # app (sidebar shell), navigation (sidebar), guest
    ├── components/              # card, empty-state, sidebar-link, user-avatar,
    │                            # password-input, dropdown, form inputs …
    ├── auth/                    # login, register, forgot/reset password
    ├── profile/                 # profile and password forms
    └── dashboard.blade.php
routes/
├── web.php                      # Home, dashboard, profile
└── auth.php                     # Authentication routes
tests/Feature/                   # Auth, registration, dashboard, profile tests
```

## Frontend

The interface is built with **Blade components**, **Tailwind CSS** for layout and styling, and **Alpine.js** for small interactions such as the menu, drawer and password toggles.

Reusable components for new pages:

| Component | Use it for |
|---|---|
| `<x-card title="…" description="…">` | A content panel, with optional `actions` and `footer` slots |
| `<x-empty-state title="…" description="…">` | A friendly "nothing here yet" message |
| `<x-sidebar-link :href :active>` | A sidebar navigation item (sets `aria-current`) |
| `<x-user-avatar :user size="sm\|md\|lg">` | The user's initials in a circle |
| `<x-password-input id name autocomplete>` | A password field with a show/hide button |

**Bootstrap 5.3** is also installed, compiled from Sass in [resources/scss/bootstrap.scss](resources/scss/bootstrap.scss):

- **Available:** components such as `btn`, `card`, `navbar`, `dropdown`, `modal`, `alert`, `badge`, `form-control`, `table`, the grid and `list-group`. Their JavaScript works through `data-bs-*` attributes, and `window.bootstrap` is available to scripts.
- **Not included:** Bootstrap's utility classes (`mt-4`, `d-flex` …), Reboot and the typography classes. They clash with Tailwind's classes of the same name, so use Tailwind for spacing, layout and text.

After changing which parts are included, run `npm run build`.

## Testing

```sh
php artisan test          # run the full suite
php artisan test --filter=DashboardTest   # run one test class
vendor/bin/pint --test    # check code style
npm run build             # confirm the production asset build works
```

Tests run against an **in-memory SQLite database** (see [phpunit.xml](phpunit.xml)), so they never touch your MySQL data.

| Test file | What it covers |
|---|---|
| `Auth/AuthenticationTest` | Valid/invalid login, validation, session regeneration, throttling, guest redirects, logout, CSRF |
| `Auth/RegistrationTest` | Sign-up, password hashing, mismatched/short passwords, duplicate email, kept input on errors |
| `DashboardTest` | Guest blocking, real user data only, HTML escaping, working links, POST logout, mobile controls, no extra queries |
| `ProfileTest` | Viewing and updating the profile |
| `Auth/PasswordResetTest`, `Auth/PasswordUpdateTest` | Breeze's tests for features to be verified in later phases |

## Security

What the app does:

- Passwords are hashed with bcrypt and never stored or logged in plain text.
- CSRF protection is on for every form.
- The session is regenerated on login and invalidated on logout.
- Login is rate-limited, and error messages don't reveal whether an account exists.
- Protected routes use the `auth` middleware; guest-only routes use `guest`.
- All user-supplied content is escaped by Blade.
- The `User` model has a mass-assignment allow-list.
- Secrets live only in `.env`, which Git ignores.

Passing tests don't prove an application is secure. Please report any vulnerability privately to the repository owner rather than in a public issue.

## Troubleshooting

| Problem | Cause and fix |
|---|---|
| `could not find driver`, or `openssl` missing | PHP isn't loading its ini. On MAMP, check `PHPRC` and open a new terminal |
| `SQLSTATE[HY000] [1045] Access denied` | Wrong `DB_USERNAME` or `DB_PASSWORD` in `.env` |
| `SQLSTATE[HY000] [1049] Unknown database` | Create the database (see [MySQL setup](#mysql-setup)) |
| `SQLSTATE[HY000] [2002]` | MySQL isn't running. Start it (e.g. in MAMP PRO) |
| HTTP 500 with `Table 'sessions' doesn't exist` | Run `php artisan migrate` |
| `Vite manifest not found` | Run `npm run build`, or keep `npm run dev` running |
| Changes to `.env` have no effect | Run `php artisan config:clear` |
| Styles look unchanged after editing | Re-run `npm run build`, or use `npm run dev` |
| Locked out after failed logins | Wait about a minute: the lock expires on its own |

## Deploying to production

This checklist will grow as features are added. At minimum:

- [ ] `APP_ENV=production` and `APP_DEBUG=false`
- [ ] A unique `APP_KEY`, generated once and kept safe
- [ ] Serve over HTTPS with `SESSION_SECURE_COOKIE=true`
- [ ] MySQL 8.0+ (or MariaDB 10.6+) with a dedicated, least-privilege database user
- [ ] A real mail provider configured, with delivery tested
- [ ] `composer install --no-dev --optimize-autoloader` and `npm run build`
- [ ] `php artisan migrate --force`, then `php artisan config:cache route:cache view:cache`
- [ ] Point the web server's document root at `public/`, and make `storage/` and `bootstrap/cache/` writable

## Roadmap

- [x] Environment setup and MySQL connection
- [x] Login, logout, registration and route protection
- [x] Responsive dashboard
- [ ] Forgot password and reset by email link
- [ ] Dedicated change-password page
- [ ] Production mail delivery
- [ ] Full production deployment guide

## Contributing

1. Create a branch: `git checkout -b feature/short-description`.
2. Make your change and add or update tests.
3. Run `php artisan test` and `vendor/bin/pint` and make sure both pass.
4. Commit with a clear message (e.g. `feat: add password reset page`) and open a pull request.

Project conventions are in [CLAUDE.md](CLAUDE.md).

## License

No license has been chosen for this project yet, so all rights are reserved by the owner. Laravel itself is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
