<?php
// Database credentials
$host = 'localhost';
$dbname = 'login';
$user = 'root';
$password = 'Samfisher1996';

// Allow only GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

header('Content-Type: application/json'); // Set response header as JSON

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count authorized users
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM auth_tokens");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the count in JSON format
    echo json_encode(['count' => (int)$result['count']]);
} catch (PDOException $e) {
    // Handle database connection errors
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?>
