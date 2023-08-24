<?php 

    session_start();
    require_once '../config/conn_db.php'; // Added semicolon at the end
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM food WHERE ID = $delete_id");
        $deletestmt->execute();

        if ($deletestmt) {
            echo "<script>sweetalert2('Data has been deleted successfully');</script>";
            $_SESSION['success'] = "Data has been deleted succesfully";
            header("refresh:1; url=menu.php");
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>menu</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  

<div class="modal fade" id="foodmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form action="../Page/insert.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="foodname" class="col-form-label"> Name:</label>
                    <input type="text" required class="form-control" name="foodname">
                </div>
                <div class="mb-3">
                    <label for="price" class="col-form-label">Price:</label>
                    <input type="text" required class="form-control" name="price">
                </div>
                
                <div class="mb-3">
                    <label for="img" class="col-form-label">Image:</label>
                    <input type="file" required class="form-control" id="imgInput" name="img">
                    <img loading="lazy" width="100%" id="previewImg" alt="">
                </div>
                <div class="mb-3">
                    <label for="img" class="col-form-label">quantity:</label>
                    <input type="file" required class="form-control" id="imgInput" name="img">
                    <img loading="lazy" width="100%" id="previewImg" alt="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
        
        </div>
    </div>
    </div>


<div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <h1>menu</h1>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#foodmodal">ADD</button>
      </div>
    </div>
      <hr>
      <?php if (isset($_SEESION['success']))  {?>
        <div class="alert alert-success" >
          <?php 
          echo $_SEESION['success'];
          unset($_SEESION['success']);
           ?>
        <?php } ?>
        <?php if (isset($_SEESION['error']))  {?>
        <div class="alert alert-danger" >
          <?php 
          echo $_SEESION['error'];
          unset($_SEESION['error']);
           ?>
        <?php } ?>

        <!-- ตาราง -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">NO.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Img</th>
                    <th scope="col">quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $conn->query("SELECT * FROM food");
                    $stmt->execute();
                    $food = $stmt->fetchAll();

                    if (!$food) {
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    } else {
                    foreach($food as $food)  {  
                ?>
                    <tr>
                        <th scope="row"><?php echo $food['ID']; ?></th>
                        <td><?php echo $food['foodname']; ?></td>
                        <td><?php echo $food['price']; ?></td>
                        
                        <td width="250px"><img class="rounded" width="100%" src="../upload/<?php echo $food['img']; ?>" alt=""></td>
                        <td>
                            <a href="../Page/edit_menu.php?id=<?php echo $food['ID']; ?>" class="btn btn-warning">Edit</a>
                            <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $food['ID']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                        <td><?php echo $food['quantity']; ?></td>
                    </tr>
                <?php }  } ?>
            </tbody>
            </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

    </script>
</body>
</html>