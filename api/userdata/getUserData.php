<?php
// Заголовок для JSON відповіді
header('Content-Type: application/json');

// Перевірка типу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed. Only GET is supported.']);
    exit;
}

// Перевірка наявності параметра login_key
if (!isset($_GET['login_key']) || empty($_GET['login_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'login_key is required']);
    exit;
}

// Дозволені значення для параметра "data"
$allowed_data_params = ['name', 'surname', 'birth_date', 'sex', 'about', 'adress'];

// Зчитування параметрів
$login_key = $_GET['login_key'];
$data_params = isset($_GET['data']) ? explode(',', $_GET['data']) : [];

// Перевірка параметра "data"
foreach ($data_params as $param) {
    if (!in_array($param, $allowed_data_params)) {
        http_response_code(400);
        echo json_encode(['error' => "no parameter '$param' for data"]);
        exit;
    }
}

// Підключення до бази даних
$auth_conn = new mysqli('localhost', 'root', 'Samfisher1996', 'login');
if ($auth_conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Перевірка наявності login_key у таблиці auth_tokens
$login_key = $auth_conn->real_escape_string($login_key);
$auth_query = "SELECT user_id FROM auth_tokens WHERE login_key = '$login_key' LIMIT 1";
$auth_result = $auth_conn->query($auth_query);

if ($auth_result->num_rows === 0) {
    http_response_code(401);
    echo json_encode(['error' => 'User does not authorized']);
    $auth_conn->close();
    exit;
}

// Отримання user_id
$user_id = $auth_result->fetch_assoc()['user_id'];
$auth_conn->close();

// Підключення до бази user_system для отримання даних користувача
$user_conn = new mysqli('localhost', 'root', 'Samfisher1996', 'user_system');
if ($user_conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Пошук даних користувача
$user_query = "SELECT name, surname, birth_date, sex, about, adress FROM user_data WHERE user_id = '$user_id' LIMIT 1";
$user_result = $user_conn->query($user_query);

if ($user_result->num_rows === 0) {
    echo json_encode(['message' => 'no data']);
    $user_conn->close();
    exit;
}

// Отримання даних
$user_data = $user_result->fetch_assoc();
$user_conn->close();

// Повернення відповідних даних залежно від параметра data
if (!empty($data_params)) {
    $filtered_data = [];
    foreach ($data_params as $param) {
        if (isset($user_data[$param])) {
            $filtered_data[$param] = $user_data[$param];
        }
    }
    echo json_encode($filtered_data);
} else {
    // Повернення усіх полів, якщо data не вказано
    echo json_encode($user_data);
}
exit;