CREATE TABLE wishes_watchers (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Ідентифікатор запису, автоінкремент
    share_token VARCHAR(255) NOT NULL,          -- Share_token власника вішліста
    watcher_id INT NOT NULL,                    -- ID того, хто дивиться вішліст
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Час створення запису, заповнюється автоматично
);
