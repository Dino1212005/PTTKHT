<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách nhà cung cấp</h2>
    <form action="" class="mb-4" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <input class="w-100 p-1" type="text" placeholder="Search" name="searchNCC" />
            </div>
            <div class="col-sm-4">
                <select name="sapXepNCC" id="">
                    <option value="">Sắp xếp theo tên sản phẩm</option>
                    <option value="">Sắp xếp theo tên NCC</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select name="sapXepTheoThuTu" id="">
                    <option value="">A-Z</option>
                    <option value="">Z-A</option>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-secondary w-100" name="timkiem">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">ID</th>
                    <th class="text-bg-secondary">Tên NCC</th>
                    <Th class="text-bg-secondary">Email</Th>
                    <Th class="text-bg-secondary">SĐT</Th>
                    <th class="text-bg-secondary">Địa chỉ</th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listNCC as $item) {
                    extract($item);
                    $countsp = loadAllNCC($ncc_id);
                ?>
                <tr>
                    <td><input type="checkbox" name="checkbox" id=""></td>
                    <td><?= $ncc_id ?></td>
                    <td>
                        <?= $ncc_name ?>
                    </td>
                    <td><?= $ncc_email ?></td>
                    <td><?= $ncc_sdt ?></td>
                    <td><?= $ncc_diachi ?></td>

                    <td>
                        <a href="indexadmin.php?act=suaNCC&ncc_id=<?php echo $ncc_id ?>" class="mb-2"><input
                                class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>

                        <a href="indexadmin.php?act=xoaNCC&ncc_id=<?php echo $ncc_id ?>"><input
                                class="mb-2 text-bg-success rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')"
                                type="button" name="" value="Xoá" id=""></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="">
        <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
    </div>
</div>