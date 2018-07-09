<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Pharmacist: Stock';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_pharmacist.php';
$db=DB::getInstance();
if(isset($_GET['delete'])){
          $uid=(int)$_GET['delete'];
          //echo $uid;
                  $db->delete('pharmacy',array(
                    'id',
                      '=',
                      $uid));
                  Session::flash('success', 'Successfully Deleted.');
                  Redirect::to('stock.php');
 
            
          }


?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Good Life</a>
			</li>
			<li class="breadcrumb-item active">Stocks</li>
		</ol>
    <?php if(Session::exists('success'))
    {
    	echo '<p class="text-success">' .Session::flash('success').'</p>';
    } ?>
    <div class="">
  		<a class="btn btn-primary btn-block" href="additem.php?add">Add New Item</a>
  	</div>

  </hr>
  	<div class="">
  		<hr>
    <form class=""method="post">
  		<div class="form-group">
              <div class="form-row">
                <div class="col-md-8">

                  <input class="form-control" id="search" type="text" aria-describedby="nameHelp" placeholder="Enter item code" name="search">
                </div>
                <div class="col-md-2">

                  <input class="form-control btn btn-info btn-block" type="submit" aria-describedby="nameHelp" placeholder="Search" value="search">
                </div>
              </div>
            </div>
    </form>

   <hr>

  </div>
    <div class="">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Code</th>
        <th>Description</th>
        <th>Pack Size</th>
        <th>Unit Price</th>
        <th>Active Grades</th>
        <th>Sup Code</th>
        <th>Supplier</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $Items=$db->get('pharmacy',array(
        'id',
        '>',
        0
      ))->results();
      if(isset($_POST['search']) && !empty($_POST['search'])){
        $searchquery=$_POST['search'];
        $searchquery=preg_replace("#[^0-9a-z]#i","",$searchquery);
        $query=$db->get('pharmacy',array('code','=',(int)$searchquery))->results();
       /* $query1=$db->get('pharmacy',array('description','=',$searchquery))->results();
          */
        $count=sizeof($query);
        if($count==0){
          echo 'No search results found!';
        }else {

      foreach ($query as $item) {
        # code.
       ?>
      <tr>
          <td><?php echo $item->code; ?></td>
          <td><?php echo $item->description; ?></td>
          <td><?php echo $item->packsize; ?></td>
          <td><?php echo $item->unit_price; ?></td>
          <td><?php echo $item->active_grades; ?></td>
          <td><?php echo $item->sup_code; ?></td>
          <td><?php echo $item->supplier; ?></td>
          <td> <a href="updateitem.php?update=<?php echo $item->id; ?>" class="btn btn-info btn-sm">Update</a>
          <a href="stock.php?delete=<?php echo $item->id; ?>" class="btn btn-danger btn-sm" >Delete</a></td>
         </tr>
    <?php }}}
    else{
      foreach ($Items as $item) {
        ?>
        <tr>
          <td><?php echo $item->code; ?></td>
          <td><?php echo $item->description; ?></td>
          <td><?php echo $item->packsize; ?></td>
          <td><?php echo $item->unit_price; ?></td>
          <td><?php echo $item->active_grades; ?></td>
          <td><?php echo $item->sup_code; ?></td>
          <td><?php echo $item->supplier; ?></td>
          <td> <a href="updateitem.php?update=<?php echo $item->id; ?>" class="btn btn-info btn-sm">Update</a>
					<a href="stock.php?delete=<?php echo $item->id; ?>" class="btn btn-danger btn-sm">Delete</a></td>
        </tr>
        <?php
      }} ?>


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
