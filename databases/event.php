<?php

function getEvents() {//ดึงevent ออกมา
    $conn = getConnection();//เชื่อม database
    $sql = 'select * from events';
    $result = $conn->query($sql);//ส่งคำสั่งด้านบนไป
    return $result;
}


function getEventsByEventId($conn, $userId, $eventId = null) {
    if ($eventId !== null) {
        // เลือก event ที่มี event_id ตรงกับ $eventId
        $eventQuery = "SELECT * FROM events WHERE event_id = ?";
        $stmt = $conn->prepare($eventQuery);
        $stmt->bind_param("i", $eventId);
    } else {
        // เลือก events ทั้งหมดที่สร้างโดย user_id
        $eventQuery = "SELECT * FROM events WHERE user_id = ?";
        $stmt = $conn->prepare($eventQuery);
        $stmt->bind_param("i", $userId);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}   

function getImagesFromDatabase($conn): array {
    // ดึงข้อมูล event_title และ url ของรูปภาพจากฐานข้อมูล
    $imageQuery = "SELECT event_id, url FROM image";
    $imageResult = $conn->query($imageQuery);
    $images = [];

    // เก็บข้อมูลรูปภาพตาม event_id
    while ($row = $imageResult->fetch_assoc()) {
        // เช็คว่า $images[$row['event_id']] มีข้อมูลอยู่แล้วหรือไม่
        // ถ้ามีข้อมูลก็เพิ่ม url ลงในอาเรย์
        $images[$row['event_id']][] = $row['url'];
    }

    return $images;
}


function getImagesFromDatabase2($conn) {
    $imageQuery = "SELECT event_id, url FROM image";
    $imageResult = $conn->query($imageQuery);
    $images = [];

    while ($row = $imageResult->fetch_assoc()) {
        $images[$row['event_id']][] = $row['url']; // ใช้ event_id เป็นคีย์หลัก
    }
    return $images;
}

function addEvent($nameevent, $description, $date, $location, $user_id, $participantlimit, $imagePath) {
    $conn = getConnection();

    // ตรวจสอบว่า user_id มีอยู่ในตาราง users หรือไม่
    $checkUser = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $checkUser->bind_param("i", $user_id);
    $checkUser->execute();
    $result = $checkUser->get_result();
    
    if ($result->num_rows == 0) {
        echo "<script>alert('Error: user_id not found in users table.');</script>";
        return false;
    }

    // คำสั่ง SQL สำหรับการเพิ่มข้อมูล
    $sql = "INSERT INTO events (title, description, date, location, user_id, participant_limit, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdis", $nameevent, $description, $date, $location, $user_id, $participantlimit, $imagePath);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    $stmt->close();
    $conn->close();
}

function uploadImage($event_title, $image) {
    $conn = getConnection();

    // ตรวจสอบค่า event_title
    var_dump($event_title); // ตรวจสอบค่า event_title ที่ส่งมา

    // ดึง event_id ตาม event_title
    $sql = "SELECT event_id FROM events WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $event_title);
    $stmt->execute();
    $stmt->bind_result($event_id);
    $stmt->fetch();
    $stmt->close();

    if (!$event_id) {
        die("Error: Event not found."); // ถ้าไม่พบ event_id
    }

    // โค้ดที่เหลือสำหรับการอัปโหลดไฟล์
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . "_" . preg_replace('/[^A-Za-z0-9_-]/', '_', $event_title) . "." . $fileExtension;
    $targetFile = $targetDir . $newFileName;

    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array(strtolower($fileExtension), $allowedTypes)) {
        die("Error: Invalid file type.");
    }

    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO image (url, event_title, event_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $targetFile, $event_title, $event_id);
        $stmt->execute();
        return $targetFile;
    } else {
        die("Error: Upload failed.");
    }
}




function updateEvent($event_id, $nameevent, $description, $date, $location, $user_id, $participantlimit, $newImages) {
    $conn = getConnection();

    // ตรวจสอบว่า event_id มีอยู่ในตาราง events หรือไม่
    $checkEvent = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
    $checkEvent->bind_param("i", $event_id);
    $checkEvent->execute();
    $result = $checkEvent->get_result();
    
    if ($result->num_rows == 0) {
        echo "<script>alert('Error: Event ID not found in events table.');</script>";
        return false;
    }

    // อัปเดตข้อมูลกิจกรรม (ไม่อัปเดตรูป)
    $sql = "UPDATE events 
            SET title = ?, description = ?, date = ?, location = ?, user_id = ?, participant_limit = ?
            WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdii", $nameevent, $description, $date, $location, $user_id, $participantlimit, $event_id);

    if (!$stmt->execute()) {
        echo "<script>alert('Error: Unable to update event details.');</script>";
        return false;
    }

    // ✅ เช็คว่าตาราง `image` ใช้ event_id หรือ event_title
    $columnCheck = $conn->query("SHOW COLUMNS FROM image LIKE 'event_id'");
    $useEventID = $columnCheck->num_rows > 0;

    // ✅ เพิ่มรูปใหม่เข้าไปในตาราง image (ถ้ามี)
    if (!empty($newImages)) {
        if ($useEventID) {
            $insertImage = $conn->prepare("INSERT INTO image (event_id, url) VALUES (?, ?)");
            foreach ($newImages as $imagePath) {
                $insertImage->bind_param("is", $event_id, $imagePath);
                $insertImage->execute();
            }
        } else {
            $insertImage = $conn->prepare("INSERT INTO image (event_title, url) VALUES (?, ?)");
            foreach ($newImages as $imagePath) {
                $insertImage->bind_param("ss", $nameevent, $imagePath);
                $insertImage->execute();
            }
        }
        $insertImage->close();
    }

    echo "<script>alert('Event updated successfully!'); window.location.href = '/loghome';</script>";
    return true;

    $stmt->close();
    $conn->close();
}


function deleteEventById($conn, int $event_id): bool
{
    // 🔹 ดึง image_path จาก event_id ก่อน
    $sql_get_image = "SELECT image_path FROM events WHERE event_id = ?";
    $stmt_image = $conn->prepare($sql_get_image);
    $stmt_image->bind_param("i", $event_id);
    $stmt_image->execute();
    $result_image = $stmt_image->get_result();
    $image_path = $result_image->fetch_assoc()['image_path'] ?? null;
    $stmt_image->close();

    // 🔹 ถ้ามีไฟล์ภาพ ให้ลบออกจากเซิร์ฟเวอร์
    if ($image_path && file_exists($image_path)) {
        unlink($image_path); // ลบไฟล์จริงจากโฟลเดอร์
    }

    // 🔹 ลบผู้เข้าร่วมกิจกรรม
    $sql_delete_participants = "DELETE FROM event_participant WHERE event_id = ?";
    $stmt2 = $conn->prepare($sql_delete_participants);
    $stmt2->bind_param("i", $event_id);
    $stmt2->execute();
    $stmt2->close();

    // 🔹 ลบอีเวนต์จาก events
    $sql_delete_event = "DELETE FROM events WHERE event_id = ?";
    $stmt3 = $conn->prepare($sql_delete_event);
    $stmt3->bind_param("i", $event_id);
    $stmt3->execute();
    
    $deleted = $stmt3->affected_rows > 0;
    $stmt3->close();

    return $deleted;
}





?>
<!-- database/event.php -->
