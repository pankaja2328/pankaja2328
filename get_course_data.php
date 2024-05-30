<?php 

require_once "PHP/db_connection.php";

$mail = $_COOKIE['user_email'];

$query = "SELECT course.name, course.code
          FROM course
          JOIN student
          ON student.id = course.id
          WHERE student.email = '$mail'";

$result = $conn->query($query);

$course = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $course[] = [
            "Name" => $row['name'],
            "Code" => $row['code'],
        ];
    }
    $result->free();
} else {
    // Handle query error
    echo "Error: " . $conn->error;
}

echo json_encode($course);

$conn->close();

?>
