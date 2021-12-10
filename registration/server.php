<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'charity_users');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $mobile = mysqli_real_escape_string($db, $_POST['mobile']);

  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($mobile)) { array_push($errors, "Mobile is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password,mobile) 
  			  VALUES('$username', '$email', '$password','$mobile')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ... 

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}
// CHARITY POST
if (isset($_POST['submitcase'])) {
  // receive all input values from the form
  $casename = mysqli_real_escape_string($db, $_POST['casename']);
  $caselocation = mysqli_real_escape_string($db, $_POST['caselocation']);
  $casedescription = mysqli_real_escape_string($db, $_POST['casedescription']);
  $casemobile = mysqli_real_escape_string($db, $_POST['casemobile']);
  $caseuser=$_SESSION['username'];
  // $caseimg = mysqli_real_escape_string($db, $_POST['caseimg']);
 if (isset($_SESSION['username'])){
     $caseuser=$_SESSION['username'];
 }
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($casename)) { array_push($errors, "casename is required"); }
  if (empty($caselocation)) { array_push($errors, "caselocation is required"); }
  if (empty($casedescription)) { array_push($errors, "casedescription is required"); }
  if (empty($casemobile)) { array_push($errors, "casemobile is required"); }
  
  // if (empty($caseimg)) { array_push($errors, "caseimg is required"); }

   if (count($errors) == 0) {

  	$query = "INSERT INTO posts (casename, caselocation, casedescription,casemobile,caseuser) 
  			  VALUES('$casename', '$caselocation', '$casedescription','$casemobile','$caseuser')";
  	mysqli_query($db, $query);

  }


}
?>