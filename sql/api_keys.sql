-- Створення бази даних
CREATE DATABASE IF NOT EXISTS api_keys;

-- Використання створеної бази даних
USE api_keys;

-- Створення таблиці api_keys_table
CREATE TABLE IF NOT EXISTS api_keys_table (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Унікальний ID для ключа
    api_key VARCHAR(255) NOT NULL UNIQUE,   -- Сам ключ (унікальний)
    user_id INT NOT NULL,                   -- ID користувача, якому належить ключ
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Час створення ключа
);
