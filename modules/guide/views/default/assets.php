<h1>资源管理（Assets）</h1>
<p>Yii 中的资源（asset） 是一个要引入页面的文件。可以是 CSS, JavaScript 或任何其他文件。框架提供了很多种途径来使用资源，从最简单的方式比如使用标签 &lt;script src="..."&gt; 添加文件（在<a href="guidelist?id=49"> 视图 </a>一章中描述），到高级应用比如发布不在web目录下的文件，解析Javascript依赖或者最小化CSS，接下来将分别进行描述。</p>
<p>&nbsp;</p>
<h2>声明资源包</h2>
<p>要在网站中定义资源集合，你可以声明一个所谓资源包（asset bundle）的类。这个包定义了一系列资源文件以及它们对于其他资源包的依赖关系。</p>
<p>资源文件可以放在服务器可访问目录也可以隐藏在应用或 vendor 目录内。如果是后者，资源包喜欢发布自身到服务器可访问目录以便被网站引入。这个功能对扩展很有用，扩展可以在一个目录装载所有内容，让安装更容易。</p>
<p>要定义一个资源需要创建一个继承自[[yii\web\AssetBundle]]的类并根据需求设置属性。以下是资源定义示例，资源定义是基础应用模板的一部分，即<code>AppAsset</code> 资源包类，它定义了应用必需资源：</p>
<pre class="brush: php;toolbar: false">
&lt;?php

use yii\web\AssetBundle as AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
</pre>
<p>上述 <code>$basePath</code> 指定资源从哪个可网络访问的目录提供服务。这是相对<code>$css</code> 和 <code>$js</code> 路径的根目录，如 <code>@webroot/css/site.css</code> 指向 <code>css/site.css</code> 。这里的 <code>@webroot</code> 是指向应用 <code>web</code> 目录的别名。</p>
<p><code>$baseUrl</code> 用来指定刚才的 <code>$css</code> 和 <code>$js</code> 相对的根 URL ，如 <code>@web/css/site.css</code> 中的 <code>@web</code> 是一个 [别名]，对应你的网站根 URL 如 <code>http://example.com/</code> 。</p>
<p>如果你的资源文件放在网络无法访问的目录，Yii 扩展正是如此，这样你必须指定 <code>$sourcePath</code> 而不是 <code>$basePath</code> and <code>$baseUrl</code> 。原始路径的<strong>所有文件</strong>在注册前将被复制或符号链接（symlink）到你应用的 <code>web/assets</code> 目录。这种情况下 <code>$basePath</code> 和 <code>$baseUrl</code> 将在发布资源包时自动生成。这是发布完整目录的资源工作方式，目录内可以包括图片、前端文件等。</p>
<blockquote>
<p><strong>注意：</strong> 不要使用d <code>web/assets</code> 目录放你自己的文件。它只用于资源发布。 当你创建网络可访问目录内的文件时，把它们放在类似 <code>web/css</code> 或 <code>web/js</code> 的文件夹内。</p>
</blockquote>
<p>和其他资源包的依赖关系用 <code>$depends</code> 属性指定。这是个包括资源包完整合格类名的数组，资源包内的这些类应发布以便该资源包能正常工作。此例中， <code>AppAsset</code> 的Javascript 和 CSS 文件添加到 header 的[[yii\web\YiiAsset]]和[[yii\bootstrap\BootstrapAsset]]之后。</p>
<p>这里的[[yii\web\YiiAsset]]添加 Yii 的 JavaScript库，而[[yii\bootstrap\BootstrapAsset]]包括<a href="http://getbootstrap.com">Bootstrap</a>前端框架。</p>
<p>资源包是常规类，所以如需定义更多资源包，以唯一名创建同样的类即可。新建的类可以放到任何地方，但惯例是放到应用的 <code>assets</code> 目录。</p>
<p>此外，可以在注册和发布资源时指定 <code>$jsOptions</code>, <code>$cssOptions</code> 和 <code>$publishOptions</code> 参数分别传递到[[yii\web\View::registerJsFile()]], [[yii\web\View::registerCssFile()]] 和 [[yii\web\AssetManager::publish()]]。</p>
<h3>特定语言资源包</h3>
<p>如果你想在一个资源包中包含特定语言的JavaScript文件，你可以实现如下：</p>
<pre class="brush: php;toolbar: false">
class LanguageAsset extends AssetBundle
{
    public $language;
    public $sourcePath = '@app/assets/language';
    public $js = [
    ];

