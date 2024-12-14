<?php
// Параметри підключення до бази даних
$host = 'localhost';
$username = 'root';
$password = 'Samfisher1996';

header('Content-Type: application/json');

// Перевіряємо метод запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

// Перевіряємо, чи переданий параметр api_key
if (!isset($_GET['api_key']) || empty($_GET['api_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or empty api_key parameter']);
    exit;
}

$apiKey = $_GET['api_key'];

// Підключення до бази даних
define('DB_API_KEYS', 'api_keys');
define('DB_USER_SYSTEM', 'user_system');

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевіряємо таблицю api_keys_table
    $stmt = $pdo->prepare("SELECT * FROM api_keys.api_keys_table WHERE api_key = :api_key");
    $stmt->execute(['api_key' => $apiKey]);
    $apiKeyRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$apiKeyRecord) {
        http_response_code(404);
        echo json_encode(['error' => 'Key doesnt exist']);
        exit;
    }

    // Отримуємо user_id
    $userId = $apiKeyRecord['user_id'] ?? null;

    if (!$userId) {
        http_response_code(500);
        echo json_encode(['error' => 'internal format error']);
        exit;
    }

    // Перевіряємо таблицю users
    $stmt = $pdo->prepare("SELECT * FROM user_system.users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $userRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRecord) {
        http_response_code(404);
        echo json_encode(['error' => 'User doesnt exist']);
        exit;
    }

    // Перевіряємо поле is_admin
    $isAdmin = $userRecord['is_admin'] ?? null;

    if ($isAdmin === null) {
        http_response_code(500);
        echo json_encode(['error' => 'internal format error']);
        exit;
    }

    // Відповідаємо JSON
    echo json_encode(['is_admin' => $isAdmin == 1]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed', 'details' => $e->getMessage()]);
    exit;
}
?>