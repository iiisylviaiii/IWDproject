USE $dbname;

CREATE TABLE IF NOT EXISTS queryresult(
	id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
	seq TEXT NOTNULL
	);
