<?php

session_start();
require_once '../config/conn_db.php'; // Added semicolon at the end

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
} else {
    $username = $_SESSION['username'];
    $storeid = $_SESSION['store_id'];

    // get data from database table
    $sql = "SELECT * FROM `qrcode` WHERE member_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['store_id']);
    $stmt->execute();
    $resultQR = $stmt->fetch(PDO::FETCH_ASSOC);
}



if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM food WHERE food_ID = $delete_id");
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
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
    <title>รายการอาหาร</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>

            <!-- Add the hamburger menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Right side -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav menunavbar">
                    <li class="nav-item username-layout">
                        <p class="text-username">ร้าน
                            <?php echo htmlspecialchars($username); ?>
                        </p>
                    </li>
                    <li class="nav-item">
                        <a href="../service/logout.php" class="btn btn-order-atnav">ออกจากระบบ</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Navbar -->


    <div class="container-fluid menu-box">
        <!-- Modal Add Food-->
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

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" name="submit" class="btn btn-success">ยืนยัน</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Modal Add Food  -->

        <!-- Modal show QRCODE if no image to show button generate qrcode and if have image to show qrcode image and show button generate qrcode again -->
        <!-- Modal -->
        <div class="modal fade" id="qrcodemodal" tabindex="-1" aria-labelledby="qrcodemodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrcodemodalLabel">QRCODE</h5>
                        <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                    </div>
                    <div class="modal-body text-center">
                        <?php if (empty($resultQR)) { ?>
                            <!-- text show "คุณยังไม่มี QRCODE -->
                            <p id="no-qrcode-text">คุณยังไม่มี QRCODE</p>
                            <!-- QR Code image will be displayed here -->
                            <img src="../upload/" id="qrcode-image" class="img-fluid" alt="QR Code" style="display: none;">
                        <?php } else { ?>
                            <?php if (empty($resultQR['qrcode_img'])) { ?>
                                <p id="no-qrcode-text">ไม่สามารถแสดงรูปภาพได้</p>
                            <?php } else { ?>
                                <img src="../upload/qrcode/<?php echo $resultQR['qrcode_img']; ?>" class="img-fluid" alt="...">
                            <?php } ?>
                        <?php } ?>
                        <!-- Button to generate QR Code -->
                        <button type="button" class="btn btn-qrcode-gen" id="generate-qrcode-btn"
                            onclick="generateQRCode()">สร้าง QRCODE</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h4>รายการอาหาร
                        <?php echo $_SESSION['username'] ?>
                    </h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end" style="gap: 8px;">
                    <button type="button" class="btn btn-add-menu" data-bs-toggle="modal"
                        data-bs-target="#qrcodemodal"><i class="bi bi-qr-code-scan"></i>แสดง QRCODE</button>
                    <button type="button" class="btn btn-add-menu" data-bs-toggle="modal"
                        data-bs-target="#qrcodemodal"><i class="bi bi-plus-circle-fill"></i>เพิ่มโต๊ะอาหาร</button>
                    <button type="button" class="btn btn-add-menu" data-bs-toggle="modal" data-bs-target="#foodmodal"><i
                            class="bi bi-plus-circle-fill"></i>เพิ่มรายการอาหาร</button>
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
                            // select data from database with store id(member_id)
                            $stmt = $conn->prepare("SELECT * FROM food WHERE member_ID = $storeid");
                            $stmt->execute();
                            $food = $stmt->fetchAll();

                            if (!$food) {
                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                            } else {
                                foreach ($food as $food) {
                                    ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $food['food_ID']; ?>
                                        </th>
                                        <td>
                                            <?php echo $food['foodname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $food['price']; ?>
                                        </td>

                                        <td width="250px"><img class="rounded" width="100%"
                                                src="../upload/<?php echo $food['img']; ?>" alt=""></td>
                                        <td class="action-btn-layout column">
                                            <a href="../Page/edit_menu.php?id=<?php echo $food['food_ID']; ?>"
                                                class="btn btn-edit">แก้ไข</a>
                                            <a onclick="return confirm('Are you sure you want to delete?');"
                                                href="?delete=<?php echo $food['food_ID']; ?>" class="btn btn-delete">ลบ</a>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
            crossorigin="anonymous"></script>
        <script>
            let imgInput = document.getElementById('imgInput');
            let previewImg = document.getElementById('previewImg');

            imgInput.onchange = evt => {
                const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
                }
            }

            function generateQRCode() {
                // redirect to page
                window.location.href = "../service/qr_code_gen.php";
            }
        </script>
</body>

</html>