-- restaurant_db.sql : run this in phpMyAdmin (Import) or the MySQL console

CREATE DATABASE IF NOT EXISTS restaurant_db;
USE restaurant_db;

CREATE TABLE IF NOT EXISTS menu_items (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    name      VARCHAR(100)  NOT NULL,
    category  VARCHAR(50)   NOT NULL,
    price     DECIMAL(8,2)  NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    table_no    INT NOT NULL,
    item_id     INT NOT NULL,
    quantity    INT NOT NULL,
    order_time  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

INSERT INTO menu_items (name, category, price) VALUES
('Paneer Butter Masala', 'Main Course', 220.00),
('Veg Biryani',          'Main Course', 180.00),
('Masala Dosa',          'Breakfast',    90.00),
('Samosa',               'Starter',      30.00),
('Gulab Jamun',          'Dessert',      60.00),
('Masala Chai',          'Beverage',     20.00);
