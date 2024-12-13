<?php
// Конфігурація баз даних
define('TRUSTED_DB_DSN', 'mysql:host=localhost;dbname=ip_database');
define('USER_SYSTEM_DB_DSN', 'mysql:host=localhost;dbname=user_system');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Samfisher1996');

// Перевірка типу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Отримання тіла запиту
$requestBody = json_decode(file_get_contents('php://input'), true);
if (!isset($requestBody['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required field: action']);
    exit;
}

$action = $requestBody['action'];
$clientIp = $_SERVER['REMOTE_ADDR'];

try {
    // Підключення до бази даних trusted_ip
    $trustedDb = new PDO(TRUSTED_DB_DSN, DB_USER, DB_PASSWORD);
    $trustedDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка IP
    $stmt = $trustedDb->prepare("SELECT COUNT(*) FROM trusted_ip WHERE ip = :ip");
    $stmt->execute(['ip' => $clientIp]);
    $isTrusted = $stmt->fetchColumn() > 0;

    if (!$isTrusted) {
        http_response_code(403);
        echo json_encode(['error' => 'IP address not trusted']);
        exit;
    }

    // Підключення до бази даних user_system
    $userSystemDb = new PDO(USER_SYSTEM_DB_DSN, DB_USER, DB_PASSWORD);
    $userSystemDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($action === 'create') {
        // Перевірка наявності адміністратора
        $stmt = $userSystemDb->query("SELECT COUNT(*) FROM users WHERE is_admin = 1");
        if ($stmt->fetchColumn() > 0) {
            http_response_code(400);
            echo json_encode(['error' => 'User already exists']);
            exit;
        }

        // Генерація випадкових email та пароля
        $randomEmail = uniqid('admin_', true) . '@example.com';
        $randomPassword = bin2hex(random_bytes(8));

        // Додавання адміністратора в базу
        $stmt = $userSystemDb->prepare("INSERT INTO users (email, password, is_admin) VALUES (:email, :password, 1)");
        $stmt->execute([
            'email' => $randomEmail,
            'password' => password_hash($randomPassword, PASSWORD_BCRYPT)
        ]);

        echo json_encode(['email' => $randomEmail, 'password' => $randomPassword]);

    } elseif ($action === 'reset') {
        // Перевірка наявності адміністраторів
        $stmt = $userSystemDb->query("SELECT COUNT(*) FROM users WHERE is_admin = 1");
        $adminCount = $stmt->fetchColumn();

        if ($adminCount > 0) {
            // Оновлення статусу адміністраторів
            $stmt = $userSystemDb->query("UPDATE users SET is_admin = 0 WHERE is_admin = 1");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'There are no admins']);
        }

    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error', 'details' => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error', 'details' => $e->getMessage()]);
}
?>