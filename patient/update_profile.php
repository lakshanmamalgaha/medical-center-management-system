<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';

if(isset($_GET['update'])){
  $updateid=(int)$_GET['update'];
  $db=DB::getInstance();
  $details=$db->get('patient',array(
    'id',
    '=',
    $updateid
  ))->first();
  $dbpath=(($details->profile_picture_path !='')?$details->profile_picture_path:'');
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
      'nic'	=> array(
        'required'	=> true,
        'min'=>10,
        'max'=>12
        ),
      'phonenumber'		=> array(
        'required'	=> true,
        'min'=>10,
        'max'=>10

      ),
      'gender'		=> array(
        'required'	=> true


      ),
      'birthday'		=> array(
        'required'	=> true

      ),
      'weight'		=> array(
        'required'	=> true,
        'min'=>0

      ),
      'height'		=> array(
        'required'	=> true,
        'min'=>0

      ),
      'blood_group'		=> array(
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
              'patient',
              $updateid,
              array(
                'nic'=>Input::get('nic'),
                'phonenumber'=>Input::get('phonenumber'),
                'gender'=>Input::get('gender'),
                'birthday'=>Input::get('birthday'),
                'weight'=>Input::get('weight'),
                'height'=>Input::get('height'),
                'blood_group'=>Input::get('blood_group'),
                'profile_picture_path'=>$prof_path
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
                            <label for="">NIC Number</label>
                            <input type="text" name="nic" cols="3" value="<?php echo $details->nic;  ?>" class="form-control">

                          </div>
                          <div class="form-group">
                            <label for="note">Phone Number</label>
                            <input class="form-control" type="text" name="phonenumber" value="<?php echo $details->phonenumber;  ?>">
                          </div>

                        <div>
                         <label for="gender">Gender*:</label>
                         <select class="form-control" name="gender">
                           <option value="<?php echo $details->gender;  ?>"><?php echo $details->gender;  ?></option>
                           <option value="male">Male</option>
                           <option value="female">Female</option>
                         </select>
                       </div>

                       <div class="form-group">
                         <label for="birthday">Birth Day</label>
                         <input type="date" name="birthday" class="form-control" value="<?php echo $details->birthday;  ?>">
                         </div>

                       <div class="form-group">
                         <label for="weight">Weight (kg)*:</label>
                         <input type="text" class="form-control" name="weight" value="<?php echo $details->weight; ?>">

                       </div>
                       <div class="form-group">
                         <label for="height">Height (m)*:</label>
                         <input type="text" class="form-control" name="height" value="<?php echo $details->height; ?>">

                       </div>
                       <div class="form-group">
                         <label for="blood_group">Blood Group*:</label>
                         <select class="form-control" name="blood_group">
                           <option value="<?php echo $details->blood_group;  ?>"><?php echo $details->blood_group;  ?></option>
                           <option value="A+">A+</option>
                           <option value="A-">A-</option>
                           <option value="B+">B+</option>
                           <option value="B-">B-</option>
                           <option value="AB+">AB+</option>
                           <option value="AB-">AB-</option>
                           <option value="O+">O+</option>
                           <option value="O-">O-</option>

                         </select>


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
