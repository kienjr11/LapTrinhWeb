<?php
// Khai báo biến $x là chuỗi (string) và $y là số nguyên (int)
$x = "5"; // Kiểu string[cite: 4]
$y = 5;   // Kiểu int[cite: 4]

// In kiểu dữ liệu của biến ra màn hình để kiể=m tra
echo "Kiểu dữ liệu của \$x: " . gettype($x) . "<br>"; 
echo "Kiểu dữ liệu của \$y: " . gettype($y) . "<br>";

// Thực hiện phép cộng $x + $y
$sum = $x + $y; 

echo "Kết quả của \$x + \$y là: " . $sum; 