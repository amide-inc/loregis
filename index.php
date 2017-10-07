<?php require_once 'core/Init.php';
if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user =  new User();
if($user->isLoggedIn()) {
	?>
	<p>hello <a href="profile.php?user=<?php echo $user->data()->username; ?>"><?php echo $user->data()->name; ?></a></p>
	<ul>
   	   <li><a href="logout.php">logout...</a></li>
   	   <li><a href="update.php">Update details</a></li>
         <li><a href="changepassword.php">Change Password</a></li>
   </ul>
	<?php

   if($user->hasPermission('admin')) {
      echo 'You are a admin';
   }
} else {
?>
   <ul>
   	   <li>You should have <a href="login.php">log in</a> or <a href="register.php">registetr</a> first</li>
   </ul>
<?php

}