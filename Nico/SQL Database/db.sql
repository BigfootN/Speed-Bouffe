-- create database
CREATE DATABASE IF NOT EXISTS speedbouffe;
USE speedbouffe;

-------------------
-- CREATE TABLES --
-------------------

-- client table --
CREATE TABLE IF NOT EXISTS client (
	client_id INT NOT NULL AUTO_INCREMENT,
	buyer_id_fk INT,
	gender BOOLEAN,
	name CHAR(50),
	first_name CHAR(50),
	age TINYINT(2) UNSIGNED,
	PRIMARY KEY (client_id)
);

-- buyer table --
CREATE TABLE IF NOT EXISTS buyer (
	buyer_id INT NOT NULL AUTO_INCREMENT,
	client_id_fk INT NOT NULL,
	email CHAR(70),
	PRIMARY KEY (buyer_id),
	FOREIGN KEY (client_id_fk) REFERENCES client(client_id)
);

-- info_order table --
CREATE TABLE IF NOT EXISTS info_order (
	info_order_id INT NOT NULL AUTO_INCREMENT,
	order_day DATE,
	delivery_time TIME,
	cash BIT,
	buyer_id_fk INT NOT NULL,
	PRIMARY KEY (info_order_id),
	FOREIGN KEY (buyer_id_fk) REFERENCES buyer(buyer_id)
);

-- price table --
CREATE TABLE IF NOT EXISTS price (
	price_id INT NOT NULL AUTO_INCREMENT,
	rate CHAR(40),
	price TINYINT(3),
	PRIMARY KEY (price_id)
);

-- order table --
CREATE TABLE IF NOT EXISTS `order` (
	order_id INT NOT NULL AUTO_INCREMENT,
	treated BOOLEAN,
	meal CHAR(60),
	info_order_id_fk INT NOT NULL,
	client_id_fk INT NOT NULL,
	price_id_fk INT NOT NULL,
	PRIMARY KEY (order_id),
	FOREIGN KEY (info_order_id_fk) REFERENCES info_order(info_order_id),
	FOREIGN KEY (client_id_fk) REFERENCES client(client_id),
	FOREIGN KEY (price_id_fk) REFERENCES price(price_id)
);


-- foreign keys --
ALTER TABLE `client`
ADD FOREIGN KEY (buyer_id_fk) REFERENCES buyer(buyer_id);

-- add prices --
INSERT INTO price(rate, price) VALUES ('Plein', 12);
INSERT INTO price(rate, price) VALUES ('Senior', 9);
INSERT INTO price(rate, price) VALUES ('Ami', 10);
INSERT INTO price(rate, price) VALUES ('Etudiant', 8);
