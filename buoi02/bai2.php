<?php
// Khai báo biến $x là chuỗi (string) và $y là số nguyên (int)
$x = "5"; // Kiểu string[cite: 4]
$y = 5;   // Kiểu int[cite: 4]

// In kiểu dữ liệu của biến ra màn hình để kiểm tra
echo "Kiểu dữ liệu của \$x: " . gettype($x) . "<br>"; // string[cite: 4]
echo "Kiểu dữ liệu của \$y: " . gettype($y) . "<br>"; // integer[cite: 4]

// Thực hiện phép cộng $x + $y
$sum = $x + $y; 

echo "Kết quả của \$x + \$y là: " . $sum; // Kết quả: 10 (PHP tự chuyển chuỗi "5" thành số 5)[cite: 4]
?>