    public function registerAssetFiles($view)
    {
        $language = $this->language ? $this->language : Yii::$app->language;
        $this->js[] = 'language-' . $language . '.js';
        parent::registerAssetFiles($view);
    }
}
</pre>
<p>然后在视图中注册一个资源包时，使用下述代码设置具体的语言：</p>
<pre class="brush: php;toolbar: false">
LanguageAsset::register($this)->language = $language;
</pre>
<p>&nbsp;</p>
<h2>注册资源包</h2>
<p>资源包类通常要注册到视图文件或小部件，以 css 和 javascript 文件来提供功能。 特例是以上定义的 AppAsset 类， AppAsset 类添加到应用的主布局文件并注册到该应用的任何页面。注册资源包简单到调用[[yii\web\AssetBundle::register()|register()]]方法即可实现：</p>
<pre class="brush: php;toolbar: false">
use app\assets\AppAsset;
AppAsset::register($this);
</pre>
<p>由于我们在一个视图上下文中，<code>$this</code> 指向 <code>View</code> 类对象。为了在widget中注册一个资源，视图实例通过 <code>$this-&gt;view</code> 来获取：</p>
<pre class="brush: php;toolbar: false">
AppAsset::register($this->view);
</pre>
<blockquote>
<p>注意：如果需要修改第三方资源包，建议你创建自己的包，依赖于第三方包，然后使用CSS或JavaScript功能来修改缺省行为，不要直接修改或替换第三方包的文件。</p>
</blockquote>
<p>&nbsp;</p>
<h2>覆盖资源包</h2>
<p>有时候你需要覆盖一些应用程序作用范围的资源包，比如想从CDN加载jQuery而不是自己的服务器。为此我们需要在config文件中配置 <code>assetManager</code> 应用程序组件。对于基础应用程序而言，就是 <code>config/web.php</code> 文件：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                     'sourcePath' => null,
                     'js' => ['//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js']
                ],
            ],
        ],
    ],
];
</pre>
<p>以上添加了资源包定义到[[yii\web\AssetManager::bundles|bundles]]资源管理器属性，数组键是拟覆写的资源包类的合格完整类名，而数组值是拟设置的类属性及对应值数组。</p>
<p><code>sourcePath</code> 设置为 <code>null</code> 是告诉资源管理器在 <code>js</code> 以 CDN 链接来覆写本地文件时不要复制。</p>
<p>&nbsp;</p>
<h2>启动符号链接（symlinks）</h2>
<p>资源管理器能使用符号链接，不用复制文件。符号链接默认是关闭的，因为它在虚拟主机通常无法使用。如果你的主机环境支持符号链接，就肯定能通过应用配置启用这个功能：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
];
</pre>
<p>启用符号链接有两个好处，第一是无须复制所以更快，第二是资源会链接源文件保持最新。</p>
<p>&nbsp;</p>
<h2>压缩和合并资源</h2>
<p>要改进应用性能可以压缩和合并多个 CSS 或 JS 文件到更少的文件以便减少 HTTP 请求次数和页面加载所需下载量。Yii 提供了一个控制台命令使你能一次完成压缩和合并。</p>
<h3>准备配置</h3>
<p>要使用<code> asset </code>命令需先准备配置文件，可使用以下命令生成内置模板的配置文件：</p>
<pre class="brush: php;toolbar: false">
yii asset/template /path/to/myapp/config.php
</pre>
<p>模板如下：</p>
<pre class="brush: php;toolbar: false">
&lt;?php
/**
 * "yii asset" 控制台命令的配置文件
 * 注意控制台环境下有些路径别名可能不存在，如 '@webroot' 和 '@web'
 * 请先定义找不到的路径别名
 */
