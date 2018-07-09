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
				<a href="index.php">GoodLife</a>
			</li>
      <li class="breadcrumb-item active">Pharmacist</li>
		</ol>

		<?php
		if(Session::exists('success'))
		{
			echo '<p class="text-success">' .Session::flash('success').'</p>';
		}

	?>
	<div class="">
		<a class="btn btn-primary btn-block" href="addPharmacist.php?register">Add New Pharmacist</a>
	</div>

</hr>
	<div class="">
		<hr>

 <hr>

</div>
	<div class="">
	 <table class="table table-striped text-center" >
		 <thead class="text-center">
			 <tr class="text-center bg-info">
			 <th>ID</th>
			 <th>Name</th>
			 <th>Email</th>
			 <th>Join Date</th>
			 </tr>
		 </thead>
		 <tbody>

			 <?php
			 			$db=DB::getInstance();
						$pharmacist=$db->get('users',array('type','=',3));
						$Plist=$pharmacist->results();
						foreach ($Plist as $key) {
							?>
            <tr class="bg-success">
                  <td><?php echo $key->id; ?></td>
                 <td><?php echo $key->fullname; ?></td>
                 <td><?php echo $key->email; ?></td>
                 <td><?php echo $key->joined; ?></td>
            </tr><?php

						}

						 ?>

		 </tbody>
	 </table>
 </div>

    </div>
  </div>
<?php
      include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}
      ?>
