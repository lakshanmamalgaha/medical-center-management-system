<?php

require_once '../core/init.php';

if(Session::exists('home'))
{
	echo '<p>' .Session::flash('home').'</p>';
}

$user = new User();

if($user->isLoggedIn()) {
?>
	<p>Hello, <a href="profile.php?user=<?php echo escape($user->data()->email); ?>"><?php echo escape($user->data()->email); ?></a>!

	<ul>
		<li><a href="../logout.php">Log Out</a></li>
		<li><a href="update.php">Update Information</a></li>
		<li><a href="changepassword.php">Change Password</a></li>
	</ul>
<?php



} else {
	echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register</a>';
}

?>
