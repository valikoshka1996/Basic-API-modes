-- Створення бази даних wishes
CREATE DATABASE IF NOT EXISTS wishes;

-- Використання бази даних wishes
USE wishes;

-- Створення таблиці wishes
CREATE TABLE wishes (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Унікальний ідентифікатор запису
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Час створення запису (автозаповнення)
    user_id INT NOT NULL,                         -- Ідентифікатор користувача
    name VARCHAR(255) NOT NULL,                  -- Назва бажання
    price DECIMAL(10, 2),                        -- Ціна товару
    link VARCHAR(2083),                          -- URL посилання (максимум для URL)
    jar VARCHAR(2083),                           -- Посилання на банку (необов'язкове)
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium', -- Пріоритет бажання
    visibility BOOLEAN DEFAULT TRUE,             -- Видимість бажання (true або false)
    `desc` TEXT                                  -- Опис бажання
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;