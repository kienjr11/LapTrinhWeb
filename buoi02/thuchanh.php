<?php
// mảng $students gồm 3 sinh viên với name, midterm, final
$students = [
    ['name' => 'Nguyễn Văn An', 'midterm' => 7.5, 'final' => 8.0],
    ['name' => 'Trần Thị Bình', 'midterm' => 4.0, 'final' => 5.5],
    ['name' => 'Lê Hoàng Cường', 'midterm' => 3.0, 'final' => 4.0]
];

//  hàm calculateAverage() tính điểm trung bình 
function calculateAverage(float $midterm, float $final): float {
    return ($midterm + $final) / 2;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng điểm 3 sinh viên</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #28a745; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; max-width: 600px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        td:first-child { text-align: left; }
        .pass { color: #155724; font-weight: bold; }
        .fail { color: #721c24; font-weight: bold; }
    </style>
</head>
<body>

    <h2>2.8 Thực hành trên lớp: Bảng điểm 3 sinh viên</h2>

    <!-- 3. Dùng foreach để in bảng HTML -->
    <table>
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Giữa kỳ</th>
                <th>Cuối kỳ</th>
                <th>Điểm trung bình</th>
                <th>Kết quả</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <?php 
                    // Tính điểm trung bình và làm tròn 2 chữ số thập phân
                    $avg = calculateAverage($student['midterm'], $student['final']);
                    $avgRounded = round($avg, 2);
                    
                    // 4. Kiểm tra điều kiện: Đạt nếu điểm trung bình >= 5
                    $isPass = ($avg >= 5.0);
                ?>
                <tr>
                    <!-- 5. Mã hóa tên sinh viên bằng htmlspecialchars() trước khi in -->
                    <td><?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo $student['midterm']; ?></td>
                    <td><?php echo $student['final']; ?></td>
                    <td><?php echo $avgRounded; ?></td>
                    <td>
                        <span class="<?php echo $isPass ? 'pass' : 'fail'; ?>">
                            <?php echo $isPass ? 'Đạt' : 'Không đạt'; ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>