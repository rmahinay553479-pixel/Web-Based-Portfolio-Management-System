<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

$conn = new mysqli($servername, $username, $password);

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS Messages_Tbl(
    Msg_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Email VARCHAR(100),
    Message TEXT
)");

if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    $conn->query("DELETE FROM Messages_Tbl WHERE Msg_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor Messages Manager</title>
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: #f5f5f5; 
            padding: 40px; 
        }
        .container { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            width: 900px; 
            margin: auto; 
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1); 
        }
        .nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .btn-back { 
            text-decoration: none; 
            color: #0c1013; 
            font-size: 14px; 
            font-weight: bold; 
        }
        h2 { 
            text-align: center; 
            color: #333; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #eee; 
        }
        th { 
            background-color: #f9f9f9; 
            color: #666; 
            text-transform: uppercase; 
            font-size: 12px; 
        }
        .msg-text { 
            font-size: 14px; 
            color: #555; 
            max-width: 300px; 
        }
        .btn-delete { 
            background: #f44336; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        .btn-delete:hover { 
            background: #d32f2f; 
        }
        .no-msg { 
            text-align: center; 
            padding: 20px; 
            color: #999; 
        }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-header">
        <a href="index.php" class="btn-back">← Go Back</a>
    </div>

    <h2>Visitor Messages</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM Messages_Tbl ORDER BY Msg_ID DESC");
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['Msg_ID']}</td>
                        <td><strong>" . htmlspecialchars($row['Name']) . "</strong></td>
                        <td>" . htmlspecialchars($row['Email']) . "</td>
                        <td class='msg-text'>" . nl2br(htmlspecialchars($row['Message'])) . "</td>
                        <td>
                            <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this message?\");'>
                                <input type='hidden' name='delete_id' value='{$row['Msg_ID']}'>
                                <button type='submit' class='btn-delete'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-msg'>No messages found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>