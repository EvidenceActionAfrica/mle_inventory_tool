<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="<?php echo URL; ?>css/login.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
<style>
  .bt-logout{
    background-color: #20253a;
    color: #fff;
    border-style: none;
    padding: .5rem 1rem ;
    font-size: 16px;
    border-radius: 5px;
    margin-right: 2rem;
    text-decoration:none;
  }

  .dfaicjcsbg2{
    display:flex; 
    align-items:center; 
    justify-content:space-between; 
    gap:2rem;
  }

.google-btn {
  display: inline-block;
  background: #4285f4;
  color: white;
  padding: 10px 15px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 600;
  margin-top: 10px;
}
.google-btn:hover {
  background: #3367d6;
}
</style>

</style>
</head>
<body>
<?php  if (!empty($invalid_credentials)){echo $invalid_credentials; }?>
  <div class="container">
    <div class="split left">
      <div class="svg-container">
        <img src="<?php echo URL; ?>img/Primary-Logo_Reversed.png" alt="logo" style="width: 50%; height: 20%;">
      </div>
    </div>
    <div class="split right">
        
      <form class="login-form" method="POST" action="<?php echo URL; ?>login/loginUser">
        <div style="display: flex; align-items: center;">
          <h2>Login</h2>
          <a style="margin-left: auto;" href="<?php echo URL; ?>login/password_reset"><u>Reset Password?</u></a>
        </div>
        
        <div class="form-group">
          <label for="email">Email Address:</label>
          <input type="email" name="inputEmailAddress" id="inputEmailAddress" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" name="inputPassword" id="inputPassword" class="form-control" required>
        </div>
        <button type="submit">Login</button>
        <!-- <a href="<?php echo URL; ?>login/loginWithGoogle" class="google-btn">
            <i class="fab fa-google"></i> Sign in with Google
        </a> -->

      </form>
    </div>
  </div>
</body>

<script src="<?php echo URL;?>/js/login.js"></script>
</html>