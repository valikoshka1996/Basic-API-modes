-- Створення бази даних
CREATE DATABASE IF NOT EXISTS ip_database;

-- Використання бази даних
USE ip_database;

-- Створення таблиці trusted_ip
CREATE TABLE IF NOT EXISTS trusted_ip (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Унікальний ID запису
    ip VARCHAR(45) NOT NULL -- IP-адреса (підтримує IPv4 та IPv6)
);
