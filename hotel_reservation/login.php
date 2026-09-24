<?php

session_start();

include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ? AND password = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $_SESSION['admin'] = $username;

        header("Location: admin_dashboard.php");
        exit();

    } else {

        $error = "Invalid username or password.";

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Grand Stay</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .login-page {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f6f1;
            padding: 50px 20px;
        }

        .login-box {
            width: 420px;
            background: white;
            padding: 45px;
            border-radius: 12px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.10);
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h1 {
            color: #17251f;
            margin-bottom: 10px;
        }

        .login-title p {
            color: #777;
        }

        .login-group {
            margin-bottom: 20px;
        }

        .login-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .login-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
        }

        .login-group input:focus {
            outline: none;
            border-color: #b08a45;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 5px;
            background: #17251f;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #b08a45;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-note {
            text-align: center;
            margin-top: 20px;
            color: #777;
            font-size: 13px;
        }

        @media (max-width: 500px) {

            .login-box {
                width: 100%;
                padding: 30px;
            }

        }

    </style>

</head>


<body>

<nav class="navbar">

    <div class="logo">GRAND STAY</div>

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="rooms.php">Rooms</a>

        <a href="reservation.php">Reservation</a>

        <a href="login.php">Admin</a>

    </div>

</nav>


<section class="login-page">

    <div class="login-box">

        <div class="login-title">

            <p class="small-title">ADMIN PANEL</p>

            <h1>Admin Login</h1>

            <p>Login to manage hotel reservations.</p>

        </div>


        <?php if ($error != "") { ?>

            <div class="error-message">

                <?php echo $error; ?>

            </div>

        <?php } ?>


        <form method="POST">

            <div class="login-group">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter username"
                    required
                >

            </div>


            <div class="login-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

            </div>


            <button type="submit" class="login-btn">

                Login

            </button>

        </form>


        <div class="login-note">

            Admin access only

        </div>

    </div>

</section>


<footer>

    <h3>GRAND STAY HOTEL</h3>

    <p>Comfort • Service • Hospitality</p>

    <p>© 2026 Grand Stay Hotel. All Rights Reserved.</p>

</footer>

</body>

</html>