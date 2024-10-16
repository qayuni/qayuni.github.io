<?php
    session_start();

    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        header("Location: DATA.php");
        exit;
    }

    // Definisikan kredensial admin
    $admin_username = "admin"; 
    $admin_password = "2309106001"; 

    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if ($username === $admin_username && $password === $admin_password) {
            // Set session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: DATA.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            font-family: Saira,Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: rgb(230, 67, 67);
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color : white;
        }
        .login-container h2 {
            margin-bottom: 15px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border-radius : 15px;
            background-color : brown;
            border-color : white;
            color : white;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: white;
            color: brown;
            border: none;
            cursor: pointer;
            border-radius : 8px;
            margin-top : 8px;
        }
        .login-container button:hover {
            background-color: brown;
            color : white;
        }
        .error {
            color: black;
            margin-bottom: 10px;
        }
        .home{
            padding : 5px;
            border-radius : 8px;
            background-color : brown;
            text-decoration : none;
        }

        .home:hover {
            background-color : white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required autofocus>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button><br><br>
            <a href="index.html" class="home">🏠</a>
        </form>
    </div>
</body>
</html>
