<?php


$user_id = $_SESSION['user_id'];  // ดึง user_id จากเซสชัน
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #2C3E50;
            color: white;
        }
        .card {
            background-color: #F8F3EE;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        .form-control {
            background-color: white;
            color: black;
            border: 2px solid black;
        }
        .btn-login {
            background-color: #0095ff;
            color: white;
            border-radius: 25px;
            font-weight: bold;
            padding: 10px;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #007acc;
        }
        .image-preview { 
            width: 100%; 
            height: 300px;
            border: 1px solid #ccc;
            margin-top: 10px;
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
<body>
<div class="container mt-5">
    <form action="create" method="POST" enctype="multipart/form-data">
        <h2 class="fw-bold">Create Event</h2>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Name Event</label>
                    <input type="text" name="nameevent" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Participant Limit</label>
                    <input type="number" name="participantlimit" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-login mt-3" 
                onclick="return confirmSubmission()">Create Event</button>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="event_id" value="EVENT_ID_HERE">

            <div class="col-md-6 d-flex justify-content-center">
                <div class="card" style="width: 300px;">
                    <p class="fw-bold">Insert Image</p>
                    <input type="file" name="images[]" class="form-control" id="imageUpload" multiple>
                <div class="image-preview" id="imagePreview">
                <p>Preview</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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
        return confirm("Are you sure you want to Create Event?");
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- templates/create_get.php -->