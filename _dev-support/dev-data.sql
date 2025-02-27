-- A set of example data created from a real library, real books and details
-- It is used for demo/testing only.
--

-- Default account, would be created during first time the application run or by user request
INSERT INTO account (username, email, name, active, password, createdAt, updatedAt)
VALUES ('codices', 'codices@placeholder.moc', 'Codices', 1, '12345678', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- List of publishers (mainly paper books)
INSERT INTO publisher(name, ownedById, website)
VALUES ('Orion', 1, 'https://www.orionbooks.co.uk/'),
       ('Orbit', 1, 'https://www.orbitbooks.net/'),
       ('Editorial Presença', 1, 'https://www.presenca.pt/'),
       ('Bloomsbury', 1, 'https://www.bloomsbury.com'),
       ('Porto Editora', 1, 'https://www.portoeditora.pt/'),
       ('Harper Collins', 1, 'https://www.harpercollins.com/'),
       ('Harper Voyager', 1, 'https://harpervoyagerbooks.co.uk/'),
       ('Pan Macmillan', 1, 'https://www.panmacmillan.com/'),
       ('ASA', 1, 'https://www.leyaeducacao.com/'),
       ('Penguin', 1, 'https://www.penguin.com/'),
       ('Manning', 1, 'https://www.manning.com/'),
       ('TOR Publishing Group', 1, 'https://us.macmillan.com/torpublishinggroup/');

INSERT INTO series(id, name, ownedById, completed, bookCount, ownedCount)
VALUES (1, 'The Saga of the Shadows', 1, 0, 0, 0),
       (2, 'Foundation', 1, 1, 0, 0),
       (3, 'Ciclo dos Demónios', 1, 0, 0, 0),
       (4, 'The Lightship Chronicles', 1, 0, 0, 0),
       (5, 'The Riftwar Saga', 1, 1, 0, 0),
       (6, 'The Empire Trilogy', 1, 1, 3, 3),
       (7, 'Krondor''s Sons', 1, 0, 0, 0),
       (8, 'The Serpentwar Saga', 1, 0, 0, 0),
       (9, 'Chaoswar Saga', 1, 0, 0, 0),
       (10, 'The Riftwar Legacy', 1, 0, 0, 0),
       (11, 'Steelhaven', 1, 0, 0, 0),
       (12, 'Saga A Espada da Verdade', 1, 0, 0, 0);

INSERT INTO collection (id, name, ownedById)
VALUES (1, 'Reading List', 1),
       (2, 'Favorite', 1),
       (3, 'Steven Erikson''s Malazan Book of the Fallen', 1),
       (4, 'Math for Programmers 2023', 1);

INSERT INTO author(id, name, ownedById, surname)
VALUES (1, 'Scott', 1, 'Adams'),
       (2, 'Kevin J.', 1, 'Anderson'),
       (3, 'Isaac', 1, 'Asimov'),
       (4, 'Petter V.', 1, 'Brett'),
       (5, 'Dave', 1, 'Bara'),
       (6, 'Raymond E.', 1, 'Feist'),
       (7, 'Forsyth', 1, 'Frederick'),
       (8, 'Richard', 1, 'Ford'),
       (9, 'Gillian', 1, 'Flynn'),
       (10, 'Terry', 1, 'Goodkind'),
       (11, 'Paul', 1, 'Hoffman');

INSERT INTO genre(id, name, ownedById)
VALUES (1, 'Literary Fiction', 1),
       (2, 'Mystery', 1),
       (3, 'Thriller', 1),
       (4, 'Horror', 1),
       (5, 'Historical', 1),
       (6, 'Romance', 1),
       (7, 'Science Fiction', 1),
       (8, 'Fantasy', 1),
       (9, 'Historical Fiction', 1),
       (10, 'Action & Adventure', 1),
       (11, 'Humor', 1),
       (12, 'Graphic Novel', 1),
       (13, 'Short Story', 1),
       (14, 'Young Adult', 1),
       (15, 'Children''s', 1),
       (16, 'Autobiography', 1),
       (17, 'Biography', 1),
       (18, 'Food & Drink', 1),
       (19, 'Art & Photography', 1),
       (20, 'Self-help', 1),
       (21, 'Travel', 1),
       (22, 'Essays', 1),
       (23, 'Guide / How-to', 1),
       (24, 'Religion & Spirituality', 1),
       (25, 'Humanities & Social Sciences', 1),
       (26, 'Science & Technology', 1);

INSERT INTO format(type, name, ownedById)
VALUES ('paper', 'Paperback', 1),
       ('paper', 'Hardcover', 1),
       ('paper', 'B-format', 1),
       ('paper', 'Mass-market', 1),
       ('ebook', 'PDF', 1),
       ('ebook', 'epub', 1),
       ('ebook', 'mobi', 1),
       ('audio', 'MP3', 1),
       ('audio', 'AAX', 1),
       ('audio', 'M4A/M4B', 1),
       ('audio', 'AAC', 1),
       ('audio', 'M4P', 1),
       ('audio', 'OGG', 1),
       ('audio', 'FLAC', 1);

INSERT INTO item (id, title, subtitle, ownedById, type, translated, read, copies, isbn, language, orderInSeries,
                  duplicatesId, seriesId, format, addedOn)
VALUES (1, 'Liberdade é só mais uma palavra para as pessoas descobrirem que és incompetente', NULL, 1, 'paper', 1, 0, 1,
        '9789892315997', 'Portuguese', NULL, NULL, NULL, 'Paperback', CURRENT_TIMESTAMP),
       (2, 'The Dark Between the Stars', NULL, 1, 'paper', 0, 0, 1, '9781840836784', 'English', 1, NULL, 1, 'Paperback',
        CURRENT_TIMESTAMP),
       (3, 'Foundation', NULL, 1, 'paper', 1, 0, 1, '9780586010808', 'English', 1, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (4, 'Second Foundation', NULL, 1, 'paper', 1, 0, 1, '9780586017135', 'English', 3, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (5, 'Prelude to Foundation', NULL, 1, 'paper', 1, 0, 1, '9780586071113', 'English', 0, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (6, 'Foundation & Earth', NULL, 1, 'paper', 1, 0, 1, '9780586071106', 'English', 5, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (7, 'Foundation''s Edge', NULL, 1, 'paper', 1, 0, 1, '9780586058398', 'English', 4, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (8, 'Foundation and Empire', NULL, 1, 'paper', 1, 0, 1, '9780586013557', 'English', 2, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (9, 'Homem Pintado', NULL, 1, 'paper', 1, 0, 1, '9789895576677', 'Portuguese', 1, NULL, 3, 'Paperback',
        CURRENT_TIMESTAMP),
       (10, 'Lança  do Deserto', NULL, 1, 'paper', 1, 0, 1, '9789895577156', 'Portuguese', 2, NULL, 3, 'Paperback',
        CURRENT_TIMESTAMP),
       (11, 'A Guerra Diurna', NULL, 1, 'paper', 1, 0, 1, '9789892324494', 'Portuguese', 3, NULL, 3, 'Paperback',
        CURRENT_TIMESTAMP),
       (12, 'O Grande Bazar e outras histórias', NULL, 1, 'paper', 1, 0, 1, '9789892331362', 'Portuguese', NULL, NULL,
        NULL, 'Paperback', CURRENT_TIMESTAMP),
       (13, 'O Trono dos Crânios', NULL, 1, 'paper', 1, 0, 1, '9789892334516', 'Portuguese', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (14, 'Impulse', NULL, 1, 'paper', 1, 0, 1, '9780756410667', 'English', 1, NULL, 4, 'Paperback',
        CURRENT_TIMESTAMP),
       (15, 'Starbound', NULL, 1, 'paper', 1, 0, 1, '9781473616110', 'English', 2, NULL, 4, 'Paperback',
        CURRENT_TIMESTAMP),
       (16, 'Magician', NULL, 1, 'paper', 1, 0, 1, '9780586217832', 'English', 1, NULL, 5, 'Paperback',
        CURRENT_TIMESTAMP),
       (17, 'Silverthorn', NULL, 1, 'paper', 1, 0, 1, '9780007229420', 'English', 2, NULL, 5, 'Paperback',
        CURRENT_TIMESTAMP),
       (18, 'A Darkness at Sethanon', NULL, 1, 'paper', 1, 0, 1, '9780007229437', 'English', 3, NULL, 5, 'Paperback',
        CURRENT_TIMESTAMP),
       (19, 'Daughter of the Empire', NULL, 1, 'paper', 1, 0, 1, '9780586074817', 'English', 1, NULL, 6, 'Paperback',
        CURRENT_TIMESTAMP),
       (20, 'Servant of the Empire', NULL, 1, 'paper', 1, 0, 1, '9780586203811', 'English', 2, NULL, 6, 'Paperback',
        CURRENT_TIMESTAMP),
       (21, 'Mistress of the Empire	', NULL, 1, 'paper', 1, 0, 1, '9780586203798', 'English', 3, NULL, 6,
        'Paperback', CURRENT_TIMESTAMP),
       (22, 'Prince of the Blood', NULL, 1, 'paper', 1, 0, 1, '9780007176168', 'English', 1, NULL, 7, 'Paperback',
        CURRENT_TIMESTAMP),
       (23, 'The King''s Buccaneer', NULL, 1, 'paper', 1, 0, 1, '9780586203224', 'English', 2, NULL, 7, 'Paperback',
        CURRENT_TIMESTAMP),
       (24, 'Shadow of a Dark Queen', NULL, 1, 'paper', 1, 0, 1, '9780006480266', 'English', 1, NULL, 8, 'Paperback',
        CURRENT_TIMESTAMP),
       (25, 'Rise of a Merchant Prince', NULL, 1, 'paper', 1, 0, 1, '9780006497011', 'English', 2, NULL, 8,
        'Paperback', CURRENT_TIMESTAMP),
       (26, 'Rage of a Demon King', NULL, 1, 'paper', 1, 0, 1, '9780006482987', 'English', 3, NULL, 8, 'Paperback',
        CURRENT_TIMESTAMP),
       (27, 'Shards of a Broken Crown', NULL, 1, 'paper', 1, 0, 1, '9780006483489', 'English', 4, NULL, 8, 'Paperback',
        CURRENT_TIMESTAMP),
       (28, 'Magician''s End', NULL, 1, 'paper', 1, 0, 1, '9780007264803', 'English', NULL, NULL, 9, 'Paperback',
        CURRENT_TIMESTAMP),
       (29, 'At the Gates of Darkness', NULL, 1, 'paper', 1, 0, 1, '9780007264728', 'English', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (30, 'Rides a Dread Legion', NULL, 1, 'paper', 1, 0, 1, '9780007342587', 'English', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (31, 'Krondor: The assassins', NULL, 1, 'paper', 1, 0, 1, '9780008311261', 'English', NULL, NULL, 10,
        'Paperback', CURRENT_TIMESTAMP),
       (32, 'The Kill List', NULL, 1, 'paper', 1, 0, 1, '9780552169486', 'English', NULL, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (33, 'The Shatered Crown', NULL, 1, 'paper', 1, 0, 1, '9780755394074', 'English', 2, NULL, 11, 'Paperback',
        CURRENT_TIMESTAMP),
       (34, 'Herald of the Storm', NULL, 1, 'paper', 1, 0, 1, '9781472203922', 'English', 1, NULL, 11, 'Paperback',
        CURRENT_TIMESTAMP),
       (35, 'Lord of Ashes', NULL, 1, 'paper', 1, 0, 1, '9780755394104', 'English', 3, NULL, 11, 'Paperback',
        CURRENT_TIMESTAMP),
       (36, 'Gone Girl', NULL, 1, 'paper', 1, 0, 1, '9780553419085', 'English', NULL, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (37, 'Em Parte Incerta', NULL, 1, 'paper', 1, 0, 1, '9799722525572', 'Portuguese', NULL, 36, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (38, 'Primeira Regra dos Feiticeiros, Parte I', NULL, 1, 'paper', 1, 0, 1, '9789720046840', 'Portuguese', 1,
        NULL, 12, 'Paperback', CURRENT_TIMESTAMP), --	Arco 1: Darken Rahl
       (39, 'A Primeira Regra dos Feiticeiros, Parte  II', NULL, 1, 'paper', 1, 0, 1, '9789720046970', 'Portuguese', 2,
        NULL, 12, 'Paperback', CURRENT_TIMESTAMP),
       (40, 'A Pedra das Lágrimas, Parte I', NULL, 1, 'paper', 1, 0, 1, '9789720047489', 'Portuguese', 3, NULL, 12,
        'Paperback', CURRENT_TIMESTAMP),
       (41, 'A Pedra das Lágrimas, Parte II', NULL, 1, 'paper', 1, 0, 1, '9789220047687', 'Portuguese', 5, NULL, 12,
        'Paperback', CURRENT_TIMESTAMP),
       (42, 'O Sangue da Virtude', NULL, 1, 'paper', 1, 0, 1, '9789720047922', 'Portuguese', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (43, 'The Left Hand of Good', NULL, 1, 'paper', 1, 0, 1, '9780141042374', 'English', 1, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (44, 'The Last Four Things', NULL, 1, 'paper', 1, 0, 1, '9780718155209', 'English', 2, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (45, 'The Beating o His Wings', NULL, 1, 'paper', 1, 0, 1, '9780141042404', 'English', 3, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP);

INSERT INTO item_author(ItemId, authorId)
VALUES (1, 1),
       (2, 2),
       (3, 3),
       (4, 3),
       (5, 3),
       (6, 3),
       (7, 3),
       (8, 3),
       (9, 4),
       (10, 4),
       (11, 4),
       (12, 4),
       (13, 4),
       (14, 5),
       (15, 5),
       (16, 6),
       (17, 6),
       (18, 6),
       (19, 6),
       (20, 6),
       (21, 6),
       (22, 6),
       (23, 6),
       (24, 6),
       (25, 6),
       (26, 6),
       (27, 6),
       (28, 6),
       (29, 6),
       (30, 6),
       (31, 6),
       (32, 7),
       (33, 8),
       (34, 8),
       (35, 8),
       (36, 9),
       (37, 9),
       (38, 10),
       (39, 10),
       (40, 10),
       (41, 10),
       (42, 10),
       (43, 11),
       (44, 11),
       (45, 11);

INSERT INTO item_genre(itemId, genreId)
VALUES (1, 11),
       (2, 7),
       (3, 7),
       (4, 7),
       (5, 7),
       (6, 7),
       (7, 7),
       (8, 7),
       (9, 8),
       (10, 8),
       (11, 8),
       (12, 8),
       (13, 8),
       (14, 7),
       (15, 7),
       (16, 8),
       (17, 8),
       (18, 8),
       (19, 8),
       (20, 8),
       (21, 8),
       (22, 8),
       (23, 8),
       (24, 8),
       (25, 8),
       (26, 8),
       (27, 8),
       (28, 8),
       (29, 8),
       (30, 8),
       (31, 8),
       (33, 8),
       (34, 8),
       (35, 8),
       (36, 3),
       (37, 3),
       (38, 8),
       (39, 8),
       (40, 8),
       (41, 8),
       (42, 8),
       (43, 8),
       (44, 8),
       (45, 8);

//-- A set of example data created from a real library, real books and details
-- It is used for demo/testing only.
--

-- Default account, would be created during first time the application run or by user request
INSERT INTO account (username, email, name, active, password, createdAt, updatedAt)
VALUES ('codices', 'codices@placeholder.moc', 'Codices', 1, '12345678', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- List of publishers (mainly paper books)
INSERT INTO publisher(name, ownedById, website)
VALUES ('Orion', 1, 'https://www.orionbooks.co.uk/'),
       ('Orbit', 1, 'https://www.orbitbooks.net/'),
       ('Editorial Presença', 1, 'https://www.presenca.pt/'),
       ('Bloomsbury', 1, 'https://www.bloomsbury.com'),
       ('Porto Editora', 1, 'https://www.portoeditora.pt/'),
       ('Harper Collins', 1, 'https://www.harpercollins.com/'),
       ('Harper Voyager', 1, 'https://harpervoyagerbooks.co.uk/'),
       ('Pan Macmillan', 1, 'https://www.panmacmillan.com/'),
       ('ASA', 1, 'https://www.leyaeducacao.com/'),
       ('Penguin', 1, 'https://www.penguin.com/'),
       ('Manning', 1, 'https://www.manning.com/'),
       ('TOR Publishing Group', 1, 'https://us.macmillan.com/torpublishinggroup/');

INSERT INTO series(id, name, ownedById, completed, bookCount, ownedCount)
VALUES (1, 'The Saga of the Shadows', 1, 0, 0, 0),
       (2, 'Foundation', 1, 1, 0, 0),
       (3, 'Ciclo dos Demónios', 1, 0, 0, 0),
       (4, 'The Lightship Chronicles', 1, 0, 0, 0),
       (5, 'The Riftwar Saga', 1, 1, 0, 0),
       (6, 'The Empire Trilogy', 1, 1, 3, 3),
       (7, 'Krondor''s Sons', 1, 0, 0, 0),
       (8, 'The Serpentwar Saga', 1, 0, 0, 0),
       (9, 'Chaoswar Saga', 1, 0, 0, 0),
       (10, 'The Riftwar Legacy', 1, 0, 0, 0),
       (11, 'Steelhaven', 1, 0, 0, 0),
       (12, 'Saga A Espada da Verdade', 1, 0, 0, 0);

INSERT INTO collection (id, name, ownedById)
VALUES (1, 'Reading List', 1),
       (2, 'Favorite', 1),
       (3, 'Steven Erikson''s Malazan Book of the Fallen', 1),
       (4, 'Math for Programmers 2023', 1);

INSERT INTO author(id, name, ownedById, surname)
VALUES (1, 'Scott', 1, 'Adams'),
       (2, 'Kevin J.', 1, 'Anderson'),
       (3, 'Isaac', 1, 'Asimov'),
       (4, 'Petter V.', 1, 'Brett'),
       (5, 'Dave', 1, 'Bara'),
       (6, 'Raymond E.', 1, 'Feist'),
       (7, 'Forsyth', 1, 'Frederick'),
       (8, 'Richard', 1, 'Ford'),
       (9, 'Gillian', 1, 'Flynn'),
       (10, 'Terry', 1, 'Goodkind'),
       (11, 'Paul', 1, 'Hoffman');

INSERT INTO genre(id, name, ownedById)
VALUES (1, 'Literary Fiction', 1),
       (2, 'Mystery', 1),
       (3, 'Thriller', 1),
       (4, 'Horror', 1),
       (5, 'Historical', 1),
       (6, 'Romance', 1),
       (7, 'Science Fiction', 1),
       (8, 'Fantasy', 1),
       (9, 'Historical Fiction', 1),
       (10, 'Action & Adventure', 1),
       (11, 'Humor', 1),
       (12, 'Graphic Novel', 1),
       (13, 'Short Story', 1),
       (14, 'Young Adult', 1),
       (15, 'Children''s', 1),
       (16, 'Autobiography', 1),
       (17, 'Biography', 1),
       (18, 'Food & Drink', 1),
       (19, 'Art & Photography', 1),
       (20, 'Self-help', 1),
       (21, 'Travel', 1),
       (22, 'Essays', 1),
       (23, 'Guide / How-to', 1),
       (24, 'Religion & Spirituality', 1),
       (25, 'Humanities & Social Sciences', 1),
       (26, 'Science & Technology', 1);

INSERT INTO format(type, name, ownedById)
VALUES ('paper', 'Paperback', 1),
       ('paper', 'Hardcover', 1),
       ('paper', 'B-format', 1),
       ('paper', 'Mass-market', 1),
       ('ebook', 'PDF', 1),
       ('ebook', 'epub', 1),
       ('ebook', 'mobi', 1),
       ('audio', 'MP3', 1),
       ('audio', 'AAX', 1),
       ('audio', 'M4A/M4B', 1),
       ('audio', 'AAC', 1),
       ('audio', 'M4P', 1),
       ('audio', 'OGG', 1),
       ('audio', 'FLAC', 1);

INSERT INTO item (id, title, subtitle, ownedById, type, translated, read, copies, isbn, language, orderInSeries,
                  duplicatesId, seriesId, format, addedOn)
VALUES (1, 'Liberdade é só mais uma palavra para as pessoas descobrirem que és incompetente', NULL, 1, 'paper', 1, 0, 1,
        '9789892315997', 'Portuguese', NULL, NULL, NULL, 'Paperback', CURRENT_TIMESTAMP),
       (2, 'The Dark Between the Stars', NULL, 1, 'paper', 0, 0, 1, '9781840836784', 'English', 1, NULL, 1, 'Paperback',
        CURRENT_TIMESTAMP),
       (3, 'Foundation', NULL, 1, 'paper', 1, 0, 1, '9780586010808', 'English', 1, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (4, 'Second Foundation', NULL, 1, 'paper', 1, 0, 1, '9780586017135', 'English', 3, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (5, 'Prelude to Foundation', NULL, 1, 'paper', 1, 0, 1, '9780586071113', 'English', 0, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (6, 'Foundation & Earth', NULL, 1, 'paper', 1, 0, 1, '9780586071106', 'English', 5, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (7, 'Foundation''s Edge', NULL, 1, 'paper', 1, 0, 1, '9780586058398', 'English', 4, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (8, 'Foundation and Empire', NULL, 1, 'paper', 1, 0, 1, '9780586013557', 'English', 2, NULL, 2, 'Paperback',
        CURRENT_TIMESTAMP),
       (9, 'Homem Pintado', NULL, 1, 'paper', 1, 0, 1, '9789895576677', 'Portuguese', 1, NULL, 3, 'Paperback',
        CURRENT_TIMESTAMP),
       (10, 'Lança  do Deserto', NULL, 1, 'paper', 1, 0, 1, '9789895577156', 'Portuguese', 2, NULL, 3, 'Paperback',
        CURRENT_TIMESTAMP),
       (11, 'A Guerra Diurna', NULL, 1, 'paper', 1, 0, 1, '9789892324494', 'Portuguese', 3, NULL, 3, 'Paperback',
        CURRENT_TIMESTAMP),
       (12, 'O Grande Bazar e outras histórias', NULL, 1, 'paper', 1, 0, 1, '9789892331362', 'Portuguese', NULL, NULL,
        NULL, 'Paperback', CURRENT_TIMESTAMP),
       (13, 'O Trono dos Crânios', NULL, 1, 'paper', 1, 0, 1, '9789892334516', 'Portuguese', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (14, 'Impulse', NULL, 1, 'paper', 1, 0, 1, '9780756410667', 'English', 1, NULL, 4, 'Paperback',
        CURRENT_TIMESTAMP),
       (15, 'Starbound', NULL, 1, 'paper', 1, 0, 1, '9781473616110', 'English', 2, NULL, 4, 'Paperback',
        CURRENT_TIMESTAMP),
       (16, 'Magician', NULL, 1, 'paper', 1, 0, 1, '9780586217832', 'English', 1, NULL, 5, 'Paperback',
        CURRENT_TIMESTAMP),
       (17, 'Silverthorn', NULL, 1, 'paper', 1, 0, 1, '9780007229420', 'English', 2, NULL, 5, 'Paperback',
        CURRENT_TIMESTAMP),
       (18, 'A Darkness at Sethanon', NULL, 1, 'paper', 1, 0, 1, '9780007229437', 'English', 3, NULL, 5, 'Paperback',
        CURRENT_TIMESTAMP),
       (19, 'Daughter of the Empire', NULL, 1, 'paper', 1, 0, 1, '9780586074817', 'English', 1, NULL, 6, 'Paperback',
        CURRENT_TIMESTAMP),
       (20, 'Servant of the Empire', NULL, 1, 'paper', 1, 0, 1, '9780586203811', 'English', 2, NULL, 6, 'Paperback',
        CURRENT_TIMESTAMP),
       (21, 'Mistress of the Empire	', NULL, 1, 'paper', 1, 0, 1, '9780586203798', 'English', 3, NULL, 6,
        'Paperback', CURRENT_TIMESTAMP),
       (22, 'Prince of the Blood', NULL, 1, 'paper', 1, 0, 1, '9780007176168', 'English', 1, NULL, 7, 'Paperback',
        CURRENT_TIMESTAMP),
       (23, 'The King''s Buccaneer', NULL, 1, 'paper', 1, 0, 1, '9780586203224', 'English', 2, NULL, 7, 'Paperback',
        CURRENT_TIMESTAMP),
       (24, 'Shadow of a Dark Queen', NULL, 1, 'paper', 1, 0, 1, '9780006480266', 'English', 1, NULL, 8, 'Paperback',
        CURRENT_TIMESTAMP),
       (25, 'Rise of a Merchant Prince', NULL, 1, 'paper', 1, 0, 1, '9780006497011', 'English', 2, NULL, 8,
        'Paperback', CURRENT_TIMESTAMP),
       (26, 'Rage of a Demon King', NULL, 1, 'paper', 1, 0, 1, '9780006482987', 'English', 3, NULL, 8, 'Paperback',
        CURRENT_TIMESTAMP),
       (27, 'Shards of a Broken Crown', NULL, 1, 'paper', 1, 0, 1, '9780006483489', 'English', 4, NULL, 8, 'Paperback',
        CURRENT_TIMESTAMP),
       (28, 'Magician''s End', NULL, 1, 'paper', 1, 0, 1, '9780007264803', 'English', NULL, NULL, 9, 'Paperback',
        CURRENT_TIMESTAMP),
       (29, 'At the Gates of Darkness', NULL, 1, 'paper', 1, 0, 1, '9780007264728', 'English', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (30, 'Rides a Dread Legion', NULL, 1, 'paper', 1, 0, 1, '9780007342587', 'English', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (31, 'Krondor: The assassins', NULL, 1, 'paper', 1, 0, 1, '9780008311261', 'English', NULL, NULL, 10,
        'Paperback', CURRENT_TIMESTAMP),
       (32, 'The Kill List', NULL, 1, 'paper', 1, 0, 1, '9780552169486', 'English', NULL, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (33, 'The Shatered Crown', NULL, 1, 'paper', 1, 0, 1, '9780755394074', 'English', 2, NULL, 11, 'Paperback',
        CURRENT_TIMESTAMP),
       (34, 'Herald of the Storm', NULL, 1, 'paper', 1, 0, 1, '9781472203922', 'English', 1, NULL, 11, 'Paperback',
        CURRENT_TIMESTAMP),
       (35, 'Lord of Ashes', NULL, 1, 'paper', 1, 0, 1, '9780755394104', 'English', 3, NULL, 11, 'Paperback',
        CURRENT_TIMESTAMP),
       (36, 'Gone Girl', NULL, 1, 'paper', 1, 0, 1, '9780553419085', 'English', NULL, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (37, 'Em Parte Incerta', NULL, 1, 'paper', 1, 0, 1, '9799722525572', 'Portuguese', NULL, 36, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (38, 'Primeira Regra dos Feiticeiros, Parte I', NULL, 1, 'paper', 1, 0, 1, '9789720046840', 'Portuguese', 1,
        NULL, 12, 'Paperback', CURRENT_TIMESTAMP), --	Arco 1: Darken Rahl
       (39, 'A Primeira Regra dos Feiticeiros, Parte  II', NULL, 1, 'paper', 1, 0, 1, '9789720046970', 'Portuguese', 2,
        NULL, 12, 'Paperback', CURRENT_TIMESTAMP),
       (40, 'A Pedra das Lágrimas, Parte I', NULL, 1, 'paper', 1, 0, 1, '9789720047489', 'Portuguese', 3, NULL, 12,
        'Paperback', CURRENT_TIMESTAMP),
       (41, 'A Pedra das Lágrimas, Parte II', NULL, 1, 'paper', 1, 0, 1, '9789220047687', 'Portuguese', 5, NULL, 12,
        'Paperback', CURRENT_TIMESTAMP),
       (42, 'O Sangue da Virtude', NULL, 1, 'paper', 1, 0, 1, '9789720047922', 'Portuguese', NULL, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP),
       (43, 'The Left Hand of Good', NULL, 1, 'paper', 1, 0, 1, '9780141042374', 'English', 1, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (44, 'The Last Four Things', NULL, 1, 'paper', 1, 0, 1, '9780718155209', 'English', 2, NULL, NULL, 'Paperback',
        CURRENT_TIMESTAMP),
       (45, 'The Beating o His Wings', NULL, 1, 'paper', 1, 0, 1, '9780141042404', 'English', 3, NULL, NULL,
        'Paperback', CURRENT_TIMESTAMP);

INSERT INTO item_author(ItemId, authorId)
VALUES (1, 1),
       (2, 2),
       (3, 3),
       (4, 3),
       (5, 3),
       (6, 3),
       (7, 3),
       (8, 3),
       (9, 4),
       (10, 4),
       (11, 4),
       (12, 4),
       (13, 4),
       (14, 5),
       (15, 5),
       (16, 6),
       (17, 6),
       (18, 6),
       (19, 6),
       (20, 6),
       (21, 6),
       (22, 6),
       (23, 6),
       (24, 6),
       (25, 6),
       (26, 6),
       (27, 6),
       (28, 6),
       (29, 6),
       (30, 6),
       (31, 6),
       (32, 7),
       (33, 8),
       (34, 8),
       (35, 8),
       (36, 9),
       (37, 9),
       (38, 10),
       (39, 10),
       (40, 10),
       (41, 10),
       (42, 10),
       (43, 11),
       (44, 11),
       (45, 11);

INSERT INTO item_genre(itemId, genreId)
VALUES (1, 11),
       (2, 7),
       (3, 7),
       (4, 7),
       (5, 7),
       (6, 7),
       (7, 7),
       (8, 7),
       (9, 8),
       (10, 8),
       (11, 8),
       (12, 8),
       (13, 8),
       (14, 7),
       (15, 7),
       (16, 8),
       (17, 8),
       (18, 8),
       (19, 8),
       (20, 8),
       (21, 8),
       (22, 8),
       (23, 8),
       (24, 8),
       (25, 8),
       (26, 8),
       (27, 8),
       (28, 8),
       (29, 8),
       (30, 8),
       (31, 8),
       (33, 8),
       (34, 8),
       (35, 8),
       (36, 3),
       (37, 3),
       (38, 8),
       (39, 8),
       (40, 8),
       (41, 8),
       (42, 8),
       (43, 8),
       (44, 8),
       (45, 8);
