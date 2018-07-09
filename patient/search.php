<?php
require_once '../core/init.php';
$user=new User();
if($user->isLoggedIn()) {
	$title='Patient:Search a Doctor';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';

if(isset($_POST)){
  $table=$_POST['table'];
  $type=$_POST['type'];
  $search=$_POST['search'];
  ?>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">GoodLife</a>
      </li>
      <li class="breadcrumb-item active">Search Results</li>
    </ol>

<?php
$db=DB::getInstance();
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
  ?>
  <div class="">
    <div class="">
      <?php echo $sc.' Results Found'; ?>
      <hr>
    </div>
	 <table class="table table-striped text-center" >
		 <thead class="text-center">
			 <tr class="text-center bg-info">
			 <th>ID</th>
			 <th>Name</th>
			 <th>Email</th>
			 <th>Join Date</th>
			 <th></th>
			 </tr>
		 </thead>
		 <tbody>

			 <?php
						foreach ($sr as $key) {
							?>
            <tr class="bg-success">
                  <td><?php echo $key->id; ?></td>
                 <td><?php echo $key->fullname; ?></td>
                 <td><?php echo $key->email; ?></td>
                 <td><?php echo $key->joined; ?></td>
								 <td>  <a class="form-control btn btn-primary btn-block" href="channel.php?channel=<?php echo $key->id; ?>">Channel</a> </td>
            </tr><?php

						}

						 ?>

		 </tbody>
	 </table>
 </div>

  <?php
}
?>
</div>
</div>

<?php
}
include BASEURL.'includes/footer.php';
}
 ?>
