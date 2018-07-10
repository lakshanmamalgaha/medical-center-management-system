<?php 
	require_once '../core/init.php';
	include "../classes/db.php";
	$user = new User();
	if($user->isLoggedIn()) {
		$title='Pharmacist: Approve Orders';
	include BASEURL.'includes/head.php';
	include BASEURL.'includes/navigation_pharmacist.php';
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Good Life</a>
			</li>
			<li class="breadcrumb-item active">Approve Orders</li>
		</ol>
    <?php if(Session::exists('success'))
    {
    	echo '<p class="text-success">' .Session::flash('success').'</p>';
    } ?>

<?php
$db=DB::getInstance();
/* approve orders */
if (isset($_GET['id'])){
	$db->update('order_medicine', $_GET['id'], array('approved'=>'1') );
	header("Location:approveorders.php");
}

/* get orders */

$appD=$db->get('order_medicine', array('approved', '=', '0'));
$appD=$appD->results();
if (count($appD)>0){ ?>
<div class="">
<table class="table table-striped">
	<thead>
		<tr>
			<th>Order ID</th>
			<th>User ID</th>
			<th>Note</th>
			<th>Prescription</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($appD as $app) { ?>
	<tr>
		<td> <?php echo $app->id; ?> </td>
		<td> <?php echo $app->user_id; ?> </td>
		<td> <?php echo $app->note; ?> </td>
		<td> <?php echo "<img src=$app->prescription width='50%' height='50%'>"; ?> </td>
		<td> <a href="approveorders.php?id=<?php echo $app->id; ?>"><button>Approve</button></a> </td>
	</tr>
</tbody>
	<?php 
	}
	} else {
		echo "<h2 style='color:red;'>Not available</h2>";
	} 
<<<<<<< HEAD
	?>
</table>
</div>
<?php

include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}

?>
=======
} 
	?>
</table>
</div>
>>>>>>> ba62090cb5c1fea09bcb025d9731802a4631b28c
