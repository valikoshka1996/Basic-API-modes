<?php require '../includes/db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <form method="post" action="">
        <h2>Авторизація</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Увійти</button>
    </form>
    <?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: ../index.php");
        } else {
            echo "<p>Невірний логін або пароль</p>";
        }
    }
    ?>
</body>
</html>
