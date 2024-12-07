<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/login/images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/main.css">
    <style>
        body {
            background: url('assets/login/images/gb.jpeg') no-repeat center;
            background-size: contain; /* Adjust to 'contain' for full visibility */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 0 20px; /* Adjust margin for better spacing */
            position: relative; /* Allow for absolute positioning */
            z-index: 1; /* Bring the card above the background */
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .wrap-input100 {
            position: relative;
            margin-bottom: 20px;
        }

        .input100 {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .input100:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px #007BFF;
        }

        .input100::placeholder {
            color: #aaa;
        }

        .login100-form-btn {
            width: 100%;
            background: #007BFF;
            border-radius: 25px;
            padding: 15px;
            font-size: 16px;
            color: #fff;
            transition: background 0.3s ease;
            border: none;
        }

        .login100-form-btn:hover {
            background: #0056b3;
        }

        .alert {
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h2>Aplikasi Izzi Laundry</h2>
        <form class="login100-form validate-form" action="cek_login.php" method="post">
            <?php if (isset($_GET['message'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['message']; ?>
                </div>
            <?php endif ?>
            <div class="wrap-input100 validate-input" data-validate="Enter username">
                <input class="input100" type="text" name="username" placeholder="User name" required>
            </div>

            <div class="wrap-input100 validate-input" data-validate="Enter password">
                <input class="input100" type="password" name="password" placeholder="Password" required>
            </div>

            <button class="login100-form-btn" type="submit">
                Login
            </button>
        </form>
    </div>

    <script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
    <script src="assets/login/vendor/bootstrap/js/popper.js"></script>
    <script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/login/js/main.js"></script>

</body>

</html>
