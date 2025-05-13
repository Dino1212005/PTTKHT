# PHP_ECOMMERCE

## Hệ thống Phân quyền và Đăng nhập

### 1. Phân loại người dùng

- **Người dùng thông thường (Khách hàng)**: `vaitro_id = 2`
- **Quản trị viên (Admin)**: `vaitro_id = 1`
- **Nhân viên**: `vaitro_id = 3, 4` và các vai trò khác

### 2. Đường dẫn đăng nhập

- **Trang đăng nhập người dùng**: `http://localhost/PTTKHT/PHP_Ecommerce-main/src/index.php?act=login`
- **Trang đăng nhập quản trị**: `http://localhost/PTTKHT/PHP_Ecommerce-main/src/Admin/indexadmin.php?act=home`

### 3. Lưu ý quan trọng

- Người dùng thông thường **KHÔNG THỂ** đăng nhập vào trang quản trị.
- Admin và nhân viên cần đăng nhập tại trang quản trị riêng.
- Nếu Admin cố gắng đăng nhập tại trang người dùng, hệ thống sẽ hiển thị thông báo và chuyển hướng tới trang đăng nhập quản trị.
- Nếu người dùng thông thường cố gắng truy cập trang quản trị, hệ thống sẽ từ chối và hiển thị thông báo lỗi.

### 4. Điều hướng

- Từ trang người dùng có thể vào trang đăng nhập admin thông qua đường dẫn ở phía dưới form đăng nhập.
- Từ trang đăng nhập admin có thể quay lại trang chủ người dùng thông qua đường dẫn ở phía dưới form đăng nhập.

### 5. Mặc định tài khoản

- **Admin**: email: `admin@gmail.com`, password: `Phonglb2004@`
- **Nhân viên**: email: `luongbaphong20041@gmail.com`, password: `Phonglb2004@`
- **Người dùng thông thường**: email: `trung@gmail.com`, password: `Quan123@`

### 6. Quyền truy cập

- Admin có toàn quyền quản lý hệ thống
- Nhân viên được phân quyền theo chức năng cụ thể
- Người dùng thông thường chỉ có thể sử dụng các chức năng mua sắm trên trang người dùng
