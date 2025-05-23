<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách chi tiết đơn hàng</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-bg-secondary">Id</th>
                    <th class="text-bg-secondary">Mã đơn hàng</th>
                    <th class="text-bg-secondary">Ảnh sản phẩm</th>
                    <th class="text-bg-secondary">Màu </th>
                    <Th class="text-bg-secondary">Size</Th>
                    <Th class="text-bg-secondary">Giá sản phẩm</Th>
                    <Th class="text-bg-secondary">Số lượng</Th>
                    <Th class="text-bg-secondary">Tổng tiền</Th>
                </tr>
            </thead>
            <tbody>
                <?php
        foreach ($chitietdh as $donhang) {
          extract($donhang);
        ?>
                <tr>
                    <td><?= $order_chitiet_id ?></td>
                    <td><?= $order_id ?></td>
                    <td><img src="./sanpham/img/<?php echo $pro_img ?>" class="w-25 h-50" alt=""></td>
                    <td><?= $color_name ?></td>
                    <td><?= $size_name ?></td>
                    <td><?= $pro_price ?></td>
                    <td><?= $soluong ?></td>
                    <td><?= $total_price ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Nút in hóa đơn -->
    <div class="mt-4 mb-4">
        <a href="indexadmin.php?act=in_hoadon&order_id=<?= $order_id ?>" class="btn btn-primary" target="_blank">
            <i class="bi bi-printer"></i> In hóa đơn bán hàng
        </a>
        <a href="indexadmin.php?act=donhang" class="btn btn-secondary">
            Quay lại danh sách đơn hàng
        </a>
    </div>
</div>