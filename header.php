<?php
include("connection.php");
session_start();

if (!isset($_SESSION["active_user"]) || $_SESSION["active_user"] != $_SESSION["username"]) {
  header("location: login.php");
}

$OConnection = new Connection();
$usersql = "SELECT * FROM `users` WHERE username = '" . $_SESSION["username"] . "'";
$user = $OConnection->querySQL($usersql);
$_SESSION["logged_user_data"] = $user;

$usersssql = "SELECT * FROM users";
$users = $OConnection->querySQL($usersssql);
$_SESSION["users"] = $users;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <title>Simple feed</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <nav class="navbar">
    <div class="navbar__username">
      <?php if ($user[0]["user_image"]) {
        print '<img src="./images/profile_pictures/' . $user[0]["user_image"] . '" alt="" />';
      } else {
        print '<img src="./images/profile_pictures/no-profile-picture.svg" alt="" />';
      } ?>
      <p>@<?php echo $user[0]["username"] ?></p>

      <!-- responsive nav -->
      <div class="navbar__search responsive">
        <input type="text">
        <i class='bx bx-search'></i>
      </div>

    </div>
    <div class="navbar__search">
      <input type="text">
      <i class='bx bx-search'></i>
    </div>
    <div class="navbar__messages">
      <i class='bx bx-chat'></i>
      <a style="text-decoration: none;" href="logout.php"><i id="logout" class='bx bx-log-out-circle'></i></a>
    </div>
  </nav>