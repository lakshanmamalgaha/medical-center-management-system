<?php
require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Admin : Patients';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_admin.php';
$db=DB::getInstance();

if (isset($_GET['delete'])) {
	$did=(int)$_GET['delete'];
	$db->delete('users',array(
		'id',
		'=',
		$did
	));
	Session::flash('success', 'Successfully deleted.');
	Redirect::to('patient.php');

}
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}
?>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">GoodLife</a>
			</li>
      <li class="breadcrumb-item active">Patients</li>
		</ol>
		<div class="">
			<hr>
		<form class=""method="post">
			<div class="form-group">
							<div class="form-row">
								<div class="col-md-8">

									<input class="form-control" id="search" type="text" aria-describedby="nameHelp" placeholder="Search a patient" name="search">
								</div>
								<div class="col-md-2">
									<input  hidden type="text" name="type" value="1">
									<input hidden type="text" name="table" value="users">
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
				 <th>Reg No</th>
				 <th>Name</th>
				 <th>Email</th>
				 <th>Join Date</th>
				 <th></th>
				 </tr>
			 </thead>
			 <tbody>
				 <?php if(isset($_POST['search'])){
					 $table=$_POST['table'];
					 $type=$_POST['type'];
					 $search=$_POST['search'];
					 $sq=$db->query("SELECT * FROM {$table} WHERE type={$type} AND fullname LIKE ?",array(
					   '%'.$search.'%'
					 ));
					 $sr=$sq->results();
					 $sc=$sq->count();
					 //$sq->execute()
					 //var_dump($sr);
					 if($sc==0){
					   echo 'No Search Results Found';
					 }
					 else{
						 foreach ($sr as $key) {
							 ?>
						 <tr class="bg-success">
									 <td><?php echo $key->id; ?></td>
									<td><?php echo $key->fullname; ?></td>
									<td><?php echo $key->email; ?></td>
									<td><?php echo date_fo($key->joined); ?></td>
									<td> <a class="btn btn-danger btn-sm" href="patient.php?delete=<?php echo $key->id; ?>">Delete</a> </td>
						 </tr><?php

						 }
					 }




				 }else{

							$doctors=$db->get('users',array('type','=',1));
							$Dlist=$doctors->results();
							foreach ($Dlist as $key) {
								?>
							<tr class="bg-success">
										<td><?php echo $key->id; ?></td>
									 <td><?php echo $key->fullname; ?></td>
									 <td><?php echo $key->email; ?></td>
									 <td><?php echo date_fo($key->joined); ?></td>
									 <td> <a class="btn btn-danger btn-sm" href="patient.php?delete=<?php echo $key->id; ?>">Delete</a> </td>
							</tr><?php

							}
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
