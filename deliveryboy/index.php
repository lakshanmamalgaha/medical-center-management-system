<?php require_once '../core/init.php';


include 'include/head.php';
include 'include/navigation.php';
//booking
if (isset($_GET['delete'])) {
  $deleteID=(int)($_GET['delete']);
  var_dump($deleteID);
  $delete_query=$db->query("SELECT * FROM order_medicine WHERE id='$deleteID'");

  $order_delete=mysqli_fetch_assoc($delete_query);
  $id=$order_delete['id'];
  $patient=$order_delete['patient'];
  $user_id=$order_delete['user_id'];
  $email=$order_delete['email'];
  $phonenumber=$order_delete['phonenumber'];
  $prescription=$order_delete['prescription'];
  $delivery_address=$order_delete['delivery_address'];
  $note=$order_delete['note'];
  $ordered_date=$order_delete['ordered_date'];
  $approved=$order_delete['approved'];
  $add_query=$db->query("INSERT INTO delivered_orders(order_id,patient,user_id,email,phonenumber,prescription,delivery_address,note,ordered_date,approved) Values ('$id','$patient','$user_id','$email','$phonenumber','$prescription','$delivery_address','$note','$ordered_date','$approved') ") or die(mysqli_error($db));   
  
  

  $db->query("DELETE FROM order_medicine WHERE id='$deleteID'");
  header('Location:index.php');

    
}

 ?>
 
<div id="booking-form" class="col-md-10">
  <div class="panel panel-info">

  <div class="panel-heading text-center">
      <span class="title text-center">Medicine Orders</span>
  </div>
  </div>
    <table class="table text-center">
      <thead>
        <tr class="bg-primary">
          <th class="text-center">Order ID</th>
        <th class="text-center">Patient</th>
        <th class="text-center">E-mail</th>
        <th class="text-center">Phone number</th>
        <th class="text-center">Prescription</th>
        <th class="text-center">Delivery Address</th>
        <th class="text-center">Note</th>
        <th class="text-center">Ordered Date and Time</th>
        <th>Status</th>
        <th></th>

        </tr>
      </thead>

      <tbody>
        <?php
          $sql_order="SELECT * FROM order_medicine WHERE  approved=1";
          $order_query=$db->query($sql_order);
          while($order_array=mysqli_fetch_assoc($order_query)):
            
           
           
         ?>
        <td><?php echo $order_array['id']; ?> </td>
        <td><?php echo $order_array['patient']; ?> </td>
        <td> <?php echo $order_array['email']; ?> </td>
        <td> <?php echo $order_array['phonenumber']; ?> </td>
        <td> <?php echo $order_array['prescription']; ?> </td>
        <td> <?php echo $order_array['delivery_address']; ?> </td>
        <td> <?php echo $order_array['note']; ?> </td>
        <td> <?php echo $order_array['ordered_date']; ?> </td>
        <?php
        
          echo '
          <td> 
          <a href="index.php?delete='.$order_array['id'].'" class="btn btn-success btn-sm">Delivered</a>  </td>';
          ?>

         </tr>
       <?php endwhile; ?>
      </tbody>
    </table>
    <div class="panel panel-info">

  <div class="panel-heading text-center">
      <span class="title text-center">Delivered Orders</span>
  </div>
  </div>
    <table class="table text-center">
      <thead>
        <tr class="bg-primary">
          <th class="text-center">Delivery ID</th>
          <th class="text-center">Order ID</th>
        <th class="text-center">Patient</th>
        <th class="text-center">E-mail</th>
        <th class="text-center">Phone number</th>
        <th class="text-center">Prescription</th>
        <th class="text-center">Delivery Address</th>
        <th class="text-center">Note</th>
        <th class="text-center">Ordered Date and Time</th>
        <th class="text-center">Delivered Date and Time</th>
        <th></th>

        </tr>
      </thead>

      <tbody>
        <?php
          $sql_deliver="SELECT * FROM delivered_orders";
          $deliver_query=$db->query($sql_deliver);
          while($deliver_array=mysqli_fetch_assoc($deliver_query)):
            
           
           
         ?>
        <td><?php echo $deliver_array['id']; ?> </td>
        <td><?php echo $deliver_array['order_id']; ?> </td>
        <td><?php echo $deliver_array['patient']; ?> </td>
        <td> <?php echo $deliver_array['email']; ?> </td>
        <td> <?php echo $deliver_array['phonenumber']; ?> </td>
        <td> <?php echo $deliver_array['prescription']; ?> </td>
        <td> <?php echo $deliver_array['delivery_address']; ?> </td>
        <td> <?php echo $deliver_array['note']; ?> </td>
        <td> <?php echo $deliver_array['ordered_date']; ?> </td>
        <td><?php echo $deliver_array['delivered_date']; ?> </td>
        </tr>
       <?php endwhile; ?>
      </tbody>
    </table>
</div>


 <?php
 include 'include/footer.php';
  ?>
