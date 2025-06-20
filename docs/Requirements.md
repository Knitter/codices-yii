# Codices

## General/Intro

`Codices` is a WEB based application, written in PHP 8.4+, HTML, CSS, and JavaScript, supported by SQLite database
engine. For UI, the main library is Bootstrap 5+.

The application provides a way to manage small, or private/ home-owned, libraries, keeping track of all the existing
books and their main metadata. Since it is a modern application, it not only manages physical books but also ebooks and
audiobooks. As most of the details about ebooks and audiobooks are the same as physical books, throughout `Codices`'
features, all three types of books are handle the same (same database tables, similar UI), with only a few differences
to handle the specificities of ebooks and audiobooks.

### Tech and Expected Code Practices

* MUST be supported by PHP8.4, Yii3, SQLite, HTML, CSS, JavaScript.
* SHOULD run on PHP-FPM with NGINX as frontend.
* CamelCase SHOULD be used in all code, including database columns.
* All code SHOULD be written in English.

## Main Features

* Offers a login feature with a recover password option.
* Manage books, ebooks, and audiobooks
* Provides three screens: one for books, one for ebooks, and one for audiobooks, where users can list and filter the
  various items.
* Provides other screens with similar features as the ones for books, ebooks, and audiobooks, but that allow managing
* authors' data, publishers' data, genres and collections.
* Provides a global search option that allows searching in all stored items except accounts.
* Provides a screen to list accounts and the necessary screens to manage accounts' details by system administrators and
  also for users to edit their own profiles.
* Offers a modern UI, featuring a collapsable sidebar menu to allow access to books, ebooks, audiobooks, authors,
  publishers, genres, series, collections, formats, accounts menus, a top bar with global search, notifications and
  profile access and logout options.

## Extra Features

* Access publicly available APIs that offer book details based on title, ISBN, authors, etc.
* Reads metadata in ebook files to extract ebook details; SHOULD read PDF, EPUB, and MOBI as the first supported
  formats.
* Imports book, ebook, and audiobook data from CSV files.
* Extracts book, ebook, and audiobook data to CSV, JSON, or HTML files. If exporting to HTML, includes cover images.

## Data Models and Database Tables

### Account Table

The `Account` table provides a way to store login and user information.
Since every other model belongs to an account (as it belongs to an user), all other tables will need a reference to the
owing account record.

```sql
CREATE TABLE account
(
    id        INTEGER PRIMARY KEY,
    username  TEXT    NOT NULL UNIQUE,
    email     TEXT    NOT NULL,
    name      TEXT    NOT NULL,
    active    INTEGER NOT NULL,
    password  TEXT    NOT NULL,
    createdOn INTEGER NOT NULL, -- timestamp
    updatedOn INTEGER NOT NULL, -- timestamp
    authKey   TEXT
);
``` 

### Publisher

The `Publisher` table contains basic information about publishers for the books stored in the application.

```sql
CREATE TABLE publisher
(
    id        INTEGER PRIMARY KEY,
    name      TEXT    NOT NULL,
    ownedById INTEGER NOT NULL, -- foreign key to account table
    summary   TEXT,
    website   TEXT,
    FOREIGN KEY (ownedById) REFERENCES account (id)
);
```

### Series

The `Series` table keeps track of any series of books a book, ebook, or audiobook belongs to.

```sql
CREATE TABLE series
(
    id         INTEGER PRIMARY KEY,
    name       TEXT    NOT NULL,
    ownedById  INTEGER NOT NULL, -- foreign key to account table
    completed  INTEGER NOT NULL,
    bookCount  INTEGER,
    ownedCount INTEGER,
    FOREIGN KEY (ownedById) REFERENCES account (id)
);
```

### Collection

The `Collection` table stores details about collections created by the user or by a publisher/seller (e,g,, HumbleBundle
collections).

```sql
CREATE TABLE collection
(
    id          INTEGER PRIMARY KEY,
    name        TEXT    NOT NULL,
    ownedById   INTEGER NOT NULL, -- foreign key to account table
    publishDate TEXT,
    publishYear INTEGER,
    description TEXT,
    FOREIGN KEY (ownedById) REFERENCES account (id)
);
```

