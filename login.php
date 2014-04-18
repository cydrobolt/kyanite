<?php
@(include('config.php')) or header('Location:setup.php');
require_once 'req.php';
require_once 'header.php';

echo '<h1>Login</h1><br>';
echo '<form action="loginproc.php" method="post" accept-charset="UTF-8">
      <input id="user_username" style="margin-bottom: 15px;" type="text" name="username" placeholder=\'Username\' size="30" class="form-control">
      <input id="user_password" style="margin-bottom: 15px;" type="password" name="password" placeholder=\'Password\' size="30" class="form-control">
      <input class="btn btn-success form-control" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="login" value="Sign In">
      <br><br>
      </form>';

require_once 'footer.php';
