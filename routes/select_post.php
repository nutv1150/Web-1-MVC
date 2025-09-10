<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = isset($_POST['userId']) ? $_POST['userId'] : null;
    $event_id = isset($_POST['eventId']) ? $_POST['eventId'] : null;
    $conn = getConnection();

    if (!$user_id || !$event_id) {
        die("Invalid request.");
    }

    // ✅ เรียกใช้ฟังก์ชันที่แก้ไข
    $message = insertEventParticipant($conn, $event_id, $user_id);

    echo "<script>
            alert('$message');
            window.location.href = 'loghome?event_id=" . urlencode($event_id) . "';
          </script>";

    $conn->close();

    renderView3("loghome_get");
}
?>




