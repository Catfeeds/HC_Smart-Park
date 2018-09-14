<?php return array(
    'yfcmf_version' => 'V2.9.9',
    'update_check' => false,
    'app_debug' => true,
    'app_trace' => true,
    'think_sdk_qq' =>
        array(
            'app_key' => '',
            'app_secret' => '',
            'display' => true,
            'callback' => 'http://www.echox.net/home/oauth/callback/type/qq.html',
        ),
    'think_sdk_sina' =>
        array(
            'app_key' => '',
            'app_secret' => '',
            'display' => true,
            'callback' => 'http://www.echox.net/home/oauth/callback/type/sina.html',
        ),
    'comment' =>
        array(
            't_open' => true,
            't_limit' => 60,
        ),
    'auth_config' =>
        array(
            'auth_on' => true,
            'auth_type' => 1,
            'auth_group' => 'auth_group',
            'auth_group_access' => 'auth_group_access',
            'auth_rule' => 'auth_rule',
            'auth_user' => 'admin',
        ),
    'baidumap_ak' => 'D91c810554767b49e3bdd2a7b25d97c1',
    'upload_validate' =>
        array(
            'size' => 10485760,
            'ext' =>
                array(
                    0 => 'jpg',
                    1 => 'gif',
                    2 => 'png',
                    3 => 'jpeg',
                ),
        ),
    'upload_path' => '/data/upload',
    'url_route_on' => true,
    'url_route_must' => false,
    'route_complete_match' => false,
    'url_html_suffix' => 'html',
    'storage' =>
        array(
            'storage_open' => false,
            'accesskey' => 'vIWB7GM5PhOwjVcOhQGP7Eq8dFKLpjORr5KGWiXf',
            'secretkey' => '9iXk4zlsUcDs9VwrXujdvklb5Bl7pqk0V_lttiPv',
            'bucket' => 'echox',
            'domain' => ' http://ov7uxfxnm.bkt.clouddn.com/',
        ),
    'lang_switch_on' => false,
    'default_lang' => 'zh-cn',
    'geetest' =>
        array(
            'geetest_on' => false,
            'captcha_id' => '',
            'private_key' => '',
        ),
    'log' =>
        array(
            'clear_on' => true,
            'timebf' => '10',
            'level' =>
                array(),
        ),
    'web_log' =>
        array(
            'weblog_on' => true,
            'not_log_module' =>
                array(
                    0 => 'install',
                ),
            'not_log_controller' =>
                array(
                    0 => 'home/Error',
                    1 => 'admin/Ajax',
                    2 => 'admin/Error',
                    3 => 'admin/Ueditor',
                ),
            'not_log_action' => NULL,
            'not_log_data' => NULL,
            'not_log_request_method' => NULL,
        ),
    'url_route_mode' => '2',
    'think_sdk_facebook' =>
        array(
            'app_key' => '',
            'app_secret' => '',
            'display' => false,
            'callback' => '',
        ),
    'payment' =>
        array(
            'alipay' =>
                array(
                    'account' => '',
                    'account_name' => '',
                    'partner' => '',
                    'md5_key' => '',
                    'rsa_private_key' => '/data/config/rsa_private_key.pem',
                    'notify_url' => 'http://www.echox.net/home/payment/ali_notify_url',
                    'return_url' => 'http://www.echox.net/home/payment/success',
                    'time_expire' => '14',
                    'sign_type' => 'MD5',
                    'display' => '1',
                ),
            'aliwappay' =>
                array(
                    'account' => '',
                    'account_name' => '',
                    'partner' => '',
                    'md5_key' => '',
                    'rsa_private_key' => '/data/config/rsa_private_key.pem',
                    'notify_url' => 'http://www.echox.net/home/payment/ali_notify_url',
                    'return_url' => 'http://www.echox.net/home/payment/success',
                    'time_expire' => '14',
                    'sign_type' => 'MD5',
                    'display' => '1',
                ),
            'wxpayqrcode' =>
                array(
                    'app_id' => '',
                    'md5_key' => '',
                    'mch_id' => '',
                    'notify_url' => 'http://www.echox.net/home/payment/wxqrcode_notify_url',
                    'time_expire' => '14',
                    'cert_path' => 'F:\\phpStudy\\WWW\\yfcms_dev\\YFCMF\\data\\conf\\wx\\apiclient_cert.pem',
                    'key_path' => 'F:\\phpStudy\\WWW\\yfcms_dev\\YFCMF\\data\\conf\\wx\\apiclient_key.pem',
                    'display' => '1',
                ),
            'wxpaypub' =>
                array(
                    'app_id' => 'wxxxxx',
                    'md5_key' => 'xxxxxx',
                    'mch_id' => 'xxxxx',
                    'notify_url' => 'http://www.echox.net/home/payment/wxpub_notify_url',
                    'cert_path' => 'F:\\phpStudy\\WWW\\yfcms_dev\\YFCMF\\data\\conf\\wx\\apiclient_cert.pem',
                    'key_path' => 'F:\\phpStudy\\WWW\\yfcms_dev\\YFCMF\\data\\conf\\wx\\apiclient_key.pem',
                ),
            'wxqrcode' =>
                array(
                    'time_expire' => '14',
                ),
            'tenpay' =>
                array(
                    'key' => '',
                    'partner' => '',
                ),
            'unionpay' =>
                array(
                    'key' => '',
                    'partner' => '',
                ),
            'palpay' =>
                array(
                    'business' => '',
                ),
        ),
    'think_sdk_weixin' =>
        array(
            'app_key' => '',
            'app_secret' => '',
            'display' => false,
            'callback' => '',
        ),
    'think_sdk_wechat' =>
        array(
            'app_key' => '',
            'app_secret' => '',
            'display' => false,
            'callback' => '',
        ),
    'think_sdk_google' =>
        array(
            'app_key' => '',
            'app_secret' => '',
            'display' => false,
            'callback' => '',
        ),
    'we_options' =>
        array(
            'we_name' => '',
            'we_id' => '',
            'we_number' => '',
            'app_id' => '',
            'secret' => '',
            'token' => '',
            'aes_key' => '',
            'we_type' => '',
        ),
    'addons_sql' => true,
    'think_sdk_sms' =>
        array(
            'AccessKeyId' => '',
            'accessKeySecret' => '',
            'signName' => '',
            'TemplateCode' => '',
            'sms_open' => NULL,
        ),
    'sms_out_time' => 120,
);