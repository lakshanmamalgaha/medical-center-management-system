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
	      <li class="breadcrumb-item active">Delivery Persons</li>
			</ol>

			<?php
			if(Session::exists('success'))
			{
				echo '<p class="text-success">' .Session::flash('success').'</p>';
			}

			 ?>
	<div class="">
		<a class="btn btn-primary btn-block" href="addDeliveryperson.php?register">Add New Delivery Person</a>
	</div>

</hr>
	<div class="">
		<hr>
  <form class=""method="post">
		<div class="form-group">
            <div class="form-row">
              <div class="col-md-8">

                <input class="form-control" id="search" type="text" aria-describedby="nameHelp" placeholder="Search a delivery person" name="search">
              </div>
              <div class="col-md-2">

                <input class="form-control btn btn-info btn-block" type="submit" aria-describedby="nameHelp" placeholder="Search" value="Search">
              </div>
            </div>
          </div>
  </form>

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
						$doctors=$db->get('users',array('type','=',4));
						$Dlist=$doctors->results();
						foreach ($Dlist as $key) {
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
	<?php
 ?>
    </div>
  </div>
<?php
      include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}
      ?>
