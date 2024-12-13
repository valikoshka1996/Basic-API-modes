<?php
header('Content-Type: application/json');

// Константи для підключення до БД
define('DB_HOST', 'localhost');
define('DB_NAME', 'login');
define('DB_USER', 'root');
define('DB_PASS', 'Samfisher1996');

// Перевірка типу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['message' => 'Only DELETE requests are allowed']);
    exit;
}

// Читання JSON-даних
$data = json_decode(file_get_contents('php://input'), true);

// Перевірка наявності необхідних полів
if (empty($data['user_id']) || empty($data['login_key'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Both user_id and login_key are required']);
    exit;
}

$user_id = $data['user_id'];
$login_key = $data['login_key'];

try {
    // Підключення до БД
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка чи існує запис з login_key
    $stmt = $pdo->prepare('SELECT user_id FROM auth_tokens WHERE login_key = :login_key');
    $stmt->bindParam(':login_key', $login_key);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(404);
        echo json_encode(['message' => 'Session not found']);
        exit;
    }

    // Перевірка user_id
    if ($result['user_id'] != $user_id) {
        http_response_code(403);
        echo json_encode(['message' => 'Not allowed to login. Wrong user_id']);
        exit;
    }

    // Видалення запису з таблиці auth_tokens
    $deleteStmt = $pdo->prepare('DELETE FROM auth_tokens WHERE login_key = :login_key');
    $deleteStmt->bindParam(':login_key', $login_key);
    $deleteStmt->execute();

    echo json_encode(['message' => 'Success']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?>
