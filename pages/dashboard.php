<?php
require '/var/www/html/includes/db_connect.php';
require '/var/www/html/includes/funtions.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
$email = $_SESSION['email'];
$isAdmin = isAdmin($email, $conn);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1><?php echo $isAdmin ? "Адмін" : $email; ?></h1>
</body>
</html>
