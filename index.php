<?php
$title = "Giriş Yap";
date_default_timezone_set('Europe/Istanbul');

include_once "header.php";
include_once "connectDB.php";
// print_r($_SESSION);

?>

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="giris-panel mt-3  p-4">
                <div class="row">
                    <div class="logo">
                        <img src="../siber_koza/img/logo.png" alt="" srcset="" width="100%">
                    </div>
                </div>
                <?php
                if (isset($_SESSION['okul_no']) and isset($_SESSION['ad_soyad'])) {
                    $tarih = $connect->prepare("SELECT * FROM in_out WHERE user_id=:user_id AND status ='1'");
                    $tarih->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_STR);
                    $tarih->execute();
                    $tarihi_cek = $tarih->fetch();
                    $sql = "SELECT * FROM users";
                    $kullanicilar = $connect->prepare($sql);
                    $kullanicilar->execute();
                    $butun_kullanicilar = $kullanicilar->fetchAll(PDO::FETCH_ASSOC);
                    //kullanıclar tablo 
                    $sorgu_butun = "SELECT name_and_surname,in_date,out_date,work_time FROM users INNER JOIN in_out ON users.id = in_out.user_id";
                    $tarih_ve_saat = $connect->prepare($sorgu_butun);
                    $tarih_ve_saat->execute();
                    $veriyi_al = $tarih_ve_saat->fetchAll(PDO::FETCH_ASSOC);

                    $count = 1;
                    $count_2 = 1;
                ?>
                    <?php
                    if (!$_SESSION['is_admin'] == '0') {
                    ?>
                        <div class="row px-2">
                            <?php
                            if (isset($_GET['add_user_success'])) {
                                #
                            ?>
                                <div class="alert alert-warning border-0 shadow alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    Kaydetme Başarılı !
                                </div>

                                <script>
                                    var alertList = document.querySelectorAll(".alert");
                                    alertList.forEach(function(alert) {
                                        new bootstrap.Alert(alert);
                                    });
                                </script>

                            <?php
                            }
                            ?>
                            <?php
                            if (isset($_GET['delete_user'])) {
                                #
                            ?>
                                <div class="alert alert-danger border-0 shadow alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    Kullanıcı Silindi
                                </div>

                                <script>
                                    var alertList = document.querySelectorAll(".alert");
                                    alertList.forEach(function(alert) {
                                        new bootstrap.Alert(alert);
                                    });
                                </script>

                            <?php
                            }
                            ?>
                            <?php
                            if (isset($_GET['delete_user_error'])) {
                                #
                            ?>
                                <div class="alert alert-warning border-0 shadow alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    Silinirlen Bir Sorun Oluştu
                                </div>

                                <script>
                                    var alertList = document.querySelectorAll(".alert");
                                    alertList.forEach(function(alert) {
                                        new bootstrap.Alert(alert);
                                    });
                                </script>

                            <?php
                            }
                            ?>
                            <?php
                            if (isset($_GET['add_user_error'])) {
                                #
                            ?>
                                <div class="alert alert-danger border-0 shadow alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    Bir Sorun Oluştu Bir Daha Dene
                                </div>

                                <script>
                                    var alertList = document.querySelectorAll(".alert");
                                    alertList.forEach(function(alert) {
                                        new bootstrap.Alert(alert);
                                    });
                                </script>

                            <?php
                            }
                            ?>
                        </div>
                        <div class="row mt-3 px-1 mb-3 ">
                            <!-- Modal trigger button -->
                            <div class="col-md-4 mb-3 ">
                                <button type="button" class="btn-desing-list btn btn-warning  btn-md w-100" data-bs-toggle="modal" data-bs-target="#listele">
                                    Listele
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="button" class=" btn-desing-list btn btn-info  btn-md w-100" data-bs-toggle="modal" data-bs-target="#ekle">
                                    Ekle
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="button" class=" btn-desing-list btn btn-info  btn-md w-100" data-bs-toggle="modal" data-bs-target="#denetle">
                                    Denetle
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="listele" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content rounded-0 shadow-lg">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Üyeler
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table id="uyeleri_goster" class="w-100 display">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Adı Soyadı</th>
                                                                <th>Okul Numarası </th>
                                                                <th>Sil</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($butun_kullanicilar as  $value) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $count++ ?></td>
                                                                    <td><?php echo ucwords($value['name_and_surname']) ?></td>
                                                                    <td><strong><?php echo $value['student_number'] ?></strong></td>
                                                                    <td><a name="" id="" class="btn btn-danger btn-sm" href="uyesil.php?id=<?php echo $value['id'] ?>" role="button">Sil</a>
                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Çık
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="denetle" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content rounded-0 shadow-lg">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Giriş-Çıkış Saatleri
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table id="giris-cikis" class="display w-100">
                                                        <thead class="">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Adı Soyadı</th>
                                                                <th>Giriş Tarih</th>
                                                                <th>Çıkış Tarih</th>
                                                                <th>Çalışma Saati</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            foreach ($veriyi_al as  $value) {

                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $count_2++ ?></td>
                                                                    <td><?php echo ucwords($value['name_and_surname']) ?></td>
                                                                    <td><?php echo ucwords($value['in_date']) ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($value['out_date'] == null) {
                                                                            echo "<span class='badge bg-danger p-2'>Çalışıyor...</span>";
                                                                        } else {
                                                                            echo $value['out_date'];
                                                                        }
                                                                        ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($value['work_time'] == null) {
                                                                            echo "<span class='badge bg-danger p-2'>Çalışıyor...</span>";
                                                                        } else {
                                                                            echo $value['work_time'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Çık
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal rounded-0  fade" id="ekle" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog rounded-0  modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content  shadow-lg rounded-0">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Üye Ekle
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form action="uyeekle.php" method="post">
                                                    <div class="form-group">
                                                        <label for="">Okul Numarası : </label>
                                                        <input type="text" name="student_number" id="" class="form_desing form-control" placeholder="" aria-describedby="helpId">
                                                        <small id="helpId" class="text-muted">Okul Numarası</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="">Adı Soyadı : </label>
                                                        <input type="text" name="name_and_surname" id="" class="form_desing form-control" placeholder="" aria-describedby="helpId">
                                                        <small id="helpId" class="text-muted">Ad Soyad</small>
                                                    </div>
                                                    <div class="form-check mb-4">
                                                        <input class="form-check-input" name="is_admin" type="checkbox" value="1" id="" />
                                                        <label class="form-check-label" for=""> Admin mi ?  </label>
                                                    </div>



                                                    <div class="form-group">
                                                        <button type="submit" name="ekle_uye" class=" shadow-lg w-100 btn btn-primary">
                                                            Kaydet
                                                        </button>

                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Çık
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    <?php } ?>
                    <div class="row px-3 ">
                        <div class="alert  bg-alert-design border-0 shadow" role="alert">
                            <strong><?php echo $_SESSION['ad_soyad'] ?></strong> Çalışılıyor...
                            <hr>
                            <strong>Giriş Tarihi : </strong> <?php echo $tarihi_cek['in_date'] ?>
                        </div>
                    </div>
                    <form action="cikis.php" method="post">
                        <button type="submit" class="button_giris btn w-100 p-5 shadow-lg " style="font-size: 23px;">ÇIKIŞ YAP</button>
                    </form>
                <?php } else {
                ?>
                    <div class="row px-2">
                        <?php
                        if (isset($_GET['work_time'])) {

                        ?>
                            <div class="alert_desing border-0  shadow alert alert-primary alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Çalışma Saatiniz : </strong><span>
                                    <?php echo $_GET['work_time'] ?> ' dir.
                                </span>
                            </div>

                            <script>
                                var alertList = document.querySelectorAll(".alert");
                                alertList.forEach(function(alert) {
                                    new bootstrap.Alert(alert);
                                });
                            </script>

                        <?php } ?>
                    </div>
                    <form action="giris.php" method="post">

                        <div class="mb-3">
                            <label for="" class="form-label">Adınız ve Soyadınız </label>
                            <input type="text" name="name_and_surname" id="" class="form_desing form-control" placeholder="" aria-describedby="helpId" />
                            <small id="helpId" class="text-muted">Lütfen Adınızı ve Soyadınızı Girin . </small>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Öğrenci Numarası </label>
                            <input type="text" name="student_number" id="" class="form_desing form-control" placeholder="" aria-describedby="helpId" />
                            <small id="helpId" class="text-muted">Öğrenci Numarası</small>
                        </div>
                        <button type="submit" class="button_giris btn w-100 p-2">Giriş</button>
                    </form>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>


<?php

include_once "footer.php";
?>