<h1>高级应用模板</h1>
<p>这个模板用于大型项目开发，前后台分离，便于团队分工和多服务器部署。相比基础模板，这个高级模板在功能上要多了些，并提供基本的数据库支持，注册、密码找回等功能。</p>
<p>&nbsp;</p>
<h2>安装</h2>
<h3>通过Composer安装</h3>
<p>如果你还没安装Composer，从这里下载<a href="http://getcomposer.org/">http://getcomposer.org/</a>，或者执行一条简单的命令：</p>
<pre class="brush: php;toolbar:false;">
curl -s http://getcomposer.org/installer | php
</pre>
<p>然后使用如下命令来安装Yii高级应用：</p>
<pre class="brush: php;toolbar:false;">
php composer.phar create-project --prefer-dist --stability=dev yiisoft/yii2-app-advanced /path/to/yii-application
</pre>
<p>&nbsp;</p>
<h2>入门</h2>
<p>安装应用后，必须执行以下步骤来初始化应用，只需做一次：</p>
<ol class="task-list">
<li>
<p>执行 <code>init</code> 命令并选择 <code>dev</code> 环境。</p>
<pre class="brush: php;toolbar:false;">
php /path/to/yii-application/init
</pre>
</li>
<li>创建新的数据库并在 <code>common/config/main-local.php</code> 相应地调整 <code>components db</code> 配置。</li>
<li>以控制台命令 <code>yii migrate</code> 运行数据库合并。</li>
<li>
<p>设置 web 服务器的文件根目录：</p>
</li>
</ol>
<ul class="task-list">
<li>前台是 <code>/path/to/yii-application/frontend/web/</code> ，使用 <code>http://frontend/</code> 访问。</li>
<li>后台是 <code>/path/to/yii-application/backend/web/</code> ，使用 <code>http://backend/</code> 访问。</li>
</ul>
<p>&nbsp;</p>
<h2>目录结构</h2>
<p>根目录包括以下子目录：</p>
<ul class="task-list">
	<li><code>backend</code> - web 应用后台</li>
	<li><code>common</code> - 所有应用共享的文件</li>
	<li><code>console</code> - 控制台应用</li>
	<li><code>environments</code> - 环境配置</li>
	<li><code>frontend</code> - web 应用前台</li>
</ul>
<p>根目录还包括以下一组文件：</p>
<ul class="task-list">
	<li><code>.gitignore</code> 包括 GIT 版本控制系统忽略的目录清单。有些文档不需要上传到源码版本库，就列入该文件。</li>
	<li><code>composer.json</code> - Composer 配置，细节描述在下面</li>
	<li><code>init</code> - 初始化脚本，和 Composer 配置在下面一起介绍</li>
	<li><code>init.bat</code> - Windows 下的初始化脚本</li>
	<li><code>LICENSE.md</code> - 版权文件，在此放你的项目许可，特别是开源项目</li>
	<li><code>README.md</code> - 安装模板的基础信息，可以用你的项目及安装相关信息来替换</li>
	<li><code>requirements.php</code> - Yii 必要环境检查文件</li>
	<li><code>yii</code> - 控制台应用引导文件</li>
	<li><code>yii.bat</code> - Windows 下的控制台应用引导文件</li>
</ul>
<p>&nbsp;</p>
<h2>预定义的路径别名</h2>
<ul class="task-list">
	<li>@yii - 框架目录</li>
	<li>@app - 当前运行应用的根路径</li>
	<li>@common - 通用目录</li>
	<li>@frontend - web 应用前台目录</li>
	<li>@backend - web 应用后台目录</li>
	<li>@console - 控制台目录</li>
	<li>@runtime - 当前运行 web 应用的运行期目录</li>
	<li>@vendor - Composer 包目录</li>
	<li>@web - 当前运行 web 应用的 URL</li>
	<li>@webroot - 当前运行 web 应用的 web 入口目录</li>
