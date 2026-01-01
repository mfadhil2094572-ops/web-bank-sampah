CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  phone VARCHAR(20),
  address TEXT,
  city VARCHAR(50),
  zip_code VARCHAR(10),
  password_hash VARCHAR(255),
  role ENUM('member','admin') DEFAULT 'member',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE waste_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  price_per_kg INT,
  point_per_kg INT
);

CREATE TABLE waste_transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total_weight DECIMAL(6,2),
  total_price INT,
  total_points INT,
  status ENUM('pending','approved','rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE waste_transaction_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  transaction_id INT,
  waste_type_id INT,
  weight DECIMAL(6,2),
  price INT,
  points INT,
  FOREIGN KEY (transaction_id) REFERENCES waste_transactions(id)
);

CREATE TABLE wallets (
  user_id INT PRIMARY KEY,
  cash_balance INT DEFAULT 0,
  total_points INT DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE pickups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  pickup_date DATE,
  time_slot VARCHAR(50),
  estimated_weight DECIMAL(6,2),
  types TEXT,
  status ENUM('pending','scheduled','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
