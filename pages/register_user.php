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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $password]);

        echo "<p>Реєстрація успішна!</p>";
    }
    ?>
</body>
</html>

