<?php
/*
购物车添加功能

1、定义接口

    1.1 接受数据
        明确：数据库要插入商品编号/图片/价格等
        但是：后端不能响应前段提交过来的任何数据  每个都要过滤麻烦
        所以：只接受商品编号，用户编号
        至于：商品图片、价格  根据商品编号去数据库取
    1.2 操作数据库（增）
        脚下留心： 
        不能闭着眼睛插入，
        因为如果 这个用户已经购买了这个商品  这时候得更新
        select * from cart goods_id= and user_id
        真 已购买  更新
        假 未购买  插入 
        insert into
    1.3 响应结果

2、请求接口

*/



// 购物车列表
include './util.php';

// 1. 接受数据
$goodsId = @$_REQUEST['goodsId'];
$userId = @$_REQUEST['userId'];  // 先请求这个接口  用户编号写 1

if (!$goodsId || !$userId) response(400, '参数有误');

// 2. 操作数据库

    $pdo = new PDO('mysql:dbname=king', 'root', 'root');
    // 2.1 得判断下 当前商品在不在
    $pdoStatement = $pdo->query("select * from cart where goods_id={$goodsId} and user_id = {$userId}");
    $isFind = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    // var_dump($goodsInfo);die; 有-true，没有-false
    
    if ($isFind)
    {// 更新
        $rs = $pdo->exec("update cart set buy_num = buy_num +1 where goods_id={$goodsId} and user_id = {$userId}");
    } else {
    // 插入
        $pdoStatement = $pdo->query("select * from goods where id={$goodsId}");
        $goodsInfo = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $goodsImg = $goodsInfo['goods_img'];
        $goodsTitle = $goodsInfo['goods_title'];
        $goodsPrice = $goodsInfo['goods_price_small'];
        $createdAt = $updatedAt =  date('Y-m-d H:i:s', time());
        $rs = $pdo->exec("insert into cart 
            (goods_id,goods_img,goods_title,goods_attr,goods_price, 
            buy_num,user_id,created_at,updated_at)
            values ({$goodsId}, '{$goodsImg}', '{$goodsTitle}', '', '{$goodsPrice}', 1,  
            {$userId}, '{$createdAt}', '{$updatedAt}') ");
    }
// 3. 响应数据
if ($rs) {
    response(201, '操作成功');
} else {
    response(500, '操作失败');
}

