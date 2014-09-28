<h1>配置（Configuration ）</h1>
<p>在 Yii 中，创建新对象和初始化已存在对象时广泛使用配置。配置通常包含被创建对象的类名和一组将要赋值给对象<a href="0502.html">属性</a>的初始值。还可能包含一组将被附加到对象<a href="0503.html">事件</a>上的句柄。和一组将被附加到对象上的<a href="0504.html">行为</a>。</p>
<p>以下代码中的配置被用来创建并初始化一个数据库连接：</p>
<pre class="brush: php;toolbar: false">
$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

$db = Yii::createObject($config);
</pre>
<p>[[Yii::createObject()]] 方法接受一个配置并根据配置中指定的类名创建对象。对象实例化后，剩余的参数被用来初始化对象的属性，事件处理和行为。</p>
<p>对于已存在的对象，可以使用 [[Yii::configure()]] 方法根据配置去初始化其属性，就像这样：</p>
<pre class="brush: php;toolbar: false">Yii::configure($object, $config);</pre>
<p>请注意，如果配置一个已存在的对象，那么配置数组中不应该包含指定类名的 class 元素。</p>
<p>&nbsp;</p>
<h2>配置的格式</h2>
<p>一个配置的格式可以描述为以下形式：</p>
<pre class="brush: php;toolbar: false">
[
    'class' => 'ClassName',
    'propertyName' => 'propertyValue',
    'on eventName' => $eventHandler,
    'as behaviorName' => $behaviorConfig,
]
</pre>
<p>其中</p>
<ul class="task-list">
<li><code>class</code> 元素指定了将要创建的对象的完全限定类名。</li>
<li><code>propertyName</code> 元素指定了对象属性的初始值。键名是属性名，值是该属性对应的初始值。只有公共成员变量以及通过 getter/setter 定义的<a href="0502.html">属性</a>可以被配置。</li>
<li><code>on eventName</code> 元素指定了附加到对象<a href="0503.html">事件</a>上的句柄是什么。请注意，数组的键名由 <code>on</code> 前缀加事件名组成。请参考<a href="0503.html">事件</a>章节了解事件句柄格式。</li>
<li><code>as behaviorName</code> 元素指定了附加到对象的<a href="0504.html">行为</a>。请注意，数组的键名由 <code>as</code> 前缀加行为名组成。<code>$behaviorConfig</code> 表示创建行为的配置信息，格式与我们现在总体叙述的配置格式一样。</li>
</ul>
<p>下面是一个配置了初始化属性值，事件句柄和行为的示例：</p>
<pre class="brush: php;toolbar: false">[
    'class' => 'app\components\SearchEngine',
    'apiKey' => 'xxxxxxxx',
    'on search' => function ($event) {
        Yii::info("搜索的关键词： " . $event->keyword);
    },
    'as indexer' => [
        'class' => 'app\components\IndexerBehavior',
        // ... 初始化属性值 ...
    ],
]
</pre>
<p>&nbsp;</p>
<h2>使用配置</h2>
<p>Yii 中的配置可以用在很多场景。本章开头我们展示了如何使用 [[Yii::creatObject()]] 根据配置信息创建对象。本小节将介绍配置的三种主要用法 —— 配置启动文件、配置应用与配置小部件。</p>
<h3>启动文件的配置</h3>
<p>每一个Yii应用都有一个启动（bootstrap）文件：一个请求处理入口的PHP脚本。对于web应用，这个启动文件为 <code>index.php</code>; 对于命令行应用程序，为 <code>yii</code>. 两者都执行基本相同的工作：</p>
<ol>
<li>设置公共常量。</li>
<li>包含Yii框架自身。</li>
<li>包含 <a href="http://getcomposer.org/doc/01-basic-usage.md#autoloading">Composer autoloader</a>。</li>
<li>读取配置文件到变量 <code>$config</code> 中。</li>
<li>创建一个新的应用程序实例，通过 <code>$config</code> 配置 并运行该实例。</li>
</ol>
<p>你可以修改启动文件来满足具体的要求。比如修改 <code>YII_DEBUG</code> 值，这个常量在开发阶段一般设置为true以便获取调试信息，但是在生产环境上应该为 <code>false</code> 。</p>
<p>缺省情况下，<code>YII_DEBUG</code> 被设置为 <code>false</code> ：</p>
<pre class="brush: php;toolbar: false">defined('YII_DEBUG') or define('YII_DEBUG', false);</pre>
<p>开发过程中，你可以如下修改为 <code>true</code>:</p>
<pre class="brush: php;toolbar: false">define('YII_DEBUG', true); // 仅开发环境
defined('YII_DEBUG') or define('YII_DEBUG', false);</pre>
<h3>应用的配置 </h3>
<p>应用的配置可能是最复杂的配置之一。因为 [[yii\web\Application|application]] 类拥有很多可配置的属性和事件。更重要的是它的 [[yii\web\Application::components|components]] 属性可以接收配置数组并通过应用注册为组件。以下是一个针对<a href="#">基础应用模板</a>的应用配置概要：</p>
<pre class="brush: php;toolbar: false">
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=stay2',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
</pre>
<p>配置中没有 class 键的原因是这段配置应用在下面的入口脚本中，类名已经指定了。</p>
<pre class="brush: php;toolbar: false">(new yii\web\Application($config))->run();</pre>
<p>更多关于应用 components 属性配置的信息可以查阅应用以及<a href="#">服务定位器</a>章节。</p>
<h3>小部件（Widgets）的配置</h3>
<p>使用<a href="#">小部件</a>时，常常需要配置以便自定义其属性。 [[yii\base\Widget::widget()]] 和 [[yii\base\Widget::beginWidget()]] 方法都可以用来创建小部件。它们可以接受配置数组：</p>
<pre class="brush: php;toolbar: false">
use yii\widgets\Menu;

