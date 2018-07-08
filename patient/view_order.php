<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
      <li class="breadcrumb-item"> <a href="orderedMedicine.php"> Ordered Medicine</a></li>
			<li class="breadcrumb-item active">View Order</li>
		</ol>
<?php

if(isset($_GET['order'])){
  $orderID=(int)$_GET['order'];
  $db=DB::getInstance();
  $url=$db->get('order_medicine',array(
    'id',
    '=',
    $orderID
  ));
?>
<article class="card card-product">
	<div class="card-body">
	<div class="row">
		<aside class="col-sm-6">
			<div class="img-wrap"><img src="<?php echo $url->first()->prescription; ?>" width="400px" height="200px"></div>
		</aside> <!-- col.// -->
		<article class="col-sm-6">

				<h4 class="title"> Order Details  </h4>
        <dl class="dlist-align">
				  <dt>Order ID</dt>
				  <dd><?php echo $url->first()->id;; ?></dd>
				</dl>
        <dl class="dlist-align">
				  <dt>Ordered Date</dt>
				  <dd><?php echo $url->first()->ordered_date; ?></dd>
				</dl>

				<dl class="dlist-align">
				  <dt>Note</dt>
				  <dd><?php echo $url->first()->note; ?></dd>
				</dl>  <!-- item-property-hor .// -->
				<dl class="dlist-align">
				  <dt>Delivery Address</dt>
				  <dd><?php echo $url->first()->delivery_address; ?></dd>
				</dl>
        

		</article>

	</div>
	</div>
</article>

<?php } ?>
	</div>
</div>
<?php

include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}

?>
