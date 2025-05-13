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
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TmnCode = "CGXZLS0Z"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "XNBCJFAKAZQSGTARRLGCHVZWCIOIGSHN"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/da1/src/";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        // end config
        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $_POST['tongtien']; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = 'NCB'; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $tongtien * 100000,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        header('Location: ' . $vnp_Url);
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