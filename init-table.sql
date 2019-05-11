CREATE DATABASE IF NOT EXISTS products;
USE products;
CREATE TABLE IF NOT EXISTS fancyservice_product_info (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    upc VARCHAR(20) NOT NULL,
    name VARCHAR(128),
    description TEXT,
    created_at DATETIME NOT NULL
);