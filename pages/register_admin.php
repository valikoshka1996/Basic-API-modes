<?php
// Параметри підключення до бази даних
$servername = "localhost";
$username = "root";
$password = "Samfisher1996";
$dbname = "ip_database";

// Підключаємося до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевіряємо з'єднання
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Масив для зберігання дозволених IP
$allowedIPs = [];

// SQL запит для отримання всіх IP з таблиці trusted_ip
$query = "SELECT ip FROM trusted_ip";

// Виконуємо запит
$result = $conn->query($query);

// Перевіряємо, чи є результати
if ($result->num_rows > 0) {
    // Додаємо кожен IP в масив $allowedIPs
    while($row = $result->fetch_assoc()) {
        $allowedIPs[] = $row['ip'];
    }
} else {
    echo "0 results found.";
}

// Закриваємо з'єднання з базою даних
$conn->close();
?>


<?php require '../includes/db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <form method="post" action="">
        <h2>Реєстрація користувача</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зареєструватися</button>
    </form>
    <?php

// Перевіряємо, чи це POST-запит
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Отримуємо IP-адресу клієнта
    $clientIP = $_SERVER['REMOTE_ADDR'];

    // Перевіряємо, чи IP-адреса в списку дозволених
    if (!in_array($clientIP, $allowedIPs)) {
        // Якщо IP не дозволено, повертаємо помилку
        http_response_code(403);
        die('Доступ заборонено');
    } 
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $is_admin = 1;
        $stmt = $conn->prepare("INSERT INTO users (email, password, is_admin) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password, $is_admin]);

        echo "<p>Реєстрація успішна!</p>";
     }
    else {
}


    ?>
</body>
</html>
