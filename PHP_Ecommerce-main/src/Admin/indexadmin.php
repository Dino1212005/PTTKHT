<?php
include '../app/model/connectdb.php';
include '../app/model/cate.php';
include '../app/model/product.php';
include '../app/model/khachhang.php';
include '../app/model/binhluan.php';
include '../app/model/size.php';
include '../app/model/color.php';
include '../app/model/thongke.php';
include '../app/model/donhang.php';
include '../app/model/nhacungcap.php';
include '../app/model/brand.php';
session_start();
ob_start();

if (isset($_SESSION['acount']) && isset($_SESSION['acount']['vaitro_id'])) {
    $vaitro_id = $_SESSION['acount']['vaitro_id'] ?? null;
} else {
    echo "Chưa đăng nhập hoặc không có vaitro_id.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="bg-white">
    <div class="grid-container">
        <?php
        if (isset($_GET['act'])) {
            $acts = $_GET['act'];
            switch ($acts) {
                case 'home':
                    # code...

                    echo '
      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
          <span class="material-icons-outlined">search</span>
        </div>
        <div class="header-right">
          <a href="../index.php?act=home"><span class="material-icons-outlined">account_circle</span></a>
        </div>
      </header>
      <!-- End Header -->';
                    break;

                default:
                    # code...
                    break;
            }
        }


        ?>

        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">inventory</span> Admin
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=home">
                        <span class="material-icons-outlined"><i class="bi bi-house-door-fill"></i></span> Trang chủ
                    </a>
                </li>
                <?php if ($vaitro_id == 1) { // Chỉ admin 
                ?>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=cate">
                        <span class="material-icons-outlined"><i class="bi bi-card-list"></i></span> Danh mục
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=pro">
                        <span class="material-icons-outlined">fact_check</span> Sản phẩm
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=listtk">
                        <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Người dùng
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=listbl">
                        <span class="material-icons-outlined"><i class="bi bi-chat-text-fill"></i></span> Bình luận
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=thongke">
                        <span class="material-icons-outlined">poll</span> Thống kê
                    </a>
                    <?php } elseif ($vaitro_id == 4) { ?>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=pro">
                        <span class="material-icons-outlined">fact_check</span> Sản phẩm
                    </a>
                </li>
                <?php } ?>
                </li>
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=donhang">
                        <span class="material-icons-outlined"><i class="bi bi-cart-check-fill"></i></span> Danh sách đơn
                        hàng
                    </a>
                </li>
                <!-- Nhà cung câps -->
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=ncc">
                        <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Nhà cung
                        cấp
                    </a>
                </li>
                <!-- quản lý màu -->
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=color">
                        <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý màu
                    </a>
                </li>
                <!-- quản lý thương hiệu -->
                <li class="sidebar-list-item">
                    <a href="indexadmin.php?act=thuonghieu">
                        <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                        thương hiệu
                    </a>
                </li>
            </ul>
        </aside>
        <!-- End Sidebar -->
        <?php
        if (isset($_GET['act'])) {
            $act = $_GET['act'];
            switch ($act) {
                case 'thuonghieu':
                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'color':
                    $listcolor = query_allcolor1();
                    include './qlmau/color.php';
                    break;
                case "ncc":
                    // Lấy các tham số sắp xếp từ form
                    $sapXep = isset($_POST['sapXepNCC']) ? $_POST['sapXepNCC'] : 'id';
                    $thuTu = isset($_POST['thuTu']) ? $_POST['thuTu'] : 'asc';
                    $keyword = isset($_POST['searchNCC']) ? $_POST['searchNCC'] : '';

                    // Gọi hàm loadall_ncc với tham số sắp xếp
                    $listNCC = loadall_ncc($keyword, $sapXep, $thuTu);

                    // Include file listNCC.php để hiển thị danh sách
                    include "nhacungcap/listNCC.php";
                    break;

                case 'suaNCC':
                    if (isset($_GET['ncc_id']) && $_GET['ncc_id'] > 0) {
                        $ncc_id = $_GET['ncc_id'];
                        $listNCC = load_ncc($ncc_id);
                    }
                    include './nhacungcap/updateNCC.php';
                    break;
                case 'updateNCC':
                    if (isset($_POST['update'])) {
                        $ncc_id = $_POST['ncc_id'];
                        $ncc_name = $_POST['ncc_name'];
                        $ncc_email = $_POST['ncc_email'];
                        $ncc_sdt = $_POST['ncc_tel'];
                        $ncc_diachi = $_POST['ncc_address'];

                        update_NCC($ncc_id, $ncc_name, $ncc_email, $ncc_sdt, $ncc_diachi);
                    }
                    $listNCC = loadAllNcc();
                    include './nhacungcap/listNCC.php';
                    break;

                case 'xoaNCC':
                    if (isset($_GET['ncc_id'])) {
                        $ncc_id = $_GET['ncc_id'];
                        delete_ncc($ncc_id);
                    }
                    $listNCC = loadAllNcc();
                    include "./nhacungcap/listNCC.php";
                    break;
                    break;
                case 'home':
                    $dh = thongke_donhang();
                    $top5 = loadall_sanpham_top5();
                    $kh = countkh();
                    $bl = countbl();
                    $donhang = countOrderIds();
                    $pro = countProId();
                    include './viewadmin/home.php';
                    break;
                case 'cate':
                    $resultcate = query_allcate();
                    include './cate/listcate.php';
                    break;

                case "thungrac_cate":
                    $resultcate = query_allcates();
                    include './cate/thungrac.php';
                    break;

                case 'addcate':

                    include './cate/addcate.php';
                    break;
                case 'themcate':
                    if (isset($_POST['themdm'])) {
                        $cate_name = $_POST['cate_name'];
                        addcate($cate_name);
                    }

                    $resultcate = query_allcate();
                    include './cate/listcate.php';

                    break;
                case 'suacate':
                    if (isset($_GET['cate_idsua'])) {
                        $cate_id = $_GET['cate_idsua'];
                        $cate_one = query_onecate($cate_id);

                        include './cate/updatecate.php';
                    }
                    break;

                case 'updatecate':
                    if (isset($_POST['suadm'])) {
                        $cate_name = $_POST['cate_name'];
                        $cate_id = $_POST['cate_id'];
                        updatecate($cate_name, $cate_id);
                    }

                    $resultcate = query_allcate();
                    include './cate/listcate.php';

                    break;

                case 'delcate':
                    if (isset($_GET['cate_idxoa'])) {
                        $cate_id = $_GET['cate_idxoa'];


                        deletecate($cate_id);
                    }
                    $resultcate = query_allcate();
                    include './cate/listcate.php';
                    break;
                case 'soft_delcate':
                    if (isset($_GET['cate_idxoa'])) {
                        $cate_id = $_GET['cate_idxoa'];


                        soft_deletecate($cate_id);
                    }
                    $resultcate = query_allcate();
                    include './cate/listcate.php';
                    break;
                case 'khoiphuc_cate':
                    if (isset($_GET['cate_idxoa'])) {
                        $cate_id = $_GET['cate_idxoa'];


                        khoiphuc_cate($cate_id);
                    }
                    $resultcate = query_allcates();
                    include './cate/thungrac.php';
                    break;
                case 'pro':

                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case 'thungrac_product':
                    $result_pro = queryallpros();
                    include './sanpham/thungrac.php';
                    break;
                case 'thempro':

                    include './sanpham/addpro.php';
                    break;
                case 'addcolor1':

                    include './qlmau/addcolor.php';
                    break;
                case 'addbrand1':

                    include './qlthuonghieu/addbrand.php';
                    break;
                case 'addbrand':
                    if (isset($_POST['addbrand'])) {
                        $brand_name = $_POST['brand_name'];
                        $mo_ta = $_POST['mo_ta'];
                        insert_brand($brand_name, $mo_ta);
                    }
                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'xoabrand':
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        deletebrand($id);
                    }
                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'suabrand':
                    if (isset($_GET['brand_idsua'])) {
                        $brand_id = $_GET['brand_idsua'];
                        $brand_one =   queryonebrand($brand_id);
                    }
                    include './qlthuonghieu/updatebrand.php';
                    break;
                case 'updatebrand':
                    if (isset($_POST['updatebrd'])) {
                        $id = $_POST['id'];
                        $brand_one =   queryonebrand($id);
                        $brand_name = $_POST['ten_thuong_hieu'];
                        $mo_ta = $_POST['mo_ta'];
                        updatebrd($brand_name, $mo_ta, $id);
                    }

                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'addcolor':
                    if (isset($_POST['addcolor'])) {
                        $color_name = $_POST['color_name'];
                        $color_ma = $_POST['color_ma'];
                        insert_color($color_name, $color_ma);
                    }
                    $listcolor = query_allcolor1();
                    include './qlmau/color.php';
                    break;
                case 'xoacolor':
                    if (isset($_GET['color_id'])) {
                        $color_id = $_GET['color_id'];


                        deletecolor($color_id);
                    }
                    $listcolor = query_allcolor1();
                    include './qlmau/color.php';
                    break;
                case 'addpro':
                    if (isset($_POST['addsp'])) {
                        $pro_name = $_POST['pro_name'];
                        $cate_id = $_POST['cate_id'];
                        $pro_price = $_POST['pro_price'];
                        $pro_stock = $_POST['pro_stock'];
                        $pro_brand = $_POST['pro_brand'];
                        $pro_mota = $_POST['pro_mota'];
                        $img_name = $_FILES['pro_img']['name'];
                        $img_tmp = $_FILES['pro_img']['tmp_name'];
                        move_uploaded_file($img_tmp, "./sanpham/img/" . $img_name);
                        addpro($pro_name, $img_name, $pro_price, $pro_mota, $cate_id, $pro_stock, $pro_brand);
                    }

                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case 'suapro':
                    if (isset($_GET['pro_idsua'])) {
                        $pro_id = $_GET['pro_idsua'];
                        $pro_one =   queryonepro($pro_id);
                    }
                    include './sanpham/updatepro.php';
                    break;
                case 'updatepro':
                    if (isset($_POST['updatesp'])) {
                        $pro_id = $_POST['pro_id'];
                        $pro_one =   queryonepro($pro_id);
                        $pro_brand = $_POST['pro_brand'];
                        $pro_name = $_POST['pro_name'];
                        $cate_id = $_POST['cate_id'];
                        $pro_price = $_POST['pro_price'];

                        $pro_mota = $_POST['pro_mota'];
                        if ($_FILES['pro_img']['name'] == null) {
                            $img_name = $pro_one['pro_img'];
                        } else {
                            $img_name = $_FILES['pro_img']['name'];
                        }
                        $img_tmp = $_FILES['pro_img']['tmp_name'];
                        move_uploaded_file($img_tmp, "./sanpham/img/" . $img_name);
                        updatepro($pro_name, $pro_price, $pro_brand, $img_name, $pro_mota, $cate_id, $pro_id);
                    }

                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case 'delpro':
                    if (isset($_GET['pro_idxoa'])) {
                        $pro_id = $_GET['pro_idxoa'];


                        deletepro($pro_id);
                    }
                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case "soft_delpro":
                    if (isset($_GET['pro_idxoa'])) {
                        $pro_id = $_GET['pro_idxoa'];


                        soft_deletepro($pro_id);
                    }
                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case "khoiphuc_product":
                    if (isset($_GET['pro_idxoa'])) {
                        $pro_id = $_GET['pro_idxoa'];


                        khoiphuc_product($pro_id);
                    }
                    $result_pro = queryallpros();
                    include './sanpham/thungrac.php';
                    break;
                case 'search':
                    include './sanpham/listproduct.php';

                    break;
                // bình luận 
                case "listbl":
                    $listbl = load_binhluan();
                    include "binhluan/list_bl.php";
                    break;
                case "xoabl":
                    if (isset($_GET['cmt_id'])) {
                        $cmt_id = $_GET['cmt_id'];
                        delete_binhluan($cmt_id);
                    }
                    $listbl = load_binhluan();
                    include "binhluan/list_bl.php";
                    break;
                // khách hàng
                case "listtk":
                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "thungrac_kh":
                    $listtk = loadall_taikhoans();
                    include "taikhoan/thungrac.php";
                    break;
                case "xoatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        delete_taikhoan($kh_id);
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "soft_xoatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        soft_deletekh($kh_id);
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "khoiphuc_kh":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        khoiphuc_kh($kh_id);
                    }

                    $listtk = loadall_taikhoans();
                    include "taikhoan/thungrac.php";
                    break;
                case "suatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id = $_GET['kh_id'];
                        $tk = loadone_taikhoan($kh_id);
                    }
                    include "taikhoan/updatetk.php";
                    break;
                case "updatetk":
                    if (isset($_POST['update'])) {
                        $kh_id  = $_POST['kh_id'];
                        $kh_name = $_POST['kh_name'];
                        $kh_pass = $_POST['kh_pass'];
                        $kh_mail = $_POST['kh_mail'];
                        $kh_tel = $_POST['kh_tel'];
                        $kh_address = $_POST['kh_address'];
                        $vaitro_id = $_POST['vaitro_id'];

                        update_taikhoan($kh_id, $kh_name, $kh_pass, $kh_mail, $kh_tel, $kh_address, $vaitro_id);
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;

                case 'chitietadmin':
                    include 'sanpham/chitietproadmin.php';

                    break;
                case 'thempro_chitiet':
                    include 'sanpham/addprochitiet.php';

                    break;
                case 'addpro_ct':
                    if (isset($_POST['addsp_ct'])) {
                        $pro_id = $_POST['pro_id'];
                        $color = $_POST['color_id'];
                        $size = $_POST['size_id'];
                        $soluong = $_POST['soluong'];
                    }
                    addpro_chitiet($pro_id, $size, $color, $soluong);



                    header("Location:indexadmin.php?act=chitietadmin&pro_id=" . $pro_id);
                    exit();
                    break;
                case 'delprochitiet':
                    if (isset($_GET['prochitiet_idxoa']) && isset($_GET['pro_id'])) {
                        $id_pro_ct = $_GET['prochitiet_idxoa'];
                        $pro_id = $_GET['pro_id'];
                        del_prochitiet($id_pro_ct);
                        header("Location:indexadmin.php?act=chitietadmin&pro_id=" . $pro_id);
                    }
                    // include 'sanpham/chitietproadmin.php';
                    break;

                case 'suaprochitiet':
                    include 'sanpham/updateprochitiet.php';







                    break;
                case 'upchitietpro':
                    if (isset($_POST['update_chitietpro'])) {
                        $soluong  = $_POST['soluong'];
                        $pro_chitiet_id = $_POST['id'];
                        $pro_id = $_POST['id_pro'];
                        updateprochitiet($pro_chitiet_id, $soluong);
                    }
                    header("location:indexadmin.php?act=chitietadmin&pro_id=" . $pro_id);
                    break;

                case 'donhang':

                    $kyw = "";
                    $start_date = "";
                    $end_date = "";

                    // Kiểm tra nếu có tìm kiếm
                    if (isset($_POST['timkiem'])) {
                        // echo "Start date: " . $_POST['start_date'] . "<br>";
                        // echo "End date: " . $_POST['end_date'] . "<br>";

                        if (!empty($_POST['kyw'])) {
                            $kyw = $_POST['kyw'];
                        }
                        if (!empty($_POST['start_date'])) {
                            $start_date = $_POST['start_date'];
                        }
                        if (!empty($_POST['end_date'])) {
                            $end_date = $_POST['end_date'];
                        }
                        if (!empty($end_date) && empty($start_date)) {
                            $start_date = "1970-01-01";
                        }

                        if (!empty($start_date) && empty($end_date)) {
                            $end_date = date("Y-m-d");
                        }
                    }

                    // Gọi hàm tìm kiếm với các điều kiện
                    $listdh = loadall_donhang($kyw, $start_date, $end_date);
                    include "./donhang/listdh.php";
                    break;
                case "xoadonhang":
                    if (isset($_GET['order_id'])) {
                        $order_id = $_GET['order_id'];
                        delete_donhang($order_id);
                    }
                    $listdh = loadall_donhang();
                    include "./donhang/listdh.php";
                    break;
                case "suadonhang":
                    if (isset($_GET['order_id']) && $_GET['order_id'] != "") {
                        $order_id = $_GET['order_id'];
                        $dh = loadall_one_donhang($order_id);
                    }
                    include "./donhang/update.php";
                    break;
                case "updatedonhang":
                    if (isset($_POST['themdh'])) {
                        $order_id = $_POST['order_id'];
                        $order_trangthai = $_POST['order_trangthai'];
                        updatedh($order_trangthai, $order_id);
                    }
                    $listdh = loadall_donhang();
                    include "./donhang/listdh.php   ";
                    break;
                case "chitietdh":
                    if (isset($_GET['order_id']) && $_GET['order_id'] != "") {
                        $order_id = $_GET['order_id'];
                    }
                    $chitietdh = loadall_chitietdh($order_id);
                    include "./donhang/chitetdh.php";
                    break;
                // thống kê
                case 'thongke':
                    $listtkbl = load_thongkebl();
                    $listthongke = loadall_thongke();
                    include "./Thongke/list.php";
                    break;
                case 'bieudo':
                    $listthongke = loadall_thongke();
                    include "./Thongke/bieudo.php";
                    break;
                case 'bieudobl':
                    $listtkbl = load_thongkebl();
                    include "./Thongke/bieudobl.php";
                    break;



                default:
                    include './viewadmin/home.php';

                    break;
            }
        }
        include './viewadmin/footter.php';
        ?>