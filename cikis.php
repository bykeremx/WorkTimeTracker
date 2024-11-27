<?php
include_once "connectDB.php";
ob_start();
session_start();
print_r($_SESSION);
date_default_timezone_set('Europe/Istanbul');
$date = date("Y-m-d H:i:s");
echo $date;
$tarih = $connect->prepare("SELECT * FROM in_out WHERE user_id=:user_id AND status ='1'");
$tarih->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_STR);
$tarih->execute();
$tarihi_cek = $tarih->fetch();

// $in_date = date_create_from_format("Y-m-d H:i:s", $tarih_cek['in_date']);
// $saat_farki = $date-$in_date;
$tarihi_cek['in_date'] = strtotime($tarihi_cek['in_date']);
$cikis_tarihi = strtotime($date);

$saat_farki = $cikis_tarihi - $tarihi_cek['in_date'];

$get_saat = date("H:i:s", $saat_farki);
$saat = floor($saat_farki / 3600);
$dakika = floor(($saat_farki % 3600) / 60);
$saniye = $saat_farki % 60;

$get_saat = sprintf('%02d:%02d:%02d', $saat, $dakika, $saniye);

echo "Bu kadar Saat Çalıştı : $get_saat";
// echo "Bu kadar Saat Çalıştı : ". date("H:i:s",$saat_farki);
$sql = "UPDATE in_out SET status='0',work_time=:work_time, out_date=:out_date WHERE user_id=:user_id AND status='1'";
$in = $connect->prepare($sql);
$in->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_STR);
$in->bindParam(':out_date', $date, PDO::PARAM_STR);
$in->bindParam(':work_time', $get_saat, PDO::PARAM_STR);
$durum = $in->execute();
session_destroy();
header("Location:index.php?work_time=$get_saat");
