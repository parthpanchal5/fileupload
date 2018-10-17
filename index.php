<?php
  // Connection
  $conn = mysqli_connect("localhost", "parth", "root", "fileupload");

  if(isset($_POST['upload'])){
    $image = $_FILES['image']['name'];
    $caption = $_POST['caption'];
    $filetmpname = $_FILES['image']['tmp_name'];

    $directory = "img/".basename($image);
    
    $sql = "INSERT INTO img (image, caption) VALUES ('$image', '$caption')";
    mysqli_query($conn, $sql);

    if (move_uploaded_file($filetmpname, $directory)) {
      $msg = "Image uploaded successfully";
    }else{
      $msg = "Failed to upload image";
    }
    header("Location:index.php");
    exit;
  }
  $sql = "SELECT * FROM img";
  $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
  <title>File Uploading</title>
</head>
<body>
  <div class="container mt-2 pt-2">
    <div class="row">
      <div class="col-md-3"></div>
      <?php while ($row = mysqli_fetch_array($result)) { ?>
        <div class="col-md-6">
          <div class="card border-primary ">
            <div class="card-body">
              <img src="img/<?php echo $row['image']; ?>" alt="" style="height: 520px;" class="card-img-top">
              <p class="card-text p-3 mt-3 text-primary"><?php echo $row['caption']; ?></p>
              <div class="card-footer">
                Posted on: <?php echo $row['created_at']; ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <div class="col-md-3"></div>
    </div>
  </div>
  <div class="container mt-3 pt-3">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <form action="index.php" enctype="multipart/form-data" method="POST">
          <div class="form-group">
            <input type="file" name="image" class="form-control">  
          </div>
          <div class="form-group mt-5">
            <input type="text" name="caption" placeholder="Caption for img" class="form-control mb-4 pb-5">
          </div>
          <input type="submit" value="Upload" name="upload" class="btn btn-primary btn-xl btn-block">
        </form>  
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</body>
</html>