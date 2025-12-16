# CODICES

Codices is a web-based book, ebook and audiobook management application, providing a simple and intuitive interface for
managing private collections (or tiny libraries, as it doesn't manage users, loans, rentals, memberships, etc.).

If you are looking for a solution to manage your personal library, Codices is the right choice.

## Project

Codices is built with PHP and the Yii framework. The application currently runs on Yii 2 while keeping some Yii 3-style components and conventions (see Code Organization below). The target storage engine is SQLite (self‑hosted and simple to set up), but the database layer and migrations are still being finalized during the ongoing cleanup.

### Features

- Offers features to manage books, ebooks and audiobooks
    - Register and manage books, ebooks and audiobooks
    - Get metadata by searching online with ISBN
    - Manage book covers and book files
    - User management to allow multiple users to access the same library and own their own books
    - Simple loan management/tracking
    - Read ebook metadata from PDF, EPUB and MOBI files
    - Register and manage support data (authors, genres, publishers, book series, etc.)
- Export books to JSON, CSV and HTML templates
- Import books from JSON, CSV and supported managers (planned)
- Supports multiple languages (English, Portuguese, more if someone wants to contribute)
- Web-based, self-hosted; desktop and mobile planned
- Open source

### Roadmap

- [ ] Project cleanup, refactoring to remove Yii3 code and documentation (hybrid state)
- [ ] Improve project structure/code organization
- [ ] Main Codices features (web-based, Yii2)
    - [ ] User management
    - [ ] Support data management
    - [ ] Book management
    - [ ] eBook management
    - [ ] Audiobook management
    - [ ] Get data from online sources
    - [ ] Basic Export/import formats (JSON, CSV)
    - [ ] Export based on HTML templates
    - [ ] Loan management
    - [ ] Export/import from other managers
- [ ] Desktop app
- [ ] Review project goals and roadmap
- [ ] Stability, quality and performance improvements
- [ ] API for external integrations
- [ ] UI/UX review
- [ ] Mobile app

## Development

### Requirements

- PHP 8.4+
- Yii 2.0.53+
- Composer
- Database: SQLite (planned default). Other engines may be supported later.

### Development Tools/Requirements

- Vagrant + VirtualBox (optional; a Vagrant configuration is provided under `dev/vagrant`)

### Getting Started (Local)

1) Install dependencies

```
composer install
```

2) Create a local environment file (optional but recommended)

Create a `.env` file in the project root to control environment flags used by `wwwroot/index.php`:

```
YII_DEBUG=1
YII_ENV=dev
```

3) Run the app locally using PHP’s built‑in server

From the project root:

```
php -S 127.0.0.1:8080 -t wwwroot
```

Then open http://127.0.0.1:8080 in your browser.

### Project Structure

```
[ROOT]
    |-- dev/                    Development-related files
      |-- vagrant/              Vagrant provisioning scripts and development VM server configuration files
    |-- runtime/                Runtime-related files (cache, test emails, etc.) and logs
    |-- src/                    Application source code
      |-- app/                  Main application source code (PHP classes and views)
        |-- Asset/              Asset bundles (e.g., CodicesAsset)
        |-- Controller/         Controllers (namespace: Codices\Controller)
        |-- Model/              ActiveRecord models and pivots (namespace: Codices\Model)
        |-- View/               View files
          |-- Layout/           Layout templates (aliased as @layout)
          |-- UI/               Controller views (aliased as @views)
      |-- config/               Application configuration files
        |-- web/                Web application configuration
        |-- common/             Shared configuration (aliases/bootstrap/components)
      |-- migrations/           Database migrations (Yii 3 style; see notes below)
      |-- resources/            JS/CSS assets, translations and other static, non‑code resources
    |-- tests/                  Application tests
    |-- vendor/                 Vendor dependencies
    |-- wwwroot/                Public-facing web root
```

### Code Organization

Codices follows MVC with a few intentional deviations from a typical Yii 2 application layout:

- All application code is inside `src/app` (both web and any potential console code live here).
- Controller namespace is `Codices\Controller` (see `src/config/web/app.php`).
- Views are not under the default `views` folder. Instead:
  - Layouts live in `src/app/View/Layout` and are referenced via the `@layout` alias.
  - Controller view files live in `src/app/View/UI` and are referenced via the `@views` alias.
- Namespaces are capitalized and singular, e.g., `Controller` instead of `controllers`.
- Action methods do not use the `actionXxx` prefix; they are named in camelCase.
- Asset bundles live in `src/app/Asset` (e.g., `CodicesAsset`).
- Migrations live under `src/migrations` and currently follow Yii 3 style (using `Yiisoft\Db\Migration`).

Aliasing and configuration highlights:

- Entry script: `wwwroot/index.php` (loads Composer, Dotenv, Yii 2, and `src/config/aliases.php`).
- Key aliases (see `src/config/aliases.php`): `@views`, `@layout`, `@assets`, `@resources`, `@messages`.
- Web app config: `src/config/web/app.php` (sets `controllerNamespace`, `defaultRoute`, etc.).

Database and migrations:

- Database component wiring is being completed as part of the cleanup. Migrations are present under `src/migrations` and use `Yiisoft\Db\Migration` (Yii 3 style). Migration execution tooling will be documented once finalized.

Testing:

- Codeception is configured (see `codeception.yml`). Run tests with:

```
vendor\bin\codecept run
```

- A `phpunit.xml.dist` file exists but points to a legacy path; the main test runner is Codeception for now.

## License

```
MIT License

Copyright (c) 2025 Sérgio Lopes

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
