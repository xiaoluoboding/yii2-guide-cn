<h1>Composer</h1>
<p>Yii2 使用 Composer 作为其依赖库管理工具。Composer 是一个 PHP 实用程序，可以自动处理所需的库和扩展的安装。 ，从而使这些第三方资源时刻保持更新，你无需再手动管理项目的各种依赖项。</p>
<p>&nbsp;</p>
<h2>安装 Composer</h2>
<p>请参考 Composer 官方提供的对应你操作系统的安装指南来安装 Composer。</p>
<ul class="task-list">
<li><a href="http://getcomposer.org/doc/00-intro.md#installation-nix">Linux</a></li>
<li><a href="http://getcomposer.org/doc/00-intro.md#installation-windows">Windows</a></li>
</ul>
<p>你可以在官方指南中找到全部的细节，这之后，你要么直接在 <a href="http://getcomposer.org/">http://getcomposer.org/</a> 下载 Composer，要么运行下列 命令在下载该软件：</p>
<pre class="brush: php;toolbar:false;">
curl -s http://getcomposer.org/installer | php
</pre>
<p>我们强烈建议你在本地安装一个全局的 Composer。</p>
<p>&nbsp;</p>
<h2>使用 Composer</h2>
<p>前面讲过<a href="0201.html">安装Yii框架</a>时，可以通过如下命令来安装Yii框架：</p>
<pre class="brush: php;toolbar:false;">
composer.phar create-project --stability dev yiisoft/yii2-app-basic
</pre>
<p>上述命令会为你的项目创建一个新的根目录，包含 <code>composer.json</code> 和 <code>compoer.lock</code> 文件。</p>
<p>前者罗列了应用程序所需的软件包，包含了版本约束信息，后者跟踪所有的安装包以及在某特定版本下的依赖关系。因此 <code>composer.lock</code> 文件也应该被<a href="https://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file" target="_blank">提交到你的版本控制系统中</a>。</p>
<p>这两个文件和两个合成器命令 <code>update</code> 和 <code>install</code> 强关联，在项目开发时，比如创建一个开发分支或部署，你会用到：</p>
<pre class="brush: php;toolbar:false;">
composer.phar install
</pre>
<p>以确保你安装跟 <code>composer.lock</code>注明版本一样的包。</p>
<p>若你只想单单更新你项目中的某一些包，你应该运行</p>
<pre class="brush: php;toolbar:false;">
composer.phar update
</pre>
<p>举例来说，<code>dev-master</code> 里的包，会在你调用 <code>update</code> 时，始终使用最新版本的包；而在你调用 <code>install</code> 时则不会，除非你已经更新过 <code>composer.lock</code> 文件。</p>
<p>对于上面的命令，其实还有一些可选的参数，分别有不同的作用。最常用的就是 <code>--no-dev</code> 命令，他会跳过那些声明在 <code>require-dev</code> 处的包。还有 <code>--prefer-dist</code>，他会在有可下载的包的时候就直接下载他们的压缩包，而不去检查 <code>vendor</code> 文件夹中的那些代码仓库。</p>
<blockquote>
<p>Composer 命令必须在你的 Yii 项目的文件夹中被执行，来让 Composer 找到 <code>composer.json</code> 文件。 这取决于你的操作系统和安装方式，可能你需要设置php可执行环境变量 和 <code>composer.phar</code> 脚本。</p>
</blockquote>
<p>&nbsp;</p>
<h2>为项目添加更多包</h2>
<p>用下列命令添加两个新的包到你的项目中：</p>
<pre class="brush: php;toolbar:false;">
composer.phar require "michelf/php-markdown:>=1.3" "ezyang/htmlpurifier:>4.5.0"
</pre>
<p>Composer 会分析依赖关系并更新你的 <code>composer.json</code> 文件。上述示例表示需要一个1.3或更高版本的 Michaelf的 PHP-Markdown 软件包以及4.5.0以上版本的 Ezyang的HTMLPurifier。</p>
<p>这部分的语法细节，请阅读 <a href="https://getcomposer.org/doc/01-basic-usage.md#package-versions" target="_blank">official Composer documentation</a>或正在更新的<a href="https://github.com/5-say/composer-doc-cn" target="_blank">Composer 中文文档https://github.com/5-say/composer-doc-cn</a>。</p>
<p>合成器支持的可用PHP软件包完整列表可以查阅 <a href="http://packagist.org/" target="_blank">packagist</a>. 你还可以通过输入 <code>composer.phar require</code> 来搜索软件包。</p>
<h3>手动编辑版本约束</h3>
<p>你也许想手动编辑 <code>composer.json</code> 文件。你可以在 <code>require</code> 部分指定所需软件包的名称和版本，和上述命令一样：</p>
<pre class="brush: php;toolbar:false;">
{
    "require": {
        "michelf/php-markdown": "&gt;=1.4",
        "ezyang/htmlpurifier": "&gt;=4.6.0"
    }
}
</pre>
<p>编辑完 <code>composer.json</code>, 你可以触发合成器来下载这个更新的依赖库，执行如下命令：</p>
<pre class="brush: php;toolbar:false;">
composer.phar update michelf/php-markdown ezyang/htmlpurifier
</pre>
<blockquote>
<p>这可能需要额外的配置（比如，你需要在配置文件中注册一个模块），但是合成器将自动处理类自动加载。</p>
</blockquote>
<p>&nbsp;</p>
<h2>使用软件包的特定版本</h2>
<p>Yii 通常使用最新兼容版本，不过也允许你使用老版本。比如jQuery 2.x 版本将不再支持某些老版本的IE浏览器 （<a href="http://jquery.com/browser-support/" target="_blank">dropped old IE browser support</a>）。当通过合成器来安装Yii时，jQuery最新2.x版本将被安装。如果你出于IE浏览器兼容需求而需要使用 jQuery 1.10，你可以像下面这样调整版本信息：</p>
<pre class="brush: php;toolbar:false;">
{
    "require": {
        ...
        "yiisoft/jquery": "1.10.*"
    }
}
</pre>
<h2>FAQ</h2>
<h3>收到"You must enable the openssl extension to download files via https"错误提示</h3>
<p>（意指你必须打开openssl扩展来通过https下载文件）如果你正在使用（WAMP），请看 <a href="http://stackoverflow.com/a/14265815/1106908" target="_blank">StackOverflow 上的这篇问答（英文）</a>。</p>
<h3>收到"Failed to clone , git was not found, check that it is installed and in your Path env."错误提示</h3>
<p>（意思是的git克隆失败：没找到git，你需要确认已经安装了git或者检查PATH环境）你可以通过要么安装git，要么在 <code>install</code> 或 <code>update</code> 命令的结尾添加 <code>--prefer-dist</code> 参数来解决。</p>
<h3>我应该向代码池中提交 Vendor 文件夹下的依赖库么?</h3>
<p>简而言之：否，不应该。想看详细解释，<a href="https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md" target="_blank">参见这里</a>.</p>
<h2>另见</h2>
<ul class="task-list">
<li><a href="http://getcomposer.org" target="_blank">Composer官方文档|Official Composer documentation</a>.</li>
</ul>
