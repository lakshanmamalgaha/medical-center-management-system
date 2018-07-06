<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';
if(isset($_GET['order'])){
  $orderID=(int)$_GET['order'];
  if(Input::exists())
  {
  		$validate = new Validation();
  		$validation = $validate->check($_POST, array(
  			'delivery_address'	=> array(
  				'required'	=> true
  				),
  			'note'		=> array(
  				'required'	=> true

  				)
  		));

  		if($validation->passed()){
        $error_array=array();
        if (isset($_FILES["prescription"]) && $_FILES["prescription"]["error"] == 0) {
            $photo=$_FILES['prescription'];
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
                $upload_location=BASEURL.'prescription/'.$upload_name;
                $prescription_path='/medicalcenter/prescription/'.$upload_name;

                if (!in_array($file_ext,$allowed)) {
                  $error_array[].='The file extension must be png,jpg,jpeg,gif';
                }
                if ($file_size> 5000000) {
                  $error_array[].='File must be under 5MB';
                }

          }

          }
          if(empty($error_array)){
                if (isset($_FILES['prescription']) && $_FILES["prescription"]["error"] == 0) {
                    move_uploaded_file($tmp_location,$upload_location);
                  }
              $db=DB::getInstance();
              $db->insert(
                'order_medicine',
                array(
                  'user_id'=>$user->data()->id,
                  'delivery_address'=>Input::get('delivery_address'),
                  'note'=>Input::get('note'),
                  'prescription'=>$prescription_path
                )
              );
              Session::flash('success', 'Medicine Order Successful');
      				Redirect::to('orderedMedicine.php');

              }

  			}else {
          ?>
          <div class="content-wrapper">
          	<div class="container-fluid">
          		<!-- Breadcrumbs-->
          		<ol class="breadcrumb">
          			<li class="breadcrumb-item">
          				<a href="index.php">GoodLife</a>
          			</li>
                <li class="breadcrumb-item active">Order Medicine</li>
          		</ol>

              <div class="center" id="order_medicine">

                <div class="row">
                    <div class="col-md-3">
                      <div class="how-it-proccess">
                      <img src="../images/presc.png" class="img-responsive" alt="upload">
                      <div style="text-align: center;">
                        <span>Upload Prescriptions</span>
                      </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                      <div class="how-it-proccess">
                      <img src="../images/order-process.png" class="img-responsive">
                      <div style="text-align: center;">
                          <span>Pharmacy process the order</span>
                      </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                      <div class="how-it-proccess">
                      <img src="../images/deliver.png" class="img-responsive">
                      <div style="text-align: center;">
                            <span>Doorstep Delivery</span>
                      </div>
                    </div>
                    </div>
                  </div>
          <hr>
          </div>
          <?php

  			foreach ($validation->errors() as $error) {
  				echo $error, '<br>';
  			}
  		}


  }else {
    ?>
    <div class="content-wrapper">
    	<div class="container-fluid">
    		<!-- Breadcrumbs-->
    		<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="index.php">GoodLife</a>
    			</li>
          <li class="breadcrumb-item active">Order Medicine</li>
    		</ol>

        <div class="center" id="order_medicine">

          <div class="row">
              <div class="col-md-3">
                <div class="how-it-proccess">
                <img src="../images/presc.png" class="img-responsive" alt="upload">
                <div style="text-align: center;">
                  <span>Upload Prescriptions</span>
                </div>
              </div>
              </div>
              <div class="col-md-3">
                <div class="how-it-proccess">
                <img src="../images/order-process.png" class="img-responsive">
                <div style="text-align: center;">
                    <span>Pharmacy process the order</span>
                </div>
              </div>
              </div>
              <div class="col-md-3">
                <div class="how-it-proccess">
                <img src="../images/deliver.png" class="img-responsive">
                <div style="text-align: center;">
                      <span>Doorstep Delivery</span>
                </div>
              </div>
              </div>
            </div>
    <hr>
    </div>
  <?php } ?>
    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Order Medicine</div>
    <div class="card-body">
     <div class="" id="order_medicine">
       <form class="form" method="post" enctype="multipart/form-data">
         <div class="form-group">
           <label for="prescription">Prescription*:</label>
           <input type="file" name="prescription" class="form-control" >

         </div>
         <div class="form-group">
           <label for="delivery_address">Delivery Address</label>
           <input type="text" name="delivery_address" cols="3" value="" class="form-control">

         </div>
         <div class="form-group">
           <label for="note">Note</label>
           <textarea name="note" rows="4" cols="80" class="form-control" value=""></textarea>

         </div>
         <div class="form-group col-md-3 pull-right">
           <input type="submit" name="submit" value="Send Order" class="form-control btn btn-success">
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


?>


<?php

      include BASEURL.'includes/footer.php';
		}else{
			Redirect::to('../login.php');
		}
      ?>
