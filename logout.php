<?php
// logout.php
session_start(); // Запускаємо сесію

// Очищуємо всі дані сесії
$_SESSION = [];

// Завершуємо сесію
session_destroy();

// Перенаправляємо користувача на сторінку входу
header("Location: index.php");
exit();
?>
