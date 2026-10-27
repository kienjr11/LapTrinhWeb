<?php
// Khởi tạo mảng danh sách sinh viên rỗng 
$students = [];

$message = "";

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputName = isset($_POST['name']) ? trim($_POST['name']) : '';
    $inputScore = isset($_POST['score']) ? trim($_POST['score']) : '';

    if ($inputName === '' || $inputScore === '') {
        $message = "Vui lòng nhập đầy đủ Tên và Điểm!";
    } elseif (!is_numeric($inputScore) || $inputScore < 0 || $inputScore > 10) {
        $message = "Điểm số không hợp lệ! Vui lòng nhập số từ 0 đến 10.";
    } else {
        // Thêm sinh viên mới do người dùng nhập vào mảng
        $students[] = [
            'name' => $inputName,
            'score' => (float)$inputScore
        ];
        $message = "Thêm sinh viên thành công!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 2.4 - Nhập Sinh Viên</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { width: 450px; border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 15px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .msg { margin: 10px 0; padding: 8px; border-radius: 3px; background-color: #e9ecef; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<div class="container">
    <h3>Nhập thông tin sinh viên</h3>
    
    <!-- Form nhập thông tin -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Tên sinh viên:</label>
            <input type="text" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A">
        </div>
        <div class="form-group">
            <label for="score">Điểm số (0 - 10):</label>
            <input type="text" id="score" name="score" placeholder="Ví dụ: 8.5">
        </div>
        <button type="submit">Thêm sinh viên</button>
    </form>

    <?php if ($message !== ""): ?>
        <div class="msg"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <hr style="margin-top: 20px;">

    <!-- Hiển thị danh sách sinh viên vừa nhập -->
    <h4>Danh sách sinh viên:</h4>
    <table>
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Điểm</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($students)): ?>
                <tr>
                    <td colspan="2" style="text-align: center; color: #777;">Chưa có sinh viên nào được nhập.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <!-- Mã hóa htmlspecialchars trước khi in ra để bảo mật -->
                        <td><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)$student['score'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>