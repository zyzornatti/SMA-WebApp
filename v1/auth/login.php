<?php

if(isset ($_POST['login'])){
  $error = [];

  if(empty ($_POST['input_email'])){
    $error['email'] = "Enter Email";
  }
  if(empty ($_POST['input_password'])){
    $error['password'] = "Enter Password";
  }

  if(empty ($error)){
    // $checkemail = selectContent($conn, "admin", ["input_email"=> $_POST['input_email']]);
    // if(count($checkemail) > 0 && password_verify($_POST['input_password'], $checkemail[0]['input_password'])){
    //   $_SESSION['admin'] = $checkemail[0]['hash_id'];
    //
    //   header("Location: /dashboard");
    // }else{
    //   $error['login_details'] = "Either email or password is incorrect";
    // }

    $email = $_POST['input_email'];
  	$password = $_POST['input_password'];
  	LoginAdmin($conn, $email, $password);
  }

}

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title><?= $site_name ?> - Login</title>

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
                <h1>Login</h1>
                <p class="account-subtitle">Access to our dashboard</p>

                <?php if (isset($_GET['success'])): ?>
    							<div class="alert alert-success alert-dismissible show" role="alert">
    													 <strong>Successful!</strong> <?php echo $_GET['success']; ?>
    													 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    												 </div>
    						<?php endif; ?>
    						<?php if (isset($_GET['wn'])): ?>
    							<div class="alert alert-warning alert-dismissible show" role="alert">
    													 <strong>Notice!</strong> <?php echo str_replace("_", " ", $_GET['wn']); ?>
    													 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    												 </div>
    						<?php endif; ?>
    						<?php if (isset($_GET['err'])): ?>
    							<div class="alert alert-danger alert-dismissible show" role="alert">
    													 <strong>Notice!</strong> <?php echo str_replace("_", " ", $_GET['err']); ?>
    													 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    												 </div>
    						<?php endif; ?>

                  <form action="" method="post">
                    <?php if(isset($error['email'])){ say($error['email']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="input_email" type="text" placeholder="Email" value="<?php if(isset($_POST['input_email'])){echo $_POST['input_email'];} ?>">
                    </div>
                    <?php if(isset($error['password'])){ say($error['password']);} ?>
                    <div class="form-group">
                      <input class="form-control" name="input_password" type="password" placeholder="Password" value="<?php if(isset($_POST['input_password'])){echo $_POST['input_password'];} ?>">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary btn-block" name="login" type="submit">Login</button>
                    </div>
                  </form>

                  <div class="text-center forgotpass"><a href="/forgot-password">Forgot Password?</a></div>
                  <div class="login-or">
                    <span class="or-line"></span>
                    <span class="span-or">or</span>
                  </div>

                  <!-- <div class="social-login">
                  <span>Login with</span>
                  <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a>
                  </div> -->

                  <div class="text-center dont-have">Don’t have an account? <a href="/register">Register</a></div>
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
