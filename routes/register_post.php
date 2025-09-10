
<?php
// เช็คว่ามีข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $email = $_POST['email'];
    $password = $_POST['password'];
    $First_name = $_POST['First_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $date = $_POST['date']; // วันเกิด

    // เรียกใช้ฟังก์ชันเพื่อบันทึกข้อมูล
    if (register($email, $password, $First_name,$last_name, $gender, $date)) {
        echo "<script>alert('Registration successful!'); window.location.href = '/';</script>";

    } else {
        echo "<script>alert('Error: Unable to register.');</script>";
    }
}
?>
<!-- routes/register_post.php -->