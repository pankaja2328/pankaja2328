<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register</title>
    <link rel="stylesheet" href="CSS/student.css">
    <script src="JS/confirm_pw.js"></script>

</head>
<body>
    <header>Student Feedback Management System</header>

    
    <form action="Stu_register.php" method="post" class="Stu_login" onsubmit="return matchPassword()">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Example@email.com" required>
    
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
    
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" placeholder="Confirm Password" required>
    
        <p>Already a Member? <a href="Stu_login.php">Login</a></p>

        
        <div id="mismached_pw"></div> 

       
        <button type="submit" name="submit">Register</button>
    </form>
   
</body>
</html>
<?php
require_once "PHP/db_connection.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $confirmation = 0;
    $role = "student";


    $checkQuery = "SELECT * FROM `password` WHERE `email` = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
       
        echo "<script>document.getElementById('mismached_pw').innerHTML = \"<p style='color: red;'>An account with this email already exists. Please log in or use a different email.</p> \";</script>";
       // echo "<script> alert('An account with this email already exists. Please log in or use a different email.');</script>";
       // echo "<script>window.location.href = 'Stu_login.php';</script>";
    } else {
        
        $registerQuery = "INSERT INTO `password`(`email`, `Password`, `confrimation`, `role`) VALUES (?,?,?,?)";
        $registerStmt = $conn->prepare($registerQuery);
        $registerStmt->bind_param("ssis", $email, $hashedPassword, $confirmation, $role);

        if ($registerStmt->execute()) {
            echo "<script> alert('Your request was sent to the MA successfully. Please wait for their confirmation.');</script>";
            echo "<script>window.location.href = 'Stu_login.php';</script>";
        } else {
            echo "<script> alert('There was an error registering your account. Please try again later.');</script>";
        }

        $registerStmt->close(); 
    }

    $checkStmt->close(); 
}

$conn->close(); 
?>
