<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute() === TRUE) {
        header("Location: login.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

/*Here, the user's username, password, and email are obtained from the request form using the POST method and
 added to the table named users in the MySQL database. The password is hashed, which means protecting it. 
If successful, redirects to the login page.*/

?>




