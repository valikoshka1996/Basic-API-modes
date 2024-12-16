<?php
// addMyWatch.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Database credentials
$db_credentials = [
    'login' => ['host' => 'localhost', 'dbname' => 'login', 'user' => 'root', 'password' => 'Samfisher1996'],
    'wishes' => ['host' => 'localhost', 'dbname' => 'wishes', 'user' => 'root', 'password' => 'Samfisher1996']
];

// Retrieve JSON input
$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['login_key']) || empty($input['share_token'])) {
    echo json_encode(['error' => 'Required fields login_key and share_token']);
    exit;
}

$login_key = $input['login_key'];
$share_token = $input['share_token'];

try {
    // Connect to login database
    $login_db = new PDO("mysql:host=" . $db_credentials['login']['host'] . ";dbname=" . $db_credentials['login']['dbname'], $db_credentials['login']['user'], $db_credentials['login']['password']);
    $login_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if login_key exists
    $stmt = $login_db->prepare("SELECT user_id FROM auth_tokens WHERE login_key = :login_key");
    $stmt->bindParam(':login_key', $login_key);
    $stmt->execute();
    $auth = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$auth) {
        echo json_encode(['error' => 'User isn\'t logged in']);
        exit;
    }

    $user_id = $auth['user_id'];

    // Connect to wishes database
    $wishes_db = new PDO("mysql:host=" . $db_credentials['wishes']['host'] . ";dbname=" . $db_credentials['wishes']['dbname'], $db_credentials['wishes']['user'], $db_credentials['wishes']['password']);
    $wishes_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if share_token exists
    $stmt = $wishes_db->prepare("SELECT user_id FROM share_tokens WHERE share_token = :share_token");
    $stmt->bindParam(':share_token', $share_token);
    $stmt->execute();
    $share = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$share) {
        echo json_encode(['error' => "The token $share_token share_token doesn\'t exist"]);
        exit;
    }

    if ($share['user_id'] == $user_id) {
        echo json_encode(['error' => 'You cannot watch own wish list']);
        exit;
    }

    // Check if the user is already watching
    $stmt = $wishes_db->prepare("SELECT 1 FROM wishes_watchers WHERE share_token = :share_token AND watcher_id = :watcher_id");
    $stmt->bindParam(':share_token', $share_token);
    $stmt->bindParam(':watcher_id', $user_id);
    $stmt->execute();

    if ($stmt->fetch()) {
        echo json_encode(['error' => 'You\'ve already watch this user']);
        exit;
    }

    // Add watcher record
    $stmt = $wishes_db->prepare("INSERT INTO wishes_watchers (share_token, watcher_id) VALUES (:share_token, :watcher_id)");
    $stmt->bindParam(':share_token', $share_token);
    $stmt->bindParam(':watcher_id', $user_id);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}