<?php

if (isset($_POST['placeordered'])) {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $soluong = $_POST['soluong'];
    $pro_id = $_POST['pro_id'];
    $kh_id  = $_POST['kh_id'];
    $cart_kh = querycart_kh($kh_id);
    $address = $_POST['address'];
    $trangthai = 'Đang chờ xác nhận';
    date_default_timezone_set('Asia/Ho_Chi_Minh'); // timezone Việt Nam
    $time = date('d-m-y');
    $tongtien = $_POST['tongtien'];

    // Create the order first
    add_order($kh_id, $time, $trangthai, $address, $tongtien);

    // Get the newly created order ID
    $sql = "select * from `order` where order_id = (select max(order_id) from `order`)";
    $order_chitiet = pdo_query_one($sql);

    $add_order_chitiet = array(
        "pro_id" => $pro_id,
        "color" => $color,
        "soluong" => $soluong,
        "size" => $size
    );

    // Process the order items
    for ($i = 0; $i < count($size); $i++) {
        $products = queryonepro($add_order_chitiet['pro_id'][$i]);
        $pro_order = $add_order_chitiet['pro_id'][$i];
        $sl_order = $add_order_chitiet['soluong'][$i];
        $size_order = $add_order_chitiet['size'][$i];
        $color_order = $add_order_chitiet['color'][$i];
        $pro_chitiet = query_pro_soluong($pro_order, $color_order, $size_order);
        $sl = $pro_chitiet['soluong'];

        // Add order details
        add_chitietdonhang($order_chitiet['order_id'], $add_order_chitiet['pro_id'][$i], $add_order_chitiet['color'][$i], $add_order_chitiet['size'][$i], $products['pro_price'], $add_order_chitiet['soluong'][$i]);

        // Remove from cart
        del_cart_order($add_order_chitiet['pro_id'][$i], $cart_kh['cart_id']);

        // Update product quantity
        $sql = "update pro_chitiet set soluong = $sl - $sl_order where pro_id = $pro_order and size_id = $size_order and color_id = $color_order";
        pdo_execute($sql);
    }

    // Handle payment methods
    if ($_POST['thanhtoan'] == 2) {
        // Chuyển đến trang thanh toán đơn giản thay vì VNPay
        $_SESSION['order_id'] = $order_chitiet['order_id'];
        $_SESSION['order_total'] = $tongtien;
        header('Location: index.php?act=simple_payment');
        die();
    } else {
        // For AJAX requests (Cash on Delivery)
        // Check if this is an AJAX request
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        // Prepare response data
        $responseData = [
            'status' => 'success',
            'message' => 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm.',
            'order_id' => $order_chitiet['order_id']
        ];

        if ($isAjax) {
            // Set appropriate headers for JSON response
            header('Content-Type: application/json');
            echo json_encode($responseData);
            exit();
        } else {
            // Regular form submission (fallback)
?>
<script>
alert('Đặt hàng thành công! Cảm ơn bạn đã mua sắm.');
window.location.href = 'index.php?act=home';
</script>
<?php
            exit();
        }
    }
}
?>