<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add User</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="main-content" style="display:flex;justify-content:center;align-items:center;min-height:100vh;">
    <div class="add-user-card">
      <h2>Add User Form</h2>
      <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email'): ?>
        <div class="error-message">Email already exists. Please use a different email.</div>
      <?php endif; ?>
      <form action="add_user_process.php" method="POST">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="full_name" class="form-input" required>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-input" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-input" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-input" required>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-input" required>
            <option value="Administrator">Administrator</option>
            <option value="Customer">Customer</option>
          </select>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
