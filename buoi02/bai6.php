<?php
// Khai báo các biến lưu trữ
$cc = "";
$mid = "";
$final = "";
$tongKet = "";
$message = "";

// Hàm tính điểm tổng kết (10% chuyên cần, 30% giữa kỳ, 60% cuối kỳ)
function finalScore(float $cc, float $mid, float $final): float {
    return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
}

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cc = trim($_POST['cc'] ?? '');
    $mid = trim($_POST['mid'] ?? '');
    $final = trim($_POST['final'] ?? '');

    // Kiểm tra tính hợp lệ của dữ liệu (phải là số từ 0 đến 10)
    if ($cc === '' || $mid === '' || $final === '') {
        $message = "Vui lòng nhập đầy đủ các đầu điểm!";
    } elseif (!is_numeric($cc) || !is_numeric($mid) || !is_numeric($final) || 
              $cc < 0 || $cc > 10 || $mid < 0 || $mid > 10 || $final < 0 || $final > 10) {
        $message = "Các đầu điểm phải là số hợp lệ từ 0 đến 10!";
    } else {
        // Gọi hàm tính điểm tổng kết
        $diemTongKet = finalScore((float)$cc, (float)$mid, (float)$final);
        $tongKet = round($diemTongKet, 2); // Làm tròn 2 chữ số thập phân
        $message = "Tính điểm thành công!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 2.5 - Hàm tính điểm tổng kết</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-box { border: 1px solid #ccc; padding: 20px; width: 380px; border-radius: 5px; }
        .input-group { margin-bottom: 12px; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .result { margin-top: 15px; padding: 10px; border-radius: 3px; background-color: #d4edda; color: #155724; }
        .error { margin-top: 15px; padding: 10px; border-radius: 3px; background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Tính điểm tổng kết môn học</h2>
    <form action="" method="POST">
        <div class="input-group">
            <label for="cc">Điểm Chuyên cần (10%):</label>
            <input type="text" id="cc" name="cc" value="<?php echo htmlspecialchars($cc); ?>" placeholder="Ví dụ: 9">
        </div>
        <div class="input-group">
            <label for="mid">Điểm Giữa kỳ (30%):</label>
            <input type="text" id="mid" name="mid" value="<?php echo htmlspecialchars($mid); ?>" placeholder="Ví dụ: 7.5">
        </div>
        <div class="input-group">
            <label for="final">Điểm Cuối kỳ (60%):</label>
            <input type="text" id="final" name="final" value="<?php echo htmlspecialchars($final); ?>" placeholder="Ví dụ: 8">
        </div>
        <button type="submit">Tính điểm tổng kết</button>
    </form>

    <?php if ($message !== ""): ?>
        <?php if ($tongKet !== ""): ?>
            <div class="result">
                <b><?php echo $message; ?></b><br>
                Điểm tổng kết của bạn là: <span style="font-size: 18px; color: #d9534f;"><?php echo $tongKet; ?></span>
            </div>
        <?php else: ?>
            <div class="error">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>