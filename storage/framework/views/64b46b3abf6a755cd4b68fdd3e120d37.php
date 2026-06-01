<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - MeysBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

  <nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand fw-bold">MeysBook</span>
  </nav>

  
  <?php if(session('success')): ?>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast bg-success text-white" role="alert">
      <div class="toast-body">
        <?php echo e(session('success')); ?>

      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if(session('error')): ?>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast bg-danger text-white" role="alert">
      <div class="toast-body">
        <?php echo e(session('error')); ?>

      </div>
    </div>
  </div>
  <?php endif; ?>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
    <div class="card shadow-sm p-4" style="max-width:420px;width:100%">
      <h4 class="text-center fw-bold mb-4">Login to MeysBook</h4>

      
      <form action="/login" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      
      <p class="text-center text-muted mt-3 mb-0">
        Don't have an account?
        <a href="<?php echo e(route('signup')); ?>" class="text-decoration-none">Sign up here.</a>
      </p>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  
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
</html><?php /**PATH C:\xampp\htdocs\Laravel-Jabolin\resources\views/login.blade.php ENDPATH**/ ?>