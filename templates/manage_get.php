<?php

// ตรวจสอบ event_id ที่ส่งมาทาง URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $event = getEventById($event_id);
} else {
    die("Error: Event ID is missing!");
}

// ตรวจสอบ user_id จากเซสชัน
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Error: User ID is missing!");
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section-container {
            display: flex; /* จัดเรียงในแนวนอน */
            align-items: center; /* จัดกึ่งกลางแนวตั้ง */
            margin-top: 1rem; /* เพิ่มระยะห่างด้านบน */
        }

        .section-item {
            margin-right: 2rem; /* เพิ่มระยะห่างระหว่างแต่ละส่วน */
        }

        .button-container {
            display: flex; /* จัดเรียงปุ่มในแนวนอน */
            margin-top: 0.5rem; /* เพิ่มระยะห่างด้านบนปุ่ม */
        }

        .button-container a {
            margin-right: 0.5rem; /* เพิ่มระยะห่างระหว่างปุ่ม */
        }

        .image-preview {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
            margin-top: 10px;
            margin-left: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-primary text-white">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Manage Event</h2>
                <form action="manage" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Name Event</label>
                        <input type="text" name="nameevent" class="form-control" value="<?php echo isset($event['title']) ? $event['title'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"><?php echo isset($event['description']) ? $event['description'] : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="<?php echo isset($event['date']) ? $event['date'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Participant Limit</label>
                        <input type="number" name="participantlimit" class="form-control" value="<?php echo isset($event['participant_limit']) ? $event['participant_limit'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="<?php echo isset($event['location']) ? $event['location'] : ''; ?>">
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                    <button type="submit" class="btn btn-success mt-3" onclick="return confirmSubmission()">Update Event</button>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <div class="card" style="width: 300px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Insert Image</h5>
                        <input type="file" name="img" class="form-control mb-3" id="imageUpload">
                        <div class="image-preview border rounded" id="imagePreview">
                            <p>Preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-item">
                <h2>Pending Approval</h2>
                <div class="button-container">
                    <a href="/pending" class="btn btn-info mt-3" <?php $_SESSION['event_id'] = $event_id; ?>>Check Info</a>
                </div>
            </div>

            <div class="section-item">
                <h2>Check in User</h2>
                <div class="button-container">
                    <a href="/checkin" class="btn btn-info mt-3" <?php $_SESSION['event_id'] = $event_id; ?>>Check In</a>
                </div>
            </div>
        </div>
    </div>
    </form>
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagePreview = document.getElementById('imagePreview');

            if (file) {
                const imageUrl = URL.createObjectURL(file);
                imagePreview.innerHTML = `<img src="${imageUrl}" alt="Preview">`;
            } else {
                imagePreview.innerHTML = '<p>Preview</p>';
            }
        });
    </script>
    <script>
        function confirmSubmission() {
            return confirm("Are you sure you want to Update Event?");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>