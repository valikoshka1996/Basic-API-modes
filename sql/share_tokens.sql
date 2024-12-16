CREATE TABLE wishes.share_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Ідентифікатор запису
    user_id INT NOT NULL,                   -- Ідентифікатор користувача
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Час створення запису
    share_token VARCHAR(255) NOT NULL        -- Спеціально згенерований токен
);
