<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all users
$users = [];
$roles = [];

// roles
$roles = [];
$res = $conn->query("SELECT role_id, role_name, role_description FROM roles ORDER BY role_id DESC");
if ($res) {
  while ($r = $res->fetch_assoc()) { $roles[] = $r; }
}

$users_tbl_result = $conn->query("SELECT * FROM users");
if ($users_tbl_result) {
    while ($row = $users_tbl_result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>
<?php
// ...existing code...
$categories = [];
$cat_result = $conn->query("SELECT * FROM categories");
if ($cat_result) {
    while ($row = $cat_result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameZone Admin Dashboard</title>
    <link rel="stylesheet" href="src/input.css">
    <link rel="stylesheet" href="dist/output.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
  <h1>GAME CREDITS</h1>
  <nav>
    <ul>
      <li>
        <a class="btn-add-user sidebar-link" href="#" onclick="showSection('dashboard')">
          <i class="fas fa-home"></i> Dashboard
        </a>
      </li>
      <li>
        <button class="btn-add-user toggle-btn" onclick="toggleMenu('usersMenu')">
          <i class="fas fa-users"></i> User Menu
        </button>
        <ul id="usersMenu" class="submenu hidden">
          <li><a class="sidebar-link" href="#" onclick="showSection('users')">Users</a></li>
          <li><a class="sidebar-link" href="#" onclick="showSection('roles')">Roles</a></li>
        </ul>
      </li>
      <li>
        <button class="btn-add-user toggle-btn" onclick="toggleMenu('productsMenu')">
          <i class="fas fa-box"></i> Product Menu
        </button>
        <ul id="productsMenu" class="submenu hidden">
          <li><a class="sidebar-link" href="#" onclick="showSection('categories')">Categories</a></li>
          <li><a class="sidebar-link" href="#" onclick="showSection('products')">Product List</a></li>
          <li><a class="sidebar-link" href="#" onclick="showSection('orders')">Orders</a></li>
        </ul>
      </li>
      <li>
        <a class="btn-add-user sidebar-link" href="#" onclick="showSection('settings')">
          <i class="fas fa-cog"></i> Settings
        </a>
      </li>
      <li>
        <button class="btn-add-user sidebar-link" onclick="window.location.href='logout.php'">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </li>
    </ul>
  </nav>
</aside>

  <!-- Main Content -->
  <div class="main-content" id="main-content">
    <header>
      <h2>Dashboard Overview</h2>
      <div class="nav-user">
        <span>Admin</span>
        <img src="images/IMG_E4035.JPG" alt="User" />
        <i class="fas fa-chevron-down"></i>
      </div>
    </header>

    <!-- Dashboard Section -->
    <div class="main-section" id="dashboard-section">
      <h2>Dashboard Overview</h2>

      <!-- Cards Section -->
      <section class="cards-grid">
        <div class="card">
          <div class="card-icon"><i class="fas fa-users"></i></div>
          <h3>Total Users</h3>
          <p>1,245</p>
        </div>
        <div class="card">
          <div class="card-icon"><i class="fas fa-boxes"></i></div>
          <h3>Products</h3>
          <p>582</p>
        </div>
        <div class="card">
          <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
          <h3>Orders</h3>
          <p>321</p>
        </div>
      </section>

      <!-- Table Section -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>User</th>
              <th>Status</th>
              <th>Role</th>
              <th>Last Login</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= $user['full_name'] . ' ' . $user['last_name'] ?></td>
                <td><?= $user['number'] ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['last_login'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Products Section -->
    <div class="main-section" id="products-section" style="display:none;">
      <h2>Products</h2>
      <button class="btn-add-user" onclick="openAddProductModal()">Add Product</button>
      <div class="table-container" style="margin-top: 2rem;">
    <table>
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Product Code</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch products with category name
        $products = [];
        $prod_result = $conn->query("SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id");
        if ($prod_result) {
            while ($row = $prod_result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        ?>
        <?php foreach ($products as $prod): ?>
          <tr>
            <td><?= htmlspecialchars($prod['product_name']) ?></td>
            <td><?= htmlspecialchars($prod['product_code']) ?></td>
            <td><?= htmlspecialchars($prod['price']) ?></td>
            <td><?= htmlspecialchars($prod['stock']) ?></td>
            <td><?= htmlspecialchars($prod['category_name']) ?></td>
            <td>
              <button class="btn-outline" onclick="alert('Edit <?= $prod['product_name'] ?>')">Edit</button>
              <button class="btn-outline" onclick="window.location.href='delete_product.php?id=<?= $prod['id'] ?>'">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
    </div>

    <!-- Users Section -->
    <div class="main-section" id="users-section" style="display:none;">
      <h2>User Management</h2>
      <button class="btn-add-user" onclick="openAddUserModal()">
        <span></span> Add User
      </button>
      <div class="table-container" style="margin-top: 2rem;">
        <table class="role-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Number</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="user-table-body">
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['full_name'] . ' ' . $user['last_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['number']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                  <button class="btn-outline" onclick="alert('Edit <?= $user['username'] ?>')">Edit</button>
                  <button class="btn-outline" onclick="alert('Delete <?= $user['username'] ?>')">Delete</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Orders Section -->
    <div class="main-section" id="orders-section" style="display:none;">
      <h2>Orders</h2>
      <!-- Orders content here -->
    </div>

    <!-- Settings Section -->
    <div class="main-section" id="settings-section" style="display:none;">
      <h2>Settings</h2>
      <!-- Settings content here -->
    </div>

    <!-- Profile Section -->
    <div class="main-section" id="profile-section" style="display:none;">
      <h2>Profile</h2>
      <!-- Profile content here -->
    </div>

    <!-- Categories Section -->
    <div class="main-section" id="categories-section" style="display:none;">
  <h2>Categories</h2>
  <button class="btn-add-user" onclick="openAddCategoryModal()">Add Category</button>
  <div class="table-container" style="margin-top: 2rem;">
    <table>
      <thead>
        <tr>
          <th>Category Name</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

 <!-- roles Section -->
   <div class="main-section" id="roles-section" style="display:none;">
  <h2>Roles Management</h2>
  <button class="btn-add-user" onclick="openAddRoleModal()">
    <span></span> Add Role
  </button>
    <!-- Roles Section -->
      <div class="table-container" style="margin-top: 2rem;">
        <table class="role-table">
          <thead>
            <tr>
                <th>ID</th>
                <th>Role Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($roles as $role): ?>
              <tr>
                <td><?= htmlspecialchars($role['role_id']) ?></td>
              <td><?= htmlspecialchars($role['role_name']) ?></td>
              <td><?= htmlspecialchars($role['role_description']) ?></td>
                <td>
                  <button class="btn-outline" onclick="alert('Edit <?= $role['role_name'] ?>')">Edit</button>
                  <button class="btn-outline" onclick="alert('Delete <?= $role['role_name'] ?>')">Delete</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

        <!-- ✅ Add User Modal -->
        <div id="addUserModal" class="modal hidden">
  <div class="modal-content">
    <h2 style="margin-bottom: 1rem;">Add User</h2>
    <form action="add_user_process.php" method="POST">
      <input type="text" name="full_name" placeholder="Full Name" class="form-input" required>
      <input type="text" name="username" placeholder="Username" class="form-input" required>
      <input type="text" name="number" placeholder="Number" class="form-input" required>
      <input type="email" name="email" placeholder="Email" class="form-input" required>
      <input type="password" name="password" placeholder="Password" class="form-input" required>
      <select name="role" class="form-input" required>
        <option value="Administrator">Admin</option>
        <option value="Customer">Customer</option>
      </select>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-outline" onclick="closeAddUserModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Add Role Modal -->
<div id="addRoleModal" class="modal hidden">
  <div class="modal-content">
    <h2 style="margin-bottom: 1rem;">Add Role</h2>
    <form action="add_role_process.php" method="POST">
      <div class="form-group">
        <label>Role Name</label>
        <input type="text" name="role_name" class="form-input" required>
      </div>

      <div class="form-group">
        <label>Description</label>
        <input type="text" name="role_description" class="form-input" placeholder="Optional">
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-outline" onclick="closeAddRoleModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>



<!-- Add Product Modal -->
        <div id="addProductModal" class="modal hidden">
  <div class="modal-content">
    <h2 style="margin-bottom: 1rem;">Add Product</h2>
    <form action="add_product_process.php" method="POST">
      <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="product_name" class="form-input" required>
      </div>
      <div class="form-group">
        <label>Product Code</label>
        <input type="text" name="product_code" class="form-input" required>
      </div>
      <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" class="form-input" required>
      </div>
      <div class="form-group">
        <label>Stock</label>
        <input type="number" name="stock" class="form-input" required>
      </div>
      <div class="form-group">
        <label>Category</label>
        <select name="category_id" class="form-input" required>
          <option value="">Select Category</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Add Product</button>
        <button type="button" class="btn btn-outline" onclick="closeAddProductModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Add Category Modal -->
<div id="addCategoryModal" class="modal hidden">
  <div class="modal-content">
    <h2 style="margin-bottom: 1rem;">Add Category</h2>
    <form action="add_category_process.php" method="POST">
      <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="category_name" class="form-input" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Add Category</button>
        <button type="button" class="btn btn-outline" onclick="closeAddCategoryModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

        <script src="script.js"></script>
</body>
</html>


