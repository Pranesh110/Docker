
<?php

header("Content-Type: application/json");

require_once "db.php";

$action = $_GET["action"] ?? "";


// Add student
if ($action === "add" && $_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $reg_no = trim($data["reg_no"] ?? "");
    $name = trim($data["name"] ?? "");
    $age = filter_var($data["age"] ?? null, FILTER_VALIDATE_INT);
    $student_id = trim($data["student_id"] ?? "");

    if ($reg_no === "" || $name === "" || $age === false || $age <= 0 || $student_id === "") {

        http_response_code(400);

        echo json_encode([
            "message" => "Please provide valid student details"
        ]);

        exit;
    }

    $stmt = $conn->prepare(
        "INSERT INTO students (reg_no, name, age, student_id)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssis",
        $reg_no,
        $name,
        $age,
        $student_id
    );

    if ($stmt->execute()) {

        echo json_encode([
            "message" => "Student added successfully"
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "message" => "Unable to add student"
        ]);
    }

    $stmt->close();
}


// Fetch student
elseif ($action === "fetch" && $_SERVER["REQUEST_METHOD"] === "GET") {

    $reg_no = trim($_GET["reg_no"] ?? "");

    if ($reg_no === "") {

        http_response_code(400);

        echo json_encode([
            "message" => "Registration number is required"
        ]);

        exit;
    }

    $stmt = $conn->prepare(
        "SELECT reg_no, name, age, student_id
         FROM students
         WHERE reg_no = ?"
    );

    $stmt->bind_param("s", $reg_no);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        echo json_encode($result->fetch_assoc());

    } else {

        http_response_code(404);

        echo json_encode([
            "message" => "Student not found"
        ]);
    }

    $stmt->close();
}


else {

    http_response_code(400);

    echo json_encode([
        "message" => "Invalid action"
    ]);
}


$conn->close();

?>
