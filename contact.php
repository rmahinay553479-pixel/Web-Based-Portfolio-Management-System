<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get In Touch | Rey Ryan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --dark-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-main: #f1f5f9;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at bottom right, #1e293b, #0f172a);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text-main);
        }

        /* Floating Background Element */
        .bg-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--primary);
            filter: blur(120px);
            opacity: 0.15;
            z-index: -1;
        }

        .box {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .go-back {
            text-decoration: none;
            color: var(--text-dim);
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .go-back:hover {
            color: var(--primary);
            transform: translateX(-5px);
        }

        h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.desc {
            color: var(--text-dim);
            font-size: 0.95rem;
            margin: 10px 0 30px 0;
        }

        .input-field {
            margin-bottom: 20px;
        }

        input, textarea {
            width: 100%;
            padding: 15px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: var(--primary);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        button {
            margin-top: 10px;
            padding: 16px;
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        /* Success Alert Style */
        .alert {
            margin-top: 25px;
            padding: 15px;
            background: rgba(34, 197, 94, 0.1);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 12px;
            text-align: center;
            font-size: 0.9rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<div class="box">
    <a href="portfolio.php" class="go-back">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
        Back to Portfolio
    </a>

    <h2>Let's Talk</h2>
    <p class="desc">May project ka ba o jamming session? Send me a message!</p>

    <form method="POST">
        <div class="input-field">
            <input type="text" name="name" placeholder="Your Name" required>
        </div>
        <div class="input-field">
            <input type="email" name="email" placeholder="Your Email" required>
        </div>
        <div class="input-field">
            <textarea name="message" rows="4" placeholder="How can I help you?" required></textarea>
        </div>
        <button type="submit">Send Message</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        echo "<div class='alert'>
                <strong>Success!</strong> Salamat, $name. I'll get back to you soon! 🚀
              </div>";
    }
    ?>
</div>

</body>
</html>