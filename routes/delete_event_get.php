<?php

declare(strict_types=1);


$conn = getConnection();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /organizer');
    exit;
}

$event_id = (int)$_GET['id'];    

// ✅ ใช้ฟังก์ชันใหม่ที่รองรับการลบข้อมูลที่เชื่อมโยง
$res = deleteEventById($conn, $event_id);

if ($res) {
    echo "<script>
            alert('Event deleted successfully!');
            window.location.href = '/organizer';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Something went wrong while deleting the event.');
            window.history.back();
          </script>";
    exit();
}
?>
