<?php

$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"] ?? null;
    $event_id = $_POST["event_id"] ?? null;
    $checked_in = $_POST["checked_in"] ?? null;

    if (!$user_id || !$event_id || !in_array($checked_in, ["1", "3"])) {
        die("Invalid request.");
    }

    // กำหนด status ตาม checked_in
    $status = ($checked_in == "3") ? "Confirmed" : "Cancelled"; // ใช้ "Cancelled" แทน "Rejected"

    // ✅ ใช้ฟังก์ชัน updateParticipantStatus()
    if (updateParticipantStatus($conn, $event_id, $user_id, $checked_in, $status)) {
        $message = ($checked_in == "3") ? "Approved Successfully!" : "User has been Cancelled!";
        echo "<script>
                alert('$message');
                window.location.href = 'pending?event_id=" . urlencode($event_id) . "';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error updating status.'); window.history.back();</script>";
    }

    $conn->close();
}
?>
