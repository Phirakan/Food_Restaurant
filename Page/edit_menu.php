<?php

session_start();
require_once '../config/conn_db.php'; // Added semicolon at the end 


if (isset($_POST['update'])) {
    $id = $_POST['ID'];
    $foodname = $_POST['foodname'];
    $price = $_POST['price'];

    $img = $_FILES['img'];

    $img2 = $_POST['img2'];
    $upload = $_FILES['img']['name'];

    if ($upload != '') {
        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt; // rand function create the rand number 
        $filePath = '../upload/' . $fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img['error'] == 0) {
                move_uploaded_file($img['tmp_name'], $filePath);
            }
        }
    } else {
        $fileNew = $img2;
    }

    $sql = $conn->prepare("UPDATE food SET foodname = :foodname, price = :price, quantity = :quantity, img = :img WHERE ID = :ID");
    $sql->bindParam(":foodname", $foodname);
    $sql->bindParam(":price", $price);
    $sql->bindParam(":img", $fileNew);
    $sql->bindParam(":quantity", $quantity);
    $sql->bindParam(":ID", $id);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "updated successfully";
        header("location: ../Page/menu.php");
    } else {
        $_SESSION['error'] = "Data has not been updated successfully";
        header("location: ../Page/menu.php");
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรายการอาหาร</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/edit-menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>

            <!-- Add the hamburger menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Right side -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav menunavbar">
                    <li class="nav-item username-layout">
                        <p class="text-username">คุณ John Doe</p>
                    </li>
                    <li class="nav-item">
                        <a href="page/order-menu.php" class="btn btn-order-atnav">ออกจากระบบ</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Navbar -->



    <div class="container-fluid edit-menu-box">
        <div class="container form-box">
            <h1>แก้ไขรายการอาหาร</h1>
            <form action="edit_menu.php" method="post" enctype="multipart/form-data">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM food WHERE ID = $id";
                    $stmt = $conn->query($sql);
                    $stmt->execute();
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $rs = $data;
                }
                ?>
                <div class="mb-3">
                    <label for="ID" class="col-form-label">ลำดับ:</label>
                    <input type="text" readonly value="<?php echo $rs['ID']; ?>" required class="form-control" name="ID">
                    <label for="foodname" class="col-form-label"> ชื่อเมนู:</label>
                    <input type="text" value="<?php echo $rs['foodname']; ?>" required class="form-control" name="foodname">
                    <input type="hidden" value="<?php echo $rs['img']; ?>" required class="form-control" name="img2">
                </div>
                <div class="mb-3">
                    <label for="price" class="col-form-label">ราคา:</label>
                    <input type="text" value="<?php echo $rs['price']; ?>" required class="form-control" name="price">
                </div>

                <div class="mb-3">
                    <label for="img" class="col-form-label">รูปภาพ:</label>
                    <input type="file" class="form-control" id="imgInput" name="img">
                    <img width="100%" src="uploads/<?php echo $rs['img']; ?>?<?php echo time(); ?>" id="previewImg" alt="">

                </div>
                <div class="btn-edit-layout">
                    <a href="../Page/menu.php" class="btn btn-back">ย้อนกลับ</a>
                    <button type="submit" name="update" class="btn btn-save">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
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