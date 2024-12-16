<?php
header('Content-Type: application/json'); // Встановлення заголовка для відповіді

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Метод не дозволено
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

// Параметри для підключення до бази даних
$host = 'localhost';
$user = 'root';
$password = 'Samfisher1996';
$database = 'wishes';

try {
    // Підключення до бази даних
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Отримання параметрів з запиту
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = isset($_GET['data']) ? explode(',', $_GET['data']) : [];

// Перевірка обов'язкового параметра id
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Wish ID is required']);
    exit;
}

// Дозволені поля для параметру data
$allowedFields = ['all', 'id', 'created_at', 'user_id', 'name', 'price', 'link', 'jar', 'priority', 'visibility', 'desc'];

// Перевірка параметра data на правильність
foreach ($data as $field) {
    if (!in_array($field, $allowedFields)) {
        http_response_code(400);
        echo json_encode(['error' => 'Wrong data type']);
        exit;
    }
}

// SQL-запит для отримання бажання за ID
$stmt = $pdo->prepare('SELECT * FROM wishes WHERE id = :id');
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    http_response_code(404);
    echo json_encode(['error' => 'Wish does not exist']);
    exit;
}

// Вибірка необхідних полів
if (empty($data) || in_array('all', $data)) {
    // Якщо data не вказано або вказано all, повертаємо всі поля
    echo json_encode($result);
} else {
    // Фільтрація даних за вказаними полями
    $filteredResult = [];
    foreach ($data as $field) {
        if (array_key_exists($field, $result)) {
            $filteredResult[$field] = $result[$field];
        }
    }
    echo json_encode($filteredResult);
}
exit;
?>