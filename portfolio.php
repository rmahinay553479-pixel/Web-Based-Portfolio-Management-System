<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$conn->select_db($dbname);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rey Ryan | Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-glow: rgba(59, 130, 246, 0.5);
            --dark-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-main: #f1f5f9;
            --text-dim: #94a3b8;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            scroll-behavior: smooth;
        }

        /* Modern Navbar */
        .navbar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            padding: 20px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .navbar a {
            text-decoration: none;
            color: var(--text-dim);
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .navbar a:hover { color: var(--primary); text-shadow: 0 0 10px var(--primary-glow); }

        .logout-btn {
            color: #f87171 !important;
            border: 1px solid rgba(248, 113, 113, 0.3);
            padding: 5px 15px;
            border-radius: 8px;
        }

        .container {
            max-width: 1000px;
            margin: 120px auto 50px;
            padding: 0 20px;
        }

        .section-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 50px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        h2 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 30px;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* Project Grid & Coming Soon Styles */
        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .p-card {
            background: rgba(15, 23, 42, 0.5);
            padding: 30px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s ease;
        }

        .placeholder-card {
            grid-column: 1 / -1;
            text-align: center;
            border: 2px dashed rgba(59, 130, 246, 0.3);
            padding: 60px 20px;
            background: rgba(59, 130, 246, 0.02);
        }

        .progress-container {
            width: 100%;
            max-width: 300px;
            background: rgba(255,255,255,0.1);
            height: 8px;
            border-radius: 10px;
            margin: 20px auto;
            overflow: hidden;
        }

        .progress-bar {
            width: 75%; /* Pwedeng baguhin to */
            height: 100%;
            background: var(--primary);
            box-shadow: 0 0 15px var(--primary);
            border-radius: 10px;
        }

        .tech-badge {
            font-size: 10px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .gallery-grid img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 20px;
            filter: grayscale(30%);
            transition: 0.5s;
            border: 2px solid rgba(255, 255, 255, 0.05);
        }

        .gallery-grid img:hover {
            filter: grayscale(0%);
            transform: scale(1.03);
            border-color: var(--primary);
        }

        /* Contact Box */
        .contact-box {
            text-align: center;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 60px;
            border-radius: 32px;
            border: 1px solid var(--primary);
        }

        .contact-btn {
            background: var(--primary);
            color: white;
            padding: 18px 50px;
            text-decoration: none;
            border-radius: 15px;
            display: inline-block;
            margin-top: 25px;
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .gallery-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="#about">About</a>
    <a href="#projects">Projects</a>
    <a href="#gallery">Gallery</a>
    <a href="login.php" class="logout-btn">Logout</a>
</nav>

<div class="container">

    <section id="about" class="section-card">
        <h2>About Me</h2>
        <p style="font-size: 1.2rem; color: var(--text-dim); margin-bottom: 20px;">
            WASUPP GUYSS, I AM RYAN (NINONG RY)! 🎸<br>
            I'm a happy-go-lucky person, a gentleman, and a guitar player serving the church. Currently taking BSIT at University of Mindanao.
        </p>
    </section>

    <section id="projects" class="section-card">
        <h2>Featured Work</h2>
        <div class="project-grid">
            <?php
            $res = $conn->query("SELECT * FROM Projects_Tbl ORDER BY Project_ID DESC");
            
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo '<div class="p-card">
                            <span class="tech-badge">'.htmlspecialchars($row['Project_Tech']).'</span>
                            <h3 style="margin: 20px 0 12px 0; color: #fff;">'.htmlspecialchars($row['Project_Title']).'</h3>
                            <p style="font-size: 0.95rem; color: var(--text-dim);">'.nl2br(htmlspecialchars($row['Project_Description'])).'</p>
                          </div>';
                }
            } else {
                // ETO YUNG "NOT YET DONE" STATE
                echo '<div class="p-card placeholder-card">
                        <div style="font-size: 3.5rem; margin-bottom: 10px;">🚧</div>
                        <h3 style="color: #fff; font-size: 1.8rem; margin-bottom: 5px;">Project Under Construction</h3>
                        <p style="color: var(--text-dim); max-width: 450px; margin: 0 auto;">
                            I\'m currently brewing some awesome PHP and Web Development projects. 
                            The database is still empty, but something big is coming soon!
                        </p>
                        <div class="progress-container">
                            <div class="progress-bar"></div>
                        </div>
                        <span class="tech-badge">Current Status: 75% Coding...</span>
                      </div>';
            }
            ?>
        </div>
    </section>

    <section id="gallery" class="section-card">
        <h2>Visual Gallery</h2>
        <div class="gallery-grid">
            <img src="ddd.jpeg" alt="Gallery 1" onerror="this.src='https://via.placeholder.com/400x300/1e293b/fff?text=Photo+1'">
            <img src="eee.jpeg" alt="Gallery 2" onerror="this.src='https://via.placeholder.com/400x300/1e293b/fff?text=Photo+2'">
            <img src="rrr.jpeg" alt="Gallery 3" onerror="this.src='https://via.placeholder.com/400x300/1e293b/fff?text=Photo+3'">
        </div>
    </section>

    <section id="contact" class="contact-box">
        <h2 style="background: none; -webkit-text-fill-color: #fff;">Let's Jam Together!</h2>
        <p style="color: var(--text-dim);">Gusto mo ba akong maka-trabaho o maka-jamming sa gitara?</p>
        <a href="contact.php" class="contact-btn">Contact Me</a>
    </section>

</div>

</body>
</html>