<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input fields
if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Email and password are required"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// Database connection
$mysqli = new mysqli("localhost", "root", "Samfisher1996", "user_system");

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Check if the user exists
$stmt = $mysqli->prepare("SELECT id, email, password, is_admin FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "User does not exist"]);
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["error" => "Wrong password"]);
    exit;
}

// Extract user details
$userId = $user['id'];
$email = $user['email'];
$isAdmin = $user['is_admin'];

// Connect to the login database
$mysqli_login = new mysqli("localhost", "root", "Samfisher1996", "login");

if ($mysqli_login->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Remove existing auth token if any
$stmt = $mysqli_login->prepare("DELETE FROM auth_tokens WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

// Generate a new token
$loginKey = bin2hex(random_bytes(16));

// Insert the new token
$stmt = $mysqli_login->prepare("INSERT INTO auth_tokens (login_key, user_id) VALUES (?, ?)");
$stmt->bind_param("si", $loginKey, $userId);
$stmt->execute();

// Respond with user details and token
$response = [
    "id" => $userId,
    "email" => $email,
    "is_admin" => $isAdmin,
    "login_key" => $loginKey
];

http_response_code(200);
echo json_encode($response);

// Close connections
$stmt->close();
$mysqli->close();
$mysqli_login->close();
?>
