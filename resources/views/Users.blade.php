<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Users - MeysBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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

  {{-- Toast Notifications --}}
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

  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold mb-0">Users Management</h3>
      <a href="#addForm" class="btn btn-primary">+ Add User</a>
    </div>

    {{-- ADD USER FORM --}}
    <div class="card shadow-sm mb-4" id="addForm">
      <div class="card-header bg-primary text-white fw-bold">Add User</div>
      <div class="card-body">

        {{-- Note: Do not forget the @csrf inside the form --}}
        <form action="/users" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Full Name</label>
              <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select" required>
                <option value="" disabled selected>Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Rather not say">Rather not say</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" minlength="6" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="confirmpassword" class="form-control" minlength="6" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Add User</button>
        </form>

      </div>
    </div>

    {{-- EDIT USER FORM --}}
    @if(isset($editUser))
    <div class="card shadow-sm mb-4 border-warning">
      <div class="card-header bg-warning text-dark fw-bold">Edit User</div>
      <div class="card-body">
        <form action="{{ route('users.update', $editUser->id) }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Full Name</label>
              <input type="text" name="fullname" class="form-control"
                     value="{{ $editUser->name }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select" required>
                <option value="" disabled>Select gender</option>
                <option value="Male"           {{ $editUser->gender == 'Male'           ? 'selected' : '' }}>Male</option>
                <option value="Female"         {{ $editUser->gender == 'Female'         ? 'selected' : '' }}>Female</option>
                <option value="Rather not say" {{ $editUser->gender == 'Rather not say' ? 'selected' : '' }}>Rather not say</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control"
                     value="{{ $editUser->email }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label>
              <input type="password" name="password" class="form-control" minlength="6">
            </div>
            <div class="col-md-4">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="confirmpassword" class="form-control" minlength="6">
            </div>
          </div>
          <button type="submit" class="btn btn-warning mt-3">Update User</button>
          <a href="/users" class="btn btn-secondary mt-3">Cancel</a>
        </form>
      </div>
    </div>
    @endif

    {{-- USERS TABLE --}}
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Gender</th>
              <th>Email</th>
              <th>Created Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {{-- Table row will use foreach  --}}
            @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->gender ?? '-' }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at->format('M d, Y') }}</td>
              <td>
                {{-- Insert Edit Button --}}
                <a href="{{ route('users.edit', $user->id) }}"
                   class="btn btn-primary btn-sm">Edit</a>

                {{-- Delete Button --}}
                <a href="{{ route('users.delete', $user->id) }}"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this user?')">Delete</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- JS for Toast with 3 seconds --}}
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