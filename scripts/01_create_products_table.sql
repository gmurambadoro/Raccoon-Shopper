CREATE TABLE IF NOT EXISTS products (
  id INT PRIMARY KEY AUTO_INCREMENT,  -- Unique identifier for each product (auto-incremented)
  name VARCHAR(255) NOT NULL UNIQUE,         -- Name of the product (cannot be null)
  price DECIMAL(10, 2) NOT NULL       -- Price of the product (up to 10 digits, 2 decimal places, cannot be null)
);
