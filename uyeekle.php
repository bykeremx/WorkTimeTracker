<?php
include_once "connectDB.php";
print_r($_POST);
if (isset($_POST['ekle_uye'])) {
    $okul_no = htmlspecialchars($_POST['student_number']);
    $name_and_surname = htmlspecialchars($_POST['name_and_surname']);
    $ekle = $connect->prepare("INSERT INTO users (name_and_surname,student_number,is_admin) VALUES (:name_and_surname,:student_number,:is_admin)");
    $ekle->bindParam(':name_and_surname', $name_and_surname);
    $ekle->bindParam(':student_number', $okul_no);
    if(isset($_POST['is_admin'])){
        $durum = '1';
        $ekle->bindParam(':is_admin', $durum);
    }
    else{
        $durum = '0';
        $ekle->bindParam(':is_admin',$durum);
    }
    $durum = $ekle->execute();
    if ($durum) {
        header("Location:index.php?add_user_success");
    } else {
        header("Location:index.php?add_user_error");
    }
}
