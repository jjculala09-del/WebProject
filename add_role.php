<?php
include 'db.php';

// kuha ng lahat ng roles
$sql = "SELECT * FROM roles ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Roles Management</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="card" style="max-width:600px;margin:2rem auto;">
    <h2 style="color:#0ff;">Add Role</h2>
    <form action="add_role_process.php" method="POST">
      <div class="form-group">
        <label>Role Name</label>
        <input type="text" name="role_name" class="form-input" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <input type="text" name="role_description" class="form-input">
      </div>
      <button type="submit" class="btn btn-primary" style="margin-bottom:1rem;">Add Role</button>
    </form>

    <h3 style="color:#0ff;margin-top:2rem;">Roles List</h3>
    <table class="role-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Role Name</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['role_name']) ?></td>
              <td><?= htmlspecialchars($row['role_description']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="3">No roles found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
