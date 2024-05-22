<?php
require 'vendor/autoload.php';
include 'db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['excel_file']['tmp_name'];
    $spreadsheet = IOFactory::load($fileTmpPath);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    $emptyRows = [];

    // 假设Excel表格第一行为列标题
    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // 跳过标题行

        $customer_name = $row[0];

        // 检查 customer_name 是否为空
        if (empty($customer_name)) {
            $emptyRows[] = $index + 1;
            continue;
        }

        $product = $row[1];
        $quantity = $row[2];
        $price = $row[3];
        
        // 检查日期是否为空
        $order_date = !empty($row[4]) ? DateTime::createFromFormat('m/d/Y', $row[4])->format('Y-m-d') : null;

        $payment_status = $row[5] == '是' ? 1 : 0;
        $phone = $row[6];
        $email = $row[7];

        $sql = "INSERT INTO orders (customer_name, product, quantity, price, order_date, payment_status, phone, email)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidsiss", $customer_name, $product, $quantity, $price, $order_date, $payment_status, $phone, $email);

        if (!$stmt->execute()) {
            echo "导入失败: " . $stmt->error;
            exit;
        }
    }

    if (!empty($emptyRows)) {
        echo "<script>alert('以下行的客户姓名为空，已跳过插入操作：" . implode(', ', $emptyRows) . "');</script>";
    }

    echo "<script>alert('数据导入成功');</script>";
} else {
    echo "文件上传失败";
}

$conn->close();
?>
