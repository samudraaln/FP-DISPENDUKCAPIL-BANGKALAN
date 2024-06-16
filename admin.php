<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ektp"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = ? AND pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        header("Location: homeadmin.php");
        exit;
    } else {
        echo '<script>alert("Username atau Password salah!");</script>';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin DespendukCapil</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        body {
            background: url('asset/bgdashboard.jpg');
            background-size: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .dashboard {
            position: absolute;
            width: 100%;
            height: 50px;
            margin: 0;
            padding: 0;
            background-color: #ffee02;
            z-index: 2; 
        }

        h1 {
            color: #000000;
            font-size:20px;
            text-align: left;
            width: 100%; 
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            position: absolute;
            top: 0px;
            left: 15px;
        }

        form {
            height: 380px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
            z-index: 2; 
            color: #ffffff;
            font-family: 'Poppins', sans-serif; 
            letter-spacing: 0.5px; 
            text-align: center;
        }

        .container 

        h3 {
            font-size: 36px; 
            font-weight: 500; 
            margin-bottom: 30px; 
        }

        label {
            display: block;
            margin-top: 10px; 
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 95%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
            color: #ffffff; 
            outline: none; 
            border: none; 
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 20px;
            align-items: center;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            outline: none; 
        }

        #back-button {
            background-color: #ffee02;
            color: #000;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard">
            <h1> DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL BANGKALAN </h1>
        </div>
    <div class="overlay"></div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>Admin Login</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password" required>

        <button type="submit" name="login">Log In</button>
        <button type="button" id="back-button">Back</button>
    </form>

    <script>
        document.getElementById('back-button').onclick = function() {
            window.location.href = 'dashboard.html';
        }
    </script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$username' AND pass = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: "); 
        exit;
    } else {
        echo '<script>alert("Username atau Password salah!");</script>';
    }
}

$conn->close();
?>
