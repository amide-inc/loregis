<?php
require_once 'core/Init.php';

$user = new User();
if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}



if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new validate();
	  $validation = $validate->check($_POST, array(
          'current_password' => array(
              'required' => true,
              'min' => 6
          	),
          'new_password' => array(
             'required' => true,
              'min' => 6
          	),
          'new_password_again' => array(
          	 'required' => true,
              'min' => 6,
              'matches' => 'new_password'
             )
	  	));

	  if($validate->passed()) {
       
           	try {

	  	   if(Hash::make(Input::get('current_password'), $user->data()->salt) !== $user->data()->password) {
	  	   	echo 'your current password in not currect';
	  	   }else {
	  	   	$salt = Hash::salt(32);
	  	   	$user->update(array(
                
                'password'=> Hash::make(Input::get('new_password'), $salt),
                'salt' => $salt,
	  	   		));

	  	   		Session::flash('home' , 'your password has been changed');
	  		    Redirect::to('index.php');
	  	   }

	  	}catch(Exception $e) {
         die($e->getMessage());

	  	}

	  } else {
	  	  foreach ($validation->errors() as $error) {
	    	echo $error , '<br>';
	    }
	  }
         
	}
}
?>

<form action="" method="post">
	<div class="field">
		<label for="current_password">Current Password</label>
		<input type="password" name="current_password"  autocomplete="off">
	</div>
	<div class="field">
		<label for="new_password">New Password</label>
		<input type="password" name="new_password"  autocomplete="off">
	</div>
	<div class="field">
		<label for="new_password_again">Repeat New Password</label>
		<input type="password" name="new_password_again"  autocomplete="off">
	</div>
  
     <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  </div>
	<div class="field">
		
		<input type="submit"  value="change password">
	</div>

</form>