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
$db=DB::getInstance();
$details=$db->get('doctor',array(
	'd_id',
	'=',
	$user->data()->id
))->first();


?>
<div class="container">
	<div class="card mx-auto mt-10">
		<div class="card-header"><?php echo $user->data()->fullname; ?></div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 col-lg-3 " align="center"> <img alt="Profile Picture" src="<?php echo $details->prof_path; ?>" class="img-circle profile-image" width="200px" height="200px">

					 </div>

					<div class=" col-md-9 col-lg-9 ">
						<table class="table table-user-information">
							<tbody>
								<th>Basic Info</th>
								<tr>
									<td>Registration No:</td>
									<td><?php echo $user->data()->id; ?></td>
								</tr>
								<tr>
									<td>Email:</td>
									<td><?php echo $user->data()->email; ?></td>
								</tr>
								<tr>
									<td>SLMC Reg No:</td>
									<td> <?php echo $details->slmc_reg_no; ?></td>
								</tr>
								<tr>
									<td>Phone Number:</td>
									<td><?php echo $details->phonenumber; ?></td>
								</tr>
								<tr>
									<td>Qualifications:</td>
									<td><?php echo $details->qualifications; ?> </td>
								</tr>
								<tr>
									<td>Joined:</td>
									<td><?php echo date_fo($user->data()->joined) ; ?></td>
								</tr>


							</tbody>
						</table>
						<a href="update_profile.php?update=<?php echo $details->id; ?>" class="btn btn-primary" >Update Profile</a>



					</div>
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
