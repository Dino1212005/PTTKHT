<?php
if (isset($_SESSION['acount']) && $_SESSION['acount']) {

?>
<form action="index.php?act=order" method="post">
    <div class="row">
        <div class="col">
            <h3 class="mb-4 fs-5 fw-light text-uppercase border-bottom">SHIPMENT DETAILS</h3>
            <div class="form-group mt-3">
                <input type="text" class="form-control mt-2 fs-6 placeholder-sm " name="fullname" id="fullname"
                    placeholder="Enter your full name*" required>
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control mt-2 fs-6 placeholder-sm " name="kh_id" id="fullname"
                    placeholder="" value="<?= $_SESSION['acount']['kh_id'] ?>" hidden>
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control mt-2 fs-6 placeholder-sm " name="address" id="address"
                    placeholder="Enter your detailed address*" required>
            </div>
            <select name="city" class="form-select form-select-sm mb-3 mt-3" id="city" aria-label=".form-select-sm"
                required>
                <option value="" selected>Choose a province</option>
            </select>

            <select name="district" class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm"
                required>
                <option value="" selected>Select district</option>
            </select>

            <select name="ward" class="form-select form-select-sm" id="ward" aria-label=".form-select-sm" required>
                <option value="" selected>Choose a ward</option>
            </select>
            <div class="form-group mt-3">
                <input type="email" class="form-control mt-2 fs-6" name="email"
                    value="<?php echo $_SESSION['acount']['kh_mail']; ?>" placeholder="Enter your email*" required>
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control mt-2 fs-6" name="phone"
                    value="<?php echo $_SESSION['acount']['kh_tel']; ?>" placeholder="Enter your phone number*"
                    required>
            </div>
            <select name="thanhtoan" class="form-select form-select-sm mb-3 mt-3" id="payment_method"
                aria-label=".form-select-sm" required>
                <option value="">Phương Thức Thanh Toán</option>
                <option value="1">Thanh Toán Khi Nhận Hàng</option>
                <option value="2">Thanh Toán Online(VnPay)</option>
            </select>

            <div class="my-3">
                <textarea class="form-control" id="usernote" name="ordernote" rows="3"
                    placeholder="Notes to the seller"></textarea>
            </div>

        </div>
        <div class="col">


            <h3 class="mb-5 fs-5 fw-light text-uppercase border-bottom">Your Shopping Cart</h3>
            <?php
                if (isset($_GET['kh_id'])) {
                    $kh_id = $_GET['kh_id'];
                    $cart_kh = querycart_kh($kh_id);
                    $my_cart = querycart_chitiet($cart_kh['cart_id']);
                }
                $totalPrice = 0;
                $shipingPrice = 10;
                foreach ($my_cart as $cartItem) {
                    $pro = queryonepro($cartItem['pro_id']);
                    $cartprice_item = (int)$pro['pro_price'] * (int)$cartItem['soluong'];
                    $totalPrice += $cartprice_item;
                ?>
            <div>
                <div class="mt-3 cart-item d-flex gap-3 border-bottom align-items-center w-100">
                    <input type="text" name="size[]" id="" value="<?= $cartItem['size_id'] ?>" hidden>
                    <input type="text" name="color[]" id="" value="<?= $cartItem['color_id'] ?>" hidden>

                    <input type="text" value="<?= $pro['pro_id'] ?>" name="pro_id[]" hidden>
                    <img width="120 flex-shrink-0" class="rounded-4"
                        src="<?php echo "./Admin/sanpham/img/" . $pro['pro_img'] ?>">
                    <div class="d-flex flex-column flex-grow-1">
                        <h4 class="fs-6 fw-normal one-line-clamp w-75">Products name: <?php echo $pro['pro_name']; ?>
                        </h4>
                        <p class="fw-bold ">Price: $<?php echo $pro['pro_price']; ?></p>
                        <div class="d-flex align-items-end ">
                            <span class="me-3">Quantity: </span>
                            <input class="ps-2 w-25" type="number" name="soluong[]" min="1" max="99"
                                value="<?php echo $cartItem['soluong']; ?>">
                        </div>
                    </div>
                    <a
                        href="index.php?act=del_procart&cart_id_del=<?php echo $cartItem['cart_chitiet_id']; ?>&kh_id=<?= $kh_id ?>">
                        <button type="submit" name='del_cart' value=""
                            class="btn btn-link text-dark cart-remove-btn d-flex align-items-center justify-content-center">

                            <i class="bi bi-x fs-2"></i>
                        </button>
                    </a>

                </div>
            </div>
            <?php
                }
                ?>

            <div class="border-bottom-nopad mt-3">
                <div class="d-flex justify-content-between ">
                    <p class="text-light text-dark ">Subtotal</p>
                    <span class="fw-bold">$<?php echo $totalPrice; ?></span>
                </div>
                <div class="d-flex justify-content-between ">
                    <p class="text-light text-dark ">Shipping</p>
                    <span class="fw-bold">$<?php echo $shipingPrice; ?></span>
                </div>
                <div class="d-flex justify-content-between ">
                    <p class="text-light text-dark ">Discount</p>
                    <span class="fw-bold">0%</span>
                </div>
            </div>
            <div class="d-flex justify-content-between pt-2">
                <p class="text-light text-dark ">Total</p>
                <span class="fw-bold">$<?php echo $totalPrice + $shipingPrice; ?></span>
                <input type="text" name="tongtien" id="" value="<?php echo $totalPrice + $shipingPrice; ?>" hidden>
            </div>

            <button type="submit" name="placeordered" id="placeOrderBtn" class="btn btn-dark w-100 ">Place
                Order</button>

        </div>
    </div>
</form>

<!-- Order success modal -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderSuccessModalLabel">Đặt hàng thành công</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Cảm ơn bạn đã mua sắm</h4>
                    <p class="text-muted">Đơn hàng của bạn đã được đặt thành công</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="index.php?act=myAccount" class="btn btn-outline-secondary">Xem đơn hàng</a>
                <a href="index.php?act=home" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
var citis = document.getElementById("city");
var districts = document.getElementById("district");
var wards = document.getElementById("ward");
var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
    method: "GET",
    responseType: "application/json",
};
var promise = axios(Parameter);
promise.then(function(result) {
    renderCity(result.data);
});

