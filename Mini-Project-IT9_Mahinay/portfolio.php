<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->select_db($dbname);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
            color: #333;
            margin: 0;
        }

        .container {
            width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .nav-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .nav-top a {
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #222;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        h2 {
            color: #444;
            border-left: 4px solid #3498db;
            padding-left: 15px;
            margin-top: 40px;
            font-size: 22px;
        }

        .section {
            margin-top: 20px;
        }

        /* Experience Style */
        .exp-item {
            display: flex;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #f9f9f9;
        }

        .exp-year {
            min-width: 120px;
            font-weight: bold;
            color: #3498db;
        }

        .project-item {
            background: #fafafa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #eee;
        }

        .skill-item {
            background: #fff;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
        }

        .skill-category {
            color: #3498db;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }

        .footer-nav {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        a.contact-link {
            display: inline-block;
            padding: 12px 30px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-top">
        <a href="index.php" class="go-back">← Go Back</a>
    </div>

    <h1>My Portfolio</h1>

    <div class="section">
        <h2>My Skills</h2>
        <?php
        $res = $conn->query("SELECT * FROM Skills_Tbl ORDER BY Skill_Category ASC");
        if ($res && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                echo "<div class='skill-item'>";
                echo "<span><strong>" . htmlspecialchars($row['Skill_Name']) . "</strong> - " . $row['Skill_Level'] . "%</span>";
                echo "<span class='skill-category'>" . htmlspecialchars($row['Skill_Category']) . "</span>";
                echo "</div>";
            }
        } else {
            echo "<p style='color:#999;'>No skills added yet.</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>My Experience</h2>
        <?php
        $check_exp = $conn->query("SHOW TABLES LIKE 'Experience_Tbl'");
        if($check_exp->num_rows > 0) {
            $res = $conn->query("SELECT * FROM Experience_Tbl ORDER BY Exp_ID DESC");
            if ($res && $res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo "<div class='exp-item'>";
                    echo "<div class='exp-year'>" . htmlspecialchars($row['Exp_Year']) . "</div>";
                    echo "<div class='exp-details'><strong>" . htmlspecialchars($row['Exp_Activity']) . "</strong></div>";
                    echo "</div>";
                }
            } else {
                echo "<p style='color:#999;'>No experience history added yet.</p>";
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>My Projects</h2>
        <?php
        $check_table = $conn->query("SHOW TABLES LIKE 'Projects_Tbl'");
        if($check_table->num_rows > 0) {
            $res = $conn->query("SELECT * FROM Projects_Tbl ORDER BY Project_ID DESC");
            if ($res && $res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo "<div class='project-item'>";
                    echo "<h3 style='margin:0 0 5px 0; color:#2c3e50;'>" . htmlspecialchars($row['Project_Title']) . "</h3>";
                    echo "<small style='color:#3498db; font-weight:bold;'>Tech: " . htmlspecialchars($row['Project_Tech']) . "</small>";
                    echo "<p style='margin-top:10px; line-height:1.6; font-size:14px;'>" . nl2br(htmlspecialchars($row['Project_Description'])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p style='color:#999;'>No projects found.</p>";
            }
        }
        ?>
    </div>

    <div class="footer-nav">
        <a href="contact.php" class="contact-link">Contact Me</a>
    </div>

</div>

</body>
</html>