<?php
require_once "PHP/db_connection.php";
session_start();


if (!isset($_SESSION['user_email'])) {
    header("Location: Stu_login.php");
    exit();
}

if (isset($_POST['submit'])) {
    
    $email = $_SESSION['user_email'];
    
    
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    
    
    if (empty($newPassword)) {
        echo "<script>alert('New password cannot be empty');</script>";
        return;
    }

   
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    
    $query = "SELECT `Password` FROM `password` WHERE `email` = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($storedHash);
            $stmt->fetch();

           
            if (password_verify($oldPassword, $storedHash)) {
               
                $update = "UPDATE `password` SET `Password` = ? WHERE `email` = ?";
                $stmt1 = $conn->prepare($update);
                $stmt1->bind_param("ss", $hashedNewPassword, $email);

                if ($stmt1->execute()) {
                    echo "<script>alert('Password updated successfully.');</script>";
                    header("Location: Stu_interface.php");
                    exit();
                } else {
                    echo "<script>alert('Error updating password.');</script>";
                }

                $stmt1->close(); 
            } else {
                
                echo "<script>
                     alert('Incorrect old password.');
                    </script>";
            }
        } else {
            echo "<script>alert('No user found with this email.');</script>";
        }

        $stmt->close(); 
    } else {
        echo "Error preparing query: " . $conn->error;
    }
}

$conn->close(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/stu_interface.css">
    <link rel="stylesheet" href="css/student.css">


    <script>document.addEventListener("DOMContentLoaded", function() {

                const menuIcon = document.querySelector(".menuicn");
                const navContainer = document.querySelector(".navcontainer");
                

                menuIcon.addEventListener("click", function() {
                    navContainer.classList.toggle("navclose"); 
                });
            });

</script>




</head>
<body>
    <header>
        <div class="logosec">
            <div class="logo">Student Feedback Management System</div>
            <img src="img/menu-icon.png" class="menuicn" alt="Menu Icon">
        </div>

       

        <div class="user-section">
            <img src="img/user-icon.png" class="user-icon" alt="User Icon">
            <img src="img/notification-icon.png" class="notification-icon" alt="Notification Icon">
        </div>
    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option"><a href="Stu_resetPassword.php"> Reset Pasword</a></div>
                    <div class="nav-option"> <a href="Stu_interface.php">Dashboard</a></div>
                    <div class="nav-option"> <a href="Stu_login.php">Logout</a></div>
                    
                </div>
            </nav>
        </div>

        <div class="main">

        <form action="Stu_resetPassword.php" method="post" class="Stu_login">
    <label for="password">Old Password</label>
    <input type="password" name="old_password" id="password" placeholder="Old Password" required>
    
    <label for="new_password">New Password</label>
    <input type="password" name="new_password" id="new_password" placeholder="New Password" required>

    <div id="new_pw"></div> 

    <button type="submit" name="submit">Reset Password</button>
</form>


            
             
        </div>
        


    
</body>
</html>


