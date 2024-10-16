<?php
session_start(); // Start the session at the very beginning

/**
 * Load items from a flat file.
 *
 * @param string $type The type of items to load (e.g., 'users', 'pets').
 * @return array The array of items.
 */
function load_items($type) {
    $file_path = __DIR__ . "/data/{$type}.txt";
    if (file_exists($file_path)) {
        $json = file_get_contents($file_path);
        return json_decode($json, true);
    }
    return [];
}

/**
 * Save items to a flat file.
 *
 * @param string $type The type of items to save (e.g., 'users', 'pets').
 * @param array $items The array of items to save.
 * @return void
 */
function save_items($type, $items) {
    $file_path = __DIR__ . "/data/{$type}.txt";
    $json = json_encode($items, JSON_PRETTY_PRINT);
    file_put_contents($file_path, $json);
}

/**
 * Check if a username already exists.
 *
 * @param string $username The username to check.
 * @return bool True if exists, false otherwise.
 */
function username_exists($username) {
    $users = load_items('users');
    foreach ($users as $user) {
        if ($user['name'] === $username) {
            return true;
        }
    }
    return false;
}

/**
 * Validate user credentials.
 *
 * @param string $username The username.
 * @param string $password The password.
 * @return bool True if valid, false otherwise.
 */
function validate_user($username, $password) {
    $users = load_items('users');
    foreach ($users as $user) {
        if ($user['name'] === $username && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

/**
 * Check if the user is logged in.
 *
 * @return bool True if logged in, false otherwise.
 */
function is_logged_in() {
    return isset($_SESSION['username']);
}
?>
