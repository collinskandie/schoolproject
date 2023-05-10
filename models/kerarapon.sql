CREATE DATABASE kerarpon;

USE kerarpon;

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL,
  last_login DATETIME,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE pumps (
  id INT NOT NULL AUTO_INCREMENT,
  pump_details VARCHAR(255) NOT NULL,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE tanks (
  id INT NOT NULL AUTO_INCREMENT,
  tank_details VARCHAR(255) NOT NULL,
  fuel_type VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE inventory (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  cost DECIMAL(10,2) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  last_sold DATETIME,
  last_received DATETIME,
  last_updated DATETIME,
  updated_by INT,
  received_by INT,
  PRIMARY KEY (id),
  FOREIGN KEY (updated_by) REFERENCES users(id),
  FOREIGN KEY (received_by) REFERENCES users(id)
);

CREATE TABLE sales (
  id INT NOT NULL AUTO_INCREMENT,
  item_id INT NOT NULL,
  item_quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  pump_id INT NOT NULL,
  salesperson_id INT NOT NULL,
  time_sold DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (item_id) REFERENCES inventory(id),
  FOREIGN KEY (pump_id) REFERENCES pumps(id),
  FOREIGN KEY (salesperson_id) REFERENCES users(id)
);

CREATE TABLE purchase_orders (
  id INT NOT NULL AUTO_INCREMENT,
  item_id INT NOT NULL,
  item_quantity INT NOT NULL,
  cost DECIMAL(10,2) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  received_by INT NOT NULL,
  time DATETIME,
  pump_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (item_id) REFERENCES inventory(id),
  FOREIGN KEY (received_by) REFERENCES users(id),
  FOREIGN KEY (pump_id) REFERENCES pumps(id)
);

CREATE TABLE suppliers (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  contact_name VARCHAR(50) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE fuel_types (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  octane_rating INT NOT NULL,
  ethanol_content INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE pump_transactions (
  id INT NOT NULL AUTO_INCREMENT,
  pump_id INT NOT NULL,
  fuel_type INT NOT NULL,
  quantity DECIMAL(10,2) NOT NULL,
  time DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (pump_id) REFERENCES pumps(id),
  FOREIGN KEY (fuel_type) REFERENCES fuel_types(id)
);
CREATE TABLE maintenance (
  id INT NOT NULL AUTO_INCREMENT,
  pump_id INT NOT NULL,
  tank_id INT NOT NULL,
  maintenance_type VARCHAR(50) NOT NULL,
  cost DECIMAL(10,2) NOT NULL,
  time DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (pump_id) REFERENCES pumps(id),
  FOREIGN KEY (tank_id) REFERENCES tanks(id)
);
