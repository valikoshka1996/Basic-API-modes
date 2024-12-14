<?php
header('Content-Type: application/json');

// Перевіряємо метод запиту
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Отримуємо тіло запиту
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['admin_token'])) {
    http_response_code(400);
    echo json_encode(['error' => 'admin_token is required']);
    exit;
}

$adminToken = $input['admin_token'];

// Налаштування для бази даних
$dbApiKeys = new mysqli('localhost', 'root', 'Samfisher1996', 'api_keys');
$dbUserSystem = new mysqli('localhost', 'root', 'Samfisher1996', 'user_system');

if ($dbApiKeys->connect_error || $dbUserSystem->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Перевіряємо наявність admin_token в таблиці api_keys_table
$stmt = $dbApiKeys->prepare('SELECT user_id FROM api_keys_table WHERE api_key = ?');
$stmt->bind_param('s', $adminToken);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'api key not found']);
    exit;
}

$userId = $result->fetch_assoc()['user_id'];
$stmt->close();

// Виконуємо запит до isAdmin.php
$isAdminResponse = file_get_contents("http://localhost/api/isAdmin.php?id=$userId");
$isAdminData = json_decode($isAdminResponse, true);

if (!$isAdminData || !$isAdminData['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => "User isn't admin"]);
    exit;
}

// Отримуємо всі записи з api_keys_table
$result = $dbApiKeys->query('SELECT user_id FROM api_keys_table');
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch api keys']);
    exit;
}

$deletedCount = 0;
while ($row = $result->fetch_assoc()) {
    $userId = $row['user_id'];

    // Перевіряємо, чи існує user_id в базі user_system
    $stmt = $dbUserSystem->prepare('SELECT id FROM users WHERE id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult->num_rows === 0) {
        // Видаляємо запис з api_keys_table
        $deleteStmt = $dbApiKeys->prepare('DELETE FROM api_keys_table WHERE user_id = ?');
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            $deletedCount++;
        }

        $deleteStmt->close();
    }

    $stmt->close();
}

// Відповідь користувачу
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'deleted_records' => $deletedCount
]);

// Закриваємо зредентключення до баз даних
$dbApiKeys->close();
$dbUserSystem->close();
?>
