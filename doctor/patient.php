<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Doctor: Patients';
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
			<li class="breadcrumb-item active">Patients</li>
		</ol>
<?php
if(Session::exists('success'))
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}
?>
<div class="">
 <table class="table table-striped text-center" >
   <thead class="text-center">
     <tr class="text-center bg-info">
     <th>ID</th>
     <th>Name</th>
     <th>Email</th>
     </tr>
   </thead>
   <tbody>

     <?php
          $db=DB::getInstance();
          $patients=$db->get('appointment',array(
            'doctor_id',
            '=',
            $user->data()->id));
            $patientList=$patients->results();
            $userID=array();

            foreach ($patientList as $key) {
              $ID=(int)$key->user_id;

              $userID[].=$ID;



            }
           $userID=array_unique($userID);

            foreach ($userID as $key) {
              $patient=$db->get('users',array(
                'id',
                '=',
                $key
              ))->results();

              foreach ($patient as $value) {?>

                <tr class="bg-success">
                      <td><?php echo $value->id; ?></td>
                     <td><?php echo $value->fullname; ?></td>
                     <td><?php echo $value->email; ?></td>

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
