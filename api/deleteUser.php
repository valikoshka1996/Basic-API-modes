<?php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Samfisher1996');
define('DB_API_KEYS', 'api_keys');
define('DB_USER_SYSTEM', 'user_system');

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only DELETE requests are allowed']);
    exit;
}

// Get input JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validate input fields
if (empty($data['admin_token']) || empty($data['delete_email'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'admin_token and delete_email are required']);
    exit;
}

$adminToken = $data['admin_token'];
$deleteEmail = $data['delete_email'];

try {
    // Connect to api_keys database
    $apiDb = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_API_KEYS, DB_USER, DB_PASS);
    $apiDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check admin_token
    $stmt = $apiDb->prepare("SELECT user_id FROM api_keys_table WHERE api_key = :admin_token");
    $stmt->bindParam(':admin_token', $adminToken);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'API key not found']);
        exit;
    }

    $userId = $result['user_id'];

    // Check if the user is an admin
    $isAdminResponse = file_get_contents("http://localhost/api/isAdmin.php?id=" . $userId);
    $isAdminData = json_decode($isAdminResponse, true);

    if (!$isAdminData || !$isAdminData['is_admin']) {
        http_response_code(403); // Forbidden
        echo json_encode(['error' => "User isn't admin"]);
        exit;
    }

    // Connect to user_system database
    $userDb = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_USER_SYSTEM, DB_USER, DB_PASS);
    $userDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user exists
    $stmt = $userDb->prepare("SELECT id FROM users WHERE email = :delete_email");
    $stmt->bindParam(':delete_email', $deleteEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Delete the user
    $stmt = $userDb->prepare("DELETE FROM users WHERE email = :delete_email");
    $stmt->bindParam(':delete_email', $deleteEmail);
    $stmt->execute();

    // Respond with success
    http_response_code(200); // OK
    echo json_encode(['message' => 'User deleted successfully']);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    exit;
}
?>
