<?php
session_start();
require_once '../../config/conn_db.php';


if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
}

if (isset($_GET['id'])) {
    $_SESSION['table_id'] = $_GET['id'];
    // Get table information from the database
    $getTableSql = "SELECT * FROM tables WHERE table_ID = :table_id AND member_ID = :member_id";
    $stmt = $conn->prepare($getTableSql);
    $stmt->bindParam(":table_id", $_SESSION['table_id']);
    $stmt->bindParam(":member_id", $_SESSION['store_id']);
    $stmt->execute();
    $table = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($table)) {
        $_SESSION['error'] = "Table information is not found";
        header("Location: table.php");
        exit();
    }

    
} else {
    $_SESSION['error'] = "Table ID is not provided";
    header("Location: table.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Table Information</title>
    <!-- Your CSS and Bootstrap links here -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../../css/edit-menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>
<body>
    <!-- Your navigation bar and other UI elements here -->
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
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
                        <p class="text-username">ร้าน <?php echo $_SESSION['username']; ?></p>
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
            <h1>แก้ไขข้อมูลโต๊ะ</h1>
            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
            <form action="../../service/tableService/tableEditService.php" method="POST">
                <div class="mb-3">
                    <label for="tableNumber" class="form-label">เลขโต๊ะ:</label>
                    <input type="text" class="form-control" name="tableNumber" value="<?php echo $table['table_number']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tableName" class="form-label">ชื่อโต๊ะ:</label>
                    <input type="text" class="form-control" name="tableName" value="<?php echo $table['table_name']; ?>" required>
                </div>

                <div class="btn-edit-layout">
                    <a href="table.php" class="btn btn-back">ย้อนกลับ</a>
                    <button type="submit" name="Update" class="btn btn-save">บันทึก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Your JavaScript and Bootstrap scripts here -->
</body>
</html>
