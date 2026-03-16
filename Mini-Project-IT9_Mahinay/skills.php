<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

/* CONNECT DATABASE */
$conn = new mysqli($servername, $username, $password);

/* CREATE DATABASE */
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

/* CREATE TABLE */
$conn->query("CREATE TABLE IF NOT EXISTS Skills_Tbl(
    Skill_ID INT AUTO_INCREMENT PRIMARY KEY,
    Skill_Name VARCHAR(100) NOT NULL,
    Skill_Level INT NOT NULL,
    Skill_Category VARCHAR(100) NOT NULL
)");

/* VARIABLES */
$edit_id = "";
$name = "";
$level = "";
$category = "";
$is_edit = false;

/* ADD SKILL */
if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $level = (int)$_POST['level'];
    $category = $conn->real_escape_string($_POST['category']);
    $conn->query("INSERT INTO Skills_Tbl (Skill_Name, Skill_Level, Skill_Category) VALUES ('$name', '$level', '$category')");
}

/* UPDATE SKILL */
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $level = (int)$_POST['level'];
    $category = $conn->real_escape_string($_POST['category']);
    $conn->query("UPDATE Skills_Tbl SET Skill_Name='$name', Skill_Level='$level', Skill_Category='$category' WHERE Skill_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh to clear edit mode
}

/* EDIT MODE */
if (isset($_POST['edit_id'])) {
    $id = (int)$_POST['edit_id'];
    $is_edit = true;
    $res = $conn->query("SELECT * FROM Skills_Tbl WHERE Skill_ID=$id");
    $row = $res->fetch_assoc();
    $edit_id = $row['Skill_ID'];
    $name = $row['Skill_Name'];
    $level = $row['Skill_Level'];
    $category = $row['Skill_Category'];
}

/* DELETE */
if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    $conn->query("DELETE FROM Skills_Tbl WHERE Skill_ID=$id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio Skills Manager</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; padding: 40px; }
        .container { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            width: 800px; 
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
            color: #555;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-back:hover { color: #000; }
        h2 { text-align: center; color: #333; margin: 10px 0; }
        form { margin-bottom: 30px; text-align: center; }
        input { padding: 10px; margin: 5px; border: 1px solid #ccc; border-radius: 4px; width: 180px; }
        .btn-main { 
            padding: 10px 20px; 
            cursor: pointer; 
            border: none; 
            border-radius: 4px;
            background: #333; 
            color: white; 
            font-weight: bold;
        }
        .btn-main:hover { background: #555; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #eee; }
        th, td { padding: 12px; text-align: center; }
        th { background-color: #f9f9f9; color: #666; font-size: 13px; text-transform: uppercase; }
        .btn-edit { background: #2196F3; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        .btn-delete { background: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-header">
        <a href="index.php" class="btn-back">← Go Back</a>
    </div>

    <h2><?php echo $is_edit ? "Edit Skill" : "Add New Skill"; ?></h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
        <input type="text" name="name" placeholder="Skill Name" value="<?php echo $name; ?>" required>
        <input type="number" name="level" placeholder="Level %" value="<?php echo $level; ?>" required min="0" max="100">
        <input type="text" name="category" placeholder="Category" value="<?php echo $category; ?>" required>
        
        <button type="submit" name="<?php echo $is_edit ? 'update' : 'save'; ?>" class="btn-main">
            <?php echo $is_edit ? 'Update' : 'Save'; ?>
        </button>
        <?php if($is_edit): ?>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 12px; color: #f44336; margin-left: 10px;">Cancel</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>Skill</th>
                <th>Level</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM Skills_Tbl ORDER BY Skill_ID DESC");
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['Skill_Name']}</td>
                        <td>{$row['Skill_Level']}%</td>
                        <td>{$row['Skill_Category']}</td>
                        <td>
                            <form method='POST' style='display:inline'>
                                <input type='hidden' name='edit_id' value='{$row['Skill_ID']}'>
                                <button type='submit' class='btn-edit'>Edit</button>
                            </form>
                            <form method='POST' style='display:inline'>
                                <input type='hidden' name='delete_id' value='{$row['Skill_ID']}'>
                                <button type='submit' class='btn-delete' onclick='return confirm(\"Delete this skill?\")'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No skills found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>