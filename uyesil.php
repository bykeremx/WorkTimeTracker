<?php 
include_once "connectDB.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sil = $connect->prepare("DELETE FROM users WHERE id=$id");
    $durum = $sil->execute();
    if ($durum) {
        header("Location:index.php?delete_user");
    }
    else{
        header("Location:index.php?delete_user_error");

    }
}
?>