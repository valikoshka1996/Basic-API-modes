<?php
// Файл: /api/getUserEmail.php

header('Content-Type: application/json');

// Дозволяємо лише GET запити
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

// Перевірка наявності параметра user_id
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'user_id is required']);
    exit;
}

// Запам'ятовуємо user_id
$user_id = intval($_GET['user_id']);

// Дані для підключення до бази даних
$host = 'localhost';
$dbname = 'user_system';
$username = 'root';
$password = 'Samfisher1996';

try {
    // Підключення до бази даних
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Запит для перевірки існування користувача
    $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Перевіряємо чи є запис
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'user does not exist']);
        exit;
    }

    // Повертаємо email користувача
    echo json_encode(['email' => $user['email']]);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
