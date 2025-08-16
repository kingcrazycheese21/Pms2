<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $file = fopen("users.csv", "a");
        fputcsv($file, [$username, password_hash($password, PASSWORD_DEFAULT)]);
        fclose($file);

        echo "<script>alert('Signup successful! You can now log in.');window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('All fields are required!');window.location.href='signup.html';</script>";
    }
}
?>