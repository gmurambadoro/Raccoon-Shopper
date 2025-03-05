CREATE TABLE IF NOT EXISTS shopping_list_items (
  id INT PRIMARY KEY AUTO_INCREMENT,  -- Unique identifier for each product (auto-incremented)
  name VARCHAR(255) NOT NULL UNIQUE,         -- Name of the product (cannot be null)
  quantity INTEGER NOT NULL,      -- Price of the product (up to 10 digits, 2 decimal places, cannot be null)
  checked BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the record was created
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Timestamp for when the record was last updated
);

