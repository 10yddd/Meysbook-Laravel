<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reservations - MeysBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand fw-bold">MeysBook</span>
    <div class="d-flex align-items-center gap-2">
      <span class="text-white"><?php echo e(session('user')->name); ?></span>
      <a href="<?php echo e(route('profile')); ?>" class="btn btn-outline-light btn-sm">Profile</a>
      <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-light btn-sm">Dashboard</a>
      <a href="<?php echo e(route('users')); ?>" class="btn btn-outline-light btn-sm">Users</a>
      <a href="<?php echo e(route('reservations')); ?>" class="btn btn-outline-light btn-sm">Reservations</a>
      <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </nav>

  
  <?php if(session('success')): ?>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast bg-success text-white" role="alert">
      <div class="toast-body">
        -- session('success') --
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

  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold mb-0">Reservation List</h3>
      <a href="#addForm" class="btn btn-primary">+ Add Reservation</a>
    </div>

    
    <div class="card shadow-sm mb-4" id="addForm">
      <div class="card-header bg-primary text-white fw-bold">Add Reservation</div>
      <div class="card-body">
        <form action="/reservations" method="POST">
          <?php echo csrf_field(); ?>
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Contact Number</label>
              <input type="text" name="contact" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Number of Guests</label>
              <input type="number" name="guests" class="form-control" min="1" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Reservation Date</label>
              <input type="date" name="reservation_date" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Reservation Time</label>
              <input type="time" name="reservation_time" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select name="status" class="form-select" required>
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Notes <small class="text-muted">(optional)</small></label>
              <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Add Reservation</button>
        </form>
      </div>
    </div>

    
    <?php if(isset($editReservation)): ?>
    <div class="card shadow-sm mb-4 border-warning">
      <div class="card-header bg-warning text-dark fw-bold">Edit Reservation</div>
      <div class="card-body">
        <form action="<?php echo e(route('reservations.update', $editReservation->id)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control"
                     value="<?php echo e($editReservation->name); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Contact Number</label>
              <input type="text" name="contact" class="form-control"
                     value="<?php echo e($editReservation->contact); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Number of Guests</label>
              <input type="number" name="guests" class="form-control"
                     value="<?php echo e($editReservation->guests); ?>" min="1" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Reservation Date</label>
              <input type="date" name="reservation_date" class="form-control"
                     value="<?php echo e($editReservation->reservation_date); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Reservation Time</label>
              <input type="time" name="reservation_time" class="form-control"
                     value="<?php echo e($editReservation->reservation_time); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select name="status" class="form-select" required>
                <option value="Pending"   <?php echo e($editReservation->status == 'Pending'   ? 'selected' : ''); ?>>Pending</option>
                <option value="Confirmed" <?php echo e($editReservation->status == 'Confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                <option value="Cancelled" <?php echo e($editReservation->status == 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Notes <small class="text-muted">(optional)</small></label>
              <textarea name="notes" class="form-control" rows="2"><?php echo e($editReservation->notes); ?></textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-warning mt-3">Update Reservation</button>
          <a href="/reservations" class="btn btn-secondary mt-3">Cancel</a>
        </form>
      </div>
    </div>
    <?php endif; ?>

    
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Date</th>
              <th>Time</th>
              <th>Guests</th>
              <th>Status</th>
              <th>Notes</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            
            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($reservation->id); ?></td>
              <td><?php echo e($reservation->name); ?></td>
              <td><?php echo e($reservation->contact); ?></td>
              <td><?php echo e($reservation->reservation_date); ?></td>
              <td><?php echo e($reservation->reservation_time); ?></td>
              <td><?php echo e($reservation->guests); ?></td>
              <td>
                <?php if($reservation->status == 'Confirmed'): ?>
                  <span class="badge bg-success">Confirmed</span>
                <?php elseif($reservation->status == 'Cancelled'): ?>
                  <span class="badge bg-danger">Cancelled</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php endif; ?>
              </td>
              <td><?php echo e($reservation->notes ?? '-'); ?></td>
              <td>
                
                <a href="<?php echo e(route('reservations.edit', $reservation->id)); ?>"
                   class="btn btn-primary btn-sm">Edit</a>

                
                <a href="<?php echo e(route('reservations.delete', $reservation->id)); ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this reservation?')">Delete</a>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

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
</html><?php /**PATH C:\xampp\htdocs\Laravel-Jabolin\resources\views/reservations.blade.php ENDPATH**/ ?>