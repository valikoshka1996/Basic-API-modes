<?php
// Налаштування підключення до бази даних
$host = 'localhost';
$dbUser = 'root';
$dbPassword = 'Samfisher1996';
$dbNameLogin = 'login';
$dbNameWishes = 'wishes';

header('Content-Type: application/json'); // Задаємо заголовок JSON

// Перевіряємо метод запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Дозволені лише GET запити']);
    exit;
}

// Перевіряємо наявність параметра login_key
if (!isset($_GET['login_key']) || empty($_GET['login_key'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Параметр login_key обов’язковий']);
    exit;
}

$loginKey = $_GET['login_key'];

try {
    // Підключення до бази даних login
    $dbLogin = new PDO("mysql:host=$host;dbname=$dbNameLogin;charset=utf8", $dbUser, $dbPassword);
    $dbLogin->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка login_key в таблиці auth_token
    $stmt = $dbLogin->prepare("SELECT user_id FROM auth_tokens WHERE login_key = :login_key LIMIT 1");
    $stmt->bindParam(':login_key', $loginKey, PDO::PARAM_STR);
    $stmt->execute();

    // Якщо запис не знайдено
    if ($stmt->rowCount() === 0) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Користувач не залогінений']);
        exit;
    }

    // Отримуємо user_id
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $user['user_id'];

    // Підключення до бази даних wishes
    $dbWishes = new PDO("mysql:host=$host;dbname=$dbNameWishes;charset=utf8", $dbUser, $dbPassword);
    $dbWishes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Отримуємо всі wishes для вказаного user_id
    $stmtWishes = $dbWishes->prepare("SELECT * FROM wishes WHERE user_id = :user_id");
    $stmtWishes->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtWishes->execute();

    $wishes = $stmtWishes->fetchAll(PDO::FETCH_ASSOC);

    // Перевірка наявності записів
    if (empty($wishes)) {
        http_response_code(200); // OK
        echo json_encode([]); // Повертаємо пустий масив
        exit;
    }

    // Повертаємо знайдені записи
    http_response_code(200); // OK
    echo json_encode($wishes);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Помилка сервера: ' . $e->getMessage()]);
    exit;
}
?>