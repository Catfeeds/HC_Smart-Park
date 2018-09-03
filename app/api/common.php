<?php
/**
 * @param $status 业务状态码
 * @param $message 提示信息
 * @param array $data 数据
 * @param int $httpCode http状态码
 * @return \think\response\Json
 * 通用的api数据输出方法
 */
function show($status, $message, $data = [], $httpCode = 200)
{
    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
    return json($data, $httpCode);
}