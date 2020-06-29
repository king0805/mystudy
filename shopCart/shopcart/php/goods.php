<?php
// 就相当于将整个文件里面的PHP代码
// 复制过来使用
include './util.php';

// response(200, '操作成功');



// 1. 接受数据(如果写分页就需要了)

// 2. 操作数据库
$pdo = new PDO('mysql:dbname=king', 'root', 'root');
$pdoStatement = $pdo->query("select * from goods");
$datas = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

// 3. 响应数据
response(200, '操作成功', $datas);