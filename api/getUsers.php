<?php
// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Only GET requests are allowed"]);
    exit;
}

header('Content-Type: application/json');

// Перевірка наявності параметра admin_api_key
if (!isset($_GET['admin_api_key'])) {
    http_response_code(400);
    echo json_encode(["error" => "API Admin key required"]);
    exit;
}

$adminApiKey = $_GET['admin_api_key'];

// Параметри підключення до бази даних
$host = 'localhost';
$username = 'root';
$password = 'Samfisher1996';

try {
    // Підключення до бази даних api_keys
    $pdoApiKeys = new PDO("mysql:host=$host;dbname=api_keys", $username, $password);
    $pdoApiKeys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка наявності ключа в базі даних
    $stmt = $pdoApiKeys->prepare("SELECT user_id FROM api_keys_table WHERE api_key = :api_key");
    $stmt->execute(['api_key' => $adminApiKey]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(404);
        echo json_encode(["error" => "User exist"]);
        exit;
    }

    $userId = $result['user_id'];
    // Виклик ендпоінту isAdmin
    $isAdminResponse = file_get_contents("http://localhost/api/isAdmin.php?id=$userId");
    $isAdminData = json_decode($isAdminResponse, true);
    if (!$isAdminData || !$isAdminData['is_admin']) {
        http_response_code(403);
        echo json_encode(["error" => "User isn't admin"]);
        exit;
    }

    // Підключення до бази даних user_system
    $pdoUsers = new PDO("mysql:host=$host;dbname=user_system", $username, $password);
    $pdoUsers->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Отримання всіх користувачів
    $stmt = $pdoUsers->query("SELECT id, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}