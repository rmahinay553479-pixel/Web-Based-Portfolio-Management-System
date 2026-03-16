<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

$conn = new mysqli($servername, $username, $password);
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS Projects_Tbl(
    Project_ID INT AUTO_INCREMENT PRIMARY KEY,
    Project_Title VARCHAR(100),
    Project_Tech VARCHAR(100),
    Project_Description TEXT
)");

$edit_id = ""; $title = ""; $tech = ""; $desc = ""; $is_edit = false;

if (isset($_POST['save'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $tech = $conn->real_escape_string($_POST['tech']);
    $desc = $conn->real_escape_string($_POST['desc']);
    $conn->query("INSERT INTO Projects_Tbl (Project_Title, Project_Tech, Project_Description) VALUES ('$title', '$tech', '$desc')");
    header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $tech = $conn->real_escape_string($_POST['tech']);
    $desc = $conn->real_escape_string($_POST['desc']);
    $conn->query("UPDATE Projects_Tbl SET Project_Title='$title', Project_Tech='$tech', Project_Description='$desc' WHERE Project_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $is_edit = true;
    $res = $conn->query("SELECT * FROM Projects_Tbl WHERE Project_ID=$id");
    $row = $res->fetch_assoc();
    $edit_id = $row['Project_ID'];
    $title = $row['Project_Title'];
    $tech = $row['Project_Tech'];
    $desc = $row['Project_Description'];
}

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $conn->query("DELETE FROM Projects_Tbl WHERE Project_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Projects</title>
    <style>
        :root {
            --primary: #000000; 
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
        }

        body { 
            font-family: 'Inter', system-ui, sans-serif; 
            background-color: var(--bg); 
            color: var(--text);
            margin: 0;
            padding: 40px 20px;
        }

        .wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-nav a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        h2 { margin-top: 0; font-size: 1.5rem; font-weight: 700; }

        form {
            display: grid;
            gap: 1rem;
            margin-bottom: 3rem;
            background: #f1f5f9;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .input-group { 
            display: flex; 
            flex-direction: column; 
            gap: 0.5rem; 
        }

        input, textarea {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 1rem;
            outline: none;
        }

        input:focus, textarea:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1); 
        }

        .btn-main {
            background: var(--primary);
            color: white; 
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-main:hover { opacity: 0.8; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th {
            text-align: left;
            padding: 1rem;
            background: #f8fafc;
            border-bottom: 2px solid var(--border);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .tech-tag {
            background: #f1f5f9;
            color: #000000;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid var(--border);
        }

        .actions { 
            display: flex; 
            gap: 0.5rem; 
        }

        .btn-edit { 
            background: #000000; 
            color: white; 
            border: none;
            padding: 5px 12px; 
            font-size: 0.8rem; 
            border-radius: 4px; 
            cursor: pointer;
            font-weight: 500;
        }
        .btn-del { 
            background: #ef4444; 
            color: white; 
            border: none; 
            padding: 5px 12px; 
            font-size: 0.8rem; 
            border-radius: 4px; 
            cursor: pointer; 
        }

        .btn-edit:hover, .btn-del:hover { opacity: 0.8; }

    </style>
</head>
<body>

<div class="wrapper">
    <div class="header-nav">
        <a href="index.php">← Go back</a>
    </div>

    <div class="card">
        <h2><?php echo $is_edit ? "Update Project" : "Add New Project"; ?></h2>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <div class="input-group">
                <input type="text" name="title" placeholder="Project Name" value="<?php echo $title; ?>" required>
            </div>
            <div class="input-group">
                <input type="text" name="tech" placeholder="Technologies (e.g. PHP, React)" value="<?php echo $tech; ?>" required>
            </div>
            <div class="input-group">
                <textarea name="desc" placeholder="Project details..."><?php echo $desc; ?></textarea>
            </div>
            <button type="submit" name="<?php echo $is_edit ? 'update' : 'save'; ?>" class="btn-main">
                <?php echo $is_edit ? 'Update Project' : 'Publish Project'; ?>
            </button>
            <?php if($is_edit): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="text-align:center; color:#ef4444; font-size:0.8rem; display: block; margin-top: 10px; text-decoration: none;">Cancel Edit</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Tech Stack</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM Projects_Tbl ORDER BY Project_ID DESC");
                while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['Project_Title']); ?></strong></td>
                    <td><span class="tech-tag"><?php echo htmlspecialchars($row['Project_Tech']); ?></span></td>
                    <td class="actions">
                        <form method="POST">
                            <input type="hidden" name="edit_id" value="<?php echo $row['Project_ID']; ?>">
                            <button type="submit" class="btn-edit">Edit</button>
                        </form>
                        <form method="POST" onsubmit="return confirm('Delete this project?')">
                            <input type="hidden" name="delete_id" value="<?php echo $row['Project_ID']; ?>">
                            <button type="submit" class="btn-del">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>