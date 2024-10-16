<?php
include 'config.php'; // Include configuration functions

// Ensure the user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_name = trim($_POST['pet_name']);
    $pet_details = trim($_POST['pet_details']);
    $owner = $_SESSION['username']; // Get the logged-in user's username

    // Validate inputs
    if (empty($pet_name) || empty($pet_details)) {
        $error = "All fields are required.";
    } else {
        // Load existing pets
        $pets = load_items('pets');

        // Create a new pet array
        $new_pet = [
            'id' => uniqid(),
            'name' => $pet_name,
            'details' => $pet_details,
            'owner' => $owner
        ];

        // Add the new pet to the pets array
        $pets[] = $new_pet;

        // Save updated pets array back to the file
        save_items('pets', $pets);

        // Redirect to the manage pets page or show success message
        header('Location: admin/manage_pets.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Pet</title>
    <!-- Grayscale Bootstrap CSS -->
    <link href="css/grayscale.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.php">My CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="create_pet.php">Create Pet</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/manage_pets.php">Manage Pets</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Create Pet Content -->
    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Create a New Pet</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="create_pet.php">
            <div class="mb-3">
                <label for="pet_name" class="form-label">Pet Name</label>
                <input type="text" class="form-control" id="pet_name" name="pet_name" required>
            </div>
            <div class="mb-3">
                <label for="pet_details" class="form-label">Pet Details</label>
                <textarea class="form-control" id="pet_details" name="pet_details" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Pet</button>
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </form>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/grayscale.js"></script>
</body>
</html>
