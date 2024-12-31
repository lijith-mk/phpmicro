<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);

    if (!empty($name) && !empty($email) && !empty($phone)) {
        $sql = "INSERT INTO contacts (name, email, phone, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $phone);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error adding contact.";
        }
    } else {
        echo "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contact</title>
</head>
<body>
    <h1>Add New Contact</h1>
    <form method="POST" action="add_contact.php">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" required><br><br>

        <button type="submit">Add Contact</button>
    </form>
    <br>
    <a href="index.php">Back to Contact List</a>
</body>
</html>
