<?php
require 'core/init.php';
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
					'joined'	=> date('Y-m-d H:i:s'),
					'type'=>1
					));
					$db=DB::getInstance();
					$ud=$db->get('users',array(
						'email',
						'=',
						Input::get('email')
					))->first();
					$db->insert('patient',array(
						'patient_id'=>$ud->id
					));
				Session::flash('home', 'Thanks for registering! You can login now.');
				Redirect::to('login.php');
			}
			catch(Exception $e){
				die($e->getMessage());
			}
		}
		else{
			foreach ($validate->errors() as $error) {
				echo '<p class="bg-danger text-center">'.$error, '<br /></p>';
			}
		}
	}
}
?>






<div class="container">
<div class="card card-register mx-auto mt-5">
	<div class="card-header text-center">Create an Account</div>
<div class="card-body">
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
        <input name="password_again" class="form-control" placeholder="Password Again" type="password" value="<?php echo escape(Input::get('password_again')); ?>" autocomplete="off">
    </div> <!-- form-group// -->
    <div class="form-group">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" class="btn btn-primary btn-block" value="Create Account">

    </div> <!-- form-group// -->
    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
</form>
</article>
</div>
</div>
</div> <!-- card.// -->
<?php include 'template/includes/footer.php'; ?>
