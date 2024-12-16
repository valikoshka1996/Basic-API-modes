<?php
header('Content-Type: application/json');

// Перевірка, що запит є PATCH
if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(["error" => "Only PATCH requests are allowed"]);
    exit;
}

// Зчитування вхідних даних
$input = json_decode(file_get_contents("php://input"), true);

// Перевірка обов'язкових полів
if (empty($input['login_key']) || empty($input['wish_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "The field login_key and wish_id is required"]);
    exit;
}

$login_key = $input['login_key'];
$wish_id = $input['wish_id'];

// Збір інших полів для оновлення
$allowedFields = ['name', 'visibility', 'price', 'link', 'jar', 'priority', 'desc'];
$updateFields = [];

foreach ($allowedFields as $field) {
    if (isset($input[$field])) {
        $updateFields[$field] = $input[$field];
    }
}

if (count($updateFields) === 0) {
    echo json_encode(["message" => "There is no data to update"]);
    exit;
}

// Валідація даних
$errors = [];
if (isset($updateFields['price']) && !is_numeric($updateFields['price'])) {
    $errors[] = "Invalid price format";
}
if (isset($updateFields['link']) && !filter_var($updateFields['link'], FILTER_VALIDATE_URL)) {
    $errors[] = "Invalid link URL format";
}
if (isset($updateFields['jar']) && !preg_match('/^send\.monobank\.ua\/jar\/.+/', $updateFields['jar'])) {
    $errors[] = "Invalid jar URL format";
}
if (isset($updateFields['priority']) && !in_array($updateFields['priority'], ['low', 'medium', 'high'])) {
    $errors[] = "Priority must be one of 'low', 'medium', or 'high";
}

if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode(["error" => $errors]);
    exit;
}

try {
    // Підключення до бази даних login для auth_tokens
    $authPdo = new PDO("mysql:host=localhost;dbname=login", "root", "Samfisher1996");
    $authPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка авторизаційного ключа
    $stmt = $authPdo->prepare("SELECT user_id FROM auth_tokens WHERE login_key = ?");
    $stmt->execute([$login_key]);
    $auth = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$auth) {
        http_response_code(401);
        echo json_encode(["error" => "User isn’t log in"]);
        exit;
    }
    $user_id = $auth['user_id'];

    // Підключення до wishes для подальших операцій
    $wishesPdo = new PDO("mysql:host=localhost;dbname=wishes", "root", "Samfisher1996");
    $wishesPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Перевірка власника бажання через API getWishById.php
    $url = "http://localhost/api/getWishById.php?id=$wish_id&data=user_id";
    $response = file_get_contents($url);
    $wishData = json_decode($response, true);

    if (isset($wishData['error'])) {
        http_response_code(404);
        echo json_encode(["error" => "Wish does not exist"]);
        exit;
    }
    if ($wishData['user_id'] !== $user_id) {
        http_response_code(403);
        echo json_encode(["error" => "User ID does not match"]);
        exit;
    }

// Оновлення запису
$updateParts = [];
foreach ($updateFields as $field => $value) {
    // Обгортаємо зарезервовані слова у бектики
    if ($field === 'desc') {
        $updateParts[] = "`$field` = :$field";
    } else {
        $updateParts[] = "$field = :$field";
    }
}

$updateSQL = "UPDATE wishes SET " . implode(', ', $updateParts) . " WHERE id = :wish_id";
$stmt = $wishesPdo->prepare($updateSQL);

// Прив'язка значень
foreach ($updateFields as $field => &$value) {
    $stmt->bindParam(":" . $field, $value);
}
$stmt->bindParam(":wish_id", $wish_id);

$stmt->execute();

    echo json_encode(["message" => "The record $wish_id has successfully updated"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

?>
