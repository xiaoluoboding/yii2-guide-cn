<h1>安装Yii框架</h1>
<p>你可以通过两种方式来安装Yii框架：</p>
<ul>
	<li>通过<a href="2004.html">Composer</a></li>
	<li>通过下载一个所需文件以及Yii框架文件的应用模板</li>
</ul>
<p>推荐前者方式，这样只需一条简单的命令就可以安装新的Yii框架了。</p>
<p>&nbsp;</p>
<h2>通过Composer安装</h2>
<blockquote>
Composer是PHP中用来管理依赖（dependency）关系的工具。你可以在自己的项目中声明所依赖的外部工具库（libraries），Composer会帮你安装这些依赖的库文件。
</blockquote>
<p>了解了什么是Composer，那么推荐您使用Composer安装Yii框架。从这里下载Composer：<a href="http://getcomposer.org/">http://getcomposer.org/</a>，或直接运行下述命令：</p>
<pre class="brush: php;toolbar:false;">
curl -s http://getcomposer.org/installer | php
</pre>
<p>官方 Composer 指南如下：</p>
<ul>
<li><a href="http://getcomposer.org/doc/00-intro.md#installation-nix" target="_blank">Linux</a></li>
<li><a href="http://getcomposer.org/doc/00-intro.md#installation-windows" target="_blank">Windows</a></li>
</ul>
<p>如果遇到任何问题或者想更深入地学习 Composer，请参考 <a href="https://getcomposer.org/doc/" target="_blank">Composer 文档（英文）</a>，<a href="https://github.com/5-say/composer-doc-cn" target="_blank">Composer 中文</a>。</p>
<p>通过Composer，你可以使用Yii的现成应用程序模板来创建一个新的Yii站点。</p>
<p>目前有两个可用模板：</p>
<ul>
<li><a href="https://github.com/yiisoft/yii2-app-basic" target="_blank">Basic Application Template</a>, 一个基础的前台应用；</li>
<li><a href="https://github.com/yiisoft/yii2-app-advanced" target="_blank">Advanced Application Template</a>, 包含前后台，命令行资源，公共目录，以及环境配置、数据库连接。</li>
</ul>
<p>安装指南参考上述链接页面。关于这两个模板的详细介绍请参考：<a href="2001.html">基础应用模板</a> 和 <a href="1401.html">高级应用模板</a> 文档。</p>
<p>如果你不想使用模板，而想从头开始，请参考 <a href="#">自建应用程序结构</a> 文档。这种方法只推荐高级用户使用。</p>
<p>&nbsp;</p>
<h2>通过应用模板安装</h2>
<p>通过应用模板安装 Yii 包括两个步骤：</p>
<ol class="task-list">
<li>从 <a href="http://www.yiiframework.com/download/yii2-basic">yiiframework.com</a> 下载归档文件。</li>
<li>将下载的模板文件解压缩到 Web 目录中。</li>
<li>修改 <code>config/web.php</code> 文件，给 <code>cookieValidationKey</code> 配置项添加一个密钥（若你通过 Composer 安装，则此步骤会自动完成）：</li>
<pre class="brush: php;toolbar:false;">
// !!! 在下面插入一段密钥（若为空） - 以供 cookie validation 的需要
'cookieValidationKey' => '在此处输入你的密钥',
</pre>
</ol>
<p>&nbsp;</p>
<h2>配置 Web 服务器 <a name="user-content-configuring-web-servers"></a></h2>
<blockquote>
<p>补充：如果你现在只是要试用 Yii 而不是将其部署到生产环境中，本小节可以跳过。</p>
</blockquote>
<p>通过上述方法安装的应用程序在 Windows，Max OS X，Linux 中的 <a href="http://httpd.apache.org/" target="_blank">Apache HTTP 服务器</a>或 <a href="http://nginx.org/" target="_blank">Nginx HTTP 服务器</a> 上都可以直接运行。</p>
<p>在生产环境的服务器上，你可能会想配置服务器让应用程序可以通过 URL <code>http://www.example.com/index.php</code> 访问而不是 <code>http://www.example.com/basic/web/index.php</code>。这种配置需要将 Web 服务器的文档根目录指向 <code>basic/web</code> 目录。可能你还会想隐藏掉 URL 中的 <code>index.php</code>，具体细节在 <a href="0406.html">URL 管理</a> 一章中有介绍，你将学到如何配置 Apache 或 Nginx 服务器实现这些目标。</p>
<blockquote>
<p>补充：将 <code>basic/web</code> 设置为文档根目录，可以防止终端用户访问 <code>basic/web</code> 相邻目录中的私有应用代码和敏感数据文件。禁止对其他目录的访问是一个不错的安全改进。</p>
<p>补充：如果你的应用程序将来要运行在共享虚拟主机环境中，没有修改其 Web 服务器配置的权限，你依然可以通过调整应用的结构来提升安全性。</p>
</blockquote>
<h3>推荐使用的 Apache 配置 <a name="user-content-recommended-apache-configuration"></a></h3>
<p>在 Apache 的 <code>httpd.conf</code> 文件或在一个虚拟主机配置文件中使用如下配置。注意，你应该将 <code>path/to/basic/web</code> 替换为实际的 <code>basic/web</code> 目录。</p>
<pre class="brush: php;toolbar:false;">
# 设置文档根目录为 “basic/web”
DocumentRoot "path/to/basic/web"

&lt;Directory "path/to/basic/web">
    RewriteEngine on

    # 如果请求的是真实存在的文件或目录，直接访问
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # 如果请求的不是真实文件或目录，分发请求至 index.php
    RewriteRule . index.php

    # ...其它设置...
&lt;/Directory>
</pre>
<h3>推荐使用的 Nginx 配置 <a name="user-content-recommended-nginx-configuration"></a></h3>
<p>为了使用 <a href="http://wiki.nginx.org/" target="_blank">Nginx</a>，你应该已经将 PHP 安装为 <a href="http://php.net/install.fpm" target="_blank">FPM SAPI</a> 了。使用如下 Nginx 配置，将 <code>path/to/basic/web</code> 替换为实际的 <code>basic/web</code> 目录，<code>mysite.local</code> 替换为实际的主机名以提供服务。</p>
<pre class="brush: php;toolbar:false;">
server {
    charset utf-8;
    client_max_body_size 128M;

    listen 80; ## 监听 ipv4 上的 80 端口
    #listen [::]:80 default_server ipv6only=on; ## 监听 ipv6 上的 80 端口

    server_name mysite.local;
    root        /path/to/basic/web;
    index       index.php;

    access_log  /path/to/basic/log/access.log main;
    error_log   /path/to/basic/log/error.log;

    location / {
        # 如果找不到真实存在的文件，把请求重定向给 index.php
        try_files $uri $uri/ /index.php?$args;
    }

    # 若取消下面这段的注释，可避免 Yii 接管不存在文件的处理过程（404）
    #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
    #    try_files $uri =404;
    #}
    #error_page 404 /404.html;

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass   127.0.0.1:9000;
        #fastcgi_pass unix:/var/run/php5-fpm.sock;
    }

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
</pre>
<p>使用该配置时，你还应该在 <code>php.ini</code> 文件中设置 <code>cgi.fix_pathinfo=0</code> ，能避免掉很多不必要的 <code>stat()</code> 系统调用。</p>
<p>还要注意当运行一个 HTTPS 服务器时，需要添加 <code>fastcgi_param HTTPS on;</code> 一行，这样 Yii 才能正确地判断连接是否安全。</p>
