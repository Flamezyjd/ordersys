<?php
$servername = "localhost";
$username = "root";
$password = "wyyzxhaetly";  // 如果没有密码，保持为空字符串
$dbname = "order_management";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
?>
