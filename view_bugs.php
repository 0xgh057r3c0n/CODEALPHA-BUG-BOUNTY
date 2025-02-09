<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db_config.php';

// Set security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Fetch bug list from the database
$sql = "SELECT title, description, severity, status FROM bugs";
$result = $conn->query($sql);

if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bugs</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Bug List</h2>
        <div class="form-box">
            <table>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Severity</th>
                    <th>Status</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['severity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No bugs reported</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
