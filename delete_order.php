<?php
include 'db.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    
    // 使用预处理语句来防止SQL注入
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    
    if ($stmt->execute()) {
        echo "订单删除成功";
    } else {
        echo "删除失败: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "未指定订单ID";
}

$conn->close();
?>
