<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <link rel="stylesheet" href="../res/css/login.css" />  
</head>
<body>
  <form name="lo" onsubmit="return validateForm()" action="../controllers/auth/logincont.php" method="post">
    <h2>Login</h2>
    <div class="container">
      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
      <button type="submit">Login</button>
      <input type="checkbox" checked="checked"> Remember me
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>

  <script>
    function validateForm() {
      var x = document.forms["myForm"]["username"].value;
      var y = document.forms["myForm"]["password"].value;
      if (x == "" || y == "") {
        alert("Username and Password must be filled out");
        return false;
      }
    }
  </script>
</body>
</html>
