<?php

namespace addons\weather;

use think\Addons;

/**
 * 插件信息
 */
class weather extends Addons
{
    public $info = [
        'name' => 'Weather',
        'title' => '天气',
        'description' => '当时当地天气情况',
        'status' => 0,
        'author' => 'echox',
        'version' => '0.1',
        'admin' => '0'
    ];

    /**
     * @var array 插件钩子
     */
    public $hooks = [
        // 钩子名称 => 钩子说明
        'weather' => '天气钩子'
    ];

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }


    /**
     * @return mixed|string
     * @throws \Exception
     * *实现的weather钩子方法
     * @return mixed
     */
    public function weather()
    {
        $config = $this->getConfig();
        $ip = \request()->ip();
//        兼容IPv6
        if ($ip == '127.0.0.1' || $ip == 'localhost' || $ip == '0000:0000:0000:0000:0000:0000:0000:0001' || $ip == '::1') {
            $weather = "暂无天气情况";
        } else {
            if ($config['display']) {

//            这里编写代码逻辑
                $weatherInfo = $this->getWeather($ip);
                $weather = $weatherInfo['1'] . '今天的天气：' . $weatherInfo['7'] . '；' . '最高温度：' . $weatherInfo['11'] . '；' . '最低温度' . $weatherInfo['12'] . '。';

            }
        }
        $this->assign('weather', $weather);
        return $this->fetch('weather');

    }

    /**
     * @return bool|string
     * 获取当地天气
     */
    function getWeather($ip)
    {
        // 心知天气接口调用凭据
        $key = '2iwriiwlof8hguka';
        $uid = 'U3D625A2D9';
        // 参数
        $api = 'https://api.seniverse.com/v3/weather/daily.json'; // 接口地址
        $location = $ip; // 城市名称。除拼音外，还可以使用 v3 id、汉语等形式
        // 生成签名。文档：https://www.seniverse.com/doc#sign
        $param = [
            'ts' => time(),
            'ttl' => 300,
            'uid' => $uid,
        ];
        $sig_data = http_build_query($param); // http_build_query会自动进行url编码
        // 使用 HMAC-SHA1 方式，以 API 密钥（key）对上一步生成的参数字符串（raw）进行加密，然后base64编码
        $sig = base64_encode(hash_hmac('sha1', $sig_data, $key, TRUE));
        // 拼接Url中的get参数。文档：https://www.seniverse.com/doc#daily
        $param['sig'] = $sig; // 签名
        $param['location'] = $location;
        $param['start'] = 0; // 开始日期。0=今天天气
        $param['days'] = 1; // 查询天数，1=只查一天
        // 构造url
        $url = $api . '?' . http_build_query($param);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_ENCODING, 'utf8');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $weather = json_decode(($output), true);
        $weather = arrToOne($weather);
        return $weather;
    }
}
