
<?php
include 'connection.php';
$insert=false;
$delete=false;
$update=false;
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Php Crud</title>
  </head>
  <body>
    


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PHP CRUD <img src="PHP-logo.svg.png" alt="" width="50px" height="50px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Service</a>
        </li>
        
        
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>


<!-- INSERT DATA/EDIT DATA /DELETE DATA  -->

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    
  if(isset($_POST['editid'])){        //  EDIT DATA
    $editid=$_POST['editid'];
    $editname=$_POST['editname'];
    $editprice=$_POST['editprice'];
    $editabout = $_POST['editabout'];
    $sql = "UPDATE `product` SET `name` = '$editname', `price` = '$editprice', `about` = '$editabout' WHERE `product`.`id` = $editid;";
     if(mysqli_query($con,$sql)){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Your Data Was Updated Successfully.</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
     }
  }else{
    $name= $_POST['name'];  // INSERT DATA
    $price= $_POST['price'];
    $about= $_POST['about'];
      $sql = "INSERT INTO `product` ( `name`, `price`, `about`) VALUES ( '$name', '$price', '$about');";
    
      if($con->query($sql)){
       $insert=true;
        // echo "Data Added ";
      }else{ 
        "error!!!";
      }
  }

}

if($_SERVER['REQUEST_METHOD']=='GET'){   //DELETE DATA
  if(isset($_GET['delete'])){
    $deleteid = $_GET['delete'];
    $sql = "DELETE FROM product WHERE `product`.`id` = $deleteid";
    if(mysqli_query($con,$sql)){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Your Data Was Deleted Successfully.</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
  }
}



?>

<?php
if($insert){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Holy guacamole!</strong> You Data Was Added Successfully...............
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<div class="container">
<form action="index.php" method="post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Product Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Price</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="price">
  </div>
  <div class="mb-3">
    <label for="about" class="form-label">About</label>
    <input type="text" class="form-control" id="about"name="about">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Add</button>
</form>
</div>


<!-- FETCH DATA /READ DATA -->

<div class="container">
  <div class="box-1-">
    <div class="box-2">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID </th>
            <th scope="col">NAME</th>
            <th scope="col">PRICE</th>
            <th scope="col">ABOUT</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
<?php
$sql = "SELECT * FROM `product`";
$result = mysqli_query($con,$sql);
 while ($row= mysqli_fetch_assoc($result)) { ?>
     <tr>
      <th scope="row"><?php echo $row['id'] ?></th>
      <td><?php echo $row['name']?></td>
      <td><?php echo $row['price'] ?></td>
      <td><?php echo  $row['about'] ?></td>
      <td>
        <button type="button" class="btn btn-warning delete">Delete</button>
        <button type="button" class="btn btn-info edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button> 
      </td>
     
    </tr>

<?php } ?>

        </tbody>
      </table>
    </div>
  </div>
</div>


         <!-- EDIT DATA MODAL  -->
<!-- Button trigger modal
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>  -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
 <div class="container">
        <form action="index.php" method="post">
          <div class="mb-3">
            <label for="editname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="editname" aria-describedby="emailHelp" name="editname">
          </div>
          <div class="mb-3">
            <label for="editprice" class="form-label">Price</label>
            <input type="text" class="form-control" id="editprice" name="editprice">
          </div>
          <div class="mb-3">
            <label for="editabout" class="form-label">About</label>
            <input type="text" class="form-control" id="editabout"name="editabout">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <input type="hidden" class="form-control" id="editid"name="editid">
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->


    <!-- Script for edit data  -->
    <script>
       edits = document.getElementsByClassName('edit');
       Array.from(edits).forEach(Element=>{
        Element.addEventListener("click",(e)=>{
         tr= e.target.parentNode.parentNode;
         $editid = tr.getElementsByTagName('th')[0].innerText;
         $editname = tr.getElementsByTagName('td')[0].innerText;
         $editprice = tr.getElementsByTagName('td')[1].innerText;
         $editabout=tr.getElementsByTagName('td')[2].innerText;

          console.log($editid,$editprice,$editname,$editabout);
          editname.value=$editname;
          editprice.value=$editprice;
          editabout.value=$editabout;
          editid.value=$editid;
        })
       })

    </script>

          <!-- Script for delete data  -->

          <script>
            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach(ele=>{
              ele.addEventListener("click",(e)=>{
                tr= e.target.parentNode.parentNode;
                deleteid= tr.getElementsByTagName('th')[0].innerText;
                console.log(deleteid);
                if(confirm("Are you sure to delete this data !!!!!!!")){
                  window.location=`/php crud/index.php?delete=${deleteid}`;
                }
              })
              
            })

          </script>



  </body>
</html>