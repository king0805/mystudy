<?php

$id = @$_REQUEST['id']; // 购物车编号去删除

// 1. 连接数据库
$pdo = new PDO('mysql:dbname=king', 'root', 'root');
// 2. 操作数据库
$rs = $pdo->exec("delete from cart where id = {$id}");
 
// 3. 判断返回
if ($rs)
{
    response(201, "操作成功");
} else {
    response(500, "操作失败");
}



function response($state, $msg, $data = null)
{
    echo json_encode([
        "meta" => [
            "msg" => $msg,
            "state" => $state
        ],
        "data" => $data
    ]);

    die; // 终止代码执行
}
?>