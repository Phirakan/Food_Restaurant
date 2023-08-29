<?php

session_start();
require_once '../config/conn_db.php'; // Added semicolon at the end 


if (isset($_POST['update_qr'])) {
    $id = $_POST['table_id'];
    $table_number = $_POST['table_number'];
    $img = $_FILES['img'];
    $img2 = $_POST['img2'];
    $upload = $_FILES['img']['name'];

    if ($upload != '') {
        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
        $filePath = '../upload/' . $fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img['error'] == 0) {
                move_uploaded_file($img['tmp_name'], $filePath);
            }
        }
    } else {
        $fileNew = $img2;
    }

    $sql = $conn->prepare("UPDATE tables SET table_number = :table_number, img = :img WHERE table_id = :table_id");

    $sql->bindParam(":table_number", $table_number);
    $sql->bindParam(":img", $fileNew);
    $sql->bindParam(":table_id", $id);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "updated successfully";
        header("location: ../Page/qrcode_gen.php");
    } else {
        $_SESSION['error'] = "Data has not been updated successfully";
        header("location: ../Page/qrcode_gen.php");
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Data</h1>
        <hr>
        <form action="table-edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['table_id'])) {
                $id = $_GET['table_id'];
                $sql = "SELECT * FROM tables WHERE table_id = $id";
                $stmt = $conn->query($sql);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $rs = $data;
            }
            ?>
            <div class="mb-3">
            <label for="table_id" class="col-form-label">ID:</label>
                <input type="text" readonly value="<?php echo $rs['table_id']; ?>" required class="form-control" name="table_id">
                
                <label for="table_number" class="col-form-label"> Table_number:</label>
                <input type="text" value="<?php echo $rs['table_number']; ?>" required class="form-control" name="table_number">
                <input type="hidden" value="<?php echo $rs['img']; ?>" required class="form-control" name="img2">
            </div>
           
           
            <div class="mb-3">
                <label for="img" class="col-form-label">Image:</label>
                <input type="file" class="form-control" id="imgInput" name="img">
                <img width="100%" src="uploads/<?php echo $rs['img']; ?>?<?php echo time(); ?>" id="previewImg" alt="">

            </div>
            <hr>
            <a href="../Page/qrcode_gen.php" class="btn btn-secondary">Go Back</a>
            <button type="submit" name="update_qr" class="btn btn-primary">Update</button>
        </form>
    </div>

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