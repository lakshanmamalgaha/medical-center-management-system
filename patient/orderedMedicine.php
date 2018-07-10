<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Ordered Medicine';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';
 if(Session::exists('success'))
    {
    	echo '<p class="text-success">' .Session::flash('success').'</p>';
    } ?>


		<div class="content-wrapper">
			<div class="container-fluid">
				<!-- Breadcrumbs-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="index.php">GoodLife</a>
					</li>
		      <li class="breadcrumb-item active">Ordered Medicine</li>
				</ol>
<div class="">
  <a class="btn btn-success btn-block" href="order.php?order=<?php echo $user->data()->id; ?>">Order</a>
  <hr>
</div>
  <div>
    <table class="table text-center">
      <thead>
        <tr class="bg-primary">
          <th class="text-center">Order ID</th>
        <th class="text-center">Ordered Date</th>
        <th class="text-center"></th>

        </tr>
      </thead>

      <tbody>
        <?php
        $db=DB::getInstance();
        $appD=$db->get('order_medicine',array(
          'user_id',
          '=',
          $user->data()->id
        ));
        $appD=$appD->results();
        foreach ($appD as $app) {
          ?>
          <tr>
          <td> <?php echo $app->id; ?> </td>
          <td> <?php echo $app->ordered_date; ?> </td>
          <td> <a class="btn btn-info btn-block" href="view_order.php?order=<?php echo $app->id; ?>">View</a> </td>

        </tr>
          <?php
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
