<?php

$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"] ?? null;
    $event_id = $_POST["event_id"] ?? null;
    $checked_in = $_POST["checked_in"] ?? null;

    if (!$user_id || !$event_id || !in_array($checked_in, ["1", "4"])) {
        die("Invalid request.");
    }

    // กำหนด status ตาม checked_in
    $status = ($checked_in == "4") ? "Checked-in" : "Cancelled"; // ใช้ "Cancelled" ถ้าไม่เช็คอิน

    // ✅ ใช้ฟังก์ชัน updateParticipantStatus()
    if (updateParticipantStatus($conn, $event_id, $user_id, $checked_in, $status)) {
        $message = ($checked_in == "4") ? "Checked in Successfully!" : "User has been Cancelled!";
        echo "<script>
                alert('$message');
                window.location.href = 'checkin?event_id=" . urlencode($event_id) . "'; 
              </script>";
        exit();
    } else {
        echo "<script>alert('Error updating status.'); window.history.back();</script>";
    }

    $conn->close();
}
?>
