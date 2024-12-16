<?php
// Налаштування підключення до бази даних
$dbUser = 'root';
$dbPassword = 'Samfisher1996';

// Бази даних
$apiDbName = 'api_keys';
$ipDbName = 'ip_database';

// Відповідь за замовчуванням
header('Content-Type: application/json');
$response = [
    'status' => 'error',
    'message' => 'Invalid request.'
];

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    $response['message'] = 'Only POST requests are allowed.';
    echo json_encode($response);
    exit;
}

// Отримання JSON-запиту
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['api_key']) || !isset($input['ip'])) {
    http_response_code(400); // Bad Request
    $response['message'] = 'Fields api_key and ip are required.';
    echo json_encode($response);
    exit;
}

$apiKey = $input['api_key'];
$ip = $input['ip'];

// Перевірка формату IP
if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    http_response_code(400); // Bad Request
    $response['message'] = 'Invalid IP format. Only IPv4 addresses are allowed.';
    echo json_encode($response);
    exit;
}

// Перевірка API ключа на адміністративні права
$adminCheckUrl = "http://localhost/api/isKeyAdmin.php?api_key=" . urlencode($apiKey);
$adminResponse = @file_get_contents($adminCheckUrl);

if ($adminResponse === FALSE) {
    http_response_code(500); // Internal Server Error
    $response['message'] = 'Failed to verify admin status.';
    echo json_encode($response);
    exit;
}

$adminData = json_decode($adminResponse, true);

if (!isset($adminData['is_admin']) || $adminData['is_admin'] !== true) {
    http_response_code(403); // Forbidden
    $response['message'] = 'Access denied.';
    echo json_encode($response);
    exit;
}

try {
    // Підключення до бази даних api_keys
    $apiDb = new PDO("mysql:host=localhost;dbname=$apiDbName", $dbUser, $dbPassword);
    $apiDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка, чи існує API ключ
    $stmt = $apiDb->prepare('SELECT id FROM api_keys_table WHERE api_key = :api_key');
    $stmt->bindParam(':api_key', $apiKey);
    $stmt->execute();
    $keyRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$keyRecord) {
        http_response_code(404); // Not Found
        $response['message'] = 'API key not found.';
        echo json_encode($response);
        exit;
    }

    // Підключення до бази даних ip_database
    $ipDb = new PDO("mysql:host=localhost;dbname=$ipDbName", $dbUser, $dbPassword);
    $ipDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Додавання IP адреси в таблицю trusted_ip
    $stmt = $ipDb->prepare('INSERT INTO trusted_ip (ip) VALUES (:ip)');
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    // Успішний респонс
    http_response_code(200); // OK
    $response['status'] = 'success';
    $response['message'] = 'IP address has been added successfully.';
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    $response['message'] = 'Database error: ' . $e->getMessage();
}

// Вивід відповіді
echo json_encode($response);
?>
