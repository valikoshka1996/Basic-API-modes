<?php
header('Content-Type: application/json');

// Обмежуємо запит тільки PATCH методом
if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed', 'message' => 'Only PATCH requests are allowed']);
    exit;
}

// Підключення до баз даних
$loginDb = new mysqli('localhost', 'root', 'Samfisher1996', 'login');
$userDb = new mysqli('localhost', 'root', 'Samfisher1996', 'user_system');

// Перевірка підключення
if ($loginDb->connect_error || $userDb->connect_error) {
    echo json_encode(['error' => 'Database Connection Failed']);
    exit;
}

// Читаємо вхідні дані
$inputData = json_decode(file_get_contents('php://input'), true);

// 1. Перевірка обов'язкового поля login_key
if (empty($inputData['login_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing login_key']);
    exit;
}

$loginKey = $loginDb->real_escape_string($inputData['login_key']);

// 2. Перевірка наявності хоча б одного необов'язкового поля
$validFields = ['name', 'surname', 'birth_date', 'sex', 'about', 'adress'];
$updateFields = array_intersect_key($inputData, array_flip($validFields));

if (empty($updateFields)) {
    echo json_encode(['message' => 'No data to update']);
    exit;
}

// Валідація значень
if (isset($updateFields['sex']) && !in_array($updateFields['sex'], ['male', 'female'])) {
    echo json_encode(['error' => 'Invalid value for sex']);
    exit;
}

// 3. Перевірка авторизації користувача
$result = $loginDb->query("SELECT user_id FROM auth_tokens WHERE login_key = '$loginKey'");

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'User does not authorized']);
    exit;
}

$userData = $result->fetch_assoc();
$userId = $userData['user_id'];

// 4. Перевірка існування запису у user_data
$userCheck = $userDb->query("SELECT * FROM user_data WHERE user_id = $userId");

if ($userCheck->num_rows === 0) {
    // 5. Створюємо новий запис
    $fields = "user_id";
    $values = "$userId";
    foreach ($updateFields as $key => $value) {
        $fields .= ", $key";
        $values .= ", '" . $userDb->real_escape_string($value) . "'";
    }

    $query = "INSERT INTO user_data ($fields) VALUES ($values)";
    if ($userDb->query($query)) {
        http_response_code(200);
        echo json_encode(array_merge(['status' => 'created success'], $updateFields));
    } else {
        echo json_encode(['error' => 'Failed to create record']);
    }
} else {
    // 6. Оновлення існуючого запису
    $updates = [];
    foreach ($updateFields as $key => $value) {
        $updates[] = "$key = '" . $userDb->real_escape_string($value) . "'";
    }

    $updateQuery = "UPDATE user_data SET " . implode(", ", $updates) . " WHERE user_id = $userId";
    if ($userDb->query($updateQuery)) {
        http_response_code(200);
        echo json_encode(array_merge(['status' => 'updated success'], $updateFields));
    } else {
        echo json_encode(['error' => 'Failed to update record']);
    }
}

// Закриття з'єднань
$loginDb->close();
$userDb->close();
?>
