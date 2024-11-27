<?php

try {
    $connect = new PDO("mysql:host=localhost;dbname=in_out_db", "root", "");
} catch (PDOException $err) {
    echo "Bağlantı Başarısız " + $err;
}
