<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>

    <header>Student Feedback Management System</header>

    <form action="Stu_login.php" method="post" class = "Stu_login">
        <label >Email</label>
        <input type="email" name= "email" placeholder="Example@emai.com" required>
        <label >Password</label>
        <input type="password" name = "password" placeholder="Password" required>
        <p>No account <a href="Stu_register.php">Create One</a></p>
        <p id= "invalid_pw" style="color:red"></p>
        <button type="submit" name="submit">Login</button>
    </form>
    
</body>
</html>
<?php
require_once "PHP/db_connection.php";
session_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $query = "SELECT `Password`, `confrimation`,`role` FROM `password` WHERE `email` = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email); 
        $stmt->execute(); 
        $stmt->store_result(); 

        if ($stmt->num_rows > 0) { 
            $stmt->bind_result($storedHash,$confrimation,$role); 
            $stmt->fetch();

           
            if (password_verify($password, $storedHash)  && $confrimation==1 && $role=="student") {

                $_SESSION['user_email'] = $email;
                setcookie("user_email",$email,time()+3600,"/");
                setcookie("user_role", $role, time() + 3600, "/");
                header("Location: Stu_interface.php");
                
            }elseif (password_verify($password, $storedHash)  && $confrimation==1 && $role=="lecture") {
                $_SESSION['user_email'] = $email;
                setcookie("user_email",$email,time()+3600,"/");
                setcookie("user_role", $role, time() + 3600, "/");
                header("Location: Lecture/lec_interface.php");
            }
             else {
                echo "<script>
                        const r = document.getElementById('invalid_pw');
                        r.innerHTML = 'Invalid password. or It not confromd by MA';
                    </script>" ;
            }
        } else {
            echo "No user found with this email."; 
        }

        $stmt->close(); 
    } else {
        echo "Error preparing query: " . $conn->error; 
    }

    $conn->close(); 
} 
?>
