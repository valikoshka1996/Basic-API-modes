<?php
// Database credentials
$login_db_host = "localhost";
$login_db_name = "login";
$login_db_user = "root";
$login_db_pass = "Samfisher1996";

$wishes_db_host = "localhost";
$wishes_db_name = "wishes";
$wishes_db_user = "root";
$wishes_db_pass = "Samfisher1996";

// Set response headers
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Only GET requests are allowed."]);
    exit;
}

if (!isset($_GET['login_key']) || empty($_GET['login_key'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing login_key parameter."]);
    exit;
}

$login_key = $_GET['login_key'];

// Step 1: Check login_key in the login database
try {
    $login_db = new PDO("mysql:host=$login_db_host;dbname=$login_db_name", $login_db_user, $login_db_pass);
    $login_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $login_db->prepare("SELECT user_id FROM auth_tokens WHERE login_key = :login_key");
    $stmt->execute(['login_key' => $login_key]);
    $auth_token = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$auth_token) {
        http_response_code(401);
        echo json_encode(["error" => "User not logged in."]);
        exit;
    }

    $user_id = $auth_token['user_id'];
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection error: " . $e->getMessage()]);
    exit;
}

// Step 2: Check share_token in the wishes database
try {
    $wishes_db = new PDO("mysql:host=$wishes_db_host;dbname=$wishes_db_name", $wishes_db_user, $wishes_db_pass);
    $wishes_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $wishes_db->prepare("SELECT share_token FROM share_tokens WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $share_token_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$share_token_record) {
        http_response_code(404);
        echo json_encode(["error" => "User hasn't shared a token."]);
        exit;
    }

    $share_token = $share_token_record['share_token'];
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection error: " . $e->getMessage()]);
    exit;
}

// Step 3: Find watchers in the wishes_watchers table
try {
    $stmt = $wishes_db->prepare("SELECT watcher_id FROM wishes_watchers WHERE share_token = :share_token");
    $stmt->execute(['share_token' => $share_token]);
    $watchers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($watchers)) {
        http_response_code(404);
        echo json_encode(["error" => "User doesn't have watchers."]);
        exit;
    }

    $response = [];
    foreach ($watchers as $watcher) {
        $response[] = ["watcher_id" => $watcher['watcher_id']];
    }

    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection error: " . $e->getMessage()]);
    exit;
}
?>