echo Menu::widget([
    'activateItems' => false,
    'items' => [
        ['label' => 'Home', 'url' => ['site/index']],
        ['label' => 'Products', 'url' => ['product/index']],
        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    ],
]);
</pre>
<p>上述代码创建了一个小部件 Menu 并将其 activateItems 属性初始化为 false。item 属性也配置成了将要显示的菜单条目。</p>
<p>请注意，代码中已经给出了类名 yii\widgets\Menu'，配置数组**不应该**再包含class` 键。</p>
<p>&nbsp;</p>
<h2>配置文件</h2>
<p>当配置的内容十分复杂，通用做法是将其存储在一或多个 PHP 文件中，这些文件被称为<strong>配置文件</strong>。一个配置文件返回的是 PHP 数组。例如，像这样把应用配置信息存储在名为 <code>web.php</code> 的文件中：</p>
<pre class="brush: php;toolbar: false">
return [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => require(__DIR__ . '/components.php'),
];
</pre>
<p>鉴于 <code>components</code> 配置也很复杂，上述代码把它们存储在单独的 <code>components.php</code> 文件中，并且包含在 <code>web.php</code> 里。<code>components.php</code> 的内容如下：</p>
<pre class="brush: php;toolbar: false">
return [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
    ],
    'log' => [
        'class' => 'yii\log\Dispatcher',
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
            ],
        ],
    ],
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=stay2',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
];
</pre>
<p>仅仅需要 “require”，就可以取得一个配置文件的配置内容，像这样：</p>
<pre class="brush: php;toolbar: false">
$config = require('path/to/web.php');
(new yii\web\Application($config))->run();</pre>
<p>&nbsp;</p>
<h2>默认配置</h2>
<p>[[Yii::createObject()]] 方法基于<a href="#">依赖注入容器</a>实现。使用 [[Yii::creatObject()]] 创建对象时，可以附加一系列<strong>默认配置</strong>到指定类的任何实例。默认配置还可以在<a href="#">入口脚本</a>中调用 <code>Yii::$container-&gt;set()</code> 来定义。</p>
<p>例如，如果你想自定义 [[yii\widgets\LinkPager]] 小部件，以便让分页器最多只显示 5 个翻页按钮（默认是 10 个），你可以用下述代码实现：</p>
<pre class="brush: php;toolbar: false">
\Yii::$container->set('yii\widgets\LinkPager', [
    'maxButtonCount' => 5,
]);
</pre>
<p>不使用默认配置的话，你就得在任何使用分页器的地方，都配置 maxButtonCount 的值。</p>
<p>&nbsp;</p>
<h2>环境常量</h2>
<p>[[Yii::createObject()]] 方法基于<a href="#">依赖注入容器</a>实现。使用 [[Yii::creatObject()]] 创建对象时，可以附加一系列<strong>默认配置</strong>到指定类的任何实例。默认配置还可以在<a href="#">入口脚本</a>中调用 <code>Yii::$container-&gt;set()</code> 来定义。</p>
<p>例如，如果你想自定义 [[yii\widgets\LinkPager]] 小部件，以便让分页器最多只显示 5 个翻页按钮（默认是 10 个），你可以用下述代码实现：</p>
<pre class="brush: php;toolbar: false">defined('YII_ENV') or define('YII_ENV', 'dev');</pre>
<p>你可以把 <code>YII_ENV</code> 定义成以下任何一种值：</p>
<ul class="task-list">
<li><code>prod</code>：生产环境。常量 <code>YII_ENV_PROD</code> 将被看作 true。如果你没修改过，这就是 <code>YII_ENV</code> 的默认值。</li>
<li><code>dev</code>：开发环境。常量 <code>YII_ENV_DEV</code> 将被看作 true。</li>
<li><code>test</code>：测试环境。常量 <code>YII_ENV_TEST</code> 将被看作 true。</li>
</ul>
<p>有了这些环境常量，你就可以根据当下应用运行环境的不同，进行差异化配置。例如，应用可以包含下述代码只在开发环境中开启<a href="#">调试工具</a>。</p>
<pre class="brush: php;toolbar: false">
$config = [...];

if (YII_ENV_DEV) {
    // 根据 `dev` 环境进行的配置调整
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
</pre>