function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("open");
}

document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', function() {
        // Remove active class from all
        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        // Hide all sections
        document.querySelectorAll('.main-section').forEach(sec => sec.style.display = 'none');
        // Show the selected section
        const target = this.getAttribute('data-target');
        const section = document.getElementById(target + '-section');
        if (section) section.style.display = '';
    });
});

// Show dashboard by default on load
window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('dashboard-section').style.display = '';
});

function openAddUserModal() {
  const modal = document.getElementById("addUserModal");
  if (modal) {
    modal.classList.remove("hidden");
  } else {
    console.error("modal not found!");
  }
}

function closeAddUserModal() {
  const modal = document.getElementById("addUserModal");
  if (modal) {
    modal.classList.add("hidden");
  }
}

function openAddProductModal() {
  document.getElementById("addProductModal").classList.remove("hidden");
}
function closeAddProductModal() {
  document.getElementById("addProductModal").classList.add("hidden");
}
function openAddCategoryModal() {
  document.getElementById("addCategoryModal").classList.remove("hidden");
}
function closeAddCategoryModal() {
  document.getElementById("addCategoryModal").classList.add("hidden");
}
function openAddRoleModal() {
  const modal = document.getElementById("addRoleModal");
  if (modal) {
    modal.classList.remove("hidden");
  } else {
    console.error("Modal not found!");
  }
}
function closeAddRoleModal() {
  const modal = document.getElementById("addRoleModal");
  if (modal) {
    modal.classList.add("hidden");
  } else {
    console.error("Modal not found!");
  }
}

function toggleMenu(menuId) {
  const menu = document.getElementById(menuId);
  if (menu) {
    menu.classList.toggle('hidden');
  }
}

function showSection(section) {
  document.querySelectorAll('.main-section').forEach(sec => sec.style.display = 'none');
  const target = document.getElementById(section + '-section');
  if (target) target.style.display = '';
}



