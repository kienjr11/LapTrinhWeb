<?php
// Khai báo các biến lưu trữ
$score = "";
$message = "";
$xepLoai = "";

// Hàm xếp loại điểm
function xepLoaiDiem($value) {
    if (!is_numeric($value) || $value < 0 || $value > 10) {
        return false;
    }
    
    $score = floatval($value);
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

// Xử lý khi người dùng bấm nút Gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = isset($_POST['score']) ? trim($_POST['score']) : '';

    if ($score === '') {
        $message = "Vui lòng nhập điểm!";
    } else {
        $ketQua = xepLoaiDiem($score);
        if ($ketQua !== false) {
            $message = "Điểm hợp lệ: " . htmlspecialchars($score);
            $xepLoai = "Xếp loại: <b>$ketQua</b>";
        } else {
            $message = "Điểm KHÔNG hợp lệ! Điểm phải là số từ 0 đến 10.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài tập - Nhập và Xếp loại điểm</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-box { border: 1px solid #ccc; padding: 20px; width: 350px; border-radius: 5px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 15px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .alert { margin-top: 15px; padding: 10px; border-radius: 3px; background-color: #e9ecef; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Nhập điểm học sinh</h2>
    <form action="" method="POST">
        <div class="input-group">
            <label for="score">Nhập điểm (0 - 10):</label>
            <input type="text" id="score" name="score" value="<?php echo htmlspecialchars($score); ?>" placeholder="Ví dụ: 8.5">
        </div>
        <button type="submit">Kiểm tra & Xếp loại</button>
    </form>

    <?php if ($message !== ""): ?>
        <div class="alert">
            <?php echo $message; ?><br>
            <?php if ($xepLoai !== "") echo $xepLoai; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>