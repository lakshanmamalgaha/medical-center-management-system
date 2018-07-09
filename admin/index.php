<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_admin.php';
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">My Dashboard</li>
		</ol>
<?php
if(Session::exists('home'))
{
	echo '<p class="text-success">' .Session::flash('home').'</p>';
}
$db=DB::getInstance();
$dcount=$db->get('users',array(
	'type',
	'=',
	2
))->count();

?>
<div class="row">
			 <div class="col-xl-3 col-sm-6 mb-3">
				 <div class="card text-white bg-primary o-hidden h-100">
					 <div class="card-body">
						 <div class="card-body-icon">
							 <i class="fa fa-fw fa-users"></i>
						 </div>
						 <div class="mr-5"><?php echo $dcount; ?> Doctors</div>
					 </div>

				 </div>
			 </div>
			 <div class="col-xl-3 col-sm-6 mb-3">
				 <div class="card text-white bg-warning o-hidden h-100">
					 <div class="card-body">
						 <div class="card-body-icon">
							 <i class="fa fa-fw fa-list"></i>
						 </div>
						 <div class="mr-5">11 New Tasks!</div>
					 </div>
				 </div>
			 </div>
			 <div class="col-xl-3 col-sm-6 mb-3">
				 <div class="card text-white bg-success o-hidden h-100">
					 <div class="card-body">
						 <div class="card-body-icon">
							 <i class="fa fa-fw fa-shopping-cart"></i>
						 </div>
						 <div class="mr-5">123 New Orders!</div>
					 </div>
				 </div>
			 </div>
			 <div class="col-xl-3 col-sm-6 mb-3">
				 <div class="card text-white bg-danger o-hidden h-100">
					 <div class="card-body">
						 <div class="card-body-icon">
							 <i class="fa fa-fw fa-support"></i>
						 </div>
						 <div class="mr-5">13 New Tickets!</div>
					 </div>

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
