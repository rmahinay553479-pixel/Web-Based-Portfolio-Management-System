<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";


$conn = new mysqli($servername, $username, $password);

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS Experience_Tbl(
    Exp_ID INT AUTO_INCREMENT PRIMARY KEY,
    Exp_Year VARCHAR(50),
    Exp_Activity VARCHAR(200)
)");

$edit_id = ""; $year = ""; $act = ""; $is_edit = false;


if (isset($_POST['save'])) {
    $year = $conn->real_escape_string($_POST['year']);
    $act = $conn->real_escape_string($_POST['act']);
    $conn->query("INSERT INTO Experience_Tbl (Exp_Year, Exp_Activity) VALUES ('$year', '$act')");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $year = $conn->real_escape_string($_POST['year']);
    $act = $conn->real_escape_string($_POST['act']);
    $conn->query("UPDATE Experience_Tbl SET Exp_Year='$year', Exp_Activity='$act' WHERE Exp_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $is_edit = true;
    $res = $conn->query("SELECT * FROM Experience_Tbl WHERE Exp_ID=$id");
    $row = $res->fetch_assoc();
    $edit_id = $row['Exp_ID'];
    $year = $row['Exp_Year'];
    $act = $row['Exp_Activity'];
}


if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $conn->query("DELETE FROM Experience_Tbl WHERE Exp_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Experience</title>
    <style>
        :root {
            --primary: #070c11;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
        }

        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            background-color: var(--bg); 
            color: var(--text);
            margin: 0;
            padding: 40px 20px;
        }

        .wrapper {
            max-width: 900px;
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
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        h2 { 
            margin: 0 0 1.5rem 0; 
            font-size: 1.25rem; 
            font-weight: 700; 
            color: #0f172a; 
        }

        form {
            display: grid;
            gap: 1rem;
            margin-bottom: 2.5rem;
            background: #f1f5f9;
            padding: 1.5rem;
            border-radius: 10px;
        }

        input {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.95rem;
            outline: none;
            transition: border 0.2s;
        }

        input:focus { 
            border-color: var(--primary); 
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem;
            background: #f8fafc;
            border-bottom: 2px solid var(--border);
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .year-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .actions { display: flex; gap: 8px; }

        .btn-edit { background: #0f172a; color: white; border:none; padding: 6px 12px; font-size: 0.75rem; border-radius: 4px; cursor: pointer; }
        .btn-del { background: #ef4444; color: white; border: none; padding: 6px 12px; font-size: 0.75rem; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="header-nav">
        <a href="index.php">← Go Back</a>
    </div>

    <div class="card">
        <h2><?php echo $is_edit ? "Update Experience" : "Add Experience Item"; ?></h2>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <input type="text" name="year" placeholder="Year (e.g. 2022 - 2024)" value="<?php echo $year; ?>" required>
            <input type="text" name="act" placeholder="Job Title or Activity" value="<?php echo $act; ?>" required>
            
            <button type="submit" name="<?php echo $is_edit ? 'update' : 'save'; ?>" class="btn-submit">
                <?php echo $is_edit ? 'Update Entry' : 'Add to Timeline'; ?>
            </button>
            <?php if($is_edit): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="text-align:center; color:#ef4444; font-size:0.8rem; text-decoration:none;">Cancel</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Activity / Achievement</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM Experience_Tbl ORDER BY Exp_ID DESC");
                while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><span class="year-badge"><?php echo htmlspecialchars($row['Exp_Year']); ?></span></td>
                    <td><strong><?php echo htmlspecialchars($row['Exp_Activity']); ?></strong></td>
                    <td>
                        <div class="actions" style="justify-content: flex-end;">
                            <form method="POST">
                                <input type="hidden" name="edit_id" value="<?php echo $row['Exp_ID']; ?>">
                                <button type="submit" class="btn-edit">Edit</button>
                            </form>
                            <form method="POST" onsubmit="return confirm('Delete this experience entry?')">
                                <input type="hidden" name="delete_id" value="<?php echo $row['Exp_ID']; ?>">
                                <button type="submit" class="btn-del">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>