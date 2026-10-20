<?php
// Định nghĩa hàm format tiền tệ (hàng nghìn phân cách bằng dấu chấm)
function money(float $value): string {
    return number_format($value, 0, ',', '.') . ' đ';
}

// Đọc dữ liệu từ form gửi lên bằng phương thức POST
$name = $_POST['name'] ?? '';
$qty = (int)($_POST['qty'] ?? 0);
$price = (float)($_POST['price'] ?? 0);
$total = $qty * $price;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Demo Hóa đơn học liệu</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-container {
            border: 1px solid #ccc;
            padding: 20px;
            width: 420px;
            border-radius: 5px;
        }
        form {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        input {
            padding: 6px;
            font-size: 14px;
        }
        input[name="name"] { width: 150px; }
        input[name="qty"], input[name="price"] { width: 90px; }
        button {
            padding: 6px 12px;
            cursor: pointer;
        }
        .result {
            margin-top: 15px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form method="post">
        <input name="name" placeholder="Tên tài liệu" value="<?php echo htmlspecialchars($name); ?>">
        <input name="qty" type="number" min="1" placeholder="Số lượng" value="<?php echo $qty > 0 ? $qty : ''; ?>">
        <input name="price" type="number" min="0" placeholder="Đơn giá" value="<?php echo $price > 0 ? $price : ''; ?>">
        <button type="submit">Tính</button>
    </form>

    <?php if ($total > 0): ?>
        <div class="result">
            <p><?php echo htmlspecialchars($name); ?>: <?php echo money($total); ?></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>