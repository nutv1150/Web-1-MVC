<?php
// รับค่าจากฟอร์ม
$nameevent = $_POST['nameevent'];
$description = $_POST['description'];
$date = $_POST['date'];
$location = $_POST['location'];
$participantlimit = $_POST['participantlimit'];
$user_id = $_POST['user_id'];
$event_id = $_POST['event_id'];

if (addEvent($nameevent, $description, $date, $location, $user_id, $participantlimit, $imagePath)) {
    echo "<script>alert('Event created successfully!'); window.location.href = '/loghome';</script>";
} else {
    echo "<script>alert('Error: Unable to create event.');</script>";
}

$imagePaths = []; // กำหนดค่าเริ่มต้นให้ตัวแปร imagePaths
// ตรวจสอบและจัดการอัปโหลดไฟล์ภาพ
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

