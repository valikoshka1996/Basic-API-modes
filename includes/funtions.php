<?php
function isAdmin($email, $conn) {
    $stmt = $conn->prepare("SELECT is_admin FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result && $result['is_admin'] == 1;
}
?>
