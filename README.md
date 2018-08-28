# YKCMF 企业系统

轻量级企业网站管理系统

## 环境要求:
* PHP >= 5.4.0(注意：PHP5.4dev版本和PHP6均不支持)
* PDO PHP Extension
* MBstring PHP Extension
* CURL PHP Extension
* 开启静态重写(方法参考:http://www.kancloud.cn/manual/thinkphp5/177576)
* 要求环境支持pathinfo
* 微信功能需要PHP >=5.5.9

## 重写设置
### [Apache]
httpd.conf配置文件中加载了mod_rewrite.so模块
AllowOverride None 将None改为 All
把下面的内容保存为.htaccess文件放到应用入口文件的同级目录下
 
```
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```
如果为phpstudy

```
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1]
</IfModule>
```
如果还是不行,请添加"?"

```
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
</IfModule>
```
### [IIS]
如果你的服务器环境支持ISAPI_Rewrite的话，可以配置httpd.ini文件，添加下面的内容：
```
RewriteRule (.*)$ /index\.php\?s=$1 [I]
```
在IIS的高版本下面可以配置web.Config，在中间添加rewrite节点：

```
<rewrite>
 <rules>
 <rule name="OrgPage" stopProcessing="true">
 <match url="^(.*)$" />
 <conditions logicalGrouping="MatchAll">
 <add input="{HTTP_HOST}" pattern="^(.*)$" />
 <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
 <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
 </conditions>
 <action type="Rewrite" url="index.php/{R:1}" />
 </rule>
 </rules>
 </rewrite>
```
### [Nginx]
在Nginx低版本中，是不支持PATHINFO的，但是可以通过在Nginx.conf中配置转发规则实现：
```
location / { // …..省略部分代码
   if (!-e $request_filename) {
   rewrite  ^(.*)$  /index.php?s=/$1  last;
   break;
    }
 }
```
其实内部是转发到了ThinkPHP提供的兼容URL，利用这种方式，可以解决其他不支持PATHINFO的WEB服务器环境。
如果你的应用安装在二级目录，Nginx的伪静态方法设置如下，其中youdomain是所在的目录名称。
```
location /youdomain/ {
    if (!-e $request_filename){
        rewrite  ^/youdomain/(.*)$  /youdomain/index.php?s=/$1  last;
    }
}
```

## [UPDATE]
v2.9.9
* 更新Thinkphp核心为5.0.20
* 修正了一些新版本不兼容的写法
* 该版本不再发布新功能

V2.3.1

* 增加前台菜单栏目修改
* 增加自定义模型单文件、多文件字段
* 增加自定义模型本地文件清理
* 增加文章列表快捷修改栏目
* 增加邮箱设置根据连接方式显示默认端口
* 增加部分输入表单type，利用html5特性过滤检测
* 兼容图片检测exif_imagetype，可以不需exif函数
* 更新TP核心框架至TP5.0.7
* 修复日志设置不显示控制器
* 修复多语言关闭，多处还显示多语言相关选项或栏目的问题
* 修复自定义菜单添加到后台菜单不含模块名的问题
* 修复自定义模型排序字段为date或datetime时不正确的问题
* 修复百度地图设置无效的问题

V2.3.0

* 增加插件机制
* 增加model模型,提升性能
* 增加手机模板主题设置
* 增加通过前台菜单快速发布文章
* 增加继续发布文章
* 更新TP核心框架至TP5.0.6
* 优化代码
* 规范代码编写
* 调整部分后台菜单结构
* 完善后台菜单编辑,自动调整子菜单
* 部分重要密钥类密码形式显示
* 部分html的css样式修改统一
* 修复部分bug

V2.2.0

* 将wechat独立为模块

V2.1.0

* 增加支付功能
* 微信公众号功能
* 修复部分bug

V2.0.2

* 完善模型管理
* 增加URL设置及URL美化功能
* 增加微信菜单管理
* 增加网站操作日志记录及管理
* 增加阿里短信功能
* 增加第三方登录开关
* 增加后台验证极验验证
* 增加TP框架log日志设置及定时清理
* 增加支付配置(功能待完善)
* 增加前台调用自定义模型demo
* 调整后台菜单结构
* 完善部分代码规范
* 修复部分bug

V2.0.1

* 更新核心框架到TP5.0.4
* 增加模型管理
* 修复部分bug

V2.0.0

* 更新核心框架到TP5.0.3
* 修复部分已知的BUG
* 增加分页ajax加载
* 增加七牛云存储支持
* 增加留言回复功能及管理
* 增加自定义标签库
* 增强文章管理筛选功能
* 增加多语言功能支持
* 增加前台登录记住功能
* 增加单文章分页功能支持
* 增加其它的操作便利性功能(太多就不例举)

V1.2.0
* 后台更新为ACE1.4最新版
* 修复部分已知的BUG

V1.1.1
* 增加后台在线更新(之后更新可以在线更新）
* 增加后台设置实时生效
* 文件上传实时写入文件管理数据库
* 前台查看别人时，隐藏IP
* 修复部分浏览器验证码不刷新


V1.1.0
* 增加后台日常维护功能
* 增加URL设置及URL美化功能
* 增加第三方登录
* 增加前台用户查看
* 整合后台JS
* 修复回收站发布人显示问题
* 修复URL模式设置导致资源文件路径错误
* 修复数据备份有可能失败的问题
* 修复其它的BUG


# 系统介绍

##各种设备自适应

- 响应式的网站设计能够对用户产生友好度，并且对于不同的分辨率能够灵活的进行操作应用。 简洁通俗表达就是页面宽度可以自适应屏幕大小，一个网站PC、手机、PAD通吃，页面地址一致。

- 一个字“酷“，可以用PC浏览器拉动窗口大小，网站内容显示依旧在设计之内，用户体验非常不错。 一个字“省”，一个网站PC、手机、PAD通吃，这样就不用花那么多心思去维护多个网站，无论是制作还是数据内容。


##基于HTML5技术

- HTML5对于用户来说，提高了用户体验，加强了视觉感受。HTML5技术在移动端，能够让应用程序回归到网页，并对网页的功能进行扩展，操作更加简单，用户体验更好。 

- HTML5技术跨平台，适配多终端。对于搜索引擎来说，HTML5新增的标签，使搜索引擎更加容易抓取和索引网页，从而驱动网站获得更多的点击流量。


##人性化的后台管理

- 传统的企业网站管理系统是以技术人员的角度出发，设计了很多复杂的功能，并且操作流程上也很复杂，对于最终要操控这个系统的管理员来说并不是很人性化，YKCMF所做的只是简化不必要的功能，从操作习惯下合理地布局和设计界面，让最普通的用户，即使没有网站管理的经营，也能很容易上手我们的系统。



# 许可协议

YKCMF企业系统遵循Apache2开源协议发布。Apache Licence是著名的非盈利开源组织Apache采用的协议。该协议和BSD类似，鼓励代码共享和尊重原作者的著作权，同样允许代码修改，再作为开源或商业软件发布。需要满足的条件:

1. 需要给代码的用户一份Apache Licence ；
2. 如果你修改了代码，需要在被修改的文件中说明；
3. 在延伸的代码中（修改和有源代码衍生的代码中）需要带有原来代码中的协议，商标，专利声明和其他原来作者规定需要包含的说明；
4. 如果再发布的产品中包含一个Notice文件，则在Notice文件中需要带有Apache Licence。你可以在Notice中增加自己的许可，但不可以表现为对Apache Licence构成更改。

具体的协议参考：[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)。