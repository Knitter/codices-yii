# CODICES

Codices is a web-based book, ebook and audiobook management application, providing a simple and intuitive interface for
managing private collections (or tiny libraries, as it doesn't manage users, loans, rentals, memberships, etc.).

If you are looking for a solution to manage your personal library, Codices is the right choice.

## Project

It is written in PHP, supported by the Yii framework and SQLite as its storage engine.

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

- [ ] Project cleanup, refactoring to remove Yii3 code and documentation
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
- SQLite
- Composer

### Development Tools/Requirements

- Vagrant + VirtualBox

### Project Structure

```
[ROOT]
    |-- dev/                    Development-related files
      |-- vagrant/              Vagrant provisioning scripts and development VM server configuration files
    |-- runtime/                Runtime-related files (cache, test emails, etc.) and logs
    |-- src/                    Application source code
      |-- app/                  Main application source code (PHP classes and views)
      |-- config/               Application configuration files
      |-- migrations/           Database migrations
      |-- resources/            JS and CSS assets, translations and other static, non-code resources
    |-- tests/                  Application tests
    |-- vendor/                 Vendor dependencies
    |-- wwwroot/                Public-facing web root
```
