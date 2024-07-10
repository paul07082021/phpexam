<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myexam";

$fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$mobileNumber = filter_input(INPUT_POST, 'mobileNumber', FILTER_SANITIZE_STRING);
$dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Invalid email format');
}

if (!preg_match("/^(09|\+639)\d{9}$/", $mobileNumber)) {
    exit('Invalid Philippine mobile number format');
}

$birthdate = new DateTime($dob);
$today = new DateTime('today');
$age = $birthdate->diff($today)->y;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // for the validation if email and phone number is already exist in database
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM tbl_users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['count'] > 0) {
        echo 'exists_email';
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM tbl_users WHERE mobileNumber = :mobileNumber");
    $stmt->bindParam(':mobileNumber', $mobileNumber);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['count'] > 0) {
        echo 'exists_mobile';
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO tbl_users (fullName, email, mobileNumber, date_of_birth, age, gender) 
                            VALUES (:fullName, :email, :mobileNumber, :dob, :age, :gender)");

    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobileNumber', $mobileNumber);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':gender', $gender);

    $stmt->execute();

    echo 'success';

} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

$conn = null;
?>
