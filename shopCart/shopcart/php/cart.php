<?php
// 购物车列表
include './util.php';

// 1. 接受数据（需要获取当前用户的商品）
$userId = @$_REQUEST['userId'];

if (!$userId) response(400, '参数有误');

// 2. 操作数据库
$pdo = new PDO('mysql:dbname=king', 'root', 'root');
$pdoStatement = $pdo->query("select * from cart where user_id = {$userId}");
$datas = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

// 3. 响应数据
response(200, '操作成功', $datas);

