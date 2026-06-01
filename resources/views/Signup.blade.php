<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up - MeysBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

  <nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand fw-bold">MeysBook</span>
  </nav>

 
  @if(session('success'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast bg-success text-white" role="alert">
      <div class="toast-body">
        {{ session('success') }}
      </div>
    </div>
  </div>
  @endif

  @if(session('error'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast bg-danger text-white" role="alert">
      <div class="toast-body">
        {{ session('error') }}
      </div>
    </div>
  </div>
  @endif

  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
    <div class="card shadow-sm p-4" style="max-width:450px;width:100%">
      <h4 class="text-center fw-bold mb-4">Create Account</h4>

      {{-- Note: Do not forget the @csrf inside the form --}}
      <form action="/signup" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" name="firstname" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" name="lastname" class="form-control" required>
        </div>

        {{-- Gender field - added because may gender column sa database --}}
        <div class="mb-3">
          <label class="form-label">Gender</label>
          <select name="gender" class="form-select" required>
            <option value="" disabled selected>Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Rather not say">Rather not say</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" minlength="6" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="confirmpassword" class="form-control" minlength="6" required>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" class="form-check-input" id="terms" required>
          <label class="form-check-label" for="terms">I agree to Terms &amp; Conditions</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
      </form>

      {{-- Route to other page using href --}}
      <p class="text-center text-muted mt-3 mb-0">
        Already have an account?
        <a href="{{ route('login') }}" class="text-decoration-none">Login here.</a>
      </p>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- JS for Toast with 3 seconds in main.blade.php --}}
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toastElList = document.querySelectorAll('.toast');
      toastElList.forEach(function (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
          delay: 3000 // 3 seconds
        });
        toast.show();
      });
    });
  </script>

</body>
</html>