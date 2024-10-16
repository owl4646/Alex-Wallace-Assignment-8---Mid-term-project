<?php
include 'config.php'; // Include configuration functions

// Load all users and pets for the homepage
$users = load_items('users');
$pets = load_items('pets');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- Grayscale Bootstrap CSS -->
    <link href="css/grayscale.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">My CMS</a>
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
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="masthead text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <h1 class="masthead-heading mb-0">Welcome to My CMS</h1>
            <p class="masthead-subheading font-weight-light mb-0">Manage your pets and users efficiently.</p>
        </div>
    </header>

    <!-- Users Section -->
    <section class="bg-light" id="users">
        <div class="container">
            <h2 class="mb-4">Users</h2>
            <div class="row">
                <?php foreach ($users as $user): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($user['name']); ?></h5>
                                <p class="card-text">User ID: <?php echo htmlspecialchars($user['id']); ?></p>
                                <a href="admin/manage_users.php" class="btn btn-primary">Manage Users</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Pets Section -->
    <section id="pets">
        <div class="container">
            <h2 class="mb-4">Pets</h2>
            <div class="row">
                <?php foreach ($pets as $pet): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars(substr($pet['details'], 0, 100)); ?>...</p>
                                <a href="admin/manage_pets.php" class="btn btn-primary">Manage Pets</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">© <?php echo date("Y"); ?> My CMS. All rights reserved.</p>
        </div>
    </footer>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/grayscale.js"></script>
</body>
</html>
