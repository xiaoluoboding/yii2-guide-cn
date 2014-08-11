<h1>URL 管理</h1>
<p>Yii中的URL管理概念很简单。URL管理基于这样的前提：应用程序的每个地方都使用内部路由和参数。框架然后将路由解释为URLs，或者相反，这取决于URL管理的配置。这样的方式允许你通过修改一个配置项就可以更改整站的URL行为，而不需要改动任何的代码。</p>
<p>&nbsp;</p>
<h2>内部路由</h2>
<p>Yii应用处理的内部路由通常指的是路由及参数。 每个控制器及其动作都有对应的内部路由，比如<code>site/index</code> 或 <code>user/create</code>。 前一例中的<code>site</code> 被称为 <em>controller ID</em> （控制器ID），而 <code>index</code> 被称为 <em>action ID</em>（动作ID）。 第二例中的<code>user</code> 是控制器ID，<code>create</code> 是动作ID。如果控制器在 <em>module</em> （模块）内部， 内部路由则以模块ID开头，比如 <code>blog/post/index</code> 是 blog 模块的 post 控制器的 index 动作。</p>
<p>&nbsp;</p>
<h2>创建 URLs</h2>
<p>为站点创建URL最重要的规则就是始终使用 URL 管理器，URL 管理器是一个名叫 <code>urlManager</code> 的内置应用组件。这个组件在Web应用和控制台应用中都可以通过 <code>\Yii::$app-&gt;urlManager</code>. 组件提供以下两种创建 URL 的方法：</p>
<ul class="task-list">
<li><code>createUrl($params)</code></li>
<li><code>createAbsoluteUrl($params, $schema = null)</code></li>
</ul>
<p><code>createUrl()</code> 方法根据应用根目录的相对位置生成URL，比如 <code>/index.php/site/index/</code>。 <code>createAbsoluteUrl()</code> 方法生成的是绝对路径 URL ，即以主机名和协议开头的 URL ： <code>http://www.example.com/index.php/site/index</code>. 前者适用于应用内部的URL，而后者 用于创建URL给外部资源使用，比如连接到第三方服务，发送邮件， 生成RSS提要等。</p>
<p>一些例子：</p>
<pre class="brush: php;toolbar: false">
echo \Yii::$app->urlManager->createUrl(['site/page', 'id' => 'about']);
// /index.php/site/page/id/about/
echo \Yii::$app->urlManager->createUrl(['date-time/fast-forward', 'id' => 105])
// /index.php?r=date-time/fast-forward&id=105
echo \Yii::$app->urlManager->createAbsoluteUrl('blog/post/index');
// http://www.example.com/index.php/blog/post/index/
</pre>
<p>URL采用哪种格式取决于 URL 的配置。 上面的例子可以输出以下格式的 URL ：</p>
<ul class="task-list">
<li><code>/site/page/id/about/</code></li>
<li><code>/index.php?r=site/page&amp;id=about</code></li>
<li><code>/index.php?r=date-time/fast-forward&amp;id=105</code></li>
<li><code>/index.php/date-time/fast-forward?id=105</code></li>
<li><code>http://www.example.com/blog/post/index/</code></li>
<li><code>http://www.example.com/index.php?r=blog/post/index</code></li>
</ul>
<p>使用 [[yii\helpers\Url]] Url 助手可简化 URL 的创建，假设有 URL <code>/index.php?r=management/default/users&amp;id=10</code> ，以下说明 <code>Url</code> 助手是如何工作的：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\Url;

// 当前活动路由
// /index.php?r=management/default/users
echo Url::to('');

// 相同的控制器，不同的动作
// /index.php?r=management/default/page&id=contact
echo Url::toRoute(['page', 'id' => 'contact']);


// 相同模块，不同控制器和动作
// /index.php?r=management/post/index
echo Url::toRoute('post/index');

// 绝对路由，不管是被哪个控制器调用
// /index.php?r=site/index
echo Url::toRoute('/site/index');

// 区分大小写的控制器动作 `actionHiTech` 的 url 格式
// /index.php?r=management/default/hi-tech
echo Url::toRoute('hi-tech');

