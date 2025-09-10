<?php
function login(string $email, string $password) 
{
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false; // ไม่มีอีเมลนี้ในระบบ
    }

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        return $user; // ส่งข้อมูลผู้ใช้กลับ
    } else {
        return false; // รหัสผ่านไม่ถูกต้อง
    }
}

function logout():void
{
    unset($_SESSION['timestamp']);
}

// database/authen.php
 