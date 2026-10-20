<?php
// Khai báo các biến lưu trữ
$score = "";
$message = "";
$isValid = null;

// Kiểm tra hàm xử lý kiểm tra điểm hợp lệ (0 <= điểm <= 10)
function checkScore($value) {
    // Kiểm tra xem có phải là số (hoặc chuỗi số) và nằm trong khoảng [0, 10]
    if (is_numeric($value) && $value >= 0 && $value <= 10) {
        return true;
    }
    return false;
}

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = isset($_POST['score']) ? trim($_POST['score']) : '';

    if ($score === '') {
        $message = "Vui lòng nhập điểm!";
        $isValid = false;
    } elseif (checkScore($score)) {
        $message = "Điểm hợp lệ: " . htmlspecialchars($score);
        $isValid = true;
    } else {
        $message = "Điểm KHÔNG hợp lệ! Điểm phải là số từ 0 đến 10.";
        $isValid = false;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kiểm Tra Điểm Hợp Lệ</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-box { border: 1px solid #ccc; padding: 20px; width: 320px; border-radius: 5px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; }
        .input-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .alert { margin-top: 15px; padding: 10px; border-radius: 3px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Thực hành PHP</h2>
    <form action="" method="POST">
        <div class="input-group">
            <label for="score">Nhập điểm (0 - 10):</label>
            <input type="text" id="score" name="score" value="<?php echo htmlspecialchars($score); ?>" placeholder="Ví dụ: 8.5">
        </div>
        <button type="submit">Kiểm tra</button>
    </form>

    <?php if ($message !== ""): ?>
        <div class="alert <?php echo $isValid ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>