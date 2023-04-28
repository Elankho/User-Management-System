<?php
// Database connection details
$host = 'localhost';
$db = 'user_management';
$user = 'root';
$password = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the verification code/token from the URL
    $verificationCode = isset($_GET['code']) ? $_GET['code'] : null;

    // Check if the verification code/token exists in the database
    if (!empty($verificationCode)) {
        $checkQuery = "SELECT * FROM users WHERE verification_code = :code";
        $stmt = $pdo->prepare($checkQuery);
        $stmt->bindParam(':code', $verificationCode);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Verification code/token exists, mark the user as verified in the database

            // Update the verified column to true
            $updateQuery = "UPDATE users SET verified = true WHERE verification_code = :code";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->bindParam(':code', $verificationCode);
            $stmt->execute();

            echo "User verified successfully!";
        } else {
            echo "Invalid verification code/token.";
        }
    } else {
        echo "Verification code/token is missing.";
    }

    // Fetch all user records
    $query = "SELECT * FROM users";
    $stmt = $pdo->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
