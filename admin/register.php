<?php
require 'core/init.php';
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

if(Input::exists()){
	if(Token::check(Input::get('token')) )
	{
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'fullname'=>array(
				'required'=>'true',
				'min'=>5,
				'max'=>20
			),
			'email' => array(
				'required' => true,
				'unique' => 'users'
			),

			'password' => array(
				'required' => true,
				'min' => 6
			),

			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			)
		));

		if($validate->passed()){
			$user = new User();

			$salt = Hash::salt(32);

			try{
				$user->create(array(
					'fullname'	=> Input::get('fullname'),
					'email'		=> Input::get('email'),
					'password'	=> Hash::make(Input::get('password'), $salt),
					'salt'		=> $salt,
					'joined'	=> date('Y-m-d H:i:s')
					));

				Session::flash('home', 'Thanks for registering! You can login now.');
				Redirect::to('index.php');
			}
			catch(Exception $e){
				die($e->getMessage());
			}
		}
		else{
			foreach ($validate->errors() as $error) {
				echo $error, '<br />';
			}
		}
	}
}
?>






<div class="card">
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Create Account</h4>
	<p class="text-center">Get started with your free account</p>

	<form method="post">
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="fullname" class="form-control" placeholder="Full name" type="text" value="<?php echo escape(Input::get('fullname')); ?>" autocomplete="off">
    </div> <!-- form-group// -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email address" type="email" value="<?php echo escape(Input::get('email')); ?>" autocomplete="off">
    </div> <!-- form-group// -->

    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" class="form-control" placeholder="Create password" type="password" value="<?php echo escape(Input::get('password')); ?>" autocomplete="off">
    </div> <!-- form-group// -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password_again" class="form-control" placeholder="Repeat password" type="password" value="<?php echo escape(Input::get('password_again')); ?>" autocomplete="off">
    </div> <!-- form-group// -->
    <div class="form-group">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" class="btn btn-primary btn-block" value="Create Account">

    </div> <!-- form-group// -->
    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
</form>
</article>
</div> <!-- card.// -->

</body>
</html>