function renderCity(data) {
    for (const x of data) {
        citis.options[citis.options.length] = new Option(x.Name, x.Id);
    }
    citis.onchange = function() {
        district.length = 1;
        ward.length = 1;
        if (this.value != "") {
            const result = data.filter(n => n.Id === this.value);

            for (const k of result[0].Districts) {
                district.options[district.options.length] = new Option(k.Name, k.Id);
            }
        }
    };
    district.onchange = function() {
        ward.length = 1;
        const dataCity = data.filter((n) => n.Id === citis.value);
        if (this.value != "") {
            const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

            for (const w of dataWards) {
                wards.options[wards.options.length] = new Option(w.Name, w.Id);
            }
        }
    };
}
</script>

<script>
// Form validation before submit
document.querySelector('form').addEventListener('submit', function(event) {
    // Prevent default form submission
    event.preventDefault();

    // Get all required inputs
    const fullname = document.getElementById('fullname').value.trim();
    const address = document.getElementById('address').value.trim();
    const city = document.getElementById('city').value;
    const district = document.getElementById('district').value;
    const ward = document.getElementById('ward').value;
    const email = document.querySelector('input[name="email"]').value.trim();
    const phone = document.querySelector('input[name="phone"]').value.trim();
    const paymentMethod = document.getElementById('payment_method').value;

    // Check if any required field is empty
    if (!fullname) {
        alert('Vui lòng nhập họ tên của bạn');
        return false;
    }

    if (!address) {
        alert('Vui lòng nhập địa chỉ chi tiết');
        return false;
    }

    if (!city) {
        alert('Vui lòng chọn tỉnh/thành phố');
        return false;
    }

    if (!district) {
        alert('Vui lòng chọn quận/huyện');
        return false;
    }

    if (!ward) {
        alert('Vui lòng chọn phường/xã');
        return false;
    }

    if (!email || !validateEmail(email)) {
        alert('Vui lòng nhập email hợp lệ');
        return false;
    }

    if (!phone || !validatePhone(phone)) {
        alert('Vui lòng nhập số điện thoại hợp lệ');
        return false;
    }

    if (!paymentMethod) {
        alert('Vui lòng chọn phương thức thanh toán');
        return false;
    }

    // If payment method is online (VnPay)
    if (paymentMethod == '2') {
        // Submit the form normally for VnPay redirection
        this.submit();
    } else {
        // Show loading state
        const orderBtn = document.getElementById('placeOrderBtn');
        orderBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
        orderBtn.disabled = true;

        // For Cash on Delivery payment
        // Send form data via AJAX
        var formData = new FormData(this);

        fetch('index.php?act=order', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .catch(() => {
                // If not JSON, assume success
                return {
                    status: 'success'
                };
            })
            .then(data => {
                // Show success in modal instead of alert
                var orderSuccessModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
                orderSuccessModal.show();

                // Clear cart visual indicators (optional)
                try {
                    document.querySelector('.cart-count').textContent = '0';
                } catch (e) {
                    // Ignore if element doesn't exist
                }

                // Reset button state
                orderBtn.innerHTML = 'Place Order';
                orderBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi đặt hàng, vui lòng thử lại.');

                // Reset button state
                orderBtn.innerHTML = 'Place Order';
                orderBtn.disabled = false;
            });
    }

    return false;
});

// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Phone validation
function validatePhone(phone) {
    const re = /^[0-9]{10,11}$/;
    return re.test(phone);
}
</script>
<?php
} else {
    include('CartEmpty.php');
}
?>