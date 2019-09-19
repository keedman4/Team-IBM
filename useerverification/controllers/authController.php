<?php 

session_start();

require 'config/db.php';

$errors = array();
$username ="";
$email ="";

//if user clicks on the sign up button
if(isset($_POST['signup-btn'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];


	//validation
	if (empty($username)) {
		$errors['username'] = "username Required";
	}


	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Email address is invalid";
	}

	if (empty($email)) {
		$errors['email'] = "Email Required";
	}

	if (empty($password)) {
		$errors['password'] = "password Required";
	}

	if($password !== $passwordConf) {
		$errors['password'] = "The passwords do not match";
	}

$emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
//$password = password_hash(password, PASSWORD_DEFAULT);
$stmt = $conn->prepare($emailQuery);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$userCount = $result->num_rows;
$stmt->close();

if ($userCount > 0) { 
$errors['email'] = "Email already exists";
}

if (count($errors) === 0) {
	$token = bin2hex(random_bytes(50));
	$verified = false;

	$sql = "INSERT INTO users (`username`, `email`, `verified`, `token`, `password`) VALUES (?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ssbss', $username, $email, $verified, $token, $password);

	if ($stmt->execute()) {
		//login user
		$user_id =$conn->insert_id;
		$_SESSION['id'] = $user_id;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['verified'] = $verified;

		//flash message
		$_SESSION['message'] = "You are now logged in!";
		$_SESSION['alert-class'] = $alert-success;
		header('location: index.php');
		exit();
		} else {
			$errors['db_error'] = "Database error: failed to register";


}

}

}

//if user clicks login button
if(isset($_POST['login-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	


	//validation
	if (empty($username)) {
		$errors['username'] = "username Required";
	}
	if (empty($password)) {
		$errors['password'] = "password Required";
	}

	$sql = "SELECT * FROM users WHERE username=? ";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_assoc();

	if(password_verify($password, $user['password'])) {
		//login success
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['email'] = $user['email'];
		// $_SESSION['verified'] = $user['verified'];

		//flash message
		$_SESSION['message'] = "You are now logged in!";
		$_SESSION['alert-class'] = $alert-success;
		header('location: index.php');
		exit();


	} else{
		$errors['login_fail'] = "Wrong Credentials";
	} 


}
