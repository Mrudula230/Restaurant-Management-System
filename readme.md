# Restaurant Management System

A web-based Restaurant Management System developed using PHP, MySQL, HTML and CSS.

## Features
- View restaurant menu items.
- Add new food items.
- Edit existing menu items.
- Place customer orders.
- Store menu and order details in MySQL.

## Technologies Used
- PHP
- MySQL
- HTML
- CSS
- XAMPP

## Database Setup
1. Start Apache and MySQL using XAMPP.
2. Open phpMyAdmin.
3. Create a database named `restaurant_db`.
4. Import the `restaurant_db.sql` file.

## Run the Project
1. Place the project folder inside XAMPP's `htdocs` directory.
2. Start Apache and MySQL.
3. Open this URL in your browser:

`http://localhost/practical6_php_restaurant/practical6_php_restaurant/`

## Project Structure
- `config.php` – Database connection
- `index.php` – Home page
- `menu.php` – Menu display
- `add_item.php` – Add menu items
- `edit_item.php` – Edit menu items
- `order.php` – Order management
- `header.php` and `footer.php` – Common page layout
- `style.css` – Styling
- `restaurant_db.sql` – Database structure and sample data