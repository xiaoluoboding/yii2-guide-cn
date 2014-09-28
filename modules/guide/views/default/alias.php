<h1>别名（Aliases）</h1>
<p>别名用来表示文件路径和 URL，这样就避免了在代码中硬编码一些绝对路径和 URL。一个别名必须以 <code>@</code> 字符开头，以区别于传统的文件路径和 URL。Yii 预定义了大量可用的别名。例如，别名 <code>@yii</code> 指的是 Yii 框架本身的安装目录，而 <code>@web</code> 表示的是当前运行应用的根 URL。</p>
<p>&nbsp;</p>
<h2>定义别名</h2>
<p>你可以调用 [[Yii::setAlias()]] 来给文件路径或 URL 定义别名：</p>
<pre class="brush: php;toolbar: false">
// 文件路径的别名
Yii::setAlias('@foo', '/path/to/foo');

// URL 的别名
Yii::setAlias('@bar', 'http://www.example.com');
</pre>
<blockquote>
<p>注意：别名所指向的文件路径或 URL 不一定是真实存在的文件或资源。</p>
</blockquote>
<p>可以通过在一个别名后面加斜杠 <code>/</code> 和一至多个路径分段生成新别名（无需调用 [[Yii::setAlias()]]）。我们把通过 [[Yii::setAlias()]] 定义的别名称为<strong>根别名</strong>，而用他们衍生出去的别名成为<strong>衍生别名</strong>。例如，<code>@foo</code> 就是根别名，而 <code>@foo/bar/file.php</code> 是一个衍生别名。</p>
<p>你还可以用别名去定义新别名（根别名与衍生别名均可）：</p>
<pre class="brush: php;toolbar: false">Yii::setAlias('@foobar', '@foo/bar');</pre>
<p>根别名通常在引导阶段定义。比如你可以在入口脚本里调用 [[Yii::setAlias()]]。为了方便起见，应用提供了一个名为 <code>aliases</code> 的可写属性，你可以在应用<a href="0505.html">配置</a>中设置它，就像这样：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'aliases' => [
        '@foo' => '/path/to/foo',
        '@bar' => 'http://www.example.com',
    ],
];
</pre>
<p>&nbsp;</p>
<h2>解析别名</h2>
<p>你可以调用 [[Yii::getAlias()]] 命令来解析根别名到对应的文件路径或 URL。同样的页面也可以用于解析衍生别名。例如：</p>
<pre class="brush: php;toolbar: false">
echo Yii::getAlias('@foo');               // 输出：/path/to/foo
echo Yii::getAlias('@bar');               // 输出：http://www.example.com
echo Yii::getAlias('@foo/bar/file.php');  // 输出：/path/to/foo/bar/file.php
</pre>
<p>由衍生别名所解析出的文件路径和 URL 是通过替换掉衍生别名中的根别名部分得到的。</p>
<blockquote>
<p>注意：[[Yii::getAlias()]] 并不检查结果路径/URL 所指向的资源是否真实存在。</p>
</blockquote>
<p>根别名可能也会包含斜杠 <code>/</code>。[[Yii::getAlias()]] 足够智能到判断一个别名中的哪部分是根别名，因此能正确解析文件路径/URL。例如：</p>
<pre class="brush: php;toolbar: false">
Yii::setAlias('@foo', '/path/to/foo');
Yii::setAlias('@foo/bar', '/path2/bar');
echo Yii::getAlias('@foo/test/file.php');  // 输出：/path/to/foo/test/file.php
echo Yii::getAlias('@foo/bar/file.php');   // 输出：/path2/bar/file.php
</pre>
<p>若 <code>@foo/bar</code> 未被定义为根别名，最后一行语句会显示为 <code>/path/to/foo/bar/file.php</code>。</p>
<p>&nbsp;</p>
<h2>使用别名</h2>
<p>别名在 Yii 的很多地方都会被正确识别，无需调用 [[Yii::getAlias()]] 来把它们转换为路径/URL。例如，[[yii\caching\FileCache::cachePath]] 能同时接受文件路径或是指向文件路径的别名，因为通过 <code>@</code> 前缀能区分它们。</p>
<pre class="brush: php;toolbar: false">
use yii\caching\FileCache;

$cache = new FileCache([
    'cachePath' => '@runtime/cache',
]);
</pre>
<p>请关注 API 文档了解特定属性或方法参数是否支持别名。</p>
<p>&nbsp;</p>
<h2>预定义的别名</h2>
<p>Yii 预定义了一系列别名来简化常用路径和 URL的使用：</p>
<ul class="task-list">
<li><code>@yii</code> - <code>BaseYii.php</code> 文件所在的目录（也被称为框架安装目录）</li>
<li><code>@app</code> - 当前运行的应用 [[yii\base\Application::basePath|根路径（base path）]]</li>
<li><code>@runtime</code> - 当前运行的应用的 [[yii\base\Application::runtimePath|运行环境（runtime）路径]]</li>
<li><code>@vendor</code> - [[yii\base\Application::vendorPath|Composer 供应商目录]]</li>
<li><code>@webroot</code> - 当前运行应用的 Web 入口目录</li>
<li><code>@web</code> - 当前运行应用的根 URL</li>
</ul>
<p><code>@yii</code> 别名是在入口脚本里包含 <code>Yii.php</code> 文件时定义的，其他的别名都是在配置应用的时候，于应用的构造方法内定义的。</p>
<p>&nbsp;</p>
<h2>扩展的别名</h2>
<p>每一个通过 Composer 安装的 <a href="0312.html">扩展</a> 都自动添加了一个别名。该别名会以该扩展在 <code>composer.json</code> 文件中所声明的根命名空间为名，且他直接代指该包的根目录。例如，如果你安装有 <code>yiisoft/yii2-jui</code> 扩展，会自动得到 <code>@yii/jui</code> 别名，它定义于引导启动阶段：</p>
<pre class="brush: php;toolbar: false">
Yii::setAlias('@yii/jui', 'VendorPath/yiisoft/yii2-jui');
</pre>