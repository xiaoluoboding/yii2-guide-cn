<h1>类自动加载（Autoloading）</h1>
<p>Yii 依靠<a href="http://www.php.net/manual/en/language.oop5.autoload.php" target="_black">类自动加载机制</a>来定位和包含所需的类文件。它提供一个高性能且完美支持<a href="https://github.com/php-fig/fig-standards/blob/master/proposed/psr-4-autoloader/psr-4-autoloader.md" target="_black">PSR-4 标准</a>（<a href="https://github.com/hfcorriez/fig-standards/blob/zh_CN/%E6%8E%A5%E5%8F%97/PSR-4-autoloader.md" target="_black">中文汉化</a>）的自动加载器。该自动加载器会在引入框架文件<code>Yii.php</code>时安装好。</p>
<blockquote>
	<p>注意：为了简化叙述，本篇文档中我们只会提及类的自动加载。不过，要记得文中的描述同样也适用于接口和Trait（特质）的自动加载哦。</p>
</blockquote>
<p>&nbsp;</p>
<h2>使用 Yii 自动加载器</h2>
<p>要使用 Yii 的类自动加载器，你需要在创建和命名类的时候遵循两个简单的规则</p>
<ul>
	<li>每个类都必须置于命名空间之下 (比如 <code>foo\bar\MyClass</code>)。</li>
	<li>每个类都必须保存为单独文件，且其完整路径能用以下算法取得：</li>
</ul>
<pre class="brush: php;toolbar:false;">
// $className 是一个开头包含反斜杠的完整类名（译者注：请自行谷歌：fully qualified class name）
$classFile = Yii::getAlias('@' . str_replace('\\', '/', $className) . '.php');
</pre>
<p>举例来说，若某个类名为<code>foo\bar\MyClass</code>，对应类的文件路径别名会是<code>@foo/bar/MyClass.php</code>。为了让该<a href="0507.html"> 别名 </a>能被正确解析为文件路径，<code>@foo</code>或<code>@foo/bar</code>中的一个必须是根别名。</p>
<p>当我们使用<a href="2001.html">基本应用模版</a>时，可以把你的类放置在顶级命名空间<code>app</code>下，这样它们就可以被 Yii 自动加载，而无需定义一个新的别名。这是因为<code>@app</code>本身是一个预定义别名，且类似于<code>app\components\MyClass</code>这样的类名，基于我们刚才所提到的算法，可以正确解析出<code>AppBasePath/components/MyClass.php</code>路径。</p>
<p>在<a href="1401.html">高级应用模版</a>里，每一逻辑层级会使用他自己的根别名。比如，前端层会使用<code>@frontend</code>而后端层会使用 @backend。因此，你可以把前端的类放在<code>frontend</code>命名空间，而后端的类放在<code>backend</code>。 这样这些类就可以被 Yii 自动加载了。</p>
<p>&nbsp;</p><h2>类映射表（Class Map）</h2>
<p>Yii 类自动加载器支持<strong>类映射表</strong>功能，该功能会建立一个从类的名字到类文件路径的映射。当自动加载器加载一个文件时，他首先检查映射表里有没有该类。如果有，对应的文件路径就直接加载了，省掉了进一步的检查。这让类的自动加载变得超级快。事实上所有的 Yii 核心类都是这样加载的。</p>
<p>你可以用<code>Yii::$classMap</code>方法向映射表中添加类，</p>
<pre class="brush: php;toolbar:false;">
Yii::$classMap['foo\bar\MyClass'] = 'path/to/MyClass.php';
</pre>
<p></p>
<p>&nbsp;</p><h2>用其他自动加载器</h2>
<p>因为 Yii 完全支持 Composer 管理依赖包，所以推荐你也同时安装 Composer 的自动加载器，如果你用了一些自带自动加载器的第三方类库，你应该也安装下它们。</p>
<p>当你同时使用其他自动加载器和 Yii 自动加载器时，应该在其他自动加载器安装成功<strong>之后</strong>，再包含<code>Yii.php</code>文件。这将使 Yii 成为第一个响应任何类自动加载请求的自动加载器。举例来说，以下代码提取自<a href="2001.html">基本应用模版</a>的<a href="0302.html">入口脚本</a> 。第一行安装了 Composer 的自动加载器，第二行才是 Yii 的自动加载器：</p>
<pre class="brush: php;toolbar:false;">
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
</pre>
<p>你也可以只使用<a href="2004.html"> Composer </a>的自动加载，而不用 Yii 的自动加载。不过这样做的话，类的加载效率会下降，且你必须遵循 Composer 所设定的规则，从而让你的类满足可以被自动加载的要求。</p>
<blockquote>
	<p>补充：若你不想要使用 Yii 的自动加载器，你必须创建一个你自己版本的<code>Yii.php</code>文件，并把它包含进你的<a href="0302.html">入口脚本</a>里。</p>
</blockquote>
<p>&nbsp;</p><h2>自动加载扩展类</h2>
<p>Yii 自动加载器支持自动加载<a href="0312.html"> 扩展 </a>的类。唯一的要求是它需要在<code>composer.json</code>文件里正确地定义<code>autoload</code>部分。请参考 Composer 文档（<a href="https://getcomposer.org/doc/04-schema.md#autoload">英文</a>）（<a href="https://github.com/5-say/composer-doc-cn/blob/master/cn-introduction/04-schema.md#autoload">中文汉化</a>），来了解如何正确描述<code>autoload</code>的更多细节。</p>
<p>在你不使用 Yii 的自动加载器时，Composer 的自动加载器仍然可以帮你自动加载扩展内的类。</p>