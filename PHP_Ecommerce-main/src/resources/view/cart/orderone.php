<?php
if (isset($_POST['placeordered'])) {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $soluong = $_POST['soluong'];
    $pro_id = $_POST['pro_id'];
    $kh_id  = $_POST['kh_id'];
    $products = queryonepro($pro_id);
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

    // Get product details and update inventory
    $pro_soluong = query_pro_soluong($pro_id, $color, $size);
    $sl = $pro_soluong['soluong'];

    // Add order details
    add_chitietdonhang($order_chitiet['order_id'], $pro_id, $color, $size, $products['pro_price'], $soluong);

    // Update product quantity
    $sql = "update pro_chitiet set soluong = $sl - $soluong where pro_id = $pro_id and size_id = $size and color_id = $color";
    pdo_execute($sql);

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