### Author

The `Author` table keeps track of author's details.

```sql
CREATE TABLE author
(
    id        INTEGER PRIMARY KEY,
    name      TEXT    NOT NULL,
    ownedById INTEGER NOT NULL, -- foreign key to account table
    surname   TEXT,
    biography TEXT,
    website   TEXT,
    photo     TEXT,
    FOREIGN KEY (ownedById) REFERENCES account (id)
);
```

## Genre

In the `Genre` table, genres for existing books, ebooks, or audiobooks are stored.

```sql
CREATE TABLE genre
(
    id        INTEGER PRIMARY KEY,
    name      TEXT    NOT NULL,
    ownedById INTEGER NOT NULL, -- foreign key to account table
    FOREIGN KEY (ownedById) REFERENCES account (id)
);
```

### Format

The `Format` table stores book formats like Paperback or Hardcover, ebook formats like PDF, EPUB, or MOBI, and audiobook
formats like MP3 or MP4.

```sql
CREATE TABLE format
(
    type      TEXT    NOT NULL,
    name      TEXT    NOT NULL,
    ownedById INTEGER NOT NULL, -- foreign key to account table
    PRIMARY KEY (type, name, ownedById),
    FOREIGN KEY (ownedById) REFERENCES account (id)
);
```

### Item

The `Item` table stores details about all existing books, ebooks, or audiobooks.

```sql
-- A paper book, ebook or audio book managed by Codiges-fx
CREATE TABLE item
(
    id            INTEGER PRIMARY KEY,
    title         TEXT    NOT NULL,
    ownedById     INTEGER NOT NULL, -- foreign key to account table
    type          TEXT    NOT NULL, -- "ebook", "audio", "paper"
    translated    INTEGER NOT NULL,
    read          INTEGER NOT NULL,
    copies        INTEGER NOT NULL,
    subtitle      TEXT,
    originalTitle TEXT,
    plot          TEXT,
    isbn          TEXT,
    format        TEXT,
    pageCount     INTEGER,
    publishDate   TEXT,
    publishYear   INTEGER,
    addedOn       TEXT,
    language      TEXT,
    edition       TEXT,
    volume        TEXT,
    rating        INTEGER,
    url           TEXT,
    review        TEXT,
    cover         TEXT,
    filename      TEXT,
    fileLocation  TEXT,
    narrator      TEXT,
    bitrate       TEXT,
    boughtFrom    TEXT,
    duration      INTEGER,          -- in minutes
    sizeBytes     INTEGER,          -- in KB
    orderInSeries INTEGER,
    publisherId   INTEGER,
    seriesId      INTEGER,
    collectionId  INTEGER,
    duplicatesId  INTEGER,
    FOREIGN KEY (ownedById) REFERENCES account (id),
    FOREIGN KEY (publisherId) REFERENCES publisher (id),
    FOREIGN KEY (seriesId) REFERENCES series (id),
    FOREIGN KEY (collectionId) REFERENCES collection (id),
    FOREIGN KEY (duplicatesId) REFERENCES item (id)
);
```

### ItemAuthor

This table results from the `Many-to-Many` relationship between `Item` and `Author` tables.

```sql
CREATE TABLE item_author
(
    itemId   INTEGER NOT NULL,
    authorId INTEGER NOT NULL,
    PRIMARY KEY (itemId, authorId),
    FOREIGN KEY (itemId) REFERENCES item (id),
    FOREIGN KEY (authorId) REFERENCES author (id)
);
```

### ItemGenre

This table results from the `Many-to-Many` relationship between `Item` and `Genre` tables.

```sql
CREATE TABLE item_genre
(
    itemId  INTEGER NOT NULL,
    genreId INTEGER NOT NULL,
    PRIMARY KEY (itemId, genreId),
    FOREIGN KEY (itemId) REFERENCES item (id),
    FOREIGN KEY (genreId) REFERENCES genre (id)
);
```
