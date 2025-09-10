<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    section {
      background-color: #2f4663;
      font-family: 'Prompt', sans-serif;
      display: flex;
      justify-content: center; /* เพิ่ม justify-content: center; เพื่อให้ center */
      align-items: center; /* เพิ่ม align-items: center; เพื่อให้ center */
      height: 100vh;
    }
    .login-container {
      background-color: #e7d9cc;
      padding: 40px;
      border-radius: 10px;
      width: 400px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      flex-direction: column;
    }
    .form-control {
      border-radius: 25px;
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
    .forgot-password {
      font-size: 14px;
      margin-top: 10px;
    }
    .register-link {
      color: #0095ff;
      text-decoration: none;
      font-weight: bold;
    }
    .register-link:hover {
      text-decoration: underline;
    }
  </style>
<section>

  <div class="login-container">
    <h3>Sign in</h3>
    <form action="login" method="POST">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-login mt-3">Sign In</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </section>

      <!-- templates/login_get.php -->