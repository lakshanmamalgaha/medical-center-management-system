<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
  $title='Doctor : Update Profile';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';

if(isset($_GET['update'])){
  $updateid=(int)$_GET['update'];
  $db=DB::getInstance();
  $details=$db->get('doctor',array(
    'id',
    '=',
    $updateid
  ))->first();
  $dbpath=(($details->prof_path !='')?$details->prof_path:'');
  //$nic=(((isset( $_POST['nic']) && $_POST['nic']) != '')? sanitize(Input::get('nic')):$details->nic);
//  $phonenumber=(((isset($_POST['phonenumber']) && $_POST['phonenumber'] ) != '')?sanitize(Input::get('phonenumber')):$detail->phonenumber);
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Good Life</a>
			</li>
			<li class="breadcrumb-item active">Update Profile</li>
		</ol>

<?php

if(Session::exists('success'))
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}
if(Input::exists())
{
  if(Token::check(Input::get('token'))){
    $validate = new Validation();
    $validation = $validate->check($_POST, array(

      'phonenumber'		=> array(
        'required'	=> true,
        'min'=>10,
        'max'=>10

      ),
      'slmc_reg_no'		=> array(
        'required'	=> true


      ),
      'qualifications'		=> array(
        'required'	=> true

      )

    ));

    if($validation->passed()){
      $error_array=array();
      if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
          $photo=$_FILES['profile_picture'];
          $photo_name=$photo['name'];
          $photo_name_array=explode('.',$photo_name);
          $file_name=$photo_name_array[0];

          if($file_name !=''){
          $file_ext=$photo_name_array[1];
              $mime=explode('/',$photo['type']);
              $mime_type=$mime[0];
              if ($mime_type != 'image') {
                $errors[].='File must be an image';
              }else {
                $mime_ext=$mime[1];
              }

              $tmp_location=$photo['tmp_name'];
              $file_size=$photo['size'];
              $allowed=array('png','jpg','jpeg','gif');

              $upload_name=md5(microtime()).'.'.$file_ext;
              $upload_location=BASEURL.'patient/profile/'.$upload_name;
              $prof_path='/Myp/patient/profile/'.$upload_name;

              if (!in_array($file_ext,$allowed)) {
                $error_array[].='The file extension must be png,jpg,jpeg,gif';
              }
              if ($file_size> 5000000) {
                $error_array[].='File must be under 5MB';
              }

        }

        }
        if(empty($error_array)){
              if (isset($_FILES['profile_picture']) && $_FILES["profile_picture"]["error"] == 0) {
                  move_uploaded_file($tmp_location,$upload_location);
                }

            $db->update(
              'doctor',
              $updateid,
              array(
                'slmc_reg_no'=>Input::get('slmc_reg_no'),
                'qualifications'=>Input::get('qualifications'),
                'phonenumber'=>Input::get('phonenumber'),
                'prof_path'=>$prof_path
              )
            );
            Session::flash('success', 'Update Successful');
            Redirect::to('index.php');

            }

      }else {
        foreach ($validation->errors() as $error) {
  				echo $error, '<br>';
  			}
      }
    }
  }



?>
						<div class="container">
				      <div class="card mx-auto mt-10">
				        <div class="card-header">Update</div>
				    			<div class="card-body">
		                <div class="row">
		                  <div class=" col-md-9 col-lg-9 ">
                        <form class="form" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="profile Picture">Profile Picture*:</label>
                            <input type="file" name="profile_picture" class="form-control" >

                          </div>
                          <div class="form-group">
                            <label for="">SLMC Reg No</label>
                            <input type="text" name="slmc_reg_no" cols="3" value="<?php echo $details->slmc_reg_no;  ?>" class="form-control">

                          </div>
                          <div class="form-group">
                            <label for="note">Phone Number</label>
                            <input class="form-control" type="text" name="phonenumber" value="<?php echo $details->phonenumber;  ?>">
                          </div>
                          <div class="form-group">
                            <label for="note">Qualifications</label>
                            <input class="form-control" type="text" name="qualifications" value="<?php echo $details->qualifications;  ?>">
                          </div>


                       <div class="form-group col-md-3 pull-right">
                         <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                         <input type="submit" name="submit" value="Update" class="form-control btn btn-success">
                       </div>
                        </form>




		                  </div>
		                </div>
		              </div>


		            </div>

		      </div>



	</div>
</div>
<?php

include BASEURL.'includes/footer.php';
}
}else{
	Redirect::to('../login.php');
}

?>
