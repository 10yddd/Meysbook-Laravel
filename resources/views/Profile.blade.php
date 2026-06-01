<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - MeysBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- NAVBAR -->
  <nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand fw-bold">MeysBook</span>
    <div class="d-flex align-items-center gap-2">
      <span class="text-white">{{ session('user')->name }}</span>
      <a href="{{ route('profile') }}" class="btn btn-outline-light btn-sm">Profile</a>
      <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
      <a href="{{ route('users') }}" class="btn btn-outline-light btn-sm">Users</a>
      <a href="{{ route('reservations') }}" class="btn btn-outline-light btn-sm">Reservations</a>
      <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </nav>

  <!-- SUCCESS Toast -->
  @if(session('success'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="appToast" class="toast align-items-center text-bg-success border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body fw-semibold">{{ session('success') }}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
  @endif

  <!-- ERROR Toast -->
  @if(session('error'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="appToast" class="toast align-items-center text-bg-danger border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body fw-semibold">{{ session('error') }}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
  @endif

  <div class="container py-5">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="row g-4 align-items-start">

          <!-- Left - Profile Picture -->
          <div class="col-md-3 text-center border-end">
            @if(session('user')->profile_pic && file_exists(public_path('uploads/' . session('user')->profile_pic)))
    <img src="/uploads/{{ session('user')->profile_pic }}"
         class="rounded-circle mb-3 border border-3 border-primary"
         style="width:120px;height:120px;object-fit:cover;" alt="Profile Picture">
@else
    <img src="/uploads/default.jpg"
         class="rounded-circle mb-3 border border-3 border-primary"
         style="width:120px;height:120px;object-fit:cover;" alt="Profile Picture">
@endif
        

            <h6 class="fw-bold mb-1">{{ session('user')->name }}</h6>
            <p class="text-muted small mb-2">{{ session('user')->email }}</p>
            <span class="badge bg-primary">User</span>
            <span class="badge bg-success ms-1">Active</span>

            <!-- Upload Profile Picture -->
            <form method="POST" action="/updateProfile" enctype="multipart/form-data" class="mt-3">
              @csrf
              <input type="hidden" name="name" value="{{ session('user')->name }}">
              <input type="hidden" name="email" value="{{ session('user')->email }}">
              <input type="file" name="profile" class="form-control form-control-sm mb-2" accept="image/*">
              <button class="btn btn-outline-primary btn-sm w-100">
                <i class="bi bi-camera me-1"></i>Change Photo
              </button>
            </form>
          </div>

          <!-- Right - Info -->
          <div class="col-md-9">
            <h6 class="fw-bold mb-3">
              <i class="bi bi-person-circle text-primary me-2"></i>Profile Information
            </h6>
            <div class="mb-4">
              <div class="mb-3">
                <p class="text-muted small mb-1 fw-semibold">FULL NAME</p>
                <p class="mb-0">{{ session('user')->name }}</p>
              </div>
              <div class="mb-3">
                <p class="text-muted small mb-1 fw-semibold">EMAIL</p>
                <p class="mb-0">{{ session('user')->email }}</p>
              </div>
              <div class="mb-3">
                <p class="text-muted small mb-1 fw-semibold">GENDER</p>
                <p class="mb-0">{{ session('user')->gender ?? 'N/A' }}</p>
              </div>
              <div class="mb-3">
                <p class="text-muted small mb-1 fw-semibold">MEMBER SINCE</p>
                <p class="mb-0">{{ session('user')->created_at->format('F Y') }}</p>
              </div>
            </div>

            <hr>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-pencil me-1"></i>Edit Profile
              </button>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal">
                <i class="bi bi-lock me-1"></i>Change Password
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- EDIT PROFILE Modal -->
  <div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Profile</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="/updateProfile" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control"
                     value="{{ session('user')->name }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control"
                     value="{{ session('user')->email }}" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- CHANGE PASSWORD Modal -->
  <div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-lock me-2"></i>Change Password</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="/updatePassword">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Current Password</label>
              <input type="password" name="current_pass" class="form-control"
                     placeholder="Enter current password" required>
            </div>
            <div class="mb-3">
              <label class="form-label">New Password</label>
              <input type="password" name="new_pass" class="form-control"
                     placeholder="Enter new password" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm New Password</label>
              <input type="password" name="confirm_pass" class="form-control"
                     placeholder="Confirm new password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Update Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var toastEl = document.getElementById('appToast');
      if(toastEl){
        var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
      }
    });
  </script>

</body>
</html>