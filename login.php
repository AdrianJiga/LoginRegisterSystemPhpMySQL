<?php
  require_once 'includes/header.php';
?>
<div>
  <h1>Log in</h1>
  <p>No account?<a href="register.php">Register here!</a></p>

  <form action="" method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">LOGIN</button>
  </form>
</div>
<?php
  require_once 'includes/footer.php';
?>
