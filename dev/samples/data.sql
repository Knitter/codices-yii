INSERT INTO account (username, email, name, active, password, createdOn, updatedOn, authKey)
VALUES ('demo',
        'demo@example.com',
        'Demo User',
        1,
        '$2y$13$ghkZoPKVw.G9c9yODDvex.gnaG4JRHM4rdcr7NJYWR5fXvBmo64hC',
        strftime('%s', 'now'),
        strftime('%s', 'now'),
        'ce620802100e16bda4d399bb5665d317');

INSERT INTO genre (name, ownedById)
VALUES ('Sci-fi', 1),
       ('Fantasy', 1),
       ('Tech, Non fiction', 1);

INSERT INTO publisher (name, ownedById)
VALUES ('Penguin Random House', 1),
       ('FCA', 1),
       ('HarperVoyager', 1),
       ('TOR', 1),
       ('Editorial Presença', 1),
       ('Delphi Publishing', 1);

INSERT INTO format (type, name, ownedById)
VALUES ('paper', 'Paperback', 1),
       ('paper', 'Hardcover', 1),
       ('ebook', 'MOBI', 1),
       ('ebook', 'EPUB', 1),
       ('ebook', 'PDF', 1),
       ('audio', 'MP4', 1);

INSERT INTO author (name, ownedById, surname)
VALUES ('Joe', 1, 'Abercrombie'),
       ('Elliot', 1, 'Ackerman'),
       ('Scott', 1, 'Adams'),
       ('Naomi', 1, 'Alderman'),
       ('Sabastião', 1, 'Alves'),
       ('Jorge', 1, 'Amado'),
       ('Sophia de Mello Breyner', 1, 'Andersen'),
       ('Kevin J.', 1, 'Anderson'),
       ('Pedro', 1, 'Andersson'),
       ('Lucy', 1, 'Angel'),
       ('Mário', 1, 'Antunes'),
       ('Isaac', 1, 'Asimov'),
       ('Edward', 1, 'Ashton'),
       ('Dave', 1, 'Bara'),
       ('J. S.', 1, 'Barnes'),
       ('Leigh', 1, 'Bardugo'),
       ('Sephen', 1, 'Baxter'),
       ('Caroline', 1, 'Bennett'),
       ('Manuel', 1, 'Bernhard');
