<?php include("header.php"); ?>
<?php include("footer.php"); ?>


<?php
$newPostMessage = "";
$loggedUser = $_SESSION["logged_user_data"][0];
if ($_POST) {
  $postDescription = $_POST["post-description"];
  $postImage = $_FILES["post-image"];

  if ($postImage["tmp_name"]) {
    // save picture
    $time = new DateTime();
    $tmpImagePost = $_FILES["post-image"]["tmp_name"];
    $imagePostName = $time->getTimestamp() . "_post_" . $loggedUser["username"] . "_" . $_FILES["post-image"]["name"];
    move_uploaded_file($tmpImagePost, "images/" . $imagePostName);
  }

  $postImageValidation = $postImage["tmp_name"] ? $imagePostName : '';

  // load in db
  $OConnection = new Connection();
  $sql = "INSERT INTO posts (`post_user`, `post_image`, `post_description`, `id_user`) 
  VALUES ('" . $loggedUser["username"] . "', '" . $postImageValidation . "', '" . $postDescription . "', '" . $loggedUser["id"] . "')";
  $OConnection->executeSQL($sql);
  $newPostMessage = "Post created successfully";
}

$OConnection = new Connection();
$postssql = "SELECT * FROM posts INNER JOIN users ON posts.id_user = users.id ORDER BY posts.id DESC";
$posts = $OConnection->querySQL($postssql);

?>

<div class="index">
  <div class="left__index"></div>

  <div class="center__index">
    <form action="index.php" method="post" enctype="multipart/form-data" class="new__post">
      <div class="post__author">
        <?php if ($user[0]["user_image"]) {
          print '<img src="./images/profile_pictures/' . $user[0]["user_image"] . '" alt="" />';
        } else {
          print '<img src="./images/profile_pictures/no-profile-picture.svg" alt="" />';
        } ?>
        <input placeholder="New post" name="post-description" type="text">
      </div>
      <div class="newpost__options">
        <i class='bx bx-message-detail'></i>
        <i class='bx bx-image-alt' id="upload__icon"></i>
        <input type="file" name="post-image" style="display: none;" id="file__input">
      </div>
      <img style="display: none;" id="new__post__img" src="" alt="">
      <i style="display: none;" id="delete__new__post__image" class='bx bx-trash'></i>
      <input id="submit__post" type="submit" value="Post">
    </form>

    <?php if ($newPostMessage != "") {
      print '
      <div id="post__notification">
        <div></div>
        Post created successfully
        <div><i id="delete__not" class="bx bx-x"></i></div>
      </div>
      ';
    } ?>

    <?php foreach ($posts as $p) { ?>
      <article class="post__container">
        <!-- <div class="post__options__dots">
          <i id="post__options__icon" class='bx bx-dots-horizontal-rounded'></i>
          <ul id="option__post__list" style="display: block">
            <li>option1</li>
            <li>option2</li>
            <li>option3</li>
          </ul>
        </div> -->
        <hr id="header__hr">
        <div class="post__header">
          <div class="user__data">
            <?php if ($p["user_image"]) {
              print '<img src="./images/profile_pictures/' . $p["user_image"] . '" alt="">';
            } else {
              print '<img src="./images/profile_pictures/no-profile-picture.svg" alt="">';
            } ?>
            <p>@<?php echo $p["post_user"] ?></p>
          </div>
          <p id="btn__follow">+ Follow</p>
        </div>
        <p><?php echo $p["post_description"] ?></p>
        <?php if ($p["post_image"] != "") {
          print '<img src="images/' . $p["post_image"] . '" alt="">';
        } else {
          print '';
        } ?>
        <hr id="comment__hr">
        <div class="post__options">
          <div class="like"><i class='bx bx-like'></i>Like</div>
          <div class="comment"><i class='bx bx-message-square-dots'></i>Comment</div>
          <div class="repost"><i class='bx bx-repost'></i>Repost</div>
          <div class="send"><i class='bx bx-send'></i>Send</div>
        </div>
      </article>
    <?php } ?>
  </div>

  <div class="right__index"></div>
</div>

<!-- js logic -->

<script>
  const fileInput = document.getElementById("file__input");
  const uploadIcon = document.getElementById("upload__icon");
  const newPostImage = document.getElementById("new__post__img");
  const deleteNewPostImage = document.getElementById("delete__new__post__image");


  uploadIcon.addEventListener("click", function() {
    fileInput.click();
  })

  fileInput.addEventListener("change", function() {
    const file = fileInput.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
      newPostImage.src = e.target.result;
      newPostImage.style.display = "block";
      deleteNewPostImage.style.display = "block";
    };

    reader.readAsDataURL(file);
  })

  deleteNewPostImage.addEventListener("click", function() {
    newPostImage.src = "";
    newPostImage.style.display = "none";
    deleteNewPostImage.style.display = "none";
    fileInput.value = null;
  })

  /* const postNotification = document.getElementById("post__notification");
  const deleteNotification = document.getElementById("delete__not");
  deleteNotification.addEventListener("click", function() {
    postNotification.style.display = "none";

    const postOptionsIcon = document.getElementById("post__options__icon");
    const optionPostList = document.getElementById("option__post__list");

    postOptionsIcon.addEventListener("click", function() {
      optionPostList.style.display = "block";
    })

  }) */
</script>