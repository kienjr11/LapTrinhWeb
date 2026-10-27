<?php
// Bài tập: Tạo mảng 3 sinh viên, mỗi sinh viên có name và score
$students = [
    ['name' => 'An', 'score' => 8.0],
    ['name' => 'Bình', 'score' => 6.5],
    ['name' => 'Chi', 'score' => 4.5]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 2.4 - Mảng kết hợp</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { width: 400px; border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<div class="container">
    <h3>Danh sách sinh viên</h3>
    
    <!-- Cách 1: In dạng danh sách dùng foreach  -->
    <h4>Hiển thị dạng dòng :</h4>
    <?php
    foreach ($students as $student) {
        echo 'Tên: ' . $student['name'] . ' - Điểm: ' . $student['score'] . '<br>';
    }
    ?>

    <!-- Cách 2: Hiển thị dạng Bảng HTML  -->
    <h4 style="margin-top: 20px;">Hiển thị dạng Bảng HTML:</h4>
    <table>
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Điểm</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['score']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>