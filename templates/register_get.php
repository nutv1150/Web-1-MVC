<title>Register Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    section {
      background-color: #2f4663;
      font-family: 'Prompt', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-container {
      background-color: #e7d9cc;
      padding: 40px;
      border-radius: 10px;
      width: 400px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .form-control {
      border-radius: 25px;
    }
    .btn-register {
      background-color: #0095ff;
      color: white;
      border-radius: 25px;
      font-weight: bold;
      padding: 10px;
      width: 100%;
    }
    .btn-register:hover {
      background-color: #007acc;
    }
  </style>

<section>
  <div class="register-container">
    <h3>Register</h3>
    <form action="register" method="POST" onsubmit="return confirmRegister()">
      <div class="row mb-3">

        <div class="col">
          <input type="text" class="form-control" name="First_name" placeholder="First_name" required>
        </div>
        <div class="col">
          <input type="text" class="form-control" name="last_name" placeholder="last_name" required>
        </div>
      </div>
      <div class="mb-3">
        <input type="email" class="form-control" name="email" placeholder="Email" required>
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <select class="form-select" name="gender" required>
          <option selected disabled  value="">Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="mb-3">
        <input type="date" name="date" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-register mt-3">Register</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function confirmRegister() {
        return confirm("❗ คุณต้องการสมัครจริงใช่ไหม?");
    }
</script>
</section>

    <!-- templates/register_get.php -->