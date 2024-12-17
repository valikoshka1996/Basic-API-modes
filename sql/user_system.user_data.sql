CREATE DATABASE IF NOT EXISTS user_system;

USE user_system;

CREATE TABLE IF NOT EXISTS user_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    sex ENUM('male', 'female') NOT NULL,
    about TEXT,
    adress VARCHAR(255)
);
