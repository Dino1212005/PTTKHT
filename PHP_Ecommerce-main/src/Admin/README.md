# Trang Quản Trị Hệ Thống

## Thông tin truy cập

- **URL đăng nhập**: `http://localhost/PTTKHT/PHP_Ecommerce-main/src/Admin/admin_login.php`
- **URL quản trị**: `http://localhost/PTTKHT/PHP_Ecommerce-main/src/Admin/indexadmin.php?act=home`
- **Chỉ dành cho**: Admin và nhân viên (vaitro_id khác 2)

## Tài khoản mặc định

- **Admin**:
  - Email: `admin@gmail.com`
  - Password: `Phonglb2004@`
  - Vai trò: vaitro_id = 1
- **Nhân viên**:
  - Email: `luongbaphong20041@gmail.com`
  - Password: `Phonglb2004@`
  - Vai trò: vaitro_id = 3

## Phân quyền trong hệ thống

Hệ thống phân quyền dựa trên các bảng:

- `vaitro`: Xác định vai trò của người dùng
- `quyen`: Danh sách các quyền trong hệ thống
- `chi_tiet_nhom_quyen`: Liên kết giữa vai trò và quyền

## Cấu trúc quản lý quyền

Các quyền chính trong hệ thống:

- Quản lý danh mục
- Quản lý sản phẩm
- Quản lý người dùng
- Quản lý bình luận
- Quản lý thống kê
- Quản lý đơn hàng
- Quản lý nhà cung cấp
- Quản lý màu
- Quản lý thương hiệu
- Quản lý phiếu nhập
- Quản lý phiếu bảo hành
- Quản lý phiếu đổi/trả
- Quản lý phân quyền
- Quản lý vai trò

## Lưu ý bảo mật

- Trang quản trị chỉ cho phép truy cập nếu đã đăng nhập và có quyền phù hợp
- Người dùng thông thường sẽ được chuyển hướng ra nếu cố gắng truy cập
- Mỗi hành động trong trang quản trị đều được kiểm tra quyền
- Admin có đầy đủ quyền, nhân viên được cấp quyền theo chức năng

## Hướng dẫn thêm quyền mới

1. Thêm mới quyền vào bảng `quyen`
2. Thêm liên kết giữa vai trò và quyền vào bảng `chi_tiet_nhom_quyen`
3. Bổ sung kiểm tra quyền tại các chức năng tương ứng

## Đường dẫn quan trọng

- `http://localhost/PTTKHT/PHP_Ecommerce-main/src/Admin/indexadmin.php`: Trang chủ quản trị
- `http://localhost/PTTKHT/PHP_Ecommerce-main/src/Admin/admin_login.php`: Trang đăng nhập quản trị
- `http://localhost/PTTKHT/PHP_Ecommerce-main/src/index.php`: Quay lại trang người dùng
