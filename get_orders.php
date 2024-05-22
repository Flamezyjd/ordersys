<?php
include 'db.php';

$sql = "SELECT id, customer_name, product, quantity, price, order_date, payment_status, phone, email FROM orders";
$result = $conn->query($sql);

$orders = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
} 

echo json_encode($orders);

$conn->close();
?>
