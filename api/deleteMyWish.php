<?php
// Налаштування бази даних
$dbLogin = [
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => 'Samfisher1996',
    'db_login' => 'login',
    'db_wishes' => 'wishes'
];

header('Content-Type: application/json');

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Prohibited']);
    exit;
}

// Отримання тіла запиту
$input = json_decode(file_get_contents("php://input"), true);

// Перевірка наявності параметрів
if (empty($input['login_key']) || empty($input['wish_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'All rows is required:login_key, wish_id']);
    exit;
}

$loginKey = $input['login_key'];
$wishId = intval($input['wish_id']);

try {
    // Підключення до бази даних login
    $pdoLogin = new PDO(
        "mysql:host={$dbLogin['host']};dbname={$dbLogin['db_login']}",
        $dbLogin['username'],
        $dbLogin['password']
    );
    $pdoLogin->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Крок 2: Перевірка login_key
    $stmt = $pdoLogin->prepare("SELECT user_id FROM auth_tokens WHERE login_key = :login_key");
    $stmt->execute(['login_key' => $loginKey]);
    $auth = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$auth) {
        http_response_code(401);
        echo json_encode(['error' => 'User isnt logged in']);
        exit;
    }

    $userId = $auth['user_id'];

    // Підключення до бази даних wishes
    $pdoWishes = new PDO(
        "mysql:host={$dbLogin['host']};dbname={$dbLogin['db_wishes']}",
        $dbLogin['username'],
        $dbLogin['password']
    );
    $pdoWishes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Крок 4: Перевірка wish_id та user_id
    $stmt = $pdoWishes->prepare("SELECT id FROM wishes WHERE id = :wish_id AND user_id = :user_id");
    $stmt->execute(['wish_id' => $wishId, 'user_id' => $userId]);
    $wish = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$wish) {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden - you not own this wish']);
        exit;
    }

    // Крок 5: Видалення запису
    $stmt = $pdoWishes->prepare("DELETE FROM wishes WHERE id = :wish_id AND user_id = :user_id");
    $stmt->execute(['wish_id' => $wishId, 'user_id' => $userId]);

    // Крок 6: Відповідь успішного видалення
    http_response_code(200);
    echo json_encode(['status' => 'success', 'id' => $wishId]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error, please contact administrator', 'details' => $e->getMessage()]);
    exit;
}