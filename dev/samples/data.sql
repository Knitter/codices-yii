INSERT INTO account (username, email, name, active, password, createdOn, updatedOn, authKey)
VALUES ('demo', 'demo@example.com', 'Demo User', 1, '$2y$13$ghkZoPKVw.G9c9yODDvex.gnaG4JRHM4rdcr7NJYWR5fXvBmo64hC',
        strftime('%s', 'now'), strftime('%s', 'now'), 'ce620802100e16bda4d399bb5665d317');
