<?php
// Khởi tạo các biến lưu trữ giá trị nhập và lỗi cho từng trường
$hoTen = "";
$email = "";
$ngaySinh = ""; 
$subject = "Hỗ trợ kỹ thuật";
$content = "";

$errHoTen = "";
$errEmail = "";
$errNgaySinh = ""; 
$errContent = "";
$errAvatar = "";
$successMessage = "";
$uploadedFileUrl = "";

// Xử lý khi form được submit bằng phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Chuẩn hóa và lấy dữ liệu
    $hoTen = trim($_POST['ho_ten'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $ngaySinh = trim($_POST['ngay_sinh'] ?? ''); 
    $subject = $_POST['subject'] ?? 'Hỗ trợ kỹ thuật';
    $content = trim($_POST['content'] ?? '');

    $hasError = false;

    // 2. Validate Họ tên
    if ($hoTen === '') {
        $errHoTen = "Họ tên không được để trống!";
        $hasError = true;
    }

    // 3. Validate Email
    if ($email === '') {
        $errEmail = "Email không được để trống!";
        $hasError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errEmail = "Địa chỉ email không đúng định dạng!";
        $hasError = true;
    }

    // 4. Validate Ngày sinh (Bắt buộc, đúng định dạng YYYY-MM-DD và không được là ngày trong tương lai)
    if ($ngaySinh === '') {
        $errNgaySinh = "Ngày sinh không được để trống!";
        $hasError = true;
    } else {
        // Tách chuỗi theo định dạng Y-m-d để kiểm tra tính hợp lệ của ngày tháng thực tế (ví dụ: tránh ngày 31/02)
        $parts = explode('-', $ngaySinh);
        if (count($parts) === 3 && checkdate((int)$parts[1], (int)$parts[2], (int)$parts[0])) {
            $dateObj = DateTime::createFromFormat('Y-m-d', $ngaySinh);
            $currentDate = new DateTime();
            if ($dateObj > $currentDate) {
                $errNgaySinh = "Ngày sinh không thể lớn hơn ngày hiện tại!";
                $hasError = true;
            }
        } else {
            $errNgaySinh = "Ngày sinh không đúng định dạng (YYYY-MM-DD)!";
            $hasError = true;
        }
    }

    // 5. Validate Nội dung (không rỗng, từ 10 đến 500 ký tự)
    if ($content === '') {
        $errContent = "Nội dung không được để trống!";
        $hasError = true;
    } elseif (mb_strlen($content) < 10 || mb_strlen($content) > 500) {
        $errContent = "Nội dung phải từ 10 đến 500 ký tự!";
        $hasError = true;
    }

    // 6. Validate File Upload Ảnh đại diện (Bắt buộc, kiểm tra kỹ 3 điều kiện + MIME type)
    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
        $errAvatar = "Vui lòng chọn ảnh đại diện!";
        $hasError = true;
    } else {
        $file = $_FILES['avatar'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errAvatar = "Đã xảy ra lỗi khi tải tệp lên!";
            $hasError = true;
        } else {
            // Điều kiện 1: Kiểm tra kích thước tối đa (2MB)
            $maxSize = 2 * 1024 * 1024;
            if ($file['size'] > $maxSize) {
                $errAvatar = "Kích thước ảnh không được vượt quá 2MB!";
                $hasError = true;
            } else {
                // Điều kiện 2: Kiểm tra định dạng phần mở rộng (extension) và MIME type thực tế
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

                $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                
                // Kiểm tra bằng finfo để lấy MIME type chuẩn từ nội dung thực của file (chống upload file giả mạo đuôi)
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if (!in_array($fileExtension, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
                    $errAvatar = "Chỉ chấp nhận tệp ảnh hợp lệ (jpg, jpeg, png, gif)!";
                    $hasError = true;
                }
            }
        }
    }

    // 7. Nếu không có lỗi, tiến hành xử lý tạo tên file an toàn, lưu file và thông báo thành công
    if (!$hasError) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Điều kiện 3: Tạo tên file mới an toàn (dùng uniqid kết hợp với extension chuẩn hóa)
        $fileExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
            $successMessage = "Gửi thông tin liên hệ thành công!";
            $uploadedFileUrl = $destination;
        } else {
            $errAvatar = "Không thể lưu tệp ảnh lên máy chủ!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 3.9 - Form liên hệ an toàn (Bổ sung Ngày sinh & Upload chuẩn)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f7f9fa; }
        .container { width: 520px; background: #fff; border: 1px solid #e1e4e8; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin: auto; }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #6c757d; font-size: 14px; margin-bottom: 25px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: bold; color: #333; font-size: 14px; }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="date"],
        .form-group select,
        .form-group textarea {
            width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;
        }
        .form-group textarea { resize: vertical; height: 90px; }
        .error-text { color: #dc3545; font-size: 12px; margin-top: 4px; display: block; }
        .alert-success { margin-bottom: 20px; padding: 15px; border-radius: 4px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; font-size: 14px; }
        button { width: 100%; padding: 12px; background-color: #1b6ec2; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background-color: #12569b; }
        .preview-img { margin-top: 10px; max-width: 100px; border-radius: 4px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="container">
    <h2>Liên hệ</h2>
    <div class="subtitle">Vui lòng nhập đầy đủ thông tin bên dưới.</div>

    <!-- Hiển thị thông báo thành công -->
    <?php if ($successMessage !== ""): ?>
        <div class="alert-success">
            <b><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></b><br>
            - Họ tên: <?php echo htmlspecialchars($hoTen, ENT_QUOTES, 'UTF-8'); ?><br>
            - Email: <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?><br>
            - Ngày sinh: <?php echo htmlspecialchars($ngaySinh, ENT_QUOTES, 'UTF-8'); ?><br>
            - Chủ đề: <?php echo htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'); ?><br>
            - Nội dung: <?php echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); ?><br>
            - Ảnh đại diện:<br>
            <img src="<?php echo htmlspecialchars($uploadedFileUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="preview-img">
        </div>
    <?php endif; ?>

    <!-- Form liên hệ -->
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="ho_ten">Họ tên</label>
            <input type="text" id="ho_ten" name="ho_ten" value="<?php echo htmlspecialchars($hoTen, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ví dụ: Đỗ Trung Kiên">
            <?php if ($errHoTen !== ""): ?>
                <span class="error-text"><?php echo htmlspecialchars($errHoTen, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" placeholder="name@example.com">
            <?php if ($errEmail !== ""): ?>
                <span class="error-text"><?php echo htmlspecialchars($errEmail, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="ngay_sinh">Ngày sinh</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" value="<?php echo htmlspecialchars($ngaySinh, ENT_QUOTES, 'UTF-8'); ?>">
            <?php if ($errNgaySinh !== ""): ?>
                <span class="error-text"><?php echo htmlspecialchars($errNgaySinh, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="subject">Chủ đề</label>
            <select id="subject" name="subject">
                <option value="Hỗ trợ kỹ thuật" <?php if ($subject == "Hỗ trợ kỹ thuật") echo "selected"; ?>>Hỗ trợ kỹ thuật</option>
                <option value="Tư vấn khóa học" <?php if ($subject == "Tư vấn khóa học") echo "selected"; ?>>Tư vấn khóa học</option>
                <option value="Góp ý dịch vụ" <?php if ($subject == "Góp ý dịch vụ") echo "selected"; ?>>Góp ý dịch vụ</option>
            </select>
        </div>

        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea id="content" name="content" placeholder="Nhập nội dung từ 10 đến 500 ký tự..."><?php echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); ?></textarea>
            <?php if ($errContent !== ""): ?>
                <span class="error-text"><?php echo htmlspecialchars($errContent, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="avatar">Ảnh đại diện (Bắt buộc, tối đa 2MB)</label>
            <input type="file" id="avatar" name="avatar">
            <?php if ($errAvatar !== ""): ?>
                <span class="error-text"><?php echo htmlspecialchars($errAvatar, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Gửi liên hệ</button>
    </form>
</div>

</body>
</html>