-- create database
CREATE DATABASE IF NOT EXISTS pictlonis_db;
USE pictlonis_db;

-------------------
-- CREATE TABLES --
-------------------

-- client table --
CREATE TABLE IF NOT EXISTS client (
	client_id INT NOT NULL,
	gender BOOLEAN,
	name CHAR(50),
	first_name CHAR(50),
	age TINYINT(2) UNSIGNED,
	email CHAR(70),
	PRIMARY KEY (client_id)
);

-- buyer table --
CREATE TABLE IF NOT EXISTS buyer (
	buyer_id INT NOT NULL,
	client_id_fk INT NOT NULL,
	PRIMARY KEY (buyer_id),
	FOREIGN KEY (buyer_id) REFERENCES client(client_id)
);

-- info_order table --
CREATE TABLE IF NOT EXISTS info_order (
	info_order_id INT NOT NULL,
	order_day DATE,
	delivery_time TIME,
	cash BIT,
	buyer_id_fk INT NOT NULL,
	PRIMARY KEY (info_order_id),
	FOREIGN KEY (buyer_id_fk) REFERENCES buyer(buyer_id)
);

-- order table --
CREATE TABLE IF NOT EXISTS `order` (
	order_id INT NOT NULL,
	meal CHAR(60),
	rate TINYINT(3),
	info_order_id_fk INT NOT NULL,
	client_id_fk INT NOT NULL,
	PRIMARY KEY(order_id),
	FOREIGN KEY (info_order_id_fk) REFERENCES info_order(info_order_id),
	FOREIGN KEY (client_id_fk) REFERENCES client(client_id)
);