<?php
include 'config.php'; // Include configuration functions

// Destroy the session
session_unset();
session_destroy();

// Redirect to homepage
header('Location: index.php');
exit();
?>
