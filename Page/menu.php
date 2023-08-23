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
    <title>รายการอาหาร</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
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


    <div class="container-fluid menu-box">
        <div class="modal fade" id="foodmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มรายการอาหาร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="../service/insert.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="foodname" class="col-form-label">ชื่อเมนู:</label>
                                <input type="text" required class="form-control" name="foodname">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="col-form-label">ราคา:</label>
                                <input type="text" required class="form-control" name="price">
                            </div>

                            <div class="mb-3">
                                <label for="img" class="col-form-label">รูปภาพ:</label>
                                <input type="file" required class="form-control" id="imgInput" name="img">
                                <img loading="lazy" width="100%" id="previewImg" alt="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" name="submit" class="btn btn-success">ยืนยัน</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>รายการอาหาร</h1>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <button type="button" class="btn btn-add-menu" data-bs-toggle="modal" data-bs-target="#foodmodal"><i class="bi bi-plus-circle-fill"></i>เพิ่มรายการอาหาร</button>
                </div>
            </div>
            <hr>
            <?php if (isset($_SEESION['success'])) { ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SEESION['success'];
                    unset($_SEESION['success']);
                    ?>
                <?php } ?>
                <?php if (isset($_SEESION['error'])) { ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $_SEESION['error'];
                        unset($_SEESION['error']);
                        ?>
                    <?php } ?>

                    <!-- ตาราง -->
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ชื่อเมนู</th>
                                <th scope="col">ราคา</th>
                                <th scope="col">รูปภาพ</th>
                                <th scope="col">Action</th>
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
                                foreach ($food as $food) {
                            ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $food['ID']; ?>
                                        </th>
                                        <td>
                                            <?php echo $food['foodname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $food['price']; ?>
                                        </td>

                                        <td width="250px"><img class="rounded" width="100%" src="../upload/<?php echo $food['img']; ?>" alt=""></td>
                                        <td class="action-btn-layout column">
                                            <a href="../Page/edit_menu.php?id=<?php echo $food['ID']; ?>" class="btn btn-edit">แก้ไข</a>
                                            <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $food['ID']; ?>" class="btn btn-delete">ลบ</a>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
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