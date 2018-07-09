<?php
	require_once 'core/init.php';
include 'template/includes/head.php';
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Register</title>
		<link href="css/bootstrap-custom.css" rel="stylesheet" type="text/css"/>
		<link href="css/uikit.css" rel="stylesheet" type="text/css"/>
		<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />
	</head>
	<body>

	<?php

	if(Input::exists())
	{
		if(Token::check(Input::get('token')))
		{
			$validate 	= new Validation();
			$validation = $validate->check($_POST, array(
				'email'	=> array(
					'required'	=> true
					),
				'password'	=> array(
					'required'	=> true
					),
			));

			if($validation->passed())
			{
				$user 	= new User();

				$remember 	= (Input::get('remember') === 'on') ? true : false;
				$login 		= $user->login(Input::get('email'), Input::get('password'), $remember);

				if($login)
				{
					if($user->userType()==0){
						Session::flash('home', 'Successfully Logged Admin.');
						Redirect::to('admin/index.php');
				}
				elseif ($user->userType()==1) {
					Session::flash('home', 'Successfully Logged patient.');
					Redirect::to('patient/index.php');
				}
				elseif ($user->userType()==2) {
					Session::flash('home', 'Successfully Logged doc.');
					Redirect::to('doctor/index.php');
				}
				elseif ($user->userType()==3) {
					Session::flash('home', 'Successfully Logged pharmacist.');
					Redirect::to('pharmacist/index.php');
				}
				}
				else{
					echo '<p class="bg-danger text-center">Incorrect Password<br /></p>';
				}
			}
			else{
				foreach ($validation->errors() as $error) {

					echo '<p class="bg-danger text-center">'.$error, '<br /></p>';
				}
			}
		}
	}
?>
<div class="container">
<div class="card card-register mx-auto mt-5">
	<div class="card-header">Login</div>
<div class="card-body">
	 <form method="post">
    <div class="form-group">
    	<label>Your email</label>
        <input name="email" class="form-control" placeholder="Email" type="email" value="<?php echo Input::get('email'); ?>">
    </div> <!-- form-group// -->
    <div class="form-group">
    	<a class="float-right" href="#">Forgot?</a>
    	<label>Your password</label>
        <input name="password" class="form-control" placeholder="******" type="password">
    </div> <!-- form-group// -->
    <div class="form-group">
    <div class="checkbox">
      <label> <input type="checkbox" name="remember" id="remember"> Save password </label>
    </div> <!-- checkbox .// -->
    </div> <!-- form-group// -->
    <div class="form-group">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Log In" class="btn btn-primary btn-block" >
				<a href="register.php">Don't have an account?</a>
    </div> <!-- form-group// -->
</form>
</article>
</div>
</div>
</div><!-- card.// -->
<?php include 'template/includes/footer.php'; ?>
