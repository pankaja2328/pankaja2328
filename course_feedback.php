<?php
require_once "PHP/db_connection.php";
session_start();
if (isset($_SESSION['user_email'])&& isset($_GET['name'])&&isset($_GET['code'])) {

    $email = $_COOKIE['user_email'];
    $course = $_GET['name'];
    $code = $_GET['code'];

}elseif(isset($_POST['submit'])){

    $code = $_POST['code'];
    $email = $_POST['email'];

    $checkQuery = "SELECT * FROM `course_feedback` WHERE `course_id` = ? AND `student_email` = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $code, $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        echo "<script>alert('Feedback already submitted for this Course.');</script>";
        echo "<script>window.location.href = 'Stu_interface.php';</script>"; 
        $stmt->close();
        $conn->close();
        exit;
    }

    
   
    $course = $_POST['name'];
    
    $q13 = $_POST['13'];
    $q14 = $_POST['14'];
    $q15 = $_POST['15'];
    $q16 = $_POST['16'];
    $q17 = $_POST['17'];
    $q18 = $_POST['18'];
    $q19 = $_POST['19'];
    $q20 = $_POST['20'];
    $q21 = $_POST['21'];
    $q22 = $_POST['22'];
    $q23 = $_POST['23'];
    $q24 = $_POST['24'];
    $q25 = $_POST['25'];
    $q26 = $_POST['26'];
    $q27 = $_POST['27'];
    $comment = $_POST['comments'];
    
    $query = "INSERT INTO `course_feedback`
            (`course_id`, `student_email`, `q13`, `q14`, `q15`, `q16`, `q17`, `q18`, `q19`, `q20`, `q21`, `q22`, `q23`, `q24`, `q25`, `q26`, `q27`, `comments`, `submitted_at`)
              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW());";

    $stmt = $conn->prepare($query) ;
    $stmt->bind_param("ssssssssssssssssss", $code, $email, $q13, $q14, $q15, $q16, $q17, $q18, $q19, $q20, $q21, $q22, $q23, $q24, $q25, $q26, $q27, $comment);

    if($stmt->execute()){
        
        header("Location: Stu_interface.php");

    }
    else{
        echo "Error Occurd";
    }
    $conn->close();
    $stmt->close();


}else{
    header("Location: Stu_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Evaluation</title>
    <link rel="stylesheet" href="CSS/feedback.css">
</head>
<body>
    <div class="container">
        <h1>Course Evaluation :  <?php echo $course ?></h1>
        <p>This questionnaire intends to collect feedback from the students about the course unit. Your valuable feedback will be vital for us to strengthen the teaching-learning environment to achieve excellence in teaching and learning.</p>
        <form action="course_feedback.php" method="post">
            <div class="section">
                <h2>General</h2>
                <label for="knowledge">This course helped me to enhance my knowledge:</label>
                <input type="radio" name="13" value="-2"> Strongly Disagree
                <input type="radio" name="13" value="-1"> Disagree
                <input type="radio" name="13" value="0"> Not Sure
                <input type="radio" name="13" value="+1"> Agree
                <input type="radio" name="13" value="+2"> Strongly Agree

                <label for="workload">The workload of the course was manageable:</label>
                <input type="radio" name="14" value="-2"> Strongly Disagree
                <input type="radio" name="14" value="-1"> Disagree
                <input type="radio" name="14" value="0"> Not Sure
                <input type="radio" name="14" value="+1"> Agree
                <input type="radio" name="14" value="+2"> Strongly Agree

                <label for="interest">The course was interesting:</label>
                <input type="radio" name="15" value="-2"> Strongly Disagree
                <input type="radio" name="15" value="-1"> Disagree
                <input type="radio" name="15" value="0"> Not Sure
                <input type="radio" name="15" value="+1"> Agree
                <input type="radio" name="15" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>Materials</h2>
                <label for="handouts">Adequate materials (handouts) were provided:</label>
                <input type="radio" name="16" value="-2"> Strongly Disagree
                <input type="radio" name="16" value="-1"> Disagree
                <input type="radio" name="16" value="0"> Not Sure
                <input type="radio" name="16" value="+1"> Agree
                <input type="radio" name="16" value="+2"> Strongly Agree

                <label for="handouts-understand">Handouts were easy to understand:</label>
                <input type="radio" name="17" value="-2"> Strongly Disagree
                <input type="radio" name="17" value="-1"> Disagree
                <input type="radio" name="17" value="0"> Not Sure
                <input type="radio" name="17" value="+1"> Agree
                <input type="radio" name="17" value="+2"> Strongly Agree

                <label for="reference-books">Enough reference books were used:</label>
                <input type="radio" name="18" value="-2"> Strongly Disagree
                <input type="radio" name="18" value="-1"> Disagree
                <input type="radio" name="18" value="0"> Not Sure
                <input type="radio" name="18" value="+1"> Agree
                <input type="radio" name="18" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>Tutorials / Examples</h2>
                <label for="examples">Given problems (examples/tutorials/exercises) were enough:</label>
                <input type="radio" name="19" value="-2"> Strongly Disagree
                <input type="radio" name="19" value="-1"> Disagree
                <input type="radio" name="19" value="0"> Not Sure
                <input type="radio" name="19" value="+1"> Agree
                <input type="radio" name="19" value="+2"> Strongly Agree

                <label for="examples-challenging">Given problems were challenging:</label>
                <input type="radio" name="20" value="-2"> Strongly Disagree
                <input type="radio" name="20" value="-1"> Disagree
                <input type="radio" name="20" value="0"> Not Sure
                <input type="radio" name="20" value="+1"> Agree
                <input type="radio" name="20" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>Lab / Fieldwork</h2>
                <label for="lab-relation">I could relate what I learnt from lectures to lab/field classes:</label>
                <input type="radio" name="21" value="-2"> Strongly Disagree
                <input type="radio" name="21" value="-1"> Disagree
                <input type="radio" name="21" value="0"> Not Sure
                <input type="radio" name="21" value="+1"> Agree
                <input type="radio" name="21" value="+2"> Strongly Agree

                <label for="lab-improvement">Labs & Fieldwork helped to improve my skills and practical knowledge:</label>
                <input type="radio" name="22" value="-2"> Strongly Disagree
                <input type="radio" name="22" value="-1"> Disagree
                <input type="radio" name="22" value="0"> Not Sure
                <input type="radio" name="22" value="+1"> Agree
                <input type="radio" name="22" value="+2"> Strongly Agree

                <label for="conduct-lab">I can conduct experiments/fieldwork myself through set of instructions in future:</label>
                <input type="radio" name="23" value="-2"> Strongly Disagree
                <input type="radio" name="23" value="-1"> Disagree
                <input type="radio" name="23" value="0"> Not Sure
                <input type="radio" name="23" value="+1"> Agree
                <input type="radio" name="23" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>About Myself</h2>
                <label for="prepared">I prepared thoroughly for each class:</label>
                <input type="radio" name="24" value="-2"> Strongly Disagree
                <input type="radio" name="24" value="-1"> Disagree
                <input type="radio" name="24" value="0"> Not Sure
                <input type="radio" name="24" value="+1"> Agree
                <input type="radio" name="24" value="+2"> Strongly Agree

                <label for="attendance">I attended lectures, lab/fieldwork regularly:</label>
                <input type="radio" name="25" value="-2"> Strongly Disagree
                <input type="radio" name="25" value="-1"> Disagree
                <input type="radio" name="25" value="0"> Not Sure
                <input type="radio" name="25" value="+1"> Agree
                <input type="radio" name="25" value="+2"> Strongly Agree

                <label for="assigned-work">I did all assigned work (homework/assignments/lab & field report) on time:</label>
                <input type="radio" name="26" value="-2"> Strongly Disagree
                <input type="radio" name="26" value="-1"> Disagree
                <input type="radio" name="26" value="0"> Not Sure
                <input type="radio" name="26" value="+1"> Agree
                <input type="radio" name="26" value="+2"> Strongly Agree

                <label for="recommended-textbooks">I referred recommended textbooks regularly:</label>
                <input type="radio" name="27" value="-2"> Strongly Disagree
                <input type="radio" name="27" value="-1"> Disagree
                <input type="radio" name="27" value="0"> Not Sure
                <input type="radio" name="27" value="+1"> Agree
                <input type="radio" name="27" value="+2"> Strongly Agree
            </div>

            <div class="section comments">
                <label for="comments">Any other comments:</label>
                <textarea name="comments" id="comments" rows="4"></textarea>

            </div>
            <input type="hidden" name="code" value="<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($course, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">



            <button name="submit" type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

