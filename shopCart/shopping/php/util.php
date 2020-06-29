<?php

// 工具文件

// 明确的时候：谁想要用这里面的方法
// 就  include './util.php' 导入一下
// 就相当于将整个文件中的代码 复制过去


/**
 * 统一响应请求方法
 * @param int    $state 200 201 400 401 500
 * @param string $msg
 * @param mixed  $data
 */
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