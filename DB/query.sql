CREATE TABLE
	usuarios (
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		nome varchar(100) NOT NULL,
		email varchar(150) NOT NULL,
		senha varchar(32) NOT NULL
	);

CREATE TABLE
	tweets (
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		id_usuario int NOT NULL,
		tweet varchar(150) NOT NULL,
		data_insercao datetime DEFAULT current_timestamp
	);
	
CREATE TABLE
	usuarios_seguidores(
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		id_usuario int NOT NULL,
		id_usuario_seguindo int NOT NULL
	);