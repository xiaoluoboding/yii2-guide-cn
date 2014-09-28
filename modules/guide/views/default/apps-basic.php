<h1>基础应用模板</h1>
<p>基础应用模板很适合用来构建小型项目或者用来学习Yii框架。</p>
<p>模板包括4个页面：Home、About、contanct、Login。contact 页面有一个表单用来给用户向网站管理员提交询问信息。假设这个网站连接了一个邮件服务器并且管理员的邮箱已经被正确配置，这个表单将可以工作。登录页面也一样，允许对用户在访问授权内容前进行认证。</p>
<p>&nbsp;</p>
<h2>安装</h2>
<p>你可以通过<a href="2004.html">Composer</a>来安装这个模板。从这里下载Composer：<a href="http://getcomposer.org/" target="_blank">http://getcomposer.org/</a>，或者在Linux/Unix/MacOS平台上运行如下命令：</p>
<pre class="brush: php;toolbar: false">
curl -s http://getcomposer.org/installer | php
</pre>
<p>然后你可以使用如下命令创建一个基础应用程序：</p>
<pre class="brush: php;toolbar: false">
php composer.phar create-project --prefer-dist --stability=dev yiisoft/yii2-app-basic /path/to/yii-application
</pre>
<p>&nbsp;在Web服务器配置文件中设置 document root 目录为 /path/to/yii-application/web，你可以使用 URL <code>http://localhost/</code>&nbsp;来访问这个应用。</p>
<p>&nbsp;</p>
<h2>目录结构</h2>
<p>这个基础应用程序没有拆分太多目录：</p>
<ul>
<li><code>assets</code> - 应用程序资源文件。</li>
<li><code>AppAsset.php</code> - 定义应用程序资源比如 CSS, JavaScript 等等。可查阅 <a href="0311.html">Managing assets</a>&nbsp;获取更多细节。</li>
<li><code>commands</code> - 命令行控制器。</li>
<li><code>config</code> - 配置。</li>
<li><code>controllers</code> - 控制器。</li>
<li><code>models</code> - 模型。</li>
<li><code>runtime</code> - 日志、应用状态、文件缓冲。</li>
<li><code>views</code> - 视图模板。</li>
<li><code>web</code> - 网站根目录。</li>
</ul>
<p>根目录包含以下文件。</p>
<ul>
<li><code>.gitignore</code>&nbsp;不需要纳入git版本控制的文件和目录。</li>
<li><code>codeception.yml</code> - Codeception 配置。</li>
<li><code>composer.json</code> - Composer 配置。</li>
<li><code>LICENSE.md</code> - 版权信息。</li>
<li><code>README.md</code> - 该安装模板的基本信息。可替换成你的项目和安装信息。</li>
<li><code>requirements.php</code> - Yii 系统需求检查器。</li>
<li><code>yii</code> - 命令行应用程序启动脚本。</li>
<li><code>yii.bat</code> - Windows平台下的命令行启动脚本。</li>
</ul>
<h3>config目录</h3>
<p>config 目录包含如下配置文件：</p>
<ul>
<li><code>console.php</code> - 命令行应用程序的配置。</li>
<li><code>params.php</code> - 公共应用程序参数。</li>
<li><code>web.php</code> - web 应用程序配置。</li>
<li><code>web-test.php</code> - 功能测试时使用的 web 应用程序配置。</li>
</ul>
<p>所有这些文件都返回一个数组，用于配置相应应用程序的各个属性。查阅&nbsp;<a href="0505.html">Configuration</a> 指南部分来获取更多细节。</p>
<h3>views目录</h3>
<p>views 目录包含视图模板文件，在这个基础应用模板中有：</p>
<pre class="brush: php;toolbar: false">
layouts
    main.php
site
    about.php
    contact.php
    error.php
    index.php
    login.php
</pre>
layouts 包含HTML页面布局，即不包含主体内容的网页标记：文档类型、页头、主菜单、页脚，等等。其他文件通常是控制器视图。根据命名规范（ convention），这些视图文件被放在匹配控制器id的子目录下。比如对于 SiteController ，视图放在 site 目录下面。 而视图文件的名字则通常和控制器动作（action）名字相匹配。 局部视图（Partials）的命名则通常以下划线开始，比如_meta。
<h3>web目录</h3>
<p>web 目录是网站的根目录：</p>
<pre class="brush: php;toolbar: false">
assets
css
index.php
index-test.php
</pre>
<p><code>assets</code> 包含已发布的资源文件比如 CSS, JavaScript 等。发布过程是自动完成的，所以你不需要进行额外的操作，除了确保该目录具有足够的写权限。</p>
<p><code>css</code>&nbsp;包含简单的CSS文件，这对于不想被资源管理器压缩和合并的全局CSS文件是有用的。</p>
<p><code>index.php</code>&nbsp;Web应用的入口文件。</p>
<p><code>index-test.php</code>&nbsp;功能测试的入口文件。</p>
<p>&nbsp;</p>
<h2>配置 Composer</h2>
<p>修改根目录下的默认<code> composer.json </code>：</p>
<pre class="brush: php;toolbar: false">
{
    "name": "yiisoft/yii2-app-basic",
    "description": "Yii 2 Basic Application Template",
    "keywords": ["yii", "framework", "basic", "application template"],
    "homepage": "http://www.yiiframework.com/",
    "type": "project",
    "license": "BSD-3-Clause",
    "support": {
        "issues": "https://github.com/yiisoft/yii2/issues?state=open",
        "forum": "http://www.yiiframework.com/forum/",
        "wiki": "http://www.yiiframework.com/wiki/",
        "irc": "irc://irc.freenode.net/yii",
        "source": "https://github.com/yiisoft/yii2"
    },
    "minimum-stability": "dev",
    "require": {
        "php": ">=5.4.0",
        "yiisoft/yii2": "*",
        "yiisoft/yii2-swiftmailer": "*",
        "yiisoft/yii2-bootstrap": "*",
        "yiisoft/yii2-debug": "*",
        "yiisoft/yii2-gii": "*"
    },
    "scripts": {
        "post-create-project-cmd": [
            "yii\\composer\\Installer::setPermission"
        ]
    },
    "extra": {
        "writable": [
            "runtime",
            "web/assets"
        ],
        "executable": [
            "yii"
        ]
    }
}
</pre>
<p>首先更新基本信息，修改&nbsp;<code>name</code>, <code>description</code>, <code>keywords</code>, <code>homepage</code> 和 <code>support</code> 以和你的项目匹配。</p>
<p>你可以在<code>require</code> 部分添加更多软件包需求。这些软件包（packages）都来自&nbsp;<a href="https://packagist.org/" target="_blank">packagist.org</a>&nbsp;网站，你可以到该网站查找有用的代码。</p>
<p>修改完&nbsp;<code>composer.json</code>&nbsp;，你可以运行 <code>php composer.phar update --prefer-dist</code>, 这会下载并安装新的依赖软件包，然后你就可以使用它们。类（classes）将会被自动加载。</p>