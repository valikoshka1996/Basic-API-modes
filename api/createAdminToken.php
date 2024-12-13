<?php
header('Content-Type: application/json');

try {
    // Перевірка методу запиту
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["error" => "Only POST requests are allowed."]);
        exit;
    }

    // Отримання вхідних даних
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['email']) || empty($input['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Email and password fields cannot be empty."]);
        exit;
    }

    $email = $input['email'];
    $password = $input['password'];

    // Налаштування з'єднання з БД user_system
    $dsn_user_system = 'mysql:host=localhost;dbname=user_system;charset=utf8mb4';
    $db_user = 'root';
    $db_pass = 'Samfisher1996';
    $pdo_user_system = new PDO($dsn_user_system, $db_user, $db_pass);
    $pdo_user_system->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка наявності користувача
    $stmt = $pdo_user_system->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["error" => "User not found."]);
        exit;
    }

    // Перевірка пароля
    if (!password_verify($password, $user['password'])) {
        http_response_code(403);
        echo json_encode(["error" => "Invalid password."]);
        exit;
    }

    // Перевірка статусу адміністратора
    if ((int)$user['is_admin'] !== 1) {
        http_response_code(403);
        echo json_encode(["error" => "User is not an administrator."]);
        exit;
    }

    // Генерація API ключа
    $api_key = bin2hex(random_bytes(16));

    // Налаштування з'єднання з БД api_keys
    $dsn_api_keys = 'mysql:host=localhost;dbname=api_keys;charset=utf8mb4';
    $pdo_api_keys = new PDO($dsn_api_keys, $db_user, $db_pass);
    $pdo_api_keys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Збереження API ключа в таблиці api_keys_table
    $stmt = $pdo_api_keys->prepare('INSERT INTO api_keys_table (api_key, user_id) VALUES (:api_key, :user_id)');
    $stmt->execute(['api_key' => $api_key, 'user_id' => $user['id']]);

    // Відповідь на успіх
    http_response_code(200);
    echo json_encode([
        "api_key" => $api_key,
        "email" => $email
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "An unexpected error occurred: " . $e->getMessage()]);
}
?>
