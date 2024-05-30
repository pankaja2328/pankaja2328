<?php
require_once "PHP/db_connection.php";
session_start();
if (isset($_SESSION['user_email']) && $_COOKIE['user_role']=="student") {
    $userMail = $_SESSION['user_email']; 
    $query = "SELECT 
                    user_name, 
                    Acedemic_year, 
                    Batch, 
                    id
                FROM 
                    student
                WHERE 
                    email = ?
            ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s",$userMail);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    $stmt->close();

    while ($row = $result->fetch_assoc()) {
       
        $uname = $row['user_name'] ;
        $ayer = $row['Acedemic_year'] ;
        $batch = $row['Batch'] ;
        $id = $row['id'];
    }

} else {
    echo "No cookie found for user_name.";
    header("Location: Stu_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/stu_interface.css">
    <script src="js/dashboard.js"></script>




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
            <h2>Welcome ! <?php echo $uname ?></h2>
            <table>
                <tr>
                    <td>Email</td>
                    <td id="email"> <?php echo $userMail; ?></td>
                </tr>
                <tr>
                    <td>Index Number </td>
                    <td id="index_number"> <?php echo $id; ?></td>
                </tr>
                <tr>
                    <td>Academic Year </td>
                    <td id="academic_year"> <?php echo $ayer; ?></td>
                </tr>
                <tr>
                    <td>Batch Number </td>
                    <td id="batch_number"> <?php echo $batch; ?></td>
                </tr>
                
            </table>
            <br>
            <div class="link-container">
                <a href="#edit" id= "edit_info" onclick = "edit_detail()">Edit</a>
            </div>

            <div class="Course_list">
           
                <div id="course-item">
                    
                    
                </div>
                
                
            </div>
        </div>

        
            
        </div>
        


    
</body>
</html>


