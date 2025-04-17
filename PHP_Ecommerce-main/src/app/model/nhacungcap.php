<?php
function load_ncc($ncc_id)
{
    $sql = "SELECT * FROM nhacungcap WHERE ncc_id = '$ncc_id'";
    $res = pdo_queryall($sql);
    return $res;
}

function loadAllNcc()
{
    $sql = "SELECT * FROM nhacungcap WHERE ncc_trangthai = 0";
    $res = pdo_queryall($sql);
    return $res;
}

function loadThongTinNCC($ncc_id)
{
    $sql = "SELECT * FROM nhacungcap WHERE ncc_id = '$ncc_id'";
    $res = pdo_queryall($sql);
    return $res;
}