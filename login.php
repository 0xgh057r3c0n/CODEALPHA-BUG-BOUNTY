<?php
session_start();
include 'db_config.php';

// Set security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die("Username and password cannot be empty.");
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password securely
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['user_id'] = $row['id'];

            header("Location: submit_bug.html");
            exit();
        }
    }

    // If login fails, show a generic error message
    die("Invalid username or password.");
}

$conn->close();
?>
