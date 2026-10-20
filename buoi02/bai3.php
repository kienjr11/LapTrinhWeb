<?php
// Bài tập tại slide: Dự đoán kết quả các phép so sánh
// 1. 0 == "0" (So sánh lỏng: có tự động chuyển đổi kiểu dữ liệu)
$kq1 = (0 == "0") ? "true" : "false";
echo "0 == \"0\" kết quả là: " . $kq1 . "<br>"; // true (vì chuỗi "0" được tự động đổi thành số 0)[cite: 6]

// 2. 0 === "0" (So sánh chặt: so sánh cả giá trị và kiểu dữ liệu)
$kq2 = (0 === "0") ? "true" : "false";
echo "0 === \"0\" kết quả là: " . $kq2 . "<br>"; // false (vì 0 là int, còn "0" là string)[cite: 6]

// 3. false == 0 (So sánh lỏng: boolean false được ép kiểu thành số 0 khi so sánh)
$kq3 = (false == 0) ? "true" : "false";
echo "false == 0 kết quả là: " . $kq3 . "<br>"; // true[cite: 6]
?>