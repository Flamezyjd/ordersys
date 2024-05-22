<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $order_date = $_POST['order_date'];
    $payment_status = isset($_POST['payment_status']) ? 1 : 0;
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO orders (customer_name, product, quantity, price, order_date, payment_status, phone, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidsiss", $customer_name, $product, $quantity, $price, $order_date, $payment_status, $phone, $email);

    if ($stmt->execute()) {
        echo "订单添加成功";
    } else {
        echo "添加订单失败: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "无效的请求";
}

$conn->close();
?>
