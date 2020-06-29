<?php

include 'util.php';

/*
向购物车添加商品

一、定义接口
  1. 接受数据
    
    商品编号
    用户编号

    过滤：如果是否传递，最好严谨写还得判断数据库是否存在

  2. 操作数据库

    // 条  件：用户编号 && 商品编号
    // 存  在：更新 update
    // 不存在：添加 insert

二、请求接口

*/

$pdo = new PDO('mysql:dbname=king','root', 'root');

// 1. 接受数据
$goodsId = @$_REQUEST['goodsId'];
$userId = @$_REQUEST['userId'];
$token = @$_REQUEST['token'];

// 是否传递
if (!$goodsId || !$userId || !$token) response(400, '参数有误');
if ($token != md5($userId.'king')) response(400, 'TOKEN校验失败');

// 检测参数是否真实
$pdoStatement = $pdo->query("select * from user where id = {$userId}");
$userInfo = $pdoStatement->fetch(PDO::FETCH_ASSOC);
if (!$userInfo) response(400, '参数有误-用户不存在');

$pdoStatement = $pdo->query("select * from goods where id = {$goodsId}");
$goodsInfo = $pdoStatement->fetch(PDO::FETCH_ASSOC);
if (!$goodsInfo) response(400, '参数有误-商品不存在');


// 2. 操作数据库（插入或修改）

    // 1. 检测购物车表是否存在：存在-更新，不存在-插入
    $pdoStatement = $pdo->query("select * from cart where user_id = {$userId} and goods_id = {$goodsId}");
    $isFind = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    if ($isFind)
    {// 更新购物车
        $rs = $pdo->exec("update cart set buy_num = buy_num+1 where user_id = {$userId} and goods_id = {$goodsId}");
    } else {
    // 插入

        $goodsImg = $goodsInfo['goods_img'];
        $goodsTitle = $goodsInfo['goods_title'];
        $goodsPrice = $goodsInfo['goods_price_small'];
        $time = date('Y-m-d H:i:s', time());

        $rs = $pdo->exec("insert into cart 
        (goods_id, goods_img, goods_title,
        goods_attr, goods_price, buy_num,
        user_id, created_at, updated_at)
        values
        ({$goodsId}, '{$goodsImg}', '{$goodsTitle}',
         '', '{$goodsPrice}', 1,
         {$userId}, '{$time}', '{$time}'
        )");
    }

    

// 3. 响应

if ($rs) {
    response(201, '操作成功');
} else {
    response(500, '操作失败');
}