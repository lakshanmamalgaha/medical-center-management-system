<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Pharmacist: Delete Item';
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
			<li class="breadcrumb-item active">Delete Item</li>
		</ol>
<?php

				if(isset($_GET['delete'])){
					$uid=(int)$_GET['delete'];
					$db=DB::getInstance();
					if(Input::exists()){
								if(Token::check(Input::get('token')) )
						{
							

							
								try{

									$db->delete('pharmacy',$uid);
									Session::flash('success', 'Successfully Deleted.');
									Redirect::to('stock.php');

								}
								catch(Exception $e){
									die($e->getMessage());
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
					
			       </form>

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
