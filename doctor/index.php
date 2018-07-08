<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Doctor:Dashboard';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_doctor.php';
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">My Dashboard</li>
		</ol>
<?php
if(Session::exists('success'))
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}



?>
	<p>Hello, <?php echo escape($user->data()->fullname); ?></p>


	</div>
</div>
<?php

include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}

?>
