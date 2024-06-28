<?php
session_start();

if (!isset($_SESSION['adminid'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['adminusername']); ?>!</h2>
    <p>This is the admin panel.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
