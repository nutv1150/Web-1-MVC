<?php
if (!isset($_SESSION['email'])) {
    echo "🔴 คุณยังไม่ได้ล็อกอิน!";
    header("Location: /login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Online Event Registration System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <style>
                body {
                        background-color: #2f4663;
                        color: white;
                }
                .navbar {
                        background-color: #1b2a41;
                }
                .event-card {
                        background-color: #d6c4b2;
                        height: 200px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 20px;
                        color: #333; /* เปลี่ยนสีตัวอักษรเป็นสีเข้มขึ้น */
                        font-weight: bold;
                        border-radius: 10px; /* เพิ่มขอบมน */
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงา */
                        overflow: hidden; /* ซ่อนเนื้อหาที่เกินขอบ */
                }
                .search-box {
                        border: 2px solid white;
                        border-radius: 25px;
                        padding: 10px 15px;
                        display: flex;
                        align-items: center;
                        max-width: 400px;
                        margin: auto;
                }
                .search-box input {
                        border: none;
                        background: none;
                        outline: none;
                        color: white;
                        flex-grow: 1;
                }
                .search-box i {
                        color: white;
                }
                .filter-btn {
                        border-radius: 20px;
                        padding: 5px 15px;
                        border: none;
                }
                .filter-btn.active {
                        background-color: #fff;
                        color: black;
                }
                .login-alert {
                        background-color: #ffc107; /* สีเหลือง */
                        color: #333; /* สีตัวอักษรเข้ม */
                        padding: 20px;
                        border-radius: 10px;
                        text-align: center;
                        margin-bottom: 20px;
                        font-size: 1.5em; /* ขนาดตัวอักษรใหญ่ขึ้น */
                        font-weight: bold;
                }
                footer {
    text-align: center;
    padding: 20px;
    background-color: #1b2a41;
    color: white;
    position: fixed;
    bottom: 0;
    width: 100%;
}
        </style>
</head>
<body>

<div class="container mt-4">
    <div class="login-alert">
        Pls Login First
    </div>
</div>

<div class="container text-center">
    <h3 class="text-white">All Event</h3>
</div>

<div class="container mt-4">
    <div class="row">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="col-md-4 mb-4">
                <div class="event-card">
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>

</body>
</html>