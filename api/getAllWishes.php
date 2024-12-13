<?php

// Налаштування доступу до бази даних
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Samfisher1996');
define('DB_API_KEYS', 'api_keys'); // Назва бази даних з api_keys_table
define('DB_WISHES', 'wishes');     // Назва бази даних з таблицею wishes
define('TABLE_API_KEYS', 'api_keys_table');
define('TABLE_WISHES', 'wishes');

header('Content-Type: application/json');

// Дозволяємо лише GET-запити
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

// Перевірка наявності api_key в запиті
if (!isset($_GET['api_key']) || empty(trim($_GET['api_key']))) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing required parameter: api_key']);
    exit;
}

$apiKey = trim($_GET['api_key']);

// Перевірка API ключа у базі даних
try {
    // Підключення до бази даних з api_keys
    $pdoKeys = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_API_KEYS, DB_USER, DB_PASSWORD);
    $pdoKeys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Пошук api_key у таблиці
    $stmt = $pdoKeys->prepare("SELECT COUNT(*) FROM " . TABLE_API_KEYS . " WHERE api_key = :api_key");
    $stmt->bindParam(':api_key', $apiKey, PDO::PARAM_STR);
    $stmt->execute();
    $keyExists = $stmt->fetchColumn();

    if (!$keyExists) {
        http_response_code(403); // Forbidden
        echo json_encode(['error' => 'Access denied. Invalid API key.']);
        exit;
    }

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}

// Отримання всіх записів з бази даних wishes
try {
    // Підключення до бази даних wishes
    $pdoWishes = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_WISHES, DB_USER, DB_PASSWORD);
    $pdoWishes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Запит для отримання всіх записів із таблиці wishes
    $stmt = $pdoWishes->query("SELECT * FROM " . TABLE_WISHES);
    $wishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($wishes)) {
        // Повертаємо пустий масив, якщо записів немає
        http_response_code(200);
        echo json_encode([]);
    } else {
        // Повертаємо дані у форматі JSON
        http_response_code(200);
        echo json_encode($wishes);
    }

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}
?>