<?php
include_once "connectDB.php";
ob_start();
session_start();


$oku_no = $_POST['student_number'];
$ad_soyad = $_POST['name_and_surname'];

$sql = "SELECT * FROM users WHERE student_number = :student_number and name_and_surname = :name_and_surname";
$giris = $connect->prepare($sql);
$giris->bindParam(':student_number', $oku_no, PDO::PARAM_STR);
$giris->bindParam(':name_and_surname', $ad_soyad, PDO::PARAM_STR);
$durum = $giris->execute();
if ($durum) {
    $kisi = $giris->fetch();
    if ($kisi) {
        echo "Kişi Bulundu";
        $sql = "INSERT INTO in_out (user_id,status) VALUES (:user_id,'1')";
        $in = $connect->prepare($sql);
        $in->bindParam(':user_id', $kisi['id'], PDO::PARAM_STR);
        // $in->bindParam(':status','1', PDO::PARAM_STR);
        $durum = $in->execute();
        if ($durum) {
            $_SESSION['id'] = $kisi['id'];
            $_SESSION['okul_no'] = $kisi['student_number'];
            $_SESSION['ad_soyad'] = $kisi['name_and_surname'];
            $_SESSION['is_admin'] = $kisi['is_admin'];
            $_SESSION['status'] = 1; 
            header("Location:index.php");
        }
    } else {
        echo "Kişi Bulanamadı ";
    }
} else {
    echo "Giriş yapılamadı. Lütfen bilgilerinizi kontrol edin.";
}
