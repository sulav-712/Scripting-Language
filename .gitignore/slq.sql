create database lab;

use lab;

-- Table Creation
-- 1. USERS 
create table users(
	user_id int auto_increment primary key,
    first_name varchar(50),
    last_name varchar(50),
    email varchar(100),
    phone varchar(20),
    country varchar(50),
    created_at datetime default current_timestamp
);


-- 2. DESTINATIONS
create table destinations (
	destination_id int auto_increment primary key,
    name varchar(100),
    country varchar(50),
    description varchar(255),
    popularity_score int
);


-- 3. ACCOMODATIONS 
create table accommodations (
	accommodation_id int auto_increment primary key,
    name varchar(100),
    destination_id int references destinations(destination_id),
    type varchar(50),
    price_per_night decimal(10,2),
    rating decimal(3,2)
);


-- 4. TRANSPORTATIONS
create table transportations (
	transport_id int auto_increment primary key,
    destination_id int references destinations(destination_id),
    type varchar(50),
    price decimal(10,2),
    duration_hrs decimal(5,2)
);


-- 5. TRIPS
create table trips (
	trip_id int auto_increment primary key,
    user_id int references users(user_id),
    destination_id int references destinations(destination_id),
	accommodation_id int references accommodations(accommodation_id),
    transport_id int references transportations(transport_id),
    start_date date,
    end_date date,
    status varchar(50)
);



-- 6. PAYMENTS
create table payments (
	payment_id int auto_increment primary key,
    trip_id int references trips (trip_id),
    amount decimal(10,2),
    payment_date datetime,
    method varchar(50),
    status varchar(50)
);


-- 7. TRIP REVIEWS
create table trip_reviews (
	review_id int auto_increment primary key,
    trip_id int references trips (trip_id),
    user_id int references users(user_id),
    rating int,
    comment varchar(255),
    review_date datetime
);



-- 8. PROMOTIONS
create table promotions (
	promotion_id int auto_increment primary key,
    code varchar(20),
    discount decimal(5,2),
    start_date date,
    end_date date
);



-- 9. TRIP PROMOTIONS
create table trip_promotions (
	trip_id int references trips (trip_id),
    promotion_id int auto_increment primary key
);


-- 10. TRAVEL PACKAGES
create table travel_packages (
	package_id int auto_increment primary key,
    name varchar(100),
    description varchar(255),
    price decimal(10,2),
    duration_days int 
);


-- Inserting 5 rows in every table
-- 1. USERS
INSERT INTO users (first_name, last_name, email, phone, country) VALUES
('Aarav', 'Shrestha', 'aarav.shrestha@example.com', '+977-9841234567', 'Nepal'),
('Sita', 'Thapa', 'sita.thapa@example.com', '+977-9812345678', 'Nepal'),
('Ramesh', 'KC', 'ramesh.kc@example.com', '+977-9801234567', 'Nepal'),
('Anisha', 'Gurung', 'anisha.gurung@example.com', '+977-9861234567', 'Nepal'),
('Bibek', 'Maharjan', 'bibek.maharjan@example.com', '+977-9851234567', 'Nepal');

-- 2. DESTINATIONS
INSERT INTO destinations (name, country, description, popularity_score) VALUES
('Kathmandu', 'Nepal', 'Capital city known for heritage sites and temples.', 98),
('Pokhara', 'Nepal', 'Lakeside city famous for mountains and adventure.', 96),
('Chitwan', 'Nepal', 'Popular for wildlife safaris and national park tours.', 91),
('Lumbini', 'Nepal', 'Birthplace of Lord Buddha and a spiritual destination.', 89),
('Bhaktapur', 'Nepal', 'Historic city with rich culture and architecture.', 90);

-- 3. ACCOMMODATIONS
INSERT INTO accommodations (name, destination_id, type, price_per_night, rating) VALUES
('Hotel Himalaya', 1, 'Hotel', 85.00, 4.50),
('Fewa Lakeside Resort', 2, 'Resort', 110.00, 4.70),
('Skyline Apartment', 3, 'Apartment', 75.00, 4.20),
('Buddha Garden Hotel', 4, 'Hotel', 75.00, 4.30),
('Heritage Apartment Bhaktapur', 5, 'Apartment', 65.00, 4.10);

-- 4. TRANSPORTATIONS
INSERT INTO transportations (destination_id, type, price, duration_hrs) VALUES
(1, 'Flight', 120.00, 0.75),
(2, 'Train', 45.00, 6.50),
(3, 'Flight', 140.00, 1.00),
(4, 'Train', 35.00, 7.00),
(5, 'Flight', 110.00, 0.80);

-- 5. TRIPS
INSERT INTO trips (user_id, destination_id, accommodation_id, transport_id, start_date, end_date, status) VALUES
(1, 1, 1, 1, '2026-08-01', '2026-08-04', 'Booked'),
(2, 2, 2, 2, '2026-09-10', '2026-09-15', 'Completed'),
(3, 3, 3, 3, '2026-10-05', '2026-10-09', 'Cancelled'),
(4, 4, 4, 4, '2026-11-12', '2026-11-14', 'Booked'),
(5, 5, 5, 5, '2026-12-20', '2026-12-22', 'Completed');