</ul>
<p>&nbsp;</p>
<h2>应用程序</h2>
<p>高级模板有三个应用：前台、后台和控制台。前台通常面向终端用户，项目自身。后台是管理平台，有数据分析等功能。控制台通常用于守护作业和底层服务器管理，也用于应用部署、数据库迁移和资源管理。</p>
<p>还有个 <code>common</code> 目录，包括的文件在不止一个应用中使用。如，<code>User</code> 模型。</p>
<p>前台和后台都是 web 应用，都包括 <code>web</code> 目录，这是设置服务器指向的 web 入口目录。</p>
<p>每个应用有其自己的命名空间和对应的路径别名，也适用于通用目录。</p>
<p>&nbsp;</p>
<h2>配置和环境</h2>
<p>用通常的做法来配置高级应用会产生很多问题：</p>
<ul class="task-list">
<li>每个应用成员都有自己的配置选项，提交这样的配置会影响其他成员（应用）.</li>
<li>生产环境的数据库密码和 API 密钥不应该出现在版本库里。</li>
<li>有很多服务器环境：开发、测试、发布。每个都应该有其单独的配置。</li>
<li>定义每个情况的所有配置选项是重复的，也需要太多时间维护。</li>
</ul>
<p>为解决这些问题， Yii 引入了简单的环境概念。每个环境用<code>environments</code> 目录下的一组文件表示。 <code>init</code> 命令用来切换环境，它所做的其实是从环境目录复制所有文件到全部应用所在的根目录。</p>
<p>典型的环境包括应用引导文件如 <code>index.php</code> 和后缀名为<code>-local.php</code> 的配置文件。这些要添加到 <code>.gitignore</code> ，不要提交到源码版本库。</p>
<p>为避免重复，配置可相互覆写。如，前台按以下顺序读取配置：</p>
<ul class="task-list">
<li><code>common/config/main.php</code></li>
<li><code>common/config/main-local.php</code></li>
<li><code>frontend/config/main.php</code></li>
<li><code>frontend/config/main-local.php</code></li>
</ul>
<p>参数按以下顺序读取：</p>
<ul class="task-list">
<li><code>common/config/params.php</code></li>
<li><code>common/config/params-local.php</code></li>
<li><code>frontend/config/params.php</code></li>
<li><code>frontend/config/params-local.php</code></li>
</ul>
<p>后面的配置文件会覆写前面的配置文件。</p>
<p>以下是完整配置方案：</p>
<p><img src="http://www.yiiframework.com/doc-2.0/images/advanced-app-configs.png" alt="Advanced application configs" /></p>
<p>&nbsp;</p>
<h2>配置 Composer</h2>
<p>应用模板安装后，调整缺省的<code> composer.json </code>是好的做法，该文件在根目录下：</p>
<pre class="brush: php;toolbar:false;">
{
    "name": "yiisoft/yii2-app-advanced",
    "description": "Yii 2 Advanced Application Template",
    "keywords": ["yii", "framework", "advanced", "application template"],
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
            "backend/runtime",
            "backend/web/assets",

            "console/runtime",
            "console/migrations",

            "frontend/runtime",
            "frontend/web/assets"
        ]
    }
}
</pre>
<p>首先升级基本信息，修改 <code>name</code>, <code>description</code>, <code>keywords</code>, <code>homepage</code> 和 <code>support</code> 以匹配你的项目。</p>
<p>现在是有趣的部分，可以添加更多项目所需的包到 <code>require</code> 部分。所有的包都来自<a href="https://packagist.org/">packagist.org</a>，请到该网站自由浏览有用的代码。</p>
<p>修改完 <code>composer.json</code> ，运行 <code>php composer.phar update --prefer-dist</code> 将下载包，完成后安装即可使用包了。Yii 会自动处理类的加载。</p>
<p>&nbsp;</p>
<h2>创建前后台链接</h2>
<p>网站常常需要创建后台到前台页面的链接。由于前台应用可能包含它自己的URL管理器规则，你需要为后台应用复制一份并重新命名：</p>
<pre class="brush: php;toolbar:false;">
return [
    'components' => [
        'urlManager' => [
            // 这是后台 URL 管理器配置
        ],
        'urlManagerFrontend' => [
            // 这是前台 URL 管理器配置
        ],

    ],
];
</pre>
<p>配置完成即可使用以下代码获得指向前台的 URL：</p>
<pre class="brush: php;toolbar:false;">
echo Yii::$app->urlManagerFrontend->createUrl(...);
</pre>
<blockquote>
<p>图文安装教程，参见我的博文：<a href="http://www.xlbd.net/xlbd/1995.html" target="_blank">通过Composer安装Yii2框架</a></p>
</blockquote>

