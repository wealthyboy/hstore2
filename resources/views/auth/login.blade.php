<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f6f3ee; /* light beige like screenshot */
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-card {
      background: #fff;
      border-radius: 12px;
      padding: 2.5rem;
      max-width: 400px;
      width: 100%;
      text-align: center;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .login-card img {
      width: 150px;
      margin-bottom: 1rem;
    }
    .btn-shop {
      background: #5a31f4;
      color: #fff;
      font-weight: 500;
      border-radius: 8px;
      padding: 0.75rem;
      width: 100%;
    }
    .btn-shop:hover {
      background: #4b28d1;
    }
    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: #aaa;
      font-size: 0.9rem;
    }
    .divider::before, .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #ddd;
      margin: 0 10px;
    }
    .form-control {
      border-radius: 8px;
      padding: 0.75rem;
    }
    .btn-continue {
      width: 100%;
      border-radius: 8px;
      padding: 0.75rem;
      background: #f5f5f5;
      border: none;
      color: #666;
      font-weight: 500;
    }
    .btn-continue:hover {
      background: #eaeaea;
    }
    .footer-links {
      font-size: 0.8rem;
      margin-top: 1rem;
      color: #aaa;
    }
    .footer-links a {
      color: #aaa;
      text-decoration: none;
      margin: 0 5px;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <!-- Logo -->
     <a href="/" class="d-block">
            <img src="{{ $system_settings->logo_path() }}" alt="{{ Config('app.name') }} Logo">

     </a>

    <h5 class="mb-3">Sign in</h5>
    <p class="text-muted">Choose how you'd like to sign in</p>

    <!-- Sign in with shop button -->
    <button class="btn btn-shop mb-3">Create Account</button>

    <!-- Divider -->
    <div class="divider">or</div>

    <!-- Email input -->
    <form method="POST" action="/login">
        @csrf
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
          <label for="email">Email address</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          <label for="password">Password</label>
        </div>
       <button type="submit" class="btn btn-continue">Continue</button>
    </form>

    <!-- Footer -->
    <div class="footer-links">
      <a href="/pages">Privacy policy</a> • <a href="#">Terms of service</a>
    </div>
  </div>

</body>
</html>
