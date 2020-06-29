<?php

include './util.php';

// 1. 接受数据（用户名和密码）
$uname = @$_REQUEST['uname'];
$pwd = @$_REQUEST['pwd'];

if (!$uname || !$pwd) response(400, '参数有误');

// 2. 操作数据库
    // 1. 根据用户名查用户
    $pdo = new PDO('mysql:dbname=king', 'root', 'root');
    $pdoStatement = $pdo->query("select * from user where username = '{$uname}'");
    $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    // 2. 检测密码是否正确
    if (!$data) response(400, '用户名或密码错误');
    if ($data['pwd'] != $pwd) response(401, '用户名或密码错误');
    
// 3. 响应结果
response(200, '登录成功', [
    'id' => $data['id'],
    // md5是一个过时的加密算法
    // 在js中拼接用+
    // 在php中用点.
    'token' => md5($data['id'].'king'),
    'uname' => $data['username']
]);

