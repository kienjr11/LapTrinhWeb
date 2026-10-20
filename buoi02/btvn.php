<?php
// Khởi tạo các biến lưu trữ giá trị form và thông báo
$name = "";
$cc = "";
$mid = "";
$final = "";
$tongKet = "";
$xepLoai = "";
$message = "";
$hasError = false;

// 1. Hàm kiểm tra điểm hợp lệ (từ 0 đến 10)
function isValidScore($score): bool {
    return is_numeric($score) && $score >= 0 && $score <= 10;
}

// 2. Hàm tính điểm tổng kết (10% chuyên cần, 30% giữa kỳ, 60% cuối kỳ)
function finalScore(float $cc, float $mid, float $final): float {
    return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
}

// Hàm xếp loại điểm
function xepLoaiHocLuc(float $score): string {
    if ($score >= 8.0) {
        return "Giỏi";
    } elseif ($score >= 6.5) {
        return "Khá";
    } elseif ($score >= 5.0) {
        return "Trung bình";
    } else {
        return "Chưa đạt";
    }
}

// Xử lý khi người dùng bấm nút Gửi form bằng phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $cc = trim($_POST['cc'] ?? '');
    $mid = trim($_POST['mid'] ?? '');
    $final = trim($_POST['final'] ?? '');

    // Kiểm tra các trường không được để trống
    if ($name === '' || $cc === '' || $mid === '' || $final === '') {
        $message = "Vui lòng nhập đầy đủ họ tên và tất cả các đầu điểm!";
        $hasError = true;
    } 
    // Kiểm tra tính hợp lệ của điểm số (phải từ 0 đến 10)
    elseif (!isValidScore($cc) || !isValidScore($mid) || !isValidScore($final)) {
        $message = "Lỗi: Điểm các thành phần phải là số và nằm trong khoảng từ 0 đến 10!";
        $hasError = true;
    } else {
        // Tính toán khi dữ liệu hoàn toàn hợp lệ
        $diemTongKet = finalScore((float)$cc, (float)$mid, (float)$final);
        $tongKet = round($diemTongKet, 2); // Làm tròn 2 chữ số thập phân
        $xepLoai = xepLoaiHocLuc($tongKet);
        $message = "Tính điểm thành công!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài tập 2.9 - Máy tính điểm học phần</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; }
        .container { width: 480px; background: #fff; border: 1px solid #ccc; padding: 25px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 18px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
        button:hover { background-color: #0056b3; }
        .alert-error { margin-top: 15px; padding: 12px; border-radius: 4px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { margin-top: 15px; padding: 12px; border-radius: 4px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="container">
    <h2>Máy tính điểm học phần</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Họ và tên sinh viên:</label>
            <!-- Giữ lại dữ liệu đã nhập bằng htmlspecialchars -->
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ví dụ: Đỗ Trung Kiên">
        </div>
        <div class="form-group">
            <label for="cc">Điểm Chuyên cần (10%):</label>
            <input type="text" id="cc" name="cc" value="<?php echo htmlspecialchars($cc, ENT_QUOTES, 'UTF-8'); ?>" placeholder="0 - 10">
        </div>
        <div class="form-group">
            <label for="mid">Điểm Giữa kỳ (30%):</label>
            <input type="text" id="mid" name="mid" value="<?php echo htmlspecialchars($mid, ENT_QUOTES, 'UTF-8'); ?>" placeholder="0 - 10">
        </div>
        <div class="form-group">
            <label for="final">Điểm Cuối kỳ (60%):</label>
            <input type="text" id="final" name="final" value="<?php echo htmlspecialchars($final, ENT_QUOTES, 'UTF-8'); ?>" placeholder="0 - 10">
        </div>
        <button type="submit">Tính điểm tổng kết</button>
    </form>

    <?php if ($message !== ""): ?>
        <?php if ($hasError): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php else: ?>
            <div class="alert-success">
                <b><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></b><br>
                Họ tên: <b><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></b><br>
                Điểm tổng kết: <span style="font-size: 18px; color: #d9534f;"><?php echo $tongKet; ?></span><br>
                Xếp loại: <b><?php echo $xepLoai; ?></b>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>