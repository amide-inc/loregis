<?php
 require_once "core/Init.php";
 if(Input::exists()){
  if(Token::check(Input::get('token'))) {
   $validate  = new validate();
   $validation = $validate->check($_POST , array(
      'username' => array(
      	   'required' => true,
      	   'min' => 2,
      	   'max' => 20,
      	   'unique' => 'users'
      	),
      'password' => array(
           'required' => true,
           'min' => 6
        ),
      'password_again' => array(
          'required' => true,
          'matches'  => 'password'
        ),
      'name'    => array(
          'required' => true,
          'min' => 2,
          'max' => 20
        )
   	));
   if($validate->passed()) {
      $user = new User();

      $salt = Hash::salt(32);

      try{
       $user->create(array(
        'username' => Input::get('username'),
        'password' => Hash::make(Input::get('password'), $salt),
        'salt'     => $salt,
        'name'     => Input::get('name'),
        'joined'   => date('Y-m-d H:i:s'),
        'group'    => 1
        ));

       Session::flash('home' , 'You have been registered and can now login !');
       Redirect::to(404);
      }catch(Exception $e) {
        die($e->getMessage());
      }

   }else{
   	 foreach ($validate->errors() as $error) {
       echo $error . '<br>';
     }
   }
 }
}
?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username"  value="<?php echo escape(Input::get('username')); ?>" id="username" autocomplete="off">
	</div>
	<div class="field">
		<label for="password">Password </label>
		<input type="password" name="password"  id="password" autocomplete="off">
	</div>
    <div class="field">
    <label for="password_again">Password </label>
    <input type="password" name="password_again"  id="password_again" autocomplete="off">
  </div>
    <div class="field">
    <label for="name"> Full Name</label>
    <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name" autocomplete="off">
  </div>
    <div class="field">
    
   <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  </div>
	<div class="field">
		
		<input type="submit"  value="register">
	</div>

</form>
