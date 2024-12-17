<?php
// getMyWatch.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

if (!isset($_GET['login_key']) || empty($_GET['login_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameter: login_key']);
    exit;
}

$loginKey = $_GET['login_key'];

try {
    // Database connection credentials
    $authDb = new PDO('mysql:host=localhost;dbname=login', 'root', 'Samfisher1996');
    $authDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $wishesDb = new PDO('mysql:host=localhost;dbname=wishes', 'root', 'Samfisher1996');
    $wishesDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate login_key in auth_tokens
    $stmt = $authDb->prepare('SELECT user_id FROM auth_tokens WHERE login_key = :login_key');
    $stmt->execute(['login_key' => $loginKey]);
    $authRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$authRecord) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid login_key']);
        exit;
    }

    $userId = $authRecord['user_id'];

    // Fetch watcher records
    $stmt = $wishesDb->prepare('SELECT share_token FROM wishes_watchers WHERE watcher_id = :user_id');
    $stmt->execute(['user_id' => $userId]);
    $watcherRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($watcherRecords)) {
        echo json_encode(['result' => 'No subscribes for this user']);
        exit;
    }

    $shareTokens = array_column($watcherRecords, 'share_token');

    $missingUsers = [];
    $response = [];

    foreach ($shareTokens as $shareToken) {
        $stmt = $wishesDb->prepare('SELECT user_id FROM share_tokens WHERE share_token = :share_token');
        $stmt->execute(['share_token' => $shareToken]);
        $shareRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($shareRecord) {
            $response[] = [
                'user_id' => $shareRecord['user_id'],
                'share_token' => $shareToken
            ];
        } else {
            $missingUsers[] = $shareToken;
        }
    }

    if (!empty($missingUsers)) {
        $response[] = ['missing_users' => $missingUsers];
    }

    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}