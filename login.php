<?php
 $login = false;
 $showError = false;
 if($_SERVER["REQUEST_METHOD"]=="POST")
 {
   
    include './partials/_dbconnect.php';

    $username = $_POST["username"];
     $password = $_POST["password"];
    
     //$sql= "Select * from users where username = '$username' AND password = '$password' ";
     $sql= "Select * from users_iNotes where username = '$username'";
     $result= mysqli_query($conn,$sql);
    
     $num= mysqli_num_rows($result);
     if($num==1)
     {
          while( $rows= mysqli_fetch_assoc($result))
          {
            if(password_verify($password, $rows['password'])){
              $login = true;
              session_start();
              $_SESSION['loggedin'] = true;
              $_SESSION['username'] = $username;
              header("location: index.php");
            }
            else{
              $showError = true;
              }
          }
    }
     else{
         $showError = true;
         }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
  <?php require './partials/_nav.php' ?>
<?php
if($login)
{
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> You are Logged-In
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
if($showError)
{
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Invalid Credentials <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}

?>
 <div class="container my-3">
 <h1 class="text-center my-2">Login to iNotes</h1>

 <form action="http://inotesmaking.ml/login.php" method="post">
  <div class="form-group">
    <label for="Username">User Name</label>
    <input type="text" class="form-control" id="Username" aria-describedby="emailHelp" name="username">
    
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
 
 
  <button type="submit" class="btn btn-primary">Log In</button>
</form>
 </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>