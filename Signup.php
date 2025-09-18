<?php
include 'db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Note: In a real app, you must hash this password.
    $email = $_POST['email'];

    // Check if the username already exists
    $sql_check = "SELECT username FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $message = "<p style='color:red;'>Username already exists.</p>";
    } else {
        // In a real app, use password_hash() for security
        $password_hash = $password; 

        $sql_insert = "INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $username, $password_hash, $email);

        if ($stmt_insert->execute()) {
            $message = "<p style='color:green;'>Account created successfully! You can now log in.</p>";
        } else {
            $message = "<p style='color:red;'>Error: " . $stmt_insert->error . "</p>";
        }
        $stmt_insert->close();
    }
    $stmt_check->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .signup-container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .signup-container h1 {
            margin-bottom: 30px;
            color: #333;
        }
        .signup-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .signup-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .signup-container button {
            width: 100%;
            padding: 12px;
            background-color: #0d1b38;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-link {
            margin-top: 20px;
        }
    </style>
</head>
<body style="background-color: #f0f2f5;">
    <div class="signup-container">
        <h1>Create an Account</h1>
        <?php echo $message; ?>
        <form action="signup.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <button type="submit">Sign Up</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Log In</a></p>
        </div>
    </div>
</body>
</html>
