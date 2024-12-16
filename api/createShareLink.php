<?php
// createShareLink.php

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed. Only POST requests are accepted."]);
    exit;
}

header('Content-Type: application/json');

// Check if login_key is provided
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['login_key'])) {
    echo json_encode(["error" => "login_key is required"]);
    exit;
}

$login_key = $input['login_key'];

// Check if user is logged in
$is_logged_in_url = "http://localhost/api/isLogIn.php?login_key=" . urlencode($login_key);
$response = file_get_contents($is_logged_in_url);
$login_status = json_decode($response, true);

if (!$login_status || !$login_status['is_loged_in']) {
    echo json_encode(["error" => "User is not logged in"]);
    exit;
}

// Database connection details
$host = 'localhost';
$username = 'root';
$password = 'Samfisher1996';
$login_db = 'login';
$wishes_db = 'wishes';

try {
    $pdo_login = new PDO("mysql:host=$host;dbname=$login_db", $username, $password);
    $pdo_wishes = new PDO("mysql:host=$host;dbname=$wishes_db", $username, $password);
    $pdo_login->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_wishes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Find user ID from login_key
    $stmt = $pdo_login->prepare("SELECT * FROM auth_tokens WHERE login_key = :login_key");
    $stmt->execute(['login_key' => $login_key]);
    $auth_token = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$auth_token) {
        echo json_encode(["error" => "There are no logged in users with login_key"]);
        exit;
    }

    $user_id = $auth_token['user_id'] ?? null;
    if (!$user_id) {
        echo json_encode(["error" => "DB error: no value for user_id"]);
        exit;
    }

    // Check if a share token already exists for this user
    $stmt = $pdo_wishes->prepare("SELECT * FROM share_tokens WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $existing_token = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_token) {
        echo json_encode([
            "share_token" => $existing_token['share_token'],
            "is_generated_previously" => true
        ]);
        exit;
    }

    // Generate a new share token
    $share_token = bin2hex(random_bytes(16));

    // Insert new share token
    $stmt = $pdo_wishes->prepare("INSERT INTO share_tokens (user_id, share_token) VALUES (:user_id, :share_token)");
    $stmt->execute([
        'user_id' => $user_id,
        'share_token' => $share_token
    ]);

    echo json_encode([
        "share_token" => $share_token,
        "is_generated_previously" => false
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}
?>
