<?php
$event_id = $_SESSION['event_id'] ?? null;
$conn = getConnection();

// Debug: ตรวจสอบค่า event_id
echo "Event ID: " . htmlspecialchars($event_id) . "<br>";

// เรียกใช้ฟังก์ชันเพื่อดึงข้อมูลที่มี status = 'Confirmed'
$approvedParticipants = getApprovedParticipants($conn, $event_id);
?>

<div class="mt-4">
    <h2>Check-in Approved Participants</h2>

    <?php if (!empty($approvedParticipants)): ?>
        <?php foreach ($approvedParticipants as $row): ?>
            <div class="border p-3 bg-light text-dark rounded mb-3 d-flex justify-content-between align-items-center">
                <span>User ID: <?php echo htmlspecialchars($row['user_id']); ?> - Status: <?php echo htmlspecialchars($row['status']); ?></span>
                <div>
                <form action="checkin" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                    <input type="hidden" name="checked_in" value="4"> <!-- แก้เป็นค่า 4 -->
                    <button type="submit" class="btn btn-success">✔ Check-in</button>
                </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No approved participants for check-in.</p>
    <?php endif; ?>
</div>
