<?php
header('Content-Type: application/json');

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only POST requests are allowed"]);
    exit;
}

// Retrieve input data
$data = json_decode(file_get_contents('php://input'), true);

// Validate presence of required fields
if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Both 'email' and 'password' fields are required"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "This is not a mail"]);
    exit;
}

// Validate password length
if (strlen($password) < 6) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "At least 6 symbols required"]);
    exit;
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Database credentials
$host = 'localhost';
$dbname = 'user_system';
$username = 'root';
$passwordDb = 'Samfisher1996';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $passwordDb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user already exists
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();

    if ($checkStmt->fetchColumn() > 0) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "User already exists"]);
        exit;
    }

    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (email, password, is_admin) VALUES (:email, :password, 0)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["message" => "success"]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to create user"]);
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => $e->getMessage()]);
}
?>
