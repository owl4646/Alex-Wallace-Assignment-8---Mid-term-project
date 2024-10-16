<?php
session_start();
include 'config.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$type = isset($_GET['type']) ? $_GET['type'] : 'users';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Load the items (users/pets)
$items = load_items($type);

// Handle create action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $name = $_POST['name'];
    $details = $_POST['details'];
    save_item($type, $name, $details);
    header("Location: admin.php?type=$type");
    exit;
}

// Handle delete action
if ($action === 'delete' && $id) {
    delete_item($type, $id);
    header("Location: admin.php?type=$type");
    exit;
}

// Handle edit action
if ($action === 'edit' && $id) {
    // Load the item for editing
    $itemToEdit = null;
    foreach ($items as $item) {
        if ($item['id'] == $id) {
            $itemToEdit = $item;
            break;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $details = $_POST['details'];
        delete_item($type, $id); // Remove the old entry
        save_item($type, $name, $details); // Save the updated entry
        header("Location: admin.php?type=$type");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage <?php echo ucfirst($type); ?></title>
    <link href="bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage <?php echo ucfirst($type); ?></h1>

        <!-- Form for adding new items -->
        <h2 class="mt-5">Add New <?php echo ucfirst($type); ?></h2>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label"><?php echo ucfirst($type); ?> Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">Details</label>
                <textarea name="details" class="form-control" id="details" rows="3" required></textarea>
            </div>
            <button type="submit" name="action" value="create" class="btn btn-primary">Save</button>
        </form>

        <!-- Table for listing users or pets -->
        <h2 class="mt-4"><?php echo ucfirst($type); ?> List</h2>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>
                            <a href="admin.php?type=<?php echo $type; ?>&action=view&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info">View</a>
                            <a href="admin.php?type=<?php echo $type; ?>&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="admin.php?type=<?php echo $type; ?>&action=delete&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger delete-btn" data-url="admin.php?type=<?php echo $type; ?>&action=delete&id=<?php echo $item['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                document.getElementById('confirmDeleteBtn').setAttribute('href', url);
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });
    </script>
</body>
</html>