// 控制器和动作都区分大小写的 url，如'DateTimeController::actionFastForward' ：
// /index.php?r=date-time/fast-forward&id=105
echo Url::toRoute(['/date-time/fast-forward', 'id' => 105]);

//  从别名中获取 URL 
// http://google.com/
Yii::setAlias('@google', 'http://google.com/');
echo Url::to('@google');

// 获取当前页的标准 URL 
// /index.php?r=management/default/users
echo Url::canonical();

// 获得 home 主页的 URL
// /index.php?r=site/index
echo Url::home();

Url::remember() ; //  保存URL以供下次使用
Url::previous(); // 取出前面保存的 URL 
</pre>
<blockquote>
<p><strong>小技巧</strong>： 为生成一个指向 # 号（锚连接 ID ）的 URL ，比如 <code>/index.php?r=site/page&amp;id=100#title</code>， 你要 指定 <code>#</code> 参数 ，采用 <code>Url::to(['post/read', 'id' =&gt; 100, '#' =&gt; 'title'])</code> 来创建。</p>
</blockquote>
<p>还有一个&nbsp;<code>Url::canonical()</code>&nbsp;方法允许你为当前执行动作生成规范URL（<a href="https://en.wikipedia.org/wiki/Canonical_link_element">canonical URL</a>）。这个方法将忽略当前动作输入参数之外的所有其它URL参数：</p>
<pre class="brush: php;toolbar: false">
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;

