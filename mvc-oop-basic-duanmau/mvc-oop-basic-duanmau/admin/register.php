<?php
include '../classes/adminregister.php';
$reg = new adminregister();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminName  = $_POST['adminName'] ?? '';
    $adminEmail = $_POST['adminEmail'] ?? '';
    $adminUser  = $_POST['adminUser'] ?? '';
    $adminPass  = $_POST['adminPass'] ?? '';

    $register_check = $reg->register_admin($adminName, $adminEmail, $adminUser, $adminPass);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Admin</title>
    <style>
        form {
            width: 300px; margin: 0 auto; padding-top: 50px;
        }
        input { width: 100%; padding: 8px; margin: 10px 0; }
        .message { text-align: center; margin-bottom: 20px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <form action="register.php" method="POST">
        <h2>Đăng ký tài khoản Admin</h2>
        <div class="message">
            <?php if (isset($register_check)) echo $register_check; ?>
        </div>
        <input type="text" name="adminName" placeholder="Họ tên" required>
        <input type="email" name="adminEmail" placeholder="Email" required>
        <input type="text" name="adminUser" placeholder="Tài khoản" required>
        <input type="password" name="adminPass" placeholder="Mật khẩu" required>
        <input type="submit" value="Đăng ký">
    </form>
</body>
</html>
