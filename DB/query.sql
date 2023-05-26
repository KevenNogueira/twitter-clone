CREATE TABLE
	usuarios (
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		nome varchar(100) NOT NULL,
		email varchar(150) NOT NULL,
		senha varchar(32) NOT NULL,
		biografia varchar(195),
		facebook varchar(250),
		instagram varchar(250),
		linkedin varchar(250),
		tiktok varchar(250),
		outros_links varchar(250)
	);



CREATE TABLE
	tweets (
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		id_usuario int NOT NULL,
		tweet varchar(200) NOT NULL,
		data_insercao datetime DEFAULT current_timestamp
	);
	
CREATE TABLE
	usuarios_seguidores(
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		id_usuario int NOT NULL,
		id_usuario_seguindo int NOT NULL
	);