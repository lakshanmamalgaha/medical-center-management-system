<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Doctor: Appoinments';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_doctor.php';
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Good Life</a>
			</li>
			<li class="breadcrumb-item active">Appoinments</li>
		</ol>
<?php
if(Session::exists('success'))
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}

?>
<div>
  <table class="table text-center">
    <thead>
      <tr class="bg-primary">
        <th class="text-center">Reference Number</th>
      <th class="text-center">Patient Name</th>
      <th class="text-center">Date</th>
      <th class="text-center"></th>
    

      </tr>
    </thead>

    <tbody>
      <?php
      $db=DB::getInstance();
      $appD=$db->get('appointment',array(
        'doctor_id',
        '=',
        $user->data()->id
      ));
      $appD=$appD->results();
      foreach ($appD as $app) {
        $pname=$db->get('users',array(
          'id',
          '=',
          $app->user_id
        ));
        ?>
        <tr>
        <td> <?php echo $app->id; ?> </td>
        <td> <?php echo $pname->first()->fullname; ?> </td>
        <td> <?php echo $app->date; ?> </td>
        <?php
          $start_date=$app->date;
          $expire=strtotime($start_date);
          $today=strtotime(date("Y-m-d H:i"));
          if($today>=$expire){
          echo '
          <td> <a href="edit_appointment.php?view='.$app->id.'" class="btn btn-info btn-sm">Add Info</a>
          <a href="edit_appointment.php?delete='.$app->id.'" class="btn btn-danger btn-sm">Delete</a>
            </td>';
        }
        ?>
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
