<?php
session_start();
require_once "config.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: register.php");
    exit;
}

$first_name = $last_name = $username = $email = "";
$first_name_err = $last_name_err = $email_err = $username_err = "";
$user_id = $_SESSION["id"];


$getsql = "SELECT first_name, last_name, username, email FROM users WHERE id = '$user_id'";
$result = $link->query($getsql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $username = $row['username'];
      $email = $row['email'];
  }
} else {
  echo "0 results";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!preg_match("/^[A-Za-z]+$/", $_POST['first_name'])){
        $first_name_err = "Only letters allowed";
    } else {
        $sql = "UPDATE users
          SET first_name = (?)
          WHERE id = '$user_id'";
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($stmt, "s", $_POST["first_name"]);
        if(mysqli_stmt_execute($stmt));{
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_close($stmt);
        }
      }

    if (!preg_match("/^[A-Za-z]+$/", $_POST['last_name'])){
      $last_name_err = "Only letters allowed";
    } else {
      $sql = "UPDATE users
        SET last_name = (?)
        WHERE id = '$user_id'";
      $stmt = mysqli_prepare($link,$sql);
      mysqli_stmt_bind_param($stmt, "s", $_POST["last_name"]);
      if(mysqli_stmt_execute($stmt));{
          mysqli_stmt_store_result($stmt);
          mysqli_stmt_close($stmt);
        }
      }
      if (!preg_match("/^[A-Za-z0-9]+$/", $_POST['username'])){
        $username_err = "Only letters and numbers allowed";
      } else {
        $sql = "UPDATE users
          SET username = (?)
          WHERE id = '$user_id'";
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($stmt, "s", $_POST["username"]);
        if(mysqli_stmt_execute($stmt));{
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_close($stmt);
          }
        }
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format";
      } else {
        $sql = "UPDATE users
          SET email = (?)
          WHERE id = '$user_id'";
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($stmt, "s", $_POST["email"]);
        if(mysqli_stmt_execute($stmt));{
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_close($stmt);
        }
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoryMap/Account Page/Change password</title>
    <link rel="stylesheet" href="accountpage.css">
</head>
<body>
  <div id="main">
  <div class="logo_wrapper">
      <a href="accountpage.php"> <img src="img/back.svg" alt="logo" height="50"> </a>
      <a href="accountpage.php"> <img src="stoymaplogo2.png" alt="logo" height="70" style="float:right";> </a>
      </div>
  <div id="header">
    <header><?php echo $username?>'s Account</header>	
  </div>
  <div id="navigation">
    <nav>
    </nav>
  </div>
  <div id="content">
    <h1> Your information </h1>
  <div class="container">
    <div class="form_wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="input_box_wrapper">
        <label for="firstname">First Name:</label>
        <input type="text" class="input_box" name="first_name" value="<?php echo $first_name?>">
      </div>
      <div>
        <span class="error_msg"><?php echo $first_name_err; ?></span>
      </div>
      <div class="input_box_wrapper">
        <label for="lastname">Last Name:</label>
        <input type="text" class="input_box" name="last_name" value="<?php echo $last_name?>">
      </div>
      <div>
        <span class="error_msg"><?php echo $last_name_err; ?></span>
      </div>
      <div class="input_box_wrapper">
        <label for="username">Username:</label>
        <input type="text" class="input_box" name="username" value="<?php echo $username?>">
      </div>
      <div>
        <span class="error_msg"><?php echo $username_err; ?></span>
      </div>
      <div class="input_box_wrapper">
        <label for="email">E-Mail:</label>
        <input type="text" class="input_box" name="email" value="<?php echo $email?>">
      </div>
      <div>
        <span class="error_msg"><?php echo $email_err; ?></span>
      </div>
        <button class="submit_button" name="Submit" type="submit" value="Submit">Submit</button>
    </form>
</div>
      <div id="footer">
          <footer>
              <p><a href="contact.html"> Contact us!</li> </a></p>    
          </footer>
      </div>
      </div>
    </div>
  </body>
</html>