<?php

$event_id = $_SESSION['event_id'] ?? null;
$conn = getConnection();

// Debug: ตรวจสอบค่า event_id
echo "Event ID: " . htmlspecialchars($event_id) . "<br>";

// เรียกใช้ฟังก์ชันเพื่อดึงข้อมูลที่มี status = 'Pending'
$pendingParticipants = getPendingParticipants($conn, $event_id);
?>

<div class="mt-4">
    <h2>Pending Approval</h2>

    <?php if (!empty($pendingParticipants)): ?>
        <?php foreach ($pendingParticipants as $row): ?>
            <div class="border p-3 bg-light text-dark rounded mb-3 d-flex justify-content-between align-items-center">
                <span>User ID: <?php echo htmlspecialchars($row['user_id']); ?> - Status: <?php echo htmlspecialchars($row['status']); ?></span>
                <div>
                    <!-- ปุ่ม ✔ อนุมัติ -->
                    <form action="pending" method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                        <input type="hidden" name="checked_in" value="3">
                        <button type="submit" class="btn btn-success">✔</button>
                    </form>

                    <!-- ปุ่ม ✖ ปฏิเสธ (มี Confirm ก่อนส่งค่า) -->
                    <form action="pending" method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                        <input type="hidden" name="checked_in" value="1">
                        <button type="submit" class="btn btn-danger" onclick="return confirmCancel();">✖</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No pending participants for this event.</p>
    <?php endif; ?>
</div>

<!-- ✅ JavaScript สำหรับ Confirm ก่อนปฏิเสธ -->
<script>
function confirmCancel() {
    return confirm("Are you sure you want to cancel this user's participation?");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
