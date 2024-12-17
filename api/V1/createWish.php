<?php
header('Content-Type: application/json');

// Підключення до бази даних
$dsn = 'mysql:host=localhost;dbname=wishes;charset=utf8mb4';
$username = 'root';
$password = 'Samfisher1996';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests are allowed.']);
    exit;
}

// Читання тіла запиту
$data = json_decode(file_get_contents('php://input'), true);

// Перевірка обов'язкових полів
$requiredFields = ['login_key', 'name'];
$missingFields = [];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        $missingFields[] = $field;
    }
}
if (!empty($missingFields)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields: ' . implode(', ', $missingFields)]);
    exit;
}

// Валідація полів
if (!filter_var($data['link'] ?? '', FILTER_VALIDATE_URL) && !empty($data['link'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid URL format for field link.']);
    exit;
}
if (!preg_match('/^send\.monobank\.ua\/jar\/.+$/', $data['jar'] ?? '') && !empty($data['jar'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid format for field jar. Example: send.monobank.ua/jar/example']);
    exit;
}
if (!in_array($data['priority'] ?? 'medium', ['low', 'medium', 'high'], true)) {
    $data['priority'] = 'medium';
}
if (!is_bool($data['visibility'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Visibility must be a boolean value.']);
    exit;
}

// Перевірка login_key
$stmt = $pdo->prepare('SELECT user_id FROM login.auth_tokens WHERE login_key = :login_key');
$stmt->execute(['login_key' => $data['login_key']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in.']);
    exit;
}

if($data['visibility']){
    $data['visibility'] = 1;
} else {
    $data['visibility'] = 0;
}

// Підготовка даних для вставки
$insertData = [
    'user_id' => $user['user_id'],
    'name' => $data['name'],
    'price' => $data['price'] ?? null,
    'link' => $data['link'] ?? null,
    'jar' => $data['jar'] ?? null,
    'priority' => $data['priority'],
    'visibility' => $data['visibility'],
    'desc' => $data['desc'] ?? null,
    'img' => $data['img'] ?? null,
];

// Вставка даних у таблицю wishes
$sql = "INSERT INTO wishes (user_id, name, price, link, jar, priority, visibility, `desc`, img) 
        VALUES (:user_id, :name, :price, :link, :jar, :priority, :visibility, :desc, :img)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute($insertData)) {
    http_response_code(201);
    echo json_encode(['success' => 'Wish successfully created.']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create wish.']);
}
?>