<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contact = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars($_POST['phone']);

        $sql = "UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error updating contact.";
        }
    }
} else {
    echo "No contact selected!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>
    <form method="POST" action="edit_contact.php?id=<?php echo $contact['id']; ?>">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($contact['name']); ?>" required><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required><br><br>

        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required><br><br>

        <button type="submit">Update Contact</button>
    </form>
    <br>
    <a href="index.php">Back to Contact List</a>
</body>
</html>
