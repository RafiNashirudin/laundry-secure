<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_laundry");

if ($conn->connect_error) {
    die("Database connection failed");
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();

    if (password_verify($password, $data['password'])) {
        session_regenerate_id(true);
        $_SESSION['role'] = $data['role'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['outlet_id'] = $data['outlet_id'];

        if ($data['role'] == 'admin') {
            header('location:admin');
        } else if ($data['role'] == 'kasir') {
            header('location:kasir');
        } else if ($data['role'] == 'owner') {
            header('location:owner');
        }
    } else {
        $message = urlencode('Username atau password salah!!!');
        header('location:index.php?message=' . $message);
    }
} else {
    $message = urlencode('Username atau password salah!!!');
    header('location:index.php?message=' . $message);
}

$stmt->close();
$conn->close();
?>
