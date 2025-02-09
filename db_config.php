<?php
// Load environment variables
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'bug_bounty';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed.");
    }
} catch (Exception $e) {
    error_log($e->getMessage()); // Log errors instead of displaying them
    die("Database connection issue. Please try again later.");
}
?>