-- 6. PAYMENTS
INSERT INTO payments (trip_id, amount, payment_date, method, status) VALUES
(1, 350.00, '2026-07-20 10:00:00', 'Credit Card', 'Paid'),
(2, 520.00, '2026-08-25 14:15:00', 'PayPal', 'Paid'),
(3, 300.00, '2026-09-30 09:45:00', 'Credit Card', 'Refunded'),
(4, 280.00, '2026-10-28 16:30:00', 'PayPal', 'Paid'),
(5, 420.00, '2026-11-18 12:20:00', 'Credit Card', 'Paid');

-- 7. TRIP REVIEWS
INSERT INTO trip_reviews (trip_id, user_id, rating, comment, review_date) VALUES
(1, 1, 5, 'Great heritage trip in Kathmandu.', '2026-08-05 11:00:00'),
(2, 2, 5, 'Pokhara was beautiful and relaxing.', '2026-09-16 13:00:00'),
(3, 3, 4, 'Chitwan safari was exciting and fun.', '2026-10-10 17:30:00'),
(4, 4, 4, 'Lumbini was peaceful and spiritual.', '2026-11-15 10:15:00'),
(5, 5, 5, 'Bhaktapur felt like a journey into history.', '2026-12-23 18:45:00');

-- 8. PROMOTIONS
INSERT INTO promotions (code, discount, start_date, end_date) VALUES
('NEPAL10', 10.00, '2026-01-01', '2026-12-31'),
('FESTIVE15', 15.00, '2026-10-01', '2026-11-30'),
('TRAVEL5', 5.00, '2026-01-01', '2026-06-30'),
('HERITAGE20', 20.00, '2026-07-01', '2026-09-30'),
('ADVENTURE25', 25.00, '2026-08-01', '2026-12-31');

-- 9. TRIP PROMOTIONS
INSERT INTO trip_promotions (trip_id, promotion_id) VALUES
(1, 1),
(2, 4),
(3, 5),
(4, 2),
(5, 3);

-- 10. TRAVEL PACKAGES
INSERT INTO travel_packages (name, description, price, duration_days) VALUES
('Kathmandu Heritage Tour', 'Explore temples, squares, and local culture.', 250.00, 3),
('Pokhara Escape', 'Lakeside relaxation with mountain views.', 450.00, 4),
('Chitwan Safari Package', 'Wildlife safari and jungle activities.', 380.00, 3),
('Lumbini Pilgrimage Tour', 'Spiritual journey to sacred sites.', 220.00, 2),
('Bhaktapur Cultural Trip', 'Discover traditional art and architecture.', 180.00, 2);


-- Adding a new column Gender (VARCHAR(10)) to the USERS table.   
alter table users
add column gender varchar(10);


--  Adding a new column date_of_birth (DATE) to the USERS table.
alter table users
add column date_of_birth date;


-- Adding a new column City (VARCHAR(50)) to the DESTINATIONS table.
alter table destinations
add column city varchar(50);


-- Adding a new column WiFiAvailable (BOOLEAN) to the ACCOMMODATIONS table. 
alter table accommodations
add column wifi_available boolean;


-- Adding a new column Capacity (INT) to the TRANSPORTOPTIONS table.
alter table transportations
add column capacity int;


-- Renaming the column PHONE to MobileNumber in the USERS table. 
alter table users
rename column phone to mobile_number;


-- Renaming the column DESCRIPTION to PackageDescription in the TRAVELPACKAGES table.  
alter table travel_packages
rename column description to package_description;


-- Changing the data type of EMAIL from VARCHAR(100) to VARCHAR(150). 
alter table users 
modify column email varchar(100);


-- Modifying the STATUS column in TRIPS to VARCHAR(30).  
alter table trips
modify column status varchar(30);


-- Dropping the column POPULARITYSCORE from DESTINATIONS.  
alter table destinations 
drop column popularity_score;

desc lab.users;

-- Creating an index named idx_users_lastname on the LASTNAME column of the USERS table. 
create index idx_users_lastname on users(last_name);

-- Creating an index named idx_destinations_country on the COUNTRY column of the DESTINATIONS table.  
create index idx_destinations_country on destinations (country);

-- Creating an index named idx_accommodation_destination on the DESTINATIONID column of the ACCOMMODATIONS table. 
create index idx_accommodation_destination on accommodations (destination_id);

-- Creating an index named idx_transport_destination on the DESTINATIONID column of the TRANSPORTOPTIONS table. 
create index idx_transport_destination on transportations (destination_id);

-- Creating an index named idx_trip_user on the USERID column of the TRIPS table. 
create index idx_trip_user on trips(user_id);

-- Creating an index named idx_payment_trip on the TRIPID column of the PAYMENTS table. 
create index idx_payment_trip on payments(trip_id);

