<?php
include './util.php';

// 1. 接受数据
$userId = @$_REQUEST['userId'];
$goodsId = @$_REQUEST['goodsId'];
$buyNum = @$_REQUEST['buyNum'];

if (!$userId || !$goodsId || !$buyNum) response(400, '参数有误');

// 2. 操作数据库
$pdo = new PDO('mysql:dbname=king','root', 'root');
// 切记得校验库存是否充足
$pdoStatement = $pdo->query("select * from goods where id = {$goodsId}");
$goodsInfo = $pdoStatement->fetch(PDO::FETCH_ASSOC);
if (!$goodsInfo) response(400, '参数有误-商品不存在');
if ($goodsInfo['goods_num'] < $buyNum ) response(400, "【{$goodsInfo['goods_title']}】库存不足");
$rs = $pdo->exec("update cart set buy_num = {$buyNum} where user_id = {$userId} and goods_id = {$goodsId}");

// 3. 响应数据
if ($rs) {
    response(200, '操作成功');
} else {
    response(500, '操作失败');
}

