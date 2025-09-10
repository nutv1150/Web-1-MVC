<?php


// ตรวจสอบว่ามีข้อมูลส่งมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nameevent = isset($_POST['nameevent']) ? trim($_POST['nameevent']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $participantlimit = isset($_POST['participantlimit']) ? (int) $_POST['participantlimit'] : 0;
    $user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
    $event_id = isset($_POST['event_id']) ? (int) $_POST['event_id'] : 0;
    // อัปเดตข้อมูลกิจกรรม
    if (updateEvent($event_id, $nameevent, $description, $date, $location, $user_id, $participantlimit, $imagePath)) {
        echo "<script>alert('Event updated successfully!'); window.location.href = '/loghome';</script>";
    } else {
        echo "<script>alert('Error: Unable to update event.'); window.history.back();</script>";
    }
} else {
    die("<script>alert('Invalid request!'); window.history.back();</script>");
}
    // ตรวจสอบค่าที่จำเป็น
    if (empty($nameevent) || empty($description) || empty($date) || empty($location) || $event_id <= 0) {
        die("<script>alert('Error: Missing required fields!'); window.history.back();</script>");
    }

    $imagePath = null; // ค่าเริ่มต้นของรูปภาพ

    // ตรวจสอบและอัปโหลดรูปภาพ
    if (isset($_FILES['images']) && $_FILES['images']['error'][0] == UPLOAD_ERR_OK) {
        $images = $_FILES['images'];
        foreach ($images['name'] as $index => $imageName) {
            $image = [
                'name' => $images['name'][$index],
                'tmp_name' => $images['tmp_name'][$index],
                'error' => $images['error'][$index],
                'size' => $images['size'][$index]
            ];
            // Call the upload function for each image
            $imagePath = uploadImage($nameevent, $image); // Modify this line as needed
        }
    }


?>