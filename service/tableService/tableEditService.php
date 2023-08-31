<?php 

    session_start();
    require_once ('../../config/conn_db.php');

    if(isset($_POST['Update'])){
        $tblNumber = $_POST['tableNumber'];
        $tblName = $_POST['tableName'];

        
        $sql = "UPDATE tables SET table_number = :table_number, table_name = :table_name,member_ID = :member_ID WHERE table_ID = :table_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":table_number", $tblNumber);
        $stmt->bindParam(":table_name", $tblName);
        $stmt->bindParam(":member_ID", $_SESSION['store_id']);
        $stmt->bindParam(":table_id", $_SESSION['table_id']);
        

        if($stmt->execute()){
            $_SESSION['tblUpdate_Success'] = "ข้อมูลโต๊ะได้รับการอัพเดทแล้ว";
            header("Location: ../../page/table/table.php");
            exit();
        }else{
            $_SESSION['tblUpdate_error'] = "ข้อมูลโต๊ะไม่ได้รับการอัพเดท";
            // echo $_SESSION['error'];
        }
    }
?>