<?php

header('Content-Type: application/json'); // Встановлюємо тип відповіді JSON

// Перевіряємо метод запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Метод не дозволено
    echo json_encode(["error" => "Only GET method is allowed"]);
    exit;
}

// Перевіряємо наявність параметра login_key
if (!isset($_GET['login_key']) || empty($_GET['login_key'])) {
    http_response_code(400); // Невірний запит
    echo json_encode(["error" => "Missing 'login_key' parameter"]);
    exit;
}

$loginKey = $_GET['login_key'];

// Дані для підключення до бази даних
$dbHost = 'localhost';
$dbName = 'login';
$dbUser = 'root';
$dbPass = 'Samfisher1996';

try {
    // Підключення до бази даних
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-запит для перевірки login_key
    $query = "SELECT COUNT(*) AS count FROM auth_tokens WHERE login_key = :login_key";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':login_key', $loginKey, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Перевірка результату
    if ($result['count'] > 0) {
        echo json_encode(["is_loged_in" => true]);
    } else {
        echo json_encode(["is_loged_in" => false]);
    }

} catch (PDOException $e) {
    http_response_code(500); // Помилка сервера
    echo json_encode(["error" => "Database error", "details" => $e->getMessage()]);
    exit;
}
?>