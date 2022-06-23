<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$idx = $_REQUEST['idx'];

$query = 
        "
            SELECT
                aa.goodsname,
                bb.server_feature,
                bb.dump_col,
                cc.tid,
                aa.amt
            FROM pay_result aa, server_info bb, user cc 
            WHERE
                aa.idx = '${idx}'
                and cc.idx = aa.user_idx
                and bb.idx = cc.server_name
         ";

$result = sql_query($query);
$emparray = array();
while($row = mysqli_fetch_assoc($result)){
    $emparray[] = $row;
}
echo json_encode($emparray);
?>
