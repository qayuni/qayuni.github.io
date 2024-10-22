<?php
require"koneksi.php";

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if($password === $cpassword){
        $checkQuery = "SELECT * FROM users WHERE username = '$username'";
        $checkResult = mysqli_query($conn, $checkQuery);

        $password = password_hash($password, PASSWORD_DEFAULT);

        if(mysqli_num_rows($checkResult) > 0){
            echo"
            <script>
                alert('Username udah ada bre!');
                document.location.href = 'registrasi.php';
            </script>";
        } else {
            $query = "INSERT INTO users VALUES('$username', '$password')";

            if (mysqli_query($conn, $query)) {
                echo"
                <script>
                    alert('UDH REGIS ANGJAI!');
                    document.location.href = 'login.php';
                </script>";
            } else {
                echo"
                <script>
                    alert('GAGAL REGIS BJIR!');
                    document.location.href = 'registrasi.php';
                </script>";
            }
            
        }
    } else {
        echo"
        <script>
            alert('Password dan Konfirmasi password harus sesuai men!!');
            document.location.href = 'registrasi.php';
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
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

        .home{
            padding : 5px;
            border-radius : 8px;
            background-color : brown;
            text-decoration : none;
            margin-right : 10px
        }

        .picik{
            display : flex;
            align-items : center;

        }

        .home:hover {
            background-color : white;
        }

        .login{
            padding : 8px;
            border-radius : 8px;
            background-color : brown;
            text-decoration : none;
            margin-right : 10px;
            color : white;
            font-size : small;
            font-weight : 600;
        }

        .login:hover {
            background-color : white;
            color : brown;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>SIGN UP</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required autofocus>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required>
            <br>
            <button type="submit" name="submit">Sign Up</button><br><br>
            <div class="picik">
            <a href="index.html" class="home">🏠😺</a> 
            <a href="login.php"class="login">login</a>
            </div>
        </form>
    </div>
</body>
</html>
