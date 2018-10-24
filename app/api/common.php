<?php

use app\api\library\Aes;
use think\Db;
use think\cache\driver\Redis;

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

/**
 * @desc：获取图片真实后缀,支持base64
 * @param   name    文件名
 * @return  suffix  文件后缀
 */
function getimgsuffix($name)
{
    $info = getimagesize($name);
    $suffix = false;
    if ($mime = $info['mime']) {
        $suffix = explode('/', $mime)[1];
    }
    return $suffix;
}

/**
 * @param $url
 * @return string
 * 返回图片完整路径
 */
function get_app_imgurl($url)
{
    if (stripos($url, 'http') !== false) {
        //网络图片
        return $url;
    } else {
        return request()->domain() . $url;
    }
}

/**
 * @param $phone
 * @return mixed
 * 根据会员手机号获取ID
 */
function getUserIdByPhone($phone)
{
    $user_id = Db::name('MemberList')->where('member_list_tel', 'eq', $phone)->value('member_list_id');
    if ($user_id) {
        return $user_id;
    } else {
        return false;
    }
}

/**
 * @param $token
 * @return mixed
 * 根据token获取用户id
 */
function getUserIdByToken($token)
{
    //先解密token
    $token = Aes::decrypt($token);
    //去Redis拿$token的值,也就是登录时存进去的user_id
    $redis = new Redis();
    $user_id = $redis->get($token);
    if ($user_id) {
        return $user_id;
    } else {
        return false;
    }
}

/**
 * @param $code
 * @return array|false|PDOStatement|string|\think\Model
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * 根据企业码获取企业基本信息
 */
function getEnterpriseBasicInfoByCode($code)
{
    return Db::name('EnterpriseList')->where('enterprise_list_code', 'eq', $code)->find();
}

//XLS导出

/**
 * $name  string 文件名称
 * $header array 列标题
 * $dataResult  数组
 **/
function ExcelPull($name, $header, $data)
{
    //这一行没啥用,根据具体情况优化下
    $headTitle = "xx详情";
    $headtitle = "<tr style='height:50px;border-style:none;><td border=\"0\" style='height:90px;width:470px;font-size:22px;' colspan='11' >{$headTitle}</th></tr>";
    $titlename = "<tr>";
    foreach ($header as $v) {
        $titlename .= "<td>$v</td>";
    }
    $titlename .= "</tr>";
    $fileName = date("Y-m-d") . "-" . $name . ".xls";
    excelData($data, $titlename, $headtitle, $fileName);
}


/**
 * @param $data
 * @param $titlename
 * @param $title
 * @param $filename
 */
function excelData($data, $titlename, $title, $filename)
{
    $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
    $str .= "<table border=1>" . $titlename;
    $str .= '';
    foreach ($data as $key => $rt) {
        $str .= "<tr>";
        foreach ($rt as $v) {
            $str .= "<td >{$v}</td>";
        }
        $str .= "</tr>\n";
    }
    $str .= "</table></body></html>";
    $str .= "<span>creator:" . '管理员' . "</span>";
    header("Content-Type: application/vnd.ms-excel; name='excel'");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $filename);
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    exit($str);
}