class CanonicalController extends Controller
{
    public function actionTest($page)
    {
        echo Url::canonical();
    }
}
</pre>
<p>&nbsp;</p>
<h2>自定义 URLs</h2>
缺省情况下， Yii 用 query string （查询字符串）的格式，如/index.php?r=news/view&id=100。 为了让 URL 更人性化，比如更易读。你需要在应用配置文件中，配置一下urlManager 组件， 通过"pretty"（美化）URL选项，你可以把查询字符串格式的 URL 转换成目录格式的 URL（/index.php/news/view?id=100）。 而禁用showScriptName参数将去除 URL 的 index.php 一部分。 这里是应用配置文件中与此相关的部分：
<pre class="brush: php;toolbar: false">
&lt;?php
return [
    // ...
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
];
</pre>
<p>请注意，只有当 web 服务器正确配置Yii时该配置内容才能正常工作，参阅 installation.</p>
<h3>命名参数</h3>
<p>URL 格式规则可以关联一些 <code>GET</code> 参数，这些 <code>GET</code> 参数以如下格式出现在规则表达式中：</p>
<pre class="brush: php;toolbar: false">
&lt;ParameterName:ParameterPattern&gt;
</pre>
<p><code>ParameterName</code>（参数名）是 <code>GET</code> 参数的名称，可选的<code>ParameterPattern</code>（参数表达式）是可选的，是一个正则表达式，用于 匹配<code>GET</code>参数的值。如果<code>ParameterPattern</code>被省略，表示这条规则将匹配 除 <code>/</code> 外的任何字符。 当创建一个URL时，这些占位参数将会替换成 相应的参数值；当解析一个URL时，相应的GET参数将会被填充到解析结果中。</p>
<p>让我们用一些例子来说明 URL 规则是怎么工作的。假设我们的规则集由三个规则组成：</p>
<pre class="brush: php;toolbar: false">
[
    'posts'=>'post/list',
    'post/&lt;id:\d+>'=>'post/read',
    'post/&lt;year:\d{4}>/&lt;title>'=>'post/read',
]
</pre>
<ul class="task-list">
<li>调用 <code>Url::toRoute('post/list')</code> 将生成 <code>/index.php/posts</code>. 第一条规则被应用。</li>
<li>调用 <code>Url::toRoute(['post/read', 'id' =&gt; 100])</code> 生成 <code>/index.php/post/100</code>. 第二条规则被应用。</li>
<li>调用 <code>Url::toRoute(['post/read', 'year' =&gt; 2008, 'title' =&gt; 'a sample post'])</code> 生成 <code>/index.php/post/2008/a%20sample%20post</code>. 第三条规则被应用。</li>
<li>调用 <code>Url::toRoute('post/read')</code> 生成 <code>/index.php/post/read</code>. 没有规则被用应, 仅仅是应用了 约定。</li>
</ul>
<p>总之，当使用 <code>createUrl</code> 来生成 URL 时，路由和 <code>GET</code> 参数传递到用于决定 哪条规则被应用的方法中。如果传递到 <code>createUrl()</code> 的 <code>GET</code> 参数里有任何一个关联到规则的参数， 而且路由参数也匹配规则路由，那这条规则将用于生成 URL 。</p>
<p>如果传递到 <code>Url::toRoute</code> 的 <code>GET</code> 参数比规则要求的多，则多余的参数 将出现在查询字符串中，例如，如果我们调用 <code>Url::toRoute(['post/read', 'id' =&gt; 100, 'year' =&gt; 2008])</code> ， 会得到 <code>/index.php/post/100?year=2008</code>.</p>
<p>正如我们前面提到的， URL 规则的另一个目的是解析请求的 URL 地址，自然，这是一个创建 URL 地址的逆过程。例如，当用户请求 <code>/index.php/post/100</code> 时，上例中 第二条规则将被应用，即解析了路由 <code>post/read</code> 和 <code>GET</code> 参数 <code>['id' =&gt; 100]</code> 的规则 （通过 <code>Yii::$app-&gt;request-&gt;get('id')</code> 得到）。</p>
<h3>参数化路由</h3>
<p>我们可以引用规则中路由部分的命名参数，这将允许规则被应用于匹配标准（criteria）的多路由中。 命名参数也可以减少应用所需的规则数量， 以全面改进性能。</p>
<p>举例说明如何用命名参数来参数化路由：</p>
<pre class="brush: php;toolbar: false">
[
    '&lt;controller:(post|comment)>/&lt;id:\d+>/&lt;action:(create|update|delete)>' => '&lt;controller>/&lt;action>',
    '&lt;controller:(post|comment)>/&lt;id:\d+>' => '&lt;controller>/read',
    '&lt;controller:(post|comment)>s' => '&lt;controller>/list',
]
</pre>
<p>在以上例子中，在规则的路由部分使用了两个命名参数：控制器和动作。前者匹配一个 post 或 comment 的路由 ID ，后者匹配创建、更新和删除的动作 ID 。你也可以另外命名这些参数，只要它们和出现在 URL 中的 GET 参数没有冲突。</p>
<p>使用上述规则，URL <code>/index.php/post/123/create</code> 将解析成post 控制器的 create 动作的路由，其 GET 参数是 <code>id=123</code> 。而给定路由 <code>comment/list</code> 和 <code>GET</code> 参数 <code>page=2</code> ，将创建URL <code>/index.php/comments?page=2</code>。</p>
<h3>参数化主机名</h3>
<p>创建和解析 URL 也可以在规则中包括主机名。主机名的一部分将提取 作为 <code>GET</code> 参数。处理二级域名特别有用。如， URL <code>http://admin.example.com/en/profile</code> 可以解析为 GET 参数<code>user=admin</code> 和 <code>lang=en</code> 。另一方面， 包括主机名的规则也可以用于创建带有参数化主机名的 URL 。</p>
<p>为应用参数化主机名，只需要用主机信息简单定义 URL 规则，如：</p>
<pre class="brush: php;toolbar: false">
[
    'http://&lt;user:\w+>.example.com/&lt;lang:\w+>/profile' => 'user/profile',
]
</pre>
<p>上例中主机名的第一部分被视为用户参数， 而路径信息的第一部分被视为语言参数。这个规则响应 <code>user/profile</code> 路由。</p>
<p>注意，当 URL 被使用参数化主机名的规则创建时，[[yii\web\UrlManager::showScriptName]] 将不再起作用。</p>
<p>还要注意，如果应用位于 WEB 根目录的子文件夹，包含参数化主机名的任何规则都<em>不能</em>包括子文件夹。 如，应用位于 <code>http://www.example.com/sandbox/blog</code> ， 那么仍然使用上面相同的规则，而不需要加上 <code>sandbox/blog</code> 。</p>
<h3>伪 URL后缀</h3>
<pre class="brush: php;toolbar: false">
&lt;?php
return [
    // ...
    'components' => [
        'urlManager' => [
            'suffix' => '.html',
        ],
    ],
];
</pre>
<h3>处理 REST 请求</h3>
<p>TBD:</p>
<ul class="task-list">
<li>RESTful 风格路由: [[yii\filters\VerbFilter]], [[yii\filters\UrlManager::$rules]]</li>
<li>Json API:
<ul class="task-list">
<li>响应: [[yii\web\Response::format]]</li>
<li>请求: [[yii\web\Request::$parsers]], [[yii\web\JsonParser]]</li>
</ul>
</li>
</ul>
<p>&nbsp;</p>
<h2>URL 解析</h2>
<p>除了完美创建 URL 外， Yii 也可以转换自定义格式的 URL 到内部路由和参数。</p>
<h3>URL 精确解析</h3>
<p>默认，如果 URL 无定制规则且匹配默认格式如 /site/page，Yii 将允许相应的控制器的动作执行。这个行为（behavior，特有名词见词汇表）也可以配置为失效，这时将弹出 404 错误（没有找到该页面）。</p>
<pre class="brush: php;toolbar: false">
&lt;?php
return [
    // ...
    'components' => [
        'urlManager' => [
            'enableStrictParsing' => true,
        ],
    ],
];
</pre>
<p>&nbsp;</p>
<h2>创建你自己的规则类</h2>
[[yii\web\UrlRule]] 类被用在解析 URL 到参数和基于参数创建 URL两方面。 尽管框架实现的URL 规则已经非常灵活，能够满足绝大多数项目的需求， 但仍有一些情况使用你自己的规则类才是最好的选择。如，在一个汽车交易网站， 我们想支持类似 /Manufacturer/Model 这样的 URL 格式，这个 URL 中的 Manufacturer 和 Model 都要匹配数据表的某些数据。 缺省规则类不适用这样的需求，因为它通常依赖无关数据库的静态正则表达式。 我们可以通过继承[[yii\web\UrlRule]] 来编写新的 URL 规则类并使用在一个或多个 URL 规则中。 以上面的汽车交易网站为例，我们可以在应用配置中定义以下 URL 规则：
<pre class="brush: php;toolbar: false">
// ...
'components' => [
    'urlManager' => [
        'rules' => [
            '&lt;action:(login|logout|about)>' => 'site/&lt;action>',

            // ...

            ['class' => 'app\components\CarUrlRule', 'connectionID' => 'db', /* ... */],
        ],
    ],
],
</pre>
<p>通过以上配置，我们可以使用自定义的 URL 规则类 <code>CarUrlRule</code>来处理 <code>/Manufacturer/Model</code> 格式的 URL 了。这个类可以这样写：</p>
<pre class="brush: php;toolbar: false">
namespace app\components;

use yii\web\UrlRule;

class CarUrlRule extends UrlRule
{
    public $connectionID = 'db';

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'car/index') {
            if (isset($params['manufacturer'], $params['model'])) {
                return $params['manufacturer'] . '/' . $params['model'];
            } elseif (isset($params['manufacturer'])) {
                return $params['manufacturer'];
            }
        }
        return false;  // 规则没有被应用
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            // 输入$matches[1] 和 $matches[3] 看看
            // 如果它们匹配了数据库中的厂商和模型，
            // 赋值给$params['manufacturer'] 和 $params['model']
            // 并返回['car/index', $params]。
        }
        return false;  // 规则没有被应用
    }
}
</pre>
<p>除了上述用法，自定义 URL 规则类还可以实现许多目的。 如，我们可以写规则类来记录 URL 解析和创建请求的日志。 开发阶段这是非常有用的。 我们也可以写规则类来显示特定的 404 错误类以防止所有其他 URL 规则 解析当前请求失败。注意这种情况，特定类的规则 必须定义在最后一条规则。</p>