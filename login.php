<?php
include("connection.php");
$OConnection = new Connection();
$users = $OConnection->querySQL("SELECT * FROM users");

$valid = 0;
$error = "";

if ($_POST) {
  foreach ($users as $u) {
    if ($u["username"] == $_POST["username"] && $u["password"] == $_POST["password"]) {
      $valid = 1;
    }
  }
  
  if ($valid) {
    session_start();
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["active_user"] = $_POST["username"];
    header("location: index.php");
  } else {
    $error = "Invalid username or password";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>Login</title>
</head>

<body>
  <form class="form__container" action="login.php" method="post">
    <main class="form__principal">
      <?php if ($error != "") {
        print '<div class="form__error">' . $error . "</div>";
      } ?>
      <div class="form__logo">
        <img src="./images/diamond.png" alt="">
        <h2>Login</h2>
        <h2>Simple post project</h2>
        <h5>Fastly and easy learning</h5>
      </div>
      <div class="form__inp">
        <input type="text" placeholder="Username" name="username" id="username">
        <input type="password" placeholder="Password" name="password" id="">
        <button href="" type="submit">Login now</button>
      </div>
      <p>If you not have an account <a id="signin__button" href="register.php">Sign in</a></p>
    </main>
  </form>
</body>

</html>