return [
    // 为 JavaScript 文件压缩调整 command/callback 命令：
    'jsCompressor' => 'java -jar compiler.jar --js {from} --js_output_file {to}',
    // 为 CSS 文件压缩调整 command/callback 命令：
    'cssCompressor' => 'java -jar yuicompressor.jar --type css {from} -o {to}',
    // 要压缩的资源包列表：
    'bundles' => [
        // 'yii\web\YiiAsset',
        // 'yii\web\JqueryAsset',
    ],
    // 输出的已压缩资源包：
    'targets' => [
        'app\config\AllAsset' => [
            'basePath' => 'path/to/web',
            'baseUrl' => '',
            'js' => 'js/all-{ts}.js',
            'css' => 'css/all-{ts}.css',
        ],
    ],
    // 资源管理器配置：
    'assetManager' => [
        'basePath' => __DIR__,
        'baseUrl' => '',
    ],
];
</pre>
<p>以上数值键是 <code>AssetController</code> 的 <code>properties</code> 。该资源控制器的属性之一 <code>bundles</code> 列表包括拟压缩资源包，通常被应用程序使用。<code>targets</code> 包括定义文件编写方式的输出资源包列表。我们的例子中编写所有文件到 <code>path/to/web</code> ，以 <code>http://example.com/</code> 来访问，这是个网站根目录。</p>
<blockquote>
<p>注意：控制台环境有些路径别名不存在，如 '@webroot' 和 '@web' ，所以在配置文件中的相应路径要直接指定。</p>
</blockquote>
<p>JavaScript 文件将压缩合并写入 <code>js/all-{ts}.js</code> ，其中 {ts} 将替换为当前的 UNIX 时间戳。</p>
<p><code>jsCompressor</code> 和 <code>cssCompressor</code> 是控制台命令或 PHP 回调函数，它们分别执行 JavaScript 和 CSS 文件压缩。你可以根据你的环境调整这些值。默认情况下，Yii 依靠<a href="https://developers.google.com/closure/compiler/" target="_blank">Closure Compiler</a>来压缩 JavaScript 文件，依赖<a href="https://github.com/yui/yuicompressor/" target="_blank">YUI Compressor</a>压缩 CSS 文件。如果你想使用它们请手动安装这些实用程序。</p>
<h3>提供压缩工具</h3>
<p>命令依靠未绑定到Yii 的外部压缩工具，所以你需要指定 <code>cssCompressor</code> 和 <code>jsCompression</code> 属性来分别提供 CSS 和 JS 的压缩工具。如果压缩工具指定为字符串将视为 shell 命令模板，该模板包括两个占位符： <code>{from}</code> 将用源文件名替换，而 <code>{to}</code> 将用输出的文件名替换。另一个指定压缩工具的方法是使用有效的 PHP 回调函数。</p>
<p>Yii 压缩 JavaScript 默认使用名为 <code>compiler.jar</code> 的<a href="https://developers.google.com/closure/compiler/" target="_blank">Google Closure compiler</a> 压缩工具。</p>
<p>Yii 压缩 CSS 使用名为 <code>yuicompressor.jar</code> 的<a href="https://github.com/yui/yuicompressor/" target="_blank">YUI Compressor</a>压缩工具。</p>
<p>要同时压缩 JavaScript 和 CSS ，需要下载以上两个工具并放在和 <code>yii</code> 控制台引导文件同一个目录下，并须安装 JRE 来运行这些工具。</p>
<p>要自定义压缩命令（如更改 jar 文件位置），请在 <code>config.php</code> 中如下设置：</p>
<pre class="brush: php;toolbar: false">
return [
       'cssCompressor' => 'java -jar path.to.file\yuicompressor.jar  --type css {from} -o {to}',
       'jsCompressor' => 'java -jar path.to.file\compiler.jar --js {from} --js_output_file {to}',
];
</pre>
<p>其中 <code>{from}</code> 和 <code>{to}</code> <code>asset</code> 是占位符，将在命令压缩文件时分别被真实的源文件路径和目标文件路径替换。</p>
<h3>执行压缩</h3>
<pre class="brush: php;toolbar: false">
yii asset /path/to/myapp/config.php /path/to/myapp/config/assets_compressed.php
</pre>
<p>现在进程将占用一点时间并最终完成。你需要调整你的 web 应用配置来使用已压缩的资源文件，如下：</p>
<pre class="brush: php;toolbar: false">
'components' => [
    // ...
    'assetManager' => [
        'bundles' => require '/path/to/myapp/config/assets_compressed.php',
    ],
],
</pre>
<p>&nbsp;</p>
<h2>使用资源转换器</h2>
<p>通常开发人员不直接使用 CSS 和 JavaScript 而是使用改进版本如 CSS 的 LESS 或 SCSS 和 JavaScript 的微软出品 TypeScript 。在 Yii 中使用它们是非常简单的。</p>
<p>首先，相应的压缩工具已经安装在 <code>yii</code> 控制台引导程序同目录下且可用。以下列示了文件扩展和相应的 Yii 转换器能识别的转换工具名。</p>
<ul class="task-list">
<li>LESS: <code>less</code> - <code>lessc</code></li>
<li>SCSS: <code>scss</code>, <code>sass</code> - <code>sass</code></li>
<li>Stylus: <code>styl</code> - <code>stylus</code></li>
<li>CoffeeScript: <code>coffee</code> - <code>coffee</code></li>
<li>TypeScript: <code>ts</code> - <code>tsc</code></li>
</ul>
<p>如果相应的工具已安装，就可以在资源包指定它们：</p>
<pre class="brush: php;toolbar: false">
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.less',
    ];
    public $js = [
        'js/site.ts',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
</pre>
<p>要调整转换工具调用参数或添加新的调用参数，可以使用应用配置：</p>
<pre class="brush: php;toolbar: false">
// ...
'components' => [
    'assetManager' => [
        'converter' => [
            'class' => 'yii\web\AssetConverter',
            'commands' => [
                'less' => ['css', 'lessc {from} {to} --no-color'],
                'ts' => ['js', 'tsc --out {to} {from}'],
            ],
        ],
    ],
],
</pre>
<p>以上列示了两种外部文件扩展，第一个是 <code>less</code> ，指定在资源包的 <code>css</code> 部分。转换通过运行 <code>lessc {from} {to} --no-color</code> 来执行，其中<code>{from}</code> 以 LESS 文件路径替换而 <code>{to}</code> 用目标 CSS 文件路径替换。第二个文件扩展是 <code>ts</code> ，指定在资源包的 <code>js</code> 部分。这个命令在转换时运行，格式同 <code>less</code>。</p>