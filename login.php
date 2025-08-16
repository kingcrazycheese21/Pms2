<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (($file = fopen("users.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($file)) !== FALSE) {
            if ($data[0] === $username && password_verify($password, $data[1])) {
                $_SESSION['user'] = $username;
                fclose($file);
                header("Location: dashboard.php");
                exit;
            }
        }
        fclose($file);
    }
    
    echo "<script>alert('Invalid credentials!');window.location.href='index.html';</script>";
}
?>