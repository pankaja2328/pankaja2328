<?php
require_once "PHP/db_connection.php";
session_start();
if (isset($_SESSION['user_email']) && isset($_GET['code'])) {
    $email = $_COOKIE['user_email'];
    $code = $_GET['code'];
    
    $selectQuery = "SELECT `id`, `name` FROM `lecturer` WHERE `course` = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {  
        $lecturerName = $row['name'];
        $lectureId = $row['id'];
    } else {
        echo "<script> alert('Error: No lecturer found for the given course code.');</script>";
        echo "<script>window.location.href = 'Stu_interface.php';</script>";
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
}elseif (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $lectureId = $_POST['lectureId'];
    $code = $_POST['code'];

    // Check if the record already exists
    $checkQuery = "SELECT * FROM `lecture_feedback` WHERE `lecture_id` = ? AND `student_email` = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $lectureId, $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        echo "<script>alert('Feedback already submitted for this lecture.');</script>";
        echo "<script>window.location.href = 'Stu_interface.php';</script>"; 
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();  

    $q1 = isset($_POST['1']) ? $_POST['1'] : '';
    $q2 = isset($_POST['2']) ? $_POST['2'] : '';
    $q3 = isset($_POST['3']) ? $_POST['3'] : '';
    $q4 = isset($_POST['4']) ? $_POST['4'] : '';
    $q5 = isset($_POST['5']) ? $_POST['5'] : '';
    $q6 = isset($_POST['6']) ? $_POST['6'] : '';
    $q7 = isset($_POST['7']) ? $_POST['7'] : '';
    $q8 = isset($_POST['8']) ? $_POST['8'] : '';
    $q9 = isset($_POST['9']) ? $_POST['9'] : '';
    $q10 = isset($_POST['10']) ? $_POST['10'] : '';
    $q11 = isset($_POST['11']) ? $_POST['11'] : '';
    $q12 = isset($_POST['12']) ? $_POST['12'] : '';
    $comment = $_POST['comments'];

    $insertQuery = "INSERT INTO `lecture_feedback` (`lecture_id`, `student_email`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `q12`, `comments`, `submitted_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW());";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param(
        "sssssssssssssss",
        $lectureId,
        $email,
        $q1,
        $q2,
        $q3,
        $q4,
        $q5,
        $q6,
        $q7,
        $q8,
        $q9,
        $q10,
        $q11,
        $q12,
        $comment
    );

    if ($stmt->execute()) {
        header("Location: Stu_interface.php");
        exit;
    } else {
        error_log("Failed to execute query: " . $stmt->error);
        echo "An error occurred. Please try again later.";
    }

    $stmt->close();
    $conn->close();  
} else {
    header("Location: Stu_login.php");
    exit;  
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Evaluation</title>
    <link rel="stylesheet" href="CSS/feedback.css">
</head>
<body>
    <div class="container">
        <h1>Teacher Evaluation : <?php echo $lecturerName ?></h1>
        <p>This questionnaire collects feedback about the lecturer from students. Your feedback helps improve the teaching-learning environment and achieve excellence in teaching and learning.</p>
        <form action="lecture_feedback.php" method="post">
            <div class="section">
                <h2>Time Management</h2>
                <label for="start-end-time">Lectures/ Labs/ Fieldworks started and finished on time:</label>
                <input type="radio" name="1" value="-2"> Strongly Disagree
                <input type="radio" name="1" value="-1"> Disagree
                <input type="radio" name="1" value="0"> Not Sure
                <input type="radio" name="1" value="+1"> Agree
                <input type="radio" name="1" value="+2"> Strongly Agree

                <label for="class-time">The lecturer managed class time effectively:</label>
                <input type="radio" name="2" value="-2"> Strongly Disagree
                <input type="radio" name="2" value="-1"> Disagree
                <input type="radio" name="2" value="0"> Not Sure
                <input type="radio" name="2" value="+1"> Agree
                <input type="radio" name="2" value="+2"> Strongly Agree

                <label for="consultation">The lecturer was readily available for consultation with students:</label>
                <input type="radio" name="3" value="-2"> Strongly Disagree
                <input type="radio" name="3" value="-1"> Disagree
                <input type="radio" name="3" value="0"> Not Sure
                <input type="radio" name="3" value="+1"> Agree
                <input type="radio" name="3" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>Delivery Method</h2>
                <label for="teaching-aids">Use of teaching aids (multimedia, whiteboard):</label>
                <input type="radio" name="4" value="-2"> Strongly Disagree
                <input type="radio" name="4" value="-1"> Disagree
                <input type="radio" name="4" value="0"> Not Sure
                <input type="radio" name="4" value="+1"> Agree
                <input type="radio" name="4" value="+2"> Strongly Agree

                <label for="lecture-understanding">Lectures were easy to understand:</label>
                <input type="radio" name="5" value="-2"> Strongly Disagree
                <input type="radio" name="5" value="-1"> Disagree
                <input type="radio" name="5" value="0"> Not Sure
                <input type="radio" name="5" value="+1"> Agree
                <input type="radio" name="5" value="+2"> Strongly Agree

                <label for="participation">The lecturer encouraged students to participate in discussions:</label>
                <input type="radio" name="6" value="-2"> Strongly Disagree
                <input type="radio" name="6" value="-1"> Disagree
                <input type="radio" name="6" value="0"> Not Sure
                <input type="radio" name="6" value="+1"> Agree
                <input type="radio" name="6" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>Subject Command</h2>
                <label for="syllabi-focus">The lecturer focused on the syllabi:</label>
                <input type="radio" name="7" value="-2"> Strongly Disagree
                <input type="radio" name="7" value="-1"> Disagree
                <input type="radio" name="7" value="0"> Not Sure
                <input type="radio" name="7" value="+1"> Agree
                <input type="radio" name="7" value="+2"> Strongly Agree

                <label for="self-confidence">The lecturer was self-confident in subject and teaching:</label>
                <input type="radio" name="8" value="-2"> Strongly Disagree
                <input type="radio" name="8" value="-1"> Disagree
                <input type="radio" name="8" value="0"> Not Sure
                <input type="radio" name="8" value="+1"> Agree
                <input type="radio" name="8" value="+2"> Strongly Agree

                <label for="real-world">The lecturer linked real-world applications, creating interest in the subject:</label>
                <input type="radio" name="9" value="-2"> Strongly Disagree
                <input type="radio" name="9" value="-1"> Disagree
                <input type="radio" name="9" value="0"> Not Sure
                <input type="radio" name="9" value="+1"> Agree
                <input type="radio" name="9" value="+2"> Strongly Agree

                <label for="field-updates">The lecturer updated latest developments in the field:</label>
                <input type="radio" name="10" value="-2"> Strongly Disagree
                <input type="radio" name="10" value="-1"> Disagree
                <input type="radio" name="10" value="0"> Not Sure
                <input type="radio" name="10" value="+1"> Agree
                <input type="radio" name="10" value="+2"> Strongly Agree
            </div>

            <div class="section">
                <h2>About Myself</h2>
                <label for="ask-questions">I asked questions from the lecturer in the class:</label>
                <input type="radio" name="11" value="-2"> Strongly Disagree
                <input type="radio" name="11" value="-1"> Disagree
                <input type="radio" name="11" value="0"> Not Sure
                <input type="radio" name="11" value="+1"> Agree
                <input type="radio" name="11" value="+2"> Strongly Agree

                <label for="consult-after">I consulted with the lecturer after lecture hours:</label>
                <input type="radio" name="12" value="-2"> Strongly Disagree
                <input type="radio" name="12" value="-1"> Disagree
                <input type="radio" name="12" value="0"> Not Sure
                <input type="radio" name="12" value="+1"> Agree
                <input type="radio" name="12" value="+2"> Strongly Agree
            </div>

            <div class="section comments">
                <label for="comments">Any other comments:</label>
                <textarea name="comments" id="comments" rows="5"></textarea>
            </div>

            <input type="hidden" name="lectureId" value="<?php echo htmlspecialchars($lectureId, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="code" value="<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>">

            <button name = "submit" type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