-- Creating an index named idx_review_user on the USERID column of the TRIPREVIEWS table.  
create index idx_review_user on trip_reviews (user_id);

-- Creating an index named idx_promotion_code on the CODE column of the PROMOTIONS table.
create index idx_promotion_code on promotions (code);

-- Creating an index named idx_trippromotion_promotion on the PROMOTIONID column of the TRIPPROMOTIONS table. 
create index idx_trippromotion_promotion on trip_promotions (promotion_id);

-- Creating an index named idx_package_name on the NAME column of the TRAVELPACKAGES table. 
create index idx_package_name on travel_packages (name); 


-- Sakila Sample Database Schema
-- Version 1.5

-- Copyright (c) 2006, 2026, Oracle and/or its affiliates.

-- Redistribution and use in source and binary forms, with or without
-- modification, are permitted provided that the following conditions are
-- met:

-- * Redistributions of source code must retain the above copyright notice,
--   this list of conditions and the following disclaimer.
-- * Redistributions in binary form must reproduce the above copyright
--   notice, this list of conditions and the following disclaimer in the
--   documentation and/or other materials provided with the distribution.
-- * Neither the name of Oracle nor the names of its contributors may be used
--   to endorse or promote products derived from this software without
--   specific prior written permission.

-- THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
-- IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
-- THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
-- PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
-- CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
-- EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
-- PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
-- PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
-- LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
-- NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
-- SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

SET NAMES utf8mb4;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS sakila;
CREATE SCHEMA sakila;
USE sakila;

--
-- Table structure for table `actor`
--

