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
    <title>Rey Ryan | Portfolio</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f7f6;
            padding: 40px 20px;
            color: #333;
            margin: 0;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .nav-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .nav-top a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            transition: 0.3s;
        }

        .nav-top a:hover { color: #000; }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #f0f0f0;
            margin-bottom: 20px;
        }

        h1 { margin: 0; color: #1a1a1a; font-size: 2.2rem; }
        .bio-short { color: #666; margin-top: 10px; font-size: 1.1rem; line-height: 1.5; }

        h2 {
            color: #1a1a1a;
            border-left: 5px solid #2563eb;
            padding-left: 15px;
            margin-top: 50px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .about-text { line-height: 1.8; color: #444; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        .info-card {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        ul, ol { padding-left: 20px; line-height: 1.8; }

        .skill-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .exp-item {
            display: flex;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .project-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 15px;
        }

        .quote-box {
            text-align: center;
            background: #1e293b;
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-top: 50px;
            font-style: italic;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }

        .btn-contact {
            display: inline-block;
            padding: 12px 35px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-top">
        <a href="index.php">← Admin Dashboard</a>
        <a href="https://github.com/rmahinay553479-pixel" target="_blank">GitHub Profile ↗</a>
    </div>

    <div class="profile-header">
        <img src="RYAN.jpg" alt="Rey Ryan" class="profile-img" onerror="this.src='https://via.placeholder.com/180'">
        <h1>Rey Ryan T. Mahinay</h1>
        <p class="bio-short">
            19 years old | Born Feb 11, 2006 <br>
            Purok 5, Km. 8, Tigatto, Davao City <br>
            <strong>BSIT Student @ University of Mindanao</strong>
        </p>
    </div>

    <hr style="border: 0; border-top: 1px solid #eee;">

    <div class="section">
        <h2>About Me</h2>
        <p class="about-text">
            WASUPP GUYSS, I AM RYAN AND YOU CAN CALL ME NINONG RY! 🎸<br>
            I’m a happy and easygoing person who believes in being kind and respectful, a true gentleman at heart. 
            I enjoy having fun, playing games, and spending time doing things that make me smile.<br><br>
            One important part of my life is the church. I actively serve by playing the guitar, 
            and music is one of the ways I express my faith and gratitude.
        </p>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3 style="margin-top:0">My Hobbies</h3>
            <ul>
                <li>Playing Online games</li>
                <li>Singing</li>
                <li>Playing guitar</li>
                <li>Listening to music</li>
            </ul>
        </div>
        <div class="info-card">
            <h3 style="margin-top:0">Daily Routine</h3>
            <ol>
                <li>Wake up & Shower</li>
                <li>Household Chores</li>
                <li>Power Nap</li>
                <li>Time with Girlfriend ❤️</li>
                <li>Gaming & Music</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <h2>Technical Skills</h2>
        <?php
        $res = $conn->query("SELECT * FROM Skills_Tbl");
        while($row = $res->fetch_assoc()) {
            echo "<div class='skill-item'>";
            echo "<span><strong>" . htmlspecialchars($row['Skill_Name']) . "</strong></span>";
            echo "<span style='color:#2563eb'>" . $row['Skill_Level'] . "%</span>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Experience</h2>
        <?php
        $res = $conn->query("SELECT * FROM Experience_Tbl ORDER BY Exp_ID DESC");
        while($row = $res->fetch_assoc()) {
            echo "<div class='exp-item'>";
            echo "<span style='min-width:100px; font-weight:bold; color:#64748b;'>" . htmlspecialchars($row['Exp_Year']) . "</span>";
            echo "<span>" . htmlspecialchars($row['Exp_Activity']) . "</span>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Featured Projects</h2>
        <?php
        $res = $conn->query("SELECT * FROM Projects_Tbl ORDER BY Project_ID DESC");
        while($row = $res->fetch_assoc()) {
            echo "<div class='project-card'>";
            echo "<h3 style='margin:0 0 5px 0;'>" . htmlspecialchars($row['Project_Title']) . "</h3>";
            echo "<span style='font-size:0.8rem; color:#2563eb; font-weight:bold;'>" . htmlspecialchars($row['Project_Tech']) . "</span>";
            echo "<p style='font-size:0.95rem; color:#666;'>" . nl2br(htmlspecialchars($row['Project_Description'])) . "</p>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="quote-box">
        <p style="font-size: 1.2rem; margin: 0;">
            "Never give up on something that you can't go a day without thinking about."
        </p>
    </div>

    <div class="footer">
        <a href="contact.php" class="btn-contact">Contact Me</a>
    </div>
</div>

</body>
</html>