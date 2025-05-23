
    <div class="container">
        <h2 class="border border-4 mb-4 text-black-50 p-3 text-center rounded">Thêm mới chi tiết sản phẩm</h2>
        <div class="container text-bg-light rounded">

            <form action="indexadmin.php?act=addpro_ct" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
                <?php
                if (isset($_GET['prochitietid'])) {
                    $pro_id = $_GET['prochitietid'];
                    ?>
                
                <div class="mb-3 mt-3">
                    <label for="giasp" class="form-label text-danger">ID Sản Phẩm</label>
                    <input type="text" class="form-control" id="giasp" placeholder="ID SanR Phẩm" name="pro_id" value="<?= $pro_id ?>">
                </div>
                <?php
                    }
                    
                ?>
                <div class="mb-3 mt-3">
                    <label for="tensp" class="form-label text-danger">Màu</label>
                    <select class="form-select" id="danhmuc" name="color_id">
                        <?php
                        $color = query_allcolor();
                        foreach ($color as $clor) {
                        ?>
                            <option value="<?php echo $clor['color_id'] ?>"><?php echo $clor['color_name'] ?></option>
                        <?php
                        }
                        ?>

                    </select>
                </div>

                <div class="mb-3 mt-3">
                    <label for="danhmuc" class="form-label text-danger">Size</label>
                    <?php
                    $size = query_allsize();

                    ?>
                    <select class="form-select" id="danhmuc" name="size_id">
                        <?php
                        foreach ($size as $sz) {
                        ?>
                            <option value="<?php echo $sz['size_id'] ?>"><?php echo $sz['size_name'] ?></option>
                        <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="mb-3 mt-3">
                    <label for="giasp" class="form-label text-danger">Số Lượng</label>
                    <input type="text" class="form-control" id="giasp" placeholder="Số lượng" name="soluong">
                </div>





                <div class="">
                    <button type="submit" class="btn btn-secondary btn-sm" name="addsp_ct">Thêm Chi Tiết sản phẩm</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                    <a href="list.html">
                        <button type="button" class="btn btn-secondary btn-sm">Danh sách sản phẩm</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

     <script>
    function validateForm() {
        const proId = document.getElementsByName("pro_id")[0]?.value.trim();
        const colorId = document.getElementsByName("color_id")[0].value;
        const sizeId = document.getElementsByName("size_id")[0].value;
        const quantity = document.getElementsByName("soluong")[0].value.trim();

        if (!proId || proId === "") {
            alert("Thiếu ID sản phẩm.");
            return false;
        }

        if (!colorId || colorId === "0") {
            alert("Vui lòng chọn màu.");
            return false;
        }

        if (!sizeId || sizeId === "0") {
            alert("Vui lòng chọn size.");
            return false;
        }

        if (quantity === "" || isNaN(quantity) || parseInt(quantity) <= 0) {
            alert("Số lượng phải là một số nguyên dương.");
            return false;
        }

        return true; // Dữ liệu hợp lệ, cho phép submit
    }
</script>
