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
				<a href="index.php">GoodLife</a>
			</li>
      <li class="breadcrumb-item active">Appointments</li>
		</ol>

  <div>
    <table class="table text-center">
      <thead>
        <tr class="bg-primary">
          <th class="text-center">Reference Number</th>
        <th class="text-center">Doctor Name</th>
        <th class="text-center">Date</th>
        <th class="text-center">Speciality</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $db=DB::getInstance();
        $appD=$db->get('appointment',array(
          'user_id',
          '=',
          $user->data()->id
        ));
        $appD=$appD->results();
        foreach ($appD as $app) {
          $dname=$db->get('users',array(
            'id',
            '=',
            $app->doctor_id
          ));
          ?>
          <tr>
          <td> <?php echo $app->id; ?> </td>
          <td> <?php echo $dname->first()->fullname; ?> </td>
          <td> <?php echo $app->date; ?> </td>
          <td> <?php echo 'test'; ?> </td>
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
