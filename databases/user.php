<?php
function register(string $email, string $password, string $Frist_name, string $last_name, string $gender, string $birthday): bool
{
    // ใช้ . แทน + ในการต่อสตริง
    $username = $Frist_name . "" . $last_name; 

    // ฟังก์ชันเชื่อมต่อกับฐานข้อมูล
    $conn = getConnection(); 

    // แฮชพาสเวิด
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); 

    // คำสั่ง SQL สำหรับการเพิ่มข้อมูล
    $sql = "INSERT INTO users (email, password, username, gender, birthday) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // ผูกตัวแปรกับคำสั่ง SQL
    $stmt->bind_param("sssss", $email, $hashed_password, $username, $gender, $birthday);

    // เรียกใช้งานคำสั่ง SQL
    if ($stmt->execute()) {
        return true; // เพิ่มข้อมูลสำเร็จ
    } else {
        return false; // เกิดข้อผิดพลาดในการเพิ่มข้อมูล
    }
}
