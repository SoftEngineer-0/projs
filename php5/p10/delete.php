<?php
$stat = 0;
$con = mysqli_connect("localhost", "root", "", "main");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"));
$email = $data->email;

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM users WHERE email = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);

if (mysqli_stmt_execute($stmt)) {
    // Deletion successful
    $stat = 1;
} else {
    // Deletion failed
    $stat = 0;
}

mysqli_stmt_close($stmt);
mysqli_close($con);

header('Content-Type: application/json');

// Send JSON response
echo json_encode(["stat" => $stat]);
?>
