<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - MeysBook</title>
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

  {{-- Toast Notifications ---}}
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

  <div class="container py-5">

    {{-- Display data from session => $user ---}}
    <h1 class="fw-bold mb-4">Welcome only, {{ session('user')->name }}</h1>

    {{-- Stats Cards - Number of Users, Number of Records from another table --}}
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Number of Users</h6>
            <h2 class="fw-bold">{{ $totalUsers }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Number of Reservations</h6>
            <h2 class="fw-bold">{{ $totalReservations }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-info shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Gender</h6>
            <h5 class="fw-bold">{{ session('user')->gender ?? 'N/A' }}</h5>
          </div>
        </div>
      </div>
    </div>

    {{-- Chart.js - (Chart.js or similar libraries) --}}
    <div class="card shadow-sm p-4">
      <h5 class="fw-bold mb-3">Reports</h5>
      <canvas id="reportsChart" height="80"></canvas>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  {{-- JS for Toast with 3 seconds ---}}
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toastElList = document.querySelectorAll('.toast');
      toastElList.forEach(function (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
          delay: 3000 // 3 seconds
        });
        toast.show();
      });

      // Chart.js 
      const ctx = document.getElementById('reportsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Number of Users', 'Number of Reservations'],
          datasets: [{
            label: 'Total Count',
            data: [{{ $totalUsers }}, {{ $totalReservations }}],
            backgroundColor: [
              'rgba(13, 110, 253, 0.7)',
              'rgba(25, 135, 84, 0.7)'
            ],
            borderColor: [
              'rgb(13, 110, 253)',
              'rgb(25, 135, 84)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, precision: 0 }
          }
        }
      });
    });
  </script>

</body>
</html>