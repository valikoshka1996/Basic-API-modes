<?php
// deleteWatch.php

header('Content-Type: application/json');

// Only accept DELETE requests
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only DELETE method is allowed"]);
    exit;
}

// Get the raw input and decode it
$input = json_decode(file_get_contents('php://input'), true);

// Validate input fields
if (empty($input['login_key']) || empty($input['share_token'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "The field login_key and share_token is required"]);
    exit;
}

$login_key = $input['login_key'];
$share_token = $input['share_token'];

// Database credentials
$db_user = 'root';
$db_password = 'Samfisher1996';

// Step 1: Verify login_key
try {
    $login_db = new PDO('mysql:host=localhost;dbname=login', $db_user, $db_password);
    $login_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $login_db->prepare("SELECT user_id FROM auth_tokens WHERE login_key = :login_key");
    $stmt->bindParam(':login_key', $login_key);
    $stmt->execute();

    $auth_result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$auth_result) {
        http_response_code(401); // Unauthorized
        echo json_encode(["error" => "User doesn’t authorised"]);
        exit;
    }

    $user_id = $auth_result['user_id'];
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}

// Step 2: Verify and delete share_token
try {
    $wishes_db = new PDO('mysql:host=localhost;dbname=wishes', $db_user, $db_password);
    $wishes_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $wishes_db->prepare(
        "SELECT * FROM wishes_watchers WHERE share_token = :share_token AND watcher_id = :user_id"
    );
    $stmt->bindParam(':share_token', $share_token);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $watch_result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$watch_result) {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "This token does not exist for this user"]);
        exit;
    }

    // Delete the record
    $stmt = $wishes_db->prepare(
        "DELETE FROM wishes_watchers WHERE share_token = :share_token AND watcher_id = :user_id"
    );
    $stmt->bindParam(':share_token', $share_token);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Response
    http_response_code(200); // OK
    echo json_encode([
        "status" => "success",
        "watcher_id" => $user_id,
        "share_token" => $share_token
    ]);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}