CREATE TABLE actor (
  actor_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(45) NOT NULL,
  last_name VARCHAR(45) NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (actor_id),
  KEY idx_actor_last_name (last_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `address`
--

CREATE TABLE address (
  address_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  address VARCHAR(50) NOT NULL,
  address2 VARCHAR(50) DEFAULT NULL,
  district VARCHAR(20) NOT NULL,
  city_id SMALLINT UNSIGNED NOT NULL,
  postal_code VARCHAR(10) DEFAULT NULL,
  phone VARCHAR(20) NOT NULL,
  -- Add GEOMETRY column for MySQL 5.7.5 and higher
  -- Also include SRID attribute for MySQL 8.0.3 and higher
  /*!50705 location GEOMETRY */ /*!80003 SRID 0 */ /*!50705 NOT NULL,*/
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (address_id),
  KEY idx_fk_city_id (city_id),
  /*!50705 SPATIAL KEY `idx_location` (location),*/
  CONSTRAINT `fk_address_city` FOREIGN KEY (city_id) REFERENCES city (city_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `category`
--

CREATE TABLE category (
  category_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(25) NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `city`
--

CREATE TABLE city (
  city_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  city VARCHAR(50) NOT NULL,
  country_id SMALLINT UNSIGNED NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (city_id),
  KEY idx_fk_country_id (country_id),
  CONSTRAINT `fk_city_country` FOREIGN KEY (country_id) REFERENCES country (country_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `country`
--

CREATE TABLE country (
  country_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  country VARCHAR(50) NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (country_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `customer`
--

CREATE TABLE customer (
  customer_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  store_id TINYINT UNSIGNED NOT NULL,
  first_name VARCHAR(45) NOT NULL,
  last_name VARCHAR(45) NOT NULL,
  email VARCHAR(50) DEFAULT NULL,
  address_id SMALLINT UNSIGNED NOT NULL,
  active BOOLEAN NOT NULL DEFAULT TRUE,
  create_date DATETIME NOT NULL,
  last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (customer_id),
  KEY idx_fk_store_id (store_id),
  KEY idx_fk_address_id (address_id),
  KEY idx_last_name (last_name),
  CONSTRAINT fk_customer_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_customer_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `film`
--

CREATE TABLE film (
  film_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(128) NOT NULL,
  description TEXT DEFAULT NULL,
  release_year YEAR DEFAULT NULL,
  language_id TINYINT UNSIGNED NOT NULL,
  original_language_id TINYINT UNSIGNED DEFAULT NULL,
  rental_duration TINYINT UNSIGNED NOT NULL DEFAULT 3,
  rental_rate DECIMAL(4,2) NOT NULL DEFAULT 4.99,
  length SMALLINT UNSIGNED DEFAULT NULL,
  replacement_cost DECIMAL(5,2) NOT NULL DEFAULT 19.99,
  rating ENUM('G','PG','PG-13','R','NC-17') DEFAULT 'G',
  special_features SET('Trailers','Commentaries','Deleted Scenes','Behind the Scenes') DEFAULT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (film_id),
  KEY idx_title (title),
  KEY idx_fk_language_id (language_id),
  KEY idx_fk_original_language_id (original_language_id),
  CONSTRAINT fk_film_language FOREIGN KEY (language_id) REFERENCES language (language_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_film_language_original FOREIGN KEY (original_language_id) REFERENCES language (language_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `film_actor`
--

CREATE TABLE film_actor (
  actor_id SMALLINT UNSIGNED NOT NULL,
  film_id SMALLINT UNSIGNED NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (actor_id,film_id),
  KEY idx_fk_film_id (`film_id`),
  CONSTRAINT fk_film_actor_actor FOREIGN KEY (actor_id) REFERENCES actor (actor_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_film_actor_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `film_category`
--

CREATE TABLE film_category (
  film_id SMALLINT UNSIGNED NOT NULL,
  category_id TINYINT UNSIGNED NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (film_id, category_id),
  CONSTRAINT fk_film_category_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_film_category_category FOREIGN KEY (category_id) REFERENCES category (category_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `film_text`
-- 
-- InnoDB added FULLTEXT support in 5.6.10. If you use an
-- earlier version, then consider upgrading (recommended) or 
-- changing InnoDB to MyISAM as the film_text engine
--

-- Use InnoDB for film_text as of 5.6.10, MyISAM prior to 5.6.10.
SET @old_default_storage_engine = @@default_storage_engine;
SET @@default_storage_engine = 'MyISAM';
/*!50610 SET @@default_storage_engine = 'InnoDB'*/;

CREATE TABLE film_text (
  film_id SMALLINT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  PRIMARY KEY  (film_id),
  FULLTEXT KEY idx_title_description (title,description)
) DEFAULT CHARSET=utf8mb4;

SET @@default_storage_engine = @old_default_storage_engine;

--
-- Triggers for loading film_text from film
--

DELIMITER ;;
CREATE TRIGGER `ins_film` AFTER INSERT ON `film` FOR EACH ROW BEGIN
    INSERT INTO film_text (film_id, title, description)
        VALUES (new.film_id, new.title, new.description);
  END;;


CREATE TRIGGER `upd_film` AFTER UPDATE ON `film` FOR EACH ROW BEGIN
    IF (old.title != new.title) OR (old.description != new.description) OR (old.film_id != new.film_id)
    THEN
        UPDATE film_text
            SET title=new.title,
                description=new.description,
                film_id=new.film_id
        WHERE film_id=old.film_id;
    END IF;
  END;;


CREATE TRIGGER `del_film` AFTER DELETE ON `film` FOR EACH ROW BEGIN
    DELETE FROM film_text WHERE film_id = old.film_id;
  END;;

DELIMITER ;

--
-- Table structure for table `inventory`
--

CREATE TABLE inventory (
  inventory_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  film_id SMALLINT UNSIGNED NOT NULL,
  store_id TINYINT UNSIGNED NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (inventory_id),
  KEY idx_fk_film_id (film_id),
  KEY idx_store_id_film_id (store_id,film_id),
  CONSTRAINT fk_inventory_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_inventory_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `language`
--

CREATE TABLE language (
  language_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name CHAR(20) NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (language_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `payment`
--

CREATE TABLE payment (
  payment_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id SMALLINT UNSIGNED NOT NULL,
  staff_id TINYINT UNSIGNED NOT NULL,
  rental_id INT DEFAULT NULL,
  amount DECIMAL(5,2) NOT NULL,
  payment_date DATETIME NOT NULL,
  last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (payment_id),
  KEY idx_fk_staff_id (staff_id),
  KEY idx_fk_customer_id (customer_id),
  CONSTRAINT fk_payment_rental FOREIGN KEY (rental_id) REFERENCES rental (rental_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_payment_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_payment_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `rental`
--

CREATE TABLE rental (
  rental_id INT NOT NULL AUTO_INCREMENT,
  rental_date DATETIME NOT NULL,
  inventory_id MEDIUMINT UNSIGNED NOT NULL,
  customer_id SMALLINT UNSIGNED NOT NULL,
  return_date DATETIME DEFAULT NULL,
  staff_id TINYINT UNSIGNED NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (rental_id),
  UNIQUE KEY  (rental_date,inventory_id,customer_id),
  KEY idx_fk_inventory_id (inventory_id),
  KEY idx_fk_customer_id (customer_id),
  KEY idx_fk_staff_id (staff_id),
  CONSTRAINT fk_rental_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_rental_inventory FOREIGN KEY (inventory_id) REFERENCES inventory (inventory_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_rental_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `staff`
--

CREATE TABLE staff (
  staff_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(45) NOT NULL,
  last_name VARCHAR(45) NOT NULL,
  address_id SMALLINT UNSIGNED NOT NULL,
  picture BLOB DEFAULT NULL,
  email VARCHAR(50) DEFAULT NULL,
  store_id TINYINT UNSIGNED NOT NULL,
  active BOOLEAN NOT NULL DEFAULT TRUE,
  username VARCHAR(16) NOT NULL,
  password VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (staff_id),
  KEY idx_fk_store_id (store_id),
  KEY idx_fk_address_id (address_id),
  CONSTRAINT fk_staff_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_staff_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `store`
--

CREATE TABLE store (
  store_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  manager_staff_id TINYINT UNSIGNED NOT NULL,
  address_id SMALLINT UNSIGNED NOT NULL,
  last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (store_id),
  UNIQUE KEY idx_unique_manager (manager_staff_id),
  KEY idx_fk_address_id (address_id),
  CONSTRAINT fk_store_staff FOREIGN KEY (manager_staff_id) REFERENCES staff (staff_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_store_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- View structure for view `customer_list`
--

CREATE VIEW customer_list
AS
SELECT cu.customer_id AS ID, CONCAT(cu.first_name, _utf8mb4' ', cu.last_name) AS name, a.address AS address, a.postal_code AS `zip code`,
	a.phone AS phone, city.city AS city, country.country AS country, IF(cu.active, _utf8mb4'active',_utf8mb4'') AS notes, cu.store_id AS SID
FROM customer AS cu JOIN address AS a ON cu.address_id = a.address_id JOIN city ON a.city_id = city.city_id
	JOIN country ON city.country_id = country.country_id;

--
-- View structure for view `film_list`
--

CREATE VIEW film_list
AS
SELECT film.film_id AS FID, film.title AS title, film.description AS description, category.name AS category, film.rental_rate AS price,
	film.length AS length, film.rating AS rating, GROUP_CONCAT(CONCAT(actor.first_name, _utf8mb4' ', actor.last_name) SEPARATOR ', ') AS actors
FROM film LEFT JOIN film_category ON film_category.film_id = film.film_id
LEFT JOIN category ON category.category_id = film_category.category_id LEFT
JOIN film_actor ON film.film_id = film_actor.film_id LEFT JOIN actor ON
  film_actor.actor_id = actor.actor_id
GROUP BY film.film_id, category.name;

--
-- View structure for view `nicer_but_slower_film_list`
--

CREATE VIEW nicer_but_slower_film_list
AS
SELECT film.film_id AS FID, film.title AS title, film.description AS description, category.name AS category, film.rental_rate AS price,
	film.length AS length, film.rating AS rating, GROUP_CONCAT(CONCAT(CONCAT(UCASE(SUBSTR(actor.first_name,1,1)),
	LCASE(SUBSTR(actor.first_name,2,LENGTH(actor.first_name))),_utf8mb4' ',CONCAT(UCASE(SUBSTR(actor.last_name,1,1)),
	LCASE(SUBSTR(actor.last_name,2,LENGTH(actor.last_name)))))) SEPARATOR ', ') AS actors
FROM film LEFT JOIN film_category ON film_category.film_id = film.film_id
LEFT JOIN category ON category.category_id = film_category.category_id LEFT
JOIN film_actor ON film.film_id = film_actor.film_id LEFT JOIN actor ON
  film_actor.actor_id = actor.actor_id
GROUP BY film.film_id, category.name;

--
-- View structure for view `staff_list`
--

CREATE VIEW staff_list
AS
SELECT s.staff_id AS ID, CONCAT(s.first_name, _utf8mb4' ', s.last_name) AS name, a.address AS address, a.postal_code AS `zip code`, a.phone AS phone,
	city.city AS city, country.country AS country, s.store_id AS SID
FROM staff AS s JOIN address AS a ON s.address_id = a.address_id JOIN city ON a.city_id = city.city_id
	JOIN country ON city.country_id = country.country_id;

--
-- View structure for view `sales_by_store`
--

CREATE VIEW sales_by_store
AS
SELECT
CONCAT(c.city, _utf8mb4',', cy.country) AS store
, CONCAT(m.first_name, _utf8mb4' ', m.last_name) AS manager
, SUM(p.amount) AS total_sales
FROM payment AS p
INNER JOIN rental AS r ON p.rental_id = r.rental_id
INNER JOIN inventory AS i ON r.inventory_id = i.inventory_id
INNER JOIN store AS s ON i.store_id = s.store_id
INNER JOIN address AS a ON s.address_id = a.address_id
INNER JOIN city AS c ON a.city_id = c.city_id
INNER JOIN country AS cy ON c.country_id = cy.country_id
INNER JOIN staff AS m ON s.manager_staff_id = m.staff_id
GROUP BY s.store_id
ORDER BY cy.country, c.city;

--
-- View structure for view `sales_by_film_category`
--
-- Note that total sales will add up to >100% because
-- some titles belong to more than 1 category
--

CREATE VIEW sales_by_film_category
AS
SELECT
c.name AS category
, SUM(p.amount) AS total_sales
FROM payment AS p
INNER JOIN rental AS r ON p.rental_id = r.rental_id
INNER JOIN inventory AS i ON r.inventory_id = i.inventory_id
INNER JOIN film AS f ON i.film_id = f.film_id
INNER JOIN film_category AS fc ON f.film_id = fc.film_id
INNER JOIN category AS c ON fc.category_id = c.category_id
GROUP BY c.name
ORDER BY total_sales DESC;

--
-- View structure for view `actor_info`
--

CREATE DEFINER=CURRENT_USER SQL SECURITY INVOKER VIEW actor_info
AS
SELECT
a.actor_id,
a.first_name,
a.last_name,
GROUP_CONCAT(DISTINCT CONCAT(c.name, ': ',
		(SELECT GROUP_CONCAT(f.title ORDER BY f.title SEPARATOR ', ')
                    FROM sakila.film f
                    INNER JOIN sakila.film_category fc
                      ON f.film_id = fc.film_id
                    INNER JOIN sakila.film_actor fa
                      ON f.film_id = fa.film_id
                    WHERE fc.category_id = c.category_id
                    AND fa.actor_id = a.actor_id
                 )
             )
             ORDER BY c.name SEPARATOR '; ')
AS film_info
FROM sakila.actor a
LEFT JOIN sakila.film_actor fa
  ON a.actor_id = fa.actor_id
LEFT JOIN sakila.film_category fc
  ON fa.film_id = fc.film_id
LEFT JOIN sakila.category c
  ON fc.category_id = c.category_id
GROUP BY a.actor_id, a.first_name, a.last_name;

--
-- Procedure structure for procedure `rewards_report`
--

DELIMITER //

CREATE PROCEDURE rewards_report (
    IN min_monthly_purchases TINYINT UNSIGNED
    , IN min_dollar_amount_purchased DECIMAL(10,2)
    , OUT count_rewardees INT
)
LANGUAGE SQL
NOT DETERMINISTIC
READS SQL DATA
SQL SECURITY DEFINER
COMMENT 'Provides a customizable report on best customers'
proc: BEGIN

    DECLARE last_month_start DATE;
    DECLARE last_month_end DATE;

    /* Some sanity checks... */
    IF min_monthly_purchases = 0 THEN
        SELECT 'Minimum monthly purchases parameter must be > 0';
        LEAVE proc;
    END IF;
    IF min_dollar_amount_purchased = 0.00 THEN
        SELECT 'Minimum monthly dollar amount purchased parameter must be > $0.00';
        LEAVE proc;
    END IF;

    /* Determine start and end time periods */
    SET last_month_start = DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH);
    SET last_month_start = STR_TO_DATE(CONCAT(YEAR(last_month_start),'-',MONTH(last_month_start),'-01'),'%Y-%m-%d');
    SET last_month_end = LAST_DAY(last_month_start);

    /*
        Create a temporary storage area for
        Customer IDs.
    */
    CREATE TEMPORARY TABLE tmpCustomer (customer_id SMALLINT UNSIGNED NOT NULL PRIMARY KEY);

    /*
        Find all customers meeting the
        monthly purchase requirements
    */
    INSERT INTO tmpCustomer (customer_id)
    SELECT p.customer_id
    FROM payment AS p
    WHERE DATE(p.payment_date) BETWEEN last_month_start AND last_month_end
    GROUP BY customer_id
    HAVING SUM(p.amount) > min_dollar_amount_purchased
    AND COUNT(customer_id) > min_monthly_purchases;

    /* Populate OUT parameter with count of found customers */
    SELECT COUNT(*) FROM tmpCustomer INTO count_rewardees;

    /*
        Output ALL customer information of matching rewardees.
        Customize output as needed.
    */
    SELECT c.*
    FROM tmpCustomer AS t
    INNER JOIN customer AS c ON t.customer_id = c.customer_id;

    /* Clean up */
    DROP TABLE tmpCustomer;
END //

DELIMITER ;

DELIMITER $$

CREATE FUNCTION get_customer_balance(p_customer_id INT, p_effective_date DATETIME) RETURNS DECIMAL(5,2)
    DETERMINISTIC
    READS SQL DATA
BEGIN

       #OK, WE NEED TO CALCULATE THE CURRENT BALANCE GIVEN A CUSTOMER_ID AND A DATE
       #THAT WE WANT THE BALANCE TO BE EFFECTIVE FOR. THE BALANCE IS:
       #   1) RENTAL FEES FOR ALL PREVIOUS RENTALS
       #   2) ONE DOLLAR FOR EVERY DAY THE PREVIOUS RENTALS ARE OVERDUE
       #   3) IF A FILM IS MORE THAN RENTAL_DURATION * 2 OVERDUE, CHARGE THE REPLACEMENT_COST
       #   4) SUBTRACT ALL PAYMENTS MADE BEFORE THE DATE SPECIFIED

  DECLARE v_rentfees DECIMAL(5,2); #FEES PAID TO RENT THE VIDEOS INITIALLY
  DECLARE v_overfees INTEGER;      #LATE FEES FOR PRIOR RENTALS
  DECLARE v_payments DECIMAL(5,2); #SUM OF PAYMENTS MADE PREVIOUSLY

  SELECT IFNULL(SUM(film.rental_rate),0) INTO v_rentfees
    FROM film, inventory, rental
    WHERE film.film_id = inventory.film_id
      AND inventory.inventory_id = rental.inventory_id
      AND rental.rental_date <= p_effective_date
      AND rental.customer_id = p_customer_id;

  SELECT IFNULL(SUM(IF((TO_DAYS(rental.return_date) - TO_DAYS(rental.rental_date)) > film.rental_duration,
        ((TO_DAYS(rental.return_date) - TO_DAYS(rental.rental_date)) - film.rental_duration),0)),0) INTO v_overfees
    FROM rental, inventory, film
    WHERE film.film_id = inventory.film_id
      AND inventory.inventory_id = rental.inventory_id
      AND rental.rental_date <= p_effective_date
      AND rental.customer_id = p_customer_id;


  SELECT IFNULL(SUM(payment.amount),0) INTO v_payments
    FROM payment

    WHERE payment.payment_date <= p_effective_date
    AND payment.customer_id = p_customer_id;

  RETURN v_rentfees + v_overfees - v_payments;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE film_in_stock(IN p_film_id INT, IN p_store_id INT, OUT p_film_count INT)
READS SQL DATA
BEGIN
     SELECT inventory_id
     FROM inventory
     WHERE film_id = p_film_id
     AND store_id = p_store_id
     AND inventory_in_stock(inventory_id);

     SELECT COUNT(*)
     FROM inventory
     WHERE film_id = p_film_id
     AND store_id = p_store_id
     AND inventory_in_stock(inventory_id)
     INTO p_film_count;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE film_not_in_stock(IN p_film_id INT, IN p_store_id INT, OUT p_film_count INT)
READS SQL DATA
BEGIN
     SELECT inventory_id
     FROM inventory
     WHERE film_id = p_film_id
     AND store_id = p_store_id
     AND NOT inventory_in_stock(inventory_id);

     SELECT COUNT(*)
     FROM inventory
     WHERE film_id = p_film_id
     AND store_id = p_store_id
     AND NOT inventory_in_stock(inventory_id)
     INTO p_film_count;
END $$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION inventory_held_by_customer(p_inventory_id INT) RETURNS INT
READS SQL DATA
BEGIN
  DECLARE v_customer_id INT;
  DECLARE EXIT HANDLER FOR NOT FOUND RETURN NULL;

  SELECT customer_id INTO v_customer_id
  FROM rental
  WHERE return_date IS NULL
  AND inventory_id = p_inventory_id;

  RETURN v_customer_id;
END $$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION inventory_in_stock(p_inventory_id INT) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE v_rentals INT;
    DECLARE v_out     INT;

    #AN ITEM IS IN-STOCK IF THERE ARE EITHER NO ROWS IN THE rental TABLE
    #FOR THE ITEM OR ALL ROWS HAVE return_date POPULATED

    SELECT COUNT(*) INTO v_rentals
    FROM rental
    WHERE inventory_id = p_inventory_id;

    IF v_rentals = 0 THEN
      RETURN TRUE;
    END IF;

    SELECT COUNT(rental_id) INTO v_out
    FROM inventory LEFT JOIN rental USING(inventory_id)
    WHERE inventory.inventory_id = p_inventory_id
    AND rental.return_date IS NULL;

    IF v_out > 0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
END $$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- Beginner level
-- Displaying first and last name of all customers 
select first_name, last_name from customer;

-- Listing all films with their title and release year
select title, release_year from film;

-- Displaying all actors whose first name is NICK
select first_name, last_name from actor where first_name like '%NICK%';

-- Showing the top 10 most expensive films based on rental rate
select title, rental_rate from film
order by rental_rate desc
limit 10;

-- Listing all customers living in the city London
select concat(cu.first_name, ' ', cu.last_name) as full_name
from customer cu
join address ad
on ad.address_id = cu.address_id
join city ci
on ci.city_id = ad.city_id
where ci.city = 'London';

select * from address;

-- Displaying all films whose rental duration is greater than 5 days.  
select title, rental_duration from film where rental_duration > 5;

-- Showing all films with a rating of PG-13.  
select title, rating from film where rating like '%PG-13%';

-- Displaying the first 15 films ordered alphabetically by title. 
select title from film
order by title asc
limit 15;

-- Listing all unique film ratings available in the database.  
select distinct(rating) from film;

-- Displaying all stores with their store IDs and manager staff IDs. 
select store_id, manager_staff_id from store;

-- Intermediate level
-- Listing all customers along with the city and country they belong to.
select cu.first_name, cu.last_name, ci.city, co.country
from customer cu
join address a
on a.address_id = cu.address_id
join city ci
on a.city_id = ci.city_id
join country co
on ci.country_id = co.country_id
order by cu.first_name asc;

-- Displaying each film with its category name.  
select f.title as film, c.name as category
from film f
join film_category fc
on fc.film_id = f.film_id
join category c
on fc.category_id = c.category_id;

-- Counting the total number of films available in each category.  
select c.name as category, count(*) as total_films
from film f
join film_category fc
on fc.film_id = f.film_id
join category c
on fc.category_id = c.category_id
group by c.category_id;

-- Finding the total number of rentals made by each customer.
select c.first_name, c.last_name, count(*) as total_rentals
from rental r
join customer c
on c.customer_id = r.customer_id
group by r.customer_id;

-- Displaying the average rental rate for each film category. 
select c.name as category, avg(f.rental_rate) as avg_rental_rate
from film f
join film_category fc
on fc.film_id = f.film_id
join category c
on fc.category_id = c.category_id
group by c.category_id;

-- Listing all staff members along with the store they work in. 
select first_name, last_name, store_id from staff;

-- Finding the total payment collected by each staff member. 
select s.first_name, s.last_name, sum(p.amount) as total_payment_collected 
from payment p
join staff s
on s.staff_id = p.staff_id
group by p.staff_id;

-- Displaying the number of customers living in each country. 
select co.country, count(*) as total_no_of_customers from customer cu
join address ad
on ad.address_id = cu.address_id
join city ci
on ci.city_id = ad.city_id
join country co
on co.country_id = ci.country_id
group by co.country_id;

-- Listing all actors along with the number of films they have acted
select concat(first_name, ' ', last_name) as full_name, count(*) as total_number_of_films from film_actor fa
join actor a
on a.actor_id = fa.actor_id
group by fa.actor_id;

-- Find the top 5 customers who have spent the highest total payment. 
select concat(cu.first_name, ' ', cu.last_name) as full_name, sum(amount) as total_payment from payment p
join customer cu
on cu.customer_id = p.customer_id
group by p.customer_id
order by total_payment desc
limit 5;



-- Advanced Level
-- Finding the customer(s) who made the highest total payment.  
with customers as (
select 
	concat(c.first_name, ' ', c.last_name) as full_name,
    sum(p.amount) as total_payments
from customer c
join payment p on p.customer_id = c.customer_id
group by p.customer_id
), ranked_customers as (
	select *,
		rank() over(order by total_payments desc) rnk
	from customers
)
select * from ranked_customers
where rnk = 1;

-- Displaying the top 10 most rented films. 
select title, rental_duration from film
order by rental_duration desc
limit 10;


-- Finding all actors who have acted in more than 20 films.
select concat(a.first_name, ' ', a.last_name) as full_name, count(*) as total_films_acted from actor a
join film_actor fa
on fa.actor_id = a.actor_id
group by fa.actor_id
having total_films_acted > 20
order by total_films_acted desc;


-- List customers who have never rented any film.
select concat(cu.first_name, ' ', cu.last_name) as full_name from customer cu
left join rental r
on r.customer_id = cu.customer_id
where r.customer_id is null;


-- Displaying each category along with its average film rental rate and average replacement cost.  
select c.name, 
	round(avg(f.rental_rate), 4) as avg_film_rental_rate, 
	round(avg(f.replacement_cost), 4) as avg_replacement_cost
from film f
join film_category fc
on fc.film_id = f.film_id
join category c
on c.category_id = fc.category_id
group by fc.category_id;


-- Ranking customers based on their total payment using a window function.  
with customer_total as (
	select concat(c.first_name, ' ', c.last_name) as full_name,
			sum(p.amount) as total_payment
	from customer c
    join payment p
    on p.customer_id = c.customer_id
    group by p.customer_id
)
select *, rank() over(order by total_payment desc) as rank_of_customer
from customer_total
order by rank_of_customer asc;


-- Finding the longest film in each category. 
select 
	t.name as category_name,
    t.title as film_title,
    t.length
from (
	select
		c.name,
		f.title,
		f.length,
        rank() over(partition by c.category_id order by f.length desc) as rnk
	from film f
    join film_category fc
    on fc.film_id = f.film_id
    join category c
    on c.category_id = fc.category_id
) t
where rnk = 1
order by category_name;

-- Displaying the running total of daily payments ordered by payment date.  
with daily as(
select 
	date(payment_date) as payment_day,
    sum(amount) as daily_total
from payment
group by payment_day
)
select
	payment_day, 
    daily_total,
    sum(daily_total) over(order by payment_day asc rows between unbounded preceding and current row) as running_total
from daily
order by payment_day;


-- Using a Common Table Expression (CTE), find the top 5 customers by total spending and display their rental count.  
with customer_spending as (
select 
	concat(c.first_name, ' ', c.last_name) as full_name,
    sum(p.amount) as total_spending,
    count(r.rental_id) as rental_count
from customer c
join payment p on p.customer_id = c.customer_id
join rental r on r.rental_id = p.rental_id
group by c.customer_id
)
select full_name,
		total_spending,
        rental_count
from customer_spending
order by total_spending desc
limit 5;


-- Finding the most popular film category based on the total number of rentals. 
select
	c.name as category_name,
    count(r.rental_id) as total_rentals
from category c
join film_category fc on fc.category_id = c.category_id
join film f on f.film_id = fc.film_id
join inventory i on i.film_id = f.film_id
join rental r on r.inventory_id = i.inventory_id
group by c.name
order by total_rentals desc
limit 1;

