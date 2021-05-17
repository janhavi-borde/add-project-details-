<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'driverSchool');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}



if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}


if (isset($_POST['login_btn'])) {
	login();
}


if(isset($_POST['check'])){
	global $db, $username, $errors;
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($db, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE code = $otp_code";
        $code_res = mysqli_query($db, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE users SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_res = mysqli_query($db, $update_otp);
            if($update_res){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header('location: index.php');
                exit();
            }else{
                array_push($errors, "Failed while updating code!");
            }
        }else{
            array_push($errors,"You've entered incorrect code!");
        }
    }



 //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
    	global $db, $username, $errors;
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $run_sql = mysqli_query($db, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($db, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: janhaviborde23@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                     array_push($errors,"Failed while sending code!");
                }
            }else{
                array_push($errors,"Something went wrong!");
            }
        }else{
            array_push($errors,"This email address does not exist!");
        }
    }


 //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
    	global $db, $username, $errors;
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($db, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE code = $otp_code";
        $code_res = mysqli_query($db, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
             array_push($errors,"You've entered incorrect code!");
        }
    }



 //if user click change password button
    if(isset($_POST['change-password'])){
    	global $db, $username, $errors;
        $_SESSION['info'] = "";
        $password_1 = mysqli_real_escape_string($db, $_POST['password']);
        $password_2 = mysqli_real_escape_string($db, $_POST['cpassword']);
        if($password_1 !== $password_2){
            array_push($errors,"Confirm password not matched!");
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass =md5($password_1);
            $update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query = mysqli_query($db, $update_pass);
            if($run_query){
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                array_push($errors,"Failed to change your password!");
            }
        }
    }




// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = md5(e($_POST['password']));

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		// echo $query;
		// die();
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1)
		{ // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if($logged_in_user['status'] == 'verified')
			{ 
				if ($logged_in_user['user_type'] == 'admin' )
				{

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: admin/home.php');		  
				}
				else
				{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";

					header('location: index.php');
				}

			}
			else
			{
				$info = "It's look like you haven't still verify your email - $email";
	         	$_SESSION['info'] = $info;
	            header('location: user-otp.php');
			}
		}
		else {
			array_push($errors, "Wrong username/password combination");
		}

	}
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	$email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($db, $email_check);
    if(mysqli_num_rows($res) > 0){
        array_push($errors,"Email that you have entered is already exist!");
    }
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database
		$code = rand(999999, 111111);
        $status = "notverified";

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password,code,status) 
					  VALUES('$username', '$email', '$user_type', '$password','$code', '$status')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO users (username, email, user_type, password,code,status) 
					  VALUES('$username', '$email', 'user', '$password','$code', '$status')";
			$data_check =mysqli_query($db, $query);

			// get id of the created user
			/*$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session

			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');	*/
			if($data_check){
            $subject = "Email Verification Code";
            $message = "Your verification code is $code";
            $sender = "From: janhaviborde23@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            }else{
                array_push($errors, "Failed while sending code!");
            }
        }else{
            array_push($errors,"Failed while inserting data into database!");
        }
    }		
	}
	
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, htmlspecialchars($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}