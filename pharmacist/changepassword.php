<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Pharmacist: Change Password';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_pharmacist.php';
?>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">GoodLife</a>
			</li>
			<li class="breadcrumb-item active">Change Password</li>
		</ol>


		<div class="container">
	    <div class="card card-register mx-auto mt-5">
	      <div class="card-header">Change Password</div>
				<div class="text-center text-danger">




<?php

$user = new User();

if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}

if(Input::exists())
{
	if(Token::check(Input::get('token'))){

		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'password_current'	=> array(
				'required'	=> true,
				'min'		=> 6
				),
			'password_new'		=> array(
				'required'	=> true,
				'min'		=> 6
				),
			'password_new_again'	=> array(
				'required'	=> true,
				'min'		=> 6,
				'matches'	=> 'password_new'
				),
		));

		if($validation->passed()){

			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
				echo "Wrong Current Password";
			} else {
				$salt = Hash::salt(32);
				$user->update(array(
					'password'	=> Hash::make(Input::get('password_new'), $salt),
					'salt'		=> $salt
					));

				Session::flash('home', 'Password Changed');
				Redirect::to('index.php');
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}

	}
}
?>


			</div>
	      <div class="card-body">
	        <form method="post">

	          <div class="form-group">
	            <label for="password">Current Password:</label>
	            <input class="form-control" type="password" name="password_current" id="password_current">
	          </div>
						<div class="form-group">
							<label for="password">New Password:</label>
							<input class="form-control" type="password" name="password_new" id="password_new">
	          </div>
						<div class="form-group">
							<label for="password">New Password Again:</label>
							<input class="form-control" type="password" name="password_new_again" id="password_new_again">
	          </div>
						<input type="submit" class="btn btn-primary btn-block" value="Change Password">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	        </form>

	      </div>
	    </div>
	  </div>
	</div>
</div>
	<?php
		include BASEURL.'includes/footer.php';
	}else{
		Redirect::to('../login.php');
	}
	 ?>
