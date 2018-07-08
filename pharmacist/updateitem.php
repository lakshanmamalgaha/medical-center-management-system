<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Pharmacist: Update Item';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_pharmacist.php';
if(Session::exists('success'))
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}
?>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Good Life</a>
			</li>
			<li class="breadcrumb-item">
				<a href="stock.php">Stocks</a>
			</li>
			<li class="breadcrumb-item active">Update Item</li>
		</ol>
<?php

				if(isset($_GET['update'])){
					$uid=(int)$_GET['update'];
					$db=DB::getInstance();
					if(Input::exists()){
								if(Token::check(Input::get('token')) )
						{
							$validate = new Validation();
							$validation = $validate->check($_POST, array(
								'packSize' => array(
									'required' => true

								),

								'unitPrice' => array(
									'required' => true

								),

								'activeGrades' => array(
									'required' => true

								),
								'sup_code'=>array(
									'required'=>true
								),
								'supplier'=>array(
									'required'=>true
								)
							));

							if($validate->passed()){
								try{

									$db->update('pharmacy',$uid,array(
										'description'=>Input::get('description'),
										'packsize'=>Input::get('packSize'),
										'unit_price'=>Input::get('unitPrice'),
										'active_grades'=>Input::get('activeGrades'),
										'sup_code'=>Input::get('sup_code'),
										'supplier'=>Input::get('supplier')
									));
									Session::flash('success', 'Successfully Updated.');
									Redirect::to('stock.php');

								}
								catch(Exception $e){
									die($e->getMessage());
								}
							}
							else{
								foreach ($validate->errors() as $error) {
									echo $error, '<br />';
								}
							}
						}
					}

				$item=$db->get('pharmacy',array(
					'id',
					'=',
					$uid
				))->first();
					?>
					<div class="container">
			      <div class="card card-register mx-auto mt-5">
			        <div class="card-header">Update Item</div>
			    <div class="card-body">
			     <div class="" id="order_medicine">
			       <form class="form" method="post" enctype="multipart/form-data">
							 <div class="form-group">
   			<label>Code</label>
   			<input type="text" class="form-control" readonly name="code" value="<?php echo $item->code; ?>" >
   		</div>
   		<div class="form-group">
   			<label>Description</label>
   			<input type="text"  class="form-control" name="description" value="<?php echo $item->description; ?>" >
   		</div>
   		<div class="form-group">
   			<label>Pack Size</label>
   			<input type="text"  class="form-control" name="packSize" value="<?php echo $item->packsize; ?>" >
   		</div>
   		<div class="form-group">
   			<label>Unit price</label>
   			<input type="text" class="form-control" name="unitPrice" value="<?php echo $item->unit_price; ?>" >
   		</div>
   		<div class="form-group">
   			<label>Active Grades</label>
   			<input type="text" class="form-control" name="activeGrades" value="<?php echo $item->active_grades; ?>" >
   		</div>
   		<div class="form-group">
   			<label>Sup. Code</label>
   			<input type="text" class="form-control" name="sup_code" value="<?php echo $item->sup_code; ?>" >
   		</div>
   		<div class="form-group">
   			<label>Supplier</label>
   			<input type="text" class="form-control" name="supplier" value="<?php echo $item->supplier; ?>">
   		</div>

   		<div class="form-group col-md">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
   			<input type="submit" name="submit" value="Update" class="form-control btn btn-primary">
   		</div>

			       </form>

			          </div>
			        </div>
			      </div>
			    </div>



	</div>
</div>
<?php
}
include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}

?>
