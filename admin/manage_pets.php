<?php
include '../config.php'; // Include configuration functions

// Ensure the user is logged in
if (!is_logged_in()) {
    header('Location: ../login.php');
    exit();
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $pet_id = $_GET['id'];
    $pets = load_items('pets');

    // Filter out the pet to delete
    $pets = array_filter($pets, function($pet) use ($pet_id) {
        return $pet['id'] !== $pet_id;
    });

    // Save the updated pets array
    save_items('pets', $pets);

    // Redirect back to manage pets
    header('Location: manage_pets.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pets</title>
    <!-- Grayscale Bootstrap CSS -->
    <link href="../css/grayscale.css" rel="stylesheet">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="../index.php">My CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../create_pet.php">Create Pet</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_pets.php">Manage Pets</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Manage Pets Content -->
    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Manage Pets</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Pet Name</th>
                    <th>Details</th>
                    <th>Owner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $pets = load_items('pets'); ?>
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pet['name']); ?></td>
                        <td><?php echo htmlspecialchars($pet['details']); ?></td>
                        <td><?php echo htmlspecialchars($pet['owner']); ?></td>
                        <td>
                            <!-- Edit functionality can be added similarly -->
                            <a href="manage_pets.php?action=delete&id=<?php echo htmlspecialchars($pet['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/grayscale.js"></script>
</body>
</html>
