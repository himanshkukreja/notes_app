<?php
session_start();
if(!isset($_SESSION['loggedin'])||$_SESSION['loggedin']!=true){
  header("location: login.php");
  echo "signin first";
  exit;
}
?>
<?php
//Connecting To a Database server
$servername= "localhost";
$username= "root";
$password="";
$database="notes";
$insert=false;
$update=false;
$delete=false;

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn)
die("Sorry we failed to connect. ". mysqli_connect_error());


$username= strtolower( $_SESSION['username']);


$sql=  "CREATE TABLE `$username` ( `sno` INT(11) NOT NULL AUTO_INCREMENT, `title` VARCHAR(100) NOT NULL , `description` VARCHAR(100) NOT NULL , `dt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`sno`)) ENGINE = InnoDB;";
$result = mysqli_query($conn, $sql);


if(isset($_GET['delete']))
{
  
  // deleting the record

$sno =  $_GET['delete'];
$sql="DELETE FROM `$username` WHERE `sno` = $sno";
$result= mysqli_query($conn, $sql);

$delete=true; 

}
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST["snoEdit"]))
  {
   // update the record
  $sno = $_POST["snoEdit"];
  $title = $_POST['titleEdit'];
  $description = $_POST['descriptionEdit'];
    
   $sql=" UPDATE `admin` SET `title` = '$title' , `description`= '$description' WHERE `$username`.`sno` = $sno";
   $result= mysqli_query($conn, $sql);

  //  if($result)
  //  {}
  //  else
  //  echo "Can't update due to error-->" . mysqli_error($conn);

  //  $update=true; 
  }
  else{
    // inserting the record
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $sql= "INSERT INTO `$username` (`title`, `description`) VALUES ('$title', '$description')";

    $result= mysqli_query($conn, $sql);
    
    if($result)
    $insert=true;
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

    <title>Welcome - <?php $_SESSION['username']?></title>
  </head>  
  <body>
   
  <?php require './partials/_nav.php' ?>

  <?php
  if($insert)
  {
    echo
    '<div class="alert alert-success  alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note have been added successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>' ;
  }
  if($update)
  {
    echo
    '<div class="alert alert-success  alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note have been update successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>' ;
  }
  if($delete)
  {
    echo
    '<div class="alert alert-success  alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note have been deleted successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>' ;
  }
  
  
  ?>
   
   <div class="container my-4">
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading"> Welcome- <?php echo $_SESSION['username']; ?></h4>
  <p>How are you doing! Welcome to our iNotes Web Application. Here you are able to add your important notes to your unique database. Along with addition of notes this app can read, update and delete your notes.  </p>
  <hr>
  <!-- <p class="mb-0">Whenever you want to log out just click on this button:- <a href="http://inotesmaking.ml/logout.php"><button class="btn btn-primary btn-sm">Log Out</button></a> <br><hr> -->
  <h3>Thankyou! and Enjoy using this app</h3></p>
</div></div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="http://inotesmaking.ml/index.php" method="post">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group">
           
            <label for="title">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" aria-describedby="emailHelp" name="titleEdit">
    
          </div>
    
          <div class="form-group">
            <label for="desc">Note Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  
  
  <div class="container my-4">
  <h2>Add a Note</h2>
    <form action="http://inotesmaking.ml/index.php" method="post">
      <div class="form-group">
       
        <label for="title">Note Title</label>
        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">

      </div>

      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S. No</th>
          <th scope="col">Title</th>
          <th scope="col">description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      
        <?php
    $sql= "SELECT * FROM `$username`";
    $result= mysqli_query($conn,$sql);
    $sno=0;
    while($row= mysqli_fetch_assoc($result))
    {     $sno=$sno+1;
          echo " <tr>
          <th scope='row'>" .$sno . "</th>
          <td>".$row['title']."</td>
          <td>".$row['description']."</td>
          <td> <button class='edit btn btn-primary btn-sm' id=".$row['sno'].">Edit</button>
                 <button class='delete btn btn-primary btn-sm'  id=d".$row['sno'].">Delete</button>
          </td>
          </tr>";
        }?>

   
      </tbody>
    </table>
    
  </div>
  <hr>
</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

   <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
      } );
</script>
<script>
  edits= document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      console.log("edit ");
      tr= e.target.parentNode.parentNode;
      title= tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
      console.log(title,description);
      titleEdit.value = title;
      descriptionEdit.value = description;
      snoEdit.value = e.target.id;
      console.log(e.target.id);
      $('#editModal').modal('toggle');
    })
  })
  deletes= document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      console.log("delete ");
      tr= e.target.parentNode.parentNode;
      title= tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
     sno= e.target.id.substr(1,);
     if(confirm("Press OK To permanently delete this record!")){
      window.location = `http://inotesmaking.ml/index.php?delete=${sno}`;
      
     }
    })
  })
 
</script>

</body>

</html>
