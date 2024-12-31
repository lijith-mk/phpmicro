<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Safely fetch the username
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Fetch contacts from the database
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <style>
        /* Reset some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding: 20px;
        }

        h1, h2 {
            color: #4caf50;
            text-align: center;
        }

        /* Container for the whole page */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* User welcome and logout styling */
        .welcome {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .welcome a {
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
        }

        .welcome a:hover {
            text-decoration: underline;
        }

        /* Links at the top of the page */
        .add-contact {
            display: block;
            text-align: center;
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .add-contact:hover {
            background-color: #45a049;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        table th {
            background-color: #4caf50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table a {
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
        }

        table a:hover {
            text-decoration: underline;
        }

        /* No contacts message */
        .no-contacts {
            text-align: center;
            color: #999;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .welcome {
                font-size: 16px;
            }

            table th, table td {
                padding: 10px;
            }

            .add-contact {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Manager</h1>

        <div class="welcome">
            <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
            <a href="logout.php">Logout</a>
        </div>

        <a href="add_contact.php" class="add-contact">Add New Contact</a>

        <h2>Contact List:</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>
                            <a href="edit_contact.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                            <a href="delete_contact.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-contacts">No contacts available.</p>
        <?php endif; ?>

    </div>
</body>
</html>

<?php
$conn->close();
?>
