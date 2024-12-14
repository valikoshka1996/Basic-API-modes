<?php
header('Content-Type: application/json');

// Встановлення з'єднання з базою даних
$host = 'localhost';
$db = 'user_system';
$user = 'root';
$password = 'Samfisher1996';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Метод не дозволено
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

// Перевірка наявності параметра ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400); // Невірний запит
    echo json_encode(['error' => 'ID parameter is required']);
    exit;
}

$id = $_GET['id'];

// Пошук користувача в базі даних
try {
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo json_encode(['error' => 'User does not exist']);
        exit;
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Перевірка значення is_admin
    $isAdmin = $user['is_admin'] == 1 ? true : false;
    echo json_encode(['is_admin' => $isAdmin]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed']);
}
?>