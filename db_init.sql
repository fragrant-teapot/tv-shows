USE tv;
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ext_id INT NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    jdoc JSON NOT NULL,
    last_query_at DATETIME NOT NULL
);

CREATE INDEX lower_name_idx ON movies ((LOWER(name)));
