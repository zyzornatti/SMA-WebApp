<?php

if(isset ($_POST['register'])){
  $error = [];

  if(empty ($_POST['input_firstname'])){
    $error['input_firstname'] = "You have not entered First name";
  }
  if(empty ($_POST['input_lastname'])){
    $error['input_lastname'] = "You have not entered Last name";
  }
  if(empty ($_POST['input_email'])){
    $error['input_email'] = "You have not entered Email";
  }
  $checkemail = selectContent($conn, "read_admin", ['input_email' => $_POST['input_email']]);
  if ($checkemail) {
		$error['input_email'] = "Email already Exists";
	}
  if(empty ($_POST['input_password'])){
    $error['input_password'] = "You have not entered Password";
  }
  if(empty ($_POST['confirm_password'])){
    $error['confirm_password'] = "You have not confirmed Password";
  }
  if($_POST['input_password'] != $_POST['confirm_password']){
    $error['input_password'] = "Password Missmatch";
  }


  if(empty ($error)){
    
    foreach ($_POST as $key => $value) {
  	  $_POST[$key] = htmlspecialchars($value, ENT_QUOTES,"UTF-8");
  	}
  	array_pop($_POST);
  	unset($_POST['confirm_password']);
  	$clean = array_map('trim', $_POST);
  	$clean = array_map( 'htmlentities' , $clean);

  	// RegisterAdmin($conn, $clean);
  	$ret = RegisterAdmin($conn, $clean);

  	$firstname = $clean['input_firstname'];
  	$lastname = $clean['input_lastname'];
  	$recipient = $clean['input_email'];

  	$subject = $site_name." - Registration";
  	$msg = "Hello $firstname $lastname, Please Follow this link to complete your registration ".'http://'.$_SERVER['HTTP_HOST']."/verify?token=".$ret[0];
  	$pword = getenv("EMAIL_PASSWORD");

  	require APP_PATH.'/phpm/PHPMailerAutoload.php';
  	SendMail($site_name, $recipient, $subject, $msg, $site_email, $pword);

  	$suc = "A mail has been sent to your email, Kindly visit your email to complete registration";
  	$message = $suc;

  	header("Location: /login?success=$message");
  }


}


 ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title><?= $site_name ?> - Register</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <div class="main-wrapper login-body">
    <div class="login-wrapper">
      <div class="container">
        <div class="loginbox">
            <div class="login-left">
              <img class="img-fluid" src="assets/img/logo-white.png" alt="Logo">
            </div>
            <div class="login-right">
              <div class="login-right-wrap">
                  <h1>Register</h1>
                  <p class="account-subtitle">Access to our dashboard</p>

                  <form action="" method="post">
                    <?php if(isset($error['input_firstname'])){ say($error['input_firstname']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="input_firstname" type="text" placeholder="Enter Firstname" value="<?php if(isset($_POST['input_firstname'])){ echo $_POST['input_firstname'];} ?>">
                    </div>
                    <?php if(isset($error['input_lastname'])){ say($error['input_lastname']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="input_lastname" type="text" placeholder="Enter Lastname" value="<?php if(isset($_POST['input_lastname'])){ echo $_POST['input_lastname'];} ?>">
                    </div>
                    <?php if(isset($error['input_email'])){ say($error['input_email']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="input_email" type="text" placeholder="Email" value="<?php if(isset($_POST['input_firstname'])){ echo $_POST['input_email'];} ?>">
                    </div>
                    <?php if(isset($error['input_password'])){ say($error['input_password']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="input_password" type="password" placeholder="Password" value="<?php if(isset($_POST['input_password'])){ echo $_POST['input_password'];} ?>">
                    </div>
                    <?php if(isset($error['confirm_password'])){ say($error['confirm_password']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="confirm_password" type="password" placeholder="Confirm Password" value="<?php if(isset($_POST['confirm_password'])){ echo $_POST['confirm_password'];} ?>">
                    </div>
                    <div class="form-group mb-0">
                    <button class="btn btn-primary btn-block" name="register" type="submit">Register</button>
                    </div>
                  </form>

                  <div class="login-or">
                  <span class="or-line"></span>
                  <span class="span-or">or</span>
                  </div>

                <!-- <div class="social-login">
                <span>Register with</span>
                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a>
                </div> -->

                <div class="text-center dont-have">Already have an account? <a href="/login">Login</a></div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>


  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/script.js"></script>

</body>

</html>
