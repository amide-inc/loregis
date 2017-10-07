<?php
require_once 'core/Init.php';

  if(Input::exists()) {
  	if(Token::check(Input::get('token'))){
  		$validate = new validate();
  		$validation= $validate->check(array(
             'username' => array('required' => true),
             'password' => array('required'=> true)
  	    ));

  	    if($validation->passed()) {
          $user = new User();

          $remember  = (Input::get('remember') === 'on') ? true : false;
          $login = $user->login(Input::get('username'), Input::get('password') ,  $remember = false);
  	          
          if($login) {
  	      	Redirect::to('index.php');
  	      }else{
  	      	echo 'Sorry, login in failed';
  	      }
  	    } else {
         foreach($validation->errors as $error) {
         	echo $error .'<br>';
         }
  	    }
  	}
  }

?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autcomplete="off">
	</div>
	<div class="field">
		<label for="password">Passsword</label>
		<input type="password" name="password" id="password" autcomplete="off">
	</div>

  <div class="field">

    <input type="checkbox" name="remember" id="remember">
    <label for="remember">Remember me</label>
  </div>
  <div class="field">
    
   <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  </div>
	
		
		<input type="submit"  value="login">
</form>
