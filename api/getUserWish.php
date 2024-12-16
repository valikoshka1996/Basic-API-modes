<?php
// Підключення до бази даних
$servername = "localhost";
$username = "root";
$password = "Samfisher1996";
$dbname = "wishes"; // Замініть на вашу базу даних

// Дозволяємо лише GET-запити
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(["error" => "Only GET requests are allowed"]);
    exit;
}

// Перевіряємо, чи переданий параметр user_id
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(["error" => "user_id is required"]);
    exit;
}

$user_id = intval($_GET['user_id']);

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Виконання запиту до бази даних
$sql = "SELECT id, name, price, link, jar, priority, `desc` FROM wishes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
if ($result->num_rows === 0) {
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "There are no wishes"
    ], JSON_PRETTY_PRINT);
} else {
    $wishes = [];
    while ($row = $result->fetch_assoc()) {
        $wishes[] = [
            "id" => $row["id"],
            "name" => $row["name"],
            "price" => number_format($row["price"], 2, '.', ''),
            "link" => $row["link"],
            "jar" => $row["jar"],
            "priority" => $row["priority"],
            "desc" => $row["desc"]
        ];
    }
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "data" => $wishes
    ], JSON_PRETTY_PRINT);
}

// Закриття з'єднання
$stmt->close();
$conn->close();
?>
