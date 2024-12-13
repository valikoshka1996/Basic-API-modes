<?php
header('Content-Type: application/json');

// Встановлення з'єднання з базами даних
$host = 'localhost';
$apiDb = 'api_keys';
$userDb = 'user_system';
$user = 'root';
$password = 'Samfisher1996';

try {
    $apiPdo = new PDO("mysql:host=$host;dbname=$apiDb", $user, $password);
    $apiPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userPdo = new PDO("mysql:host=$host;dbname=$userDb", $user, $password);
    $userPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Метод не дозволено
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Отримання та декодування вхідних даних
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['email'], $input['admin_token'])) {
    http_response_code(400); // Невірний запит
    echo json_encode(['error' => 'Email and admin_token are required']);
    exit;
}

$email = $input['email'];
$adminToken = $input['admin_token'];

// Перевірка admin_token
try {
    $stmt = $apiPdo->prepare("SELECT user_id FROM api_keys_table WHERE api_key = :adminToken");
    $stmt->bindParam(':adminToken', $adminToken, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo json_encode(['error' => 'API key not found']);
        exit;
    }

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $adminUserId = $admin['user_id'];

    // Перевірка, чи є користувач адміністратором через isAdmin.php
    $isAdminResponse = file_get_contents("http://localhost/api/isAdmin.php?id=$adminUserId");
    $isAdminData = json_decode($isAdminResponse, true);

    if (!$isAdminData['is_admin']) {
        echo json_encode(['error' => "User isn't admin"]);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

// Перевірка користувача за email
try {
    $stmt = $userPdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $user['id'];

    // Генерація API ключа
    $apiKey = bin2hex(random_bytes(16));

    // Збереження API ключа в базу даних
    $stmt = $apiPdo->prepare("INSERT INTO api_keys_table (api_key, user_id) VALUES (:apiKey, :userId)");
    $stmt->bindParam(':apiKey', $apiKey, PDO::PARAM_STR);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['key' => $apiKey]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

?>