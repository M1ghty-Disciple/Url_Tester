<?php  
require_once 'Database.php';

// Start the session
session_start();



$username = $_POST['usr'];
$pwd = $_POST['pwd'];
// Validate input
if(!isset($username) || !isset($pwd)){
    // Redirect back to login with an error message
    header('Location: Index.php?error=Please enter both username and password');
    exit();
}



$query = 'SELECT *
          FROM users
          WHERE user_name = :username AND pwd = :pwd';

$statement = $db->prepare($query);
$statement->bindValue(':username', $username);
$statement->bindValue(':pwd', $pwd);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();

if ($user) {
    // User found, set session variables
    $_SESSION['username'] = $user['user_name'];
    $_SESSION['user_id'] = $user['user_id'];
    
    // Redirect to the main page or dashboard
    header('Location: main.php');
    exit();
} else {
    // Invalid credentials, redirect back to login with an error message
    header('Location: Index.php?error=Invalid credentials');
    exit();
}





?>