<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Retrieve the form data
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];

// Perform form validation
if (empty($name) || empty($email) || empty($mobile)) {
    echo "All fields are required.";
    exit;
}

// Database connection details
$host = 'localhost';
$db = 'user_management';
$user = 'root';
$password = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO users (name, email, mobile, verified, verification_code) VALUES (?, ?, ?, false, ?)");

    // Generate a random verification code/token
    $verificationCode = uniqid();

    // Bind the parameters
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $mobile);
    $stmt->bindParam(4, $verificationCode);

    // Execute the query
    $stmt->execute();

    echo "User added successfully!";
    
    // Prepare the update query
    $updateQuery = "UPDATE users SET verification_code = :code WHERE email = :email";

    // Bind the parameters
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':code', $verificationCode);
    $stmt->bindParam(':email', $email);

    // Execute the query
    $stmt->execute();
    
    
    // Load the PHPMailer autoloader
    require 'C:\wamp64\www\user-management\phpmailer\vendor\phpmailer\phpmailer\src\Exception.php';
    require 'C:\wamp64\www\user-management\phpmailer\vendor\phpmailer\phpmailer\src\PHPMailer.php';
    require 'C:\wamp64\www\user-management\phpmailer\vendor\phpmailer\phpmailer\src\SMTP.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer();
    
    // Set the SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'elan.ajith@gmail.com'; // Replace with your email address
    $mail->Password = 'pfozrntnnpcoshdw'; // Replace with your email password
    $mail->SMTPSecure = 'tls'; // Set the encryption type (tls or ssl)
    $mail->Port = 587; // Set the SMTP port number
    
    // Set the email content
    $mail->setFrom('elan.ajith@gmail.com');
    $mail->addAddress('elan.ajith@gmail.com'); // Replace with the user's email address
    $mail->Subject ='Email Verification'; 
    $mail->Body ='Please click the following link to verify your email: http://example.com/verify.php?code='. $verificationCode;
    
    
     // Enable SMTP debugging
    // $mail->SMTPDebug = 2;

    // Send the email
    if ($mail->send()) {
        echo 'Verification email sent!';
    } else {
        echo 'Error sending the verification email: ' . $mail->ErrorInfo;
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
