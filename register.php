<?php
include("connection.php");
session_start();

// search user that exists
function handleUsers($username)
{
  $OConnection = new Connection();
  $users = $OConnection->querySQL("SELECT * FROM users");

  foreach ($users as $u) {
    if ($u["username"] == $username) {
      return 2;
    }
  }
}


$account__created = "";
$error = "";

if ($_POST) {
  if ($_POST["username"] == "" || $_POST["password"] == "") {
    $error = "Please fill fields correctly";
  } else if (handleUsers($_POST["username"]) == 2) {
    $error = "User already exists";
  } else {
    $time = new DateTime();
    $username = $_POST["username"];
    $password = $_POST["password"];
    $tmpUserImageName = $_FILES["user_image"]["tmp_name"];
    if ($tmpUserImageName) {
      $userImageName = $time->getTimestamp() . "_" . $_FILES["user_image"]["name"];
      move_uploaded_file($tmpUserImageName, "images/profile_pictures/" . $userImageName);
    }

    $OConnection = new Connection();
    $sql = "INSERT INTO `users` (`username`, `password`, `user_image`) VALUES('$username', '$password', '$userImageName')";
    $OConnection->executeSQL($sql);

    $account__created = "Account created succesfully";
    header("location: " . $_SERVER["PHP_SELF"] . "?created=" . urlencode($account__created));
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Register</title>
</head>

<body>
  <form class="form__container" enctype="multipart/form-data" action="register.php" method="post">
    <main class="form__principal">
      <?php
      if ($error != "") {
        print '<div class="form__error">' . $error . '</div>';
      }
      if (isset($_GET["created"])) {
        print '<div class="form__success">' . $_GET["created"] . '</div>';
      }
      ?>
      <div class="form__logo">
        <img src="./images/diamond.png" alt="">
        <h2>Register account</h2>
      </div>
      <div class="form__inp">
        <input type="text" placeholder="Username" name="username" id="username">
        <input type="password" placeholder="Password" name="password" id="">
        <i id="upload__icon" class='bx bx-upload'></i>
        <input type="file" name="user_image" style="display: none;" id="upload__input">
        <img id="preview__image" style="display: none;" src="" alt="">
        <button href="" type="submit">Register now</button>
      </div>
      <p>I already have an account <a id="signin__button" href="login.php">Login in</a></p>
    </main>
  </form>
</body>

<script>
  const previewImage = document.getElementById("preview__image");
  const uploadInput = document.getElementById("upload__input");
  const uploadIncon = document.getElementById("upload__icon");

  uploadIncon.addEventListener("click", function() {
    uploadInput.click();
  })

  uploadInput.addEventListener("change", function() {
    const file = uploadInput.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
      previewImage.src = e.target.result;
      previewImage.style.display = "block";
    };

    reader.readAsDataURL(file);
  });
</script>

</html>