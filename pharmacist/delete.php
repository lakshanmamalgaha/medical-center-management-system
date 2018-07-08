<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
  if(isset($_GET['delete'])){
    $did=(int)$_GET['delete'];

    $db=DB::getInstance();
    $db->delete('pharmacy',array(
      'id',
      '=',
      $did
    ));
    Session::flash('success', 'Successfully Deleted.');
    Redirect::to('stock.php');

  }
}else{
  Redirect::to('../login.php');
}
