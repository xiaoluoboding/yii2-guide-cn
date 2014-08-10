<h1>视图</h1>
<p>视图组件是 MVC 的重要部分。视图作为应用界面，履行其向终端用户展示数据的职责，如显示表单等。</p>
<p>&nbsp;</p>
<h2>基础</h2>
<p>Yii 默认使用 PHP 作为视图模板来生成内容和元素。web 应用视图通常包括一些 HTML 和 PHP <code>echo</code>, <code>foreach</code>, <code>if</code> 等基础结构的联合体。视图中使用复杂的 PHP 代码被认为是不良实践。当复杂逻辑和功能是必须的，这些代码应移动到控制器或小部件。</p>
<p>视图通常被控制器动作用[[yii\base\Controller::render()|render()]]方法调用：</p>
<pre class="brush: php;toolbar: false">
public function actionIndex()
{
    return $this->render('index', ['username' => 'samdark']);
}
</pre>
<p>[[yii\base\Controller::render()|render()]]方法的第一个参数是拟显示的视图名。在控制器背景下，Yii 将在 <code>views/site/</code> 目录下寻找该控制器的视图文件，其中 <code>site</code> 是控制器 ID 。更多有关视图名如何分解 的细节请参考[[yii\base\Controller::render()]]方法。</p>
<p>[[yii\base\Controller::render()|render()]]的第二个参数是键值对数组，控制器通过该数组将数据传递给视图，数组键为视图变量名，数组值在视图中通过引用相应的数组键变量名可获取使用。</p>
<p>上述动作 actionIndex 的视图是<code>views/site/index.php</code> ，在视图中可以这样使用：</p>
<pre class="brush: php;toolbar: false">
 &lt;p&gt;Hello, &lt;?= $username ?&gt! &lt;/p&gt
</pre>
<p>render()第二个参数的数组键'username' 在视图文件中作为变量名 $username 使用，引用输出的结果是第二个参数的数组值 'samdark'。</p>
<p>任何数据类型都可以传递给视图，包括数组和对象。</p>
<p>除了上述的[[yii\web\Controller::render()|render()]]方法，[[yii\web\Controller]]类还提供了一些其他的渲染方法，以下是这些方法的摘要：</p>
<ul class="task-list">
<li>[[yii\web\Controller::render()|render()]]：渲染视图并应用布局到渲染结果，最常用于整个页面的渲染。</li>
<li>[[yii\web\Controller::renderPartial()|renderPartial()]]：渲染无须布局的视图，常用于渲染页面片段。</li>
<li>[[yii\web\Controller::renderAjax()|renderAjax()]]：渲染无须布局的视图并注入已注册的 JS/CSS 脚本文件。通常用于渲染响应 AJAX 请求的 HTML 输出。</li>
<li>[[yii\web\Controller::renderFile()|renderFile()]]：渲染视图文件，和 [[yii\web\Controller::renderPartial()|renderPartial()]]类似，除了该方法使用视图文件路径而 不是视图文件名做参数。</li>
</ul>
<p>&nbsp;</p>
<h2>小部件（Widgets）</h2>
<p>小部件用于视图，是独立的积木块，一种结合复杂逻辑、显示和功能到简单组件的方法(如官方给出的Alert方法，用于展示提示信息)。一个小部件：</p>
<ul class="task-list">
<li>可能包括 PHP 高级编程</li>
<li>通常是可配置的</li>
<li>通常提供要显示的数据</li>
<li>在视图内返还要显示的 HTML</li>
</ul>
<p>Yii 捆绑了大量的小部件，如<a href="#">活动表单</a>，面包屑，菜单和<a href="#">bootstrap 框架的封装小部件</a>。另外，Yii 扩展提供更多小部件，如<a href="http://www.jqueryui.com">jQueryUI</a>的官方小部件。</p>
<p>要使用小部件，视图文件须如下操作：</p>
<pre class="brush: php;toolbar: false">
// 注意必须 "echo" 结果才能显示
echo \yii\widgets\Menu::widget(['items' => $items]);

// 传递数组以初始化对象属性
$form = \yii\widgets\ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => ['inputOptions' => ['class' => 'input-xlarge']],
]);
... 表单输入数据在此 ...
\yii\widgets\ActiveForm::end();
</pre>
<p>&nbsp;</p>
<h2>安全性<a href="#security" name="security"></a></h2>
<p>主要的安全原则之一是始终转义输出。违反该原则将导致脚本执行，更可能导致被称为 XSS 的跨站点脚本攻击，以致管理员密码泄露，使用户可以自动执行动作等。</p>
<p>Yii 提供了很好的工具以帮助你转义输出。最基本的转义要求是文本不带任何标记。可以如下这样处理：</p>
<pre class="brush: php;toolbar: false">
&lt;?php
use yii\helpers\Html;
?>

<div class="username">
    &lt;?= Html::encode($user->name) ?>
</div>
</pre>
<p>如果需要渲染的 HTML 变得复杂，可以分配转义任务给优秀的HTMLPurifier库，这个库在 Yii 中包装成一个助手类[[yii\helpers\HtmlPurifier]]：</p>
<pre class="brush: php;toolbar: false">
&lt;?php
use yii\helpers\HtmlPurifier;
?>

<div class="post">
    &lt;?= HtmlPurifier::process($post->text) ?>
</div>
</pre>
<p>注意虽然 HTMLPurifier 在输出安全上非常优秀，但它不是非常快速，所以可考虑<a href="#">缓存结果</a>。</p>
<p>&nbsp;</p>
<h2>任选其一的两种模板语言</h2>
<p>官方扩展的模板引擎有<a href="http://www.smarty.net/">Smarty</a> 和 <a href="http://twig.sensiolabs.org/">Twig</a>。了解更多内容请参考本指南的<a href="#">使用模板引擎</a>部分。</p>
<p>&nbsp;</p>
<h2>模板中使用视图对象</h2>
<p>[[yii\web\View]]组件的实例在视图模板中可用，以<code>$this</code> 变量表示。模板中使用视图对象可以完成许多有用的事情，如设置页面标题和元标签（meta tags），注册脚本和访问环境（控制器或小部件）。</p>
<h3>设置页面标题</h3>
<p>通常在视图模板设置页面标题。既然可以使用<code>$this</code> 访问视图对象，设置标题变得非常简单：</p>
<pre class="brush: php;toolbar: false">$this->title = 'My page title';</pre>
<h3>添加元标签</h3>
<p>添加元标签（meta tags）如编码、描述、关键词用视图对象也是非常简单的：</p>
<pre class="brush: php;toolbar: false">$this->registerMetaTag(['encoding' => 'utf-8']);</pre>
<p>第一个参数是 <meta> 标签选项名和值的映射。以上代码将生成：</p>
<pre class="brush: php;toolbar: false"><meta encoding="utf-8"></pre>
<p>有时一个类型只允许存在一条标签，这种情况需要指定第二个参数：</p>
<pre class="brush: php;toolbar: false">
$this->registerMetaTag(['name' => 'description', 'content' => 'This is my cool website made with Yii!'], 'meta-description');
$this->registerMetaTag(['name' => 'description', 'content' => 'This website is about funny raccoons.'], 'meta-description');
</pre>
<p>如果有第二个参数相同的多个调用（该例是 <code>meta-description</code>），后者将覆盖前者，只有一条标签被渲染：</p>
<pre class="brush: php;toolbar: false"><meta name="description" content="This website is about funny raccoons."></pre>
<h3>注册链接标签</h3>
<p><code>&lt;link></code>标签在许多情况都非常有用，如自定义网站图标、指向 RSS 订阅和分派 OpenID 到另一个服务器。 Yii 的视图对象有一个方法可以完成这些目标：</p>
<pre class="brush: php;toolbar: false">
$this->registerLinkTag([
    'title' => 'Lives News for Yii Framework',
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'href' => 'http://www.yiiframework.com/rss.xml/',
]);
</pre>
<p>上面的代码运行的结果</p>
<pre class="brush: php;toolbar: false">
&lt;link title="Lives News for Yii Framework" rel="alternate" type="application/rss+xml" href="http://www.yiiframework.com/rss.xml/" />
</pre>
<p>跟 meta 标签一样，你可以指定其它的参数来确保每种类型只有一个链接被注册。</p>
<h3>注册 CSS</h3>
<p>用[[yii\web\View::registerCss()|registerCss()]] 或 [[yii\web\View::registerCssFile()|registerCssFile()]]来注册 CSS。前者注册 CSS 代码块，而后者注册了一个外部的 CSS 文件。如：</p>
<pre class="brush: php;toolbar: false">$this->registerCss("body { background: #f00; }");</pre>
<p>以上代码运行结果是添加下面代码到页面的 head 部分：</p>
<pre class="brush: php;toolbar: false">
<style>
body { background: #f00; }
</style>
</pre>
<p>要指定样式标签的其他属性，可以传递键值对数组到第三个参数。如需确保只有一个样式标签，用第四个参数，方法如 meta 标签描述的一样。</p>
<pre class="brush: php;toolbar: false">
$this->registerCssFile("http://example.com/css/themes/black-and-white.css", [BootstrapAsset::className()], ['media' => 'print'], 'css-print-theme');
</pre>
<p>以上代码将添加一条 CSS 文件链接到页面的 head 部分。</p>
<ul class="task-list">
<li>第一个参数指定要注册的 CSS 文件。</li>
<li>第二个参数指定该 CSS 文件基于[[yii\bootstrap\BootstrapAsset|BootstrapAsset]]，意味着该 CSS 文件将添加在[[yii\bootstrap\BootstrapAsset|BootstrapAsset]]的 CSS 文件后面。不指定这个依赖关系，这个 CSS 文件和[[yii\bootstrap\BootstrapAsset|BootstrapAsset]] CSS 文件的相对位置就是未定义的。</li>
<li>第三个参数指定<code>&lt;link&gt;</code> 标签有哪些属性。</li>
<li>最后一个参数指定识别该 CSS 文件的 ID 。如没提供，将使用 CSS 文件的 URL 替代。</li>
</ul>
<p>强烈推荐使用<a href="#">资源包</a>来注册外部 CSS 文件，而不是使用[[yii\web\View::registerCssFile()|registerCssFile()]]。资源包允许你结合和压缩多个 CSS 文件，这在大流量站点非常可取。</p>
<h3>注册脚本文件</h3>
<p>[[yii\web\View]]对象可以注册脚本，有两个专用方法： 用于内部脚本的[[yii\web\View::registerJs()|registerJs()]]和用于外部脚本文件的[[yii\web \View::registerJsFile()|registerJsFile()]]。内部脚本在配置和动态生成代码上非常有用。方法添加这些功能的 使用如下：</p>
<pre class="brush: php;toolbar: false">
$this->registerJs("var options = ".json_encode($options).";", View::POS_END, 'my-options');
</pre>
<p>第一个参数是要插入页码真正的 JS 代码，第二个参数是确定脚本在页面的哪个位置插入，可能的值有：</p>
<ul class="task-list">
<li>[[yii\web\View::POS_HEAD|View::POS_HEAD]] 头部</li>
<li>[[yii\web\View::POS_BEGIN|View::POS_BEGIN]] 刚打开 <code>&lt;body&gt;</code> 后</li>
<li>[[yii\web\View::POS_END|View::POS_END]] 刚关闭 <code>&lt;/body&gt;</code> 前</li>
<li>[[yii\web\View::POS_READY|View::POS_READY]] 文档 <code>ready</code> 事件执行代码时。这将自动注册[[yii\web\JqueryAsset|jQuery]]。</li>
<li>[[yii\web\View::POS_LOAD|View::POS_LOAD]] 文档<code>load</code>事件执行代码时，这将自动注册[[yii\web\JqueryAsset|jQuery]]。</li>
</ul>
<p>最后的参数是用来识别代码块的唯一脚本 ID ，ID 相同将替换存在的脚本代码而不是添加新的。如不提供， JS 代码会用自己来做脚本 ID 。</p>
<p>外部脚本可以如下这样添加：</p>
<pre class="brush: php;toolbar: false">
$this->registerJsFile('http://example.com/js/main.js', [JqueryAsset::className()]);
</pre>
<p>[[yii\web\View::registerJsFile()|registerJsFile()]]的参数和 [[yii\web\View::registerCssFile()|registerCssFile()]]的参数类似。上例中依赖 <code>JqueryAsset</code> 注册<code>main.js</code> 文件。就是说 <code>main.js</code> 文件添加在 <code>jquery.js</code> 后面。不指明这个依赖关系， <code>main.js</code> 和 <code>jquery.js</code> 的相对位置就是未定义。</p>
<p>如同[[yii\web\View::registerCssFile()|registerCssFile()]]，强烈推荐使用<a href="#">资源包</a>来注册外部 JS 文件而不是使用[[yii\web\View::registerJsFile()|registerJsFile()]]。</p>
<h3>注册资源包</h3>
<p>如前所述，使用资源包替代直接使用 CSS 和 JS 是更好的方式。定义资源包的更多细节请参考本指南的<a href="#">资源管理</a>部分。使用已定义资源包是非常直观的：</p>
<pre class="brush: php;toolbar: false">
\frontend\assets\AppAsset::register($this);
</pre>
<h3>布局</h3>
<p>布局是表现页面通用部分的便利方式。通用部分可以在全部页面或至少你应用的大多数页面通用。通常布局包括<code>&lt;head&gt;</code> 部分，footer，主菜单和这样的元素。可以在<a href="#">基础应用模板</a>找到布局的使用示例。这里将回顾一个非常基本、没有任何小部件或额外标记的布局：</p>
<pre class="brush: php;toolbar: false">
&lt;?php
use yii\helpers\Html;
?>
&lt;?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="&lt;?= Yii::$app->language ?>">
<head>
    <meta charset="&lt;?= Yii::$app->charset ?>"/>
    <title>&lt;?= Html::encode($this->title) ?></title>
    &lt;?php $this->head() ?>
</head>
<body>
&lt;?php $this->beginBody() ?>
    <div class="container">
        &lt;?= $content ?>
    </div>
    <footer class="footer">© 2013 me :)</footer>
&lt;?php $this->endBody() ?>
</body>
</html>
&lt;?php $this->endPage() ?>
</pre>
<p>以上标记是一些代码，首先， <code>$content</code> 是一个变量，这个变量包含控制器 <code>$this-&gt;render()</code> 方法渲染视图的结果。</p>
<p>通过标准的 PHP <code>use</code> 表达式来引入（ import ）[[yii\helpers\Html|Html]]助手类，该助手类通常用于绝大多数需要转义输出数据的视图。</p>
<p>一些特别的方法如 [[yii\web\View::beginPage()|beginPage()]]/[[yii\web\View::endPage()|endPage()]], [[yii\web\View::head()|head()]], [[yii\web\View::beginBody()|beginBody()]]/[[yii\web \View::endBody()|endBody()]]触发用于注册脚本、链接和其他页面处理的渲染事件。需要一直包括这些在布局以便渲染正常工作。</p>
<h3>局部视图（partials）</h3>
<p>通常在许多页面中需要复用一些 HTML 标记，而为此创建全功能的小部件又太夸张，这种情况可以使用局部。</p>
<p>局部视图也是一个视图，位于 <code>views</code> 下相应的视图目录，并约定以下划线 <code>_</code>开头。例如，渲染一系列用户简介的同时在其他地方显示单个简介。</p>
<p>首先需要定义一个用户简介的局部视图 <code>_profile.php</code> ：</p>
<pre class="brush: php;toolbar: false">
&lt;?php
use yii\helpers\Html;
?>

<div class="profile">
    <h2>&lt;?= Html::encode($username) ?></h2>
    <p>&lt;?= Html::encode($tagline) ?></p>
</div>
</pre>
<p>然后在需要显示一系列用户的 <code>index.php</code> 视图文件使用：</p>
<pre class="brush: php;toolbar: false">
<div class="user-index">
    &lt;?php
    foreach ($users as $user) {
        echo $this->render('_profile', [
            'username' => $user->name,
            'tagline' => $user->tagline,
        ]);
    }
    ?>
</div>
</pre>
<p>在其他视图中复用同样的方式它来显示单个用户简介：</p>
<pre class="brush: php;toolbar: false">
echo $this->render('_profile', [
    'username' => $user->name,
    'tagline' => $user->tagline,
]);
</pre>
<p>当调用 <code>render()</code> 来渲染当前视图的局部视图，可以使用不同格式来指向局部视图。最经常使用的格式是所谓的相对路径视图名，如上例所示。局部视图文件和目录里当前视图的路径是相对的。如果局部视图位于子目录，要在视图名包含子目录名，如 <code>public/_profile</code> 。</p>
<p>也可以使用路径别名来指向一个视图，如， <code>@app/views/common/_profile</code> 。</p>
<p>也可以使用所谓的绝对路径视图名，如 <code>/user/_profile</code>, <code>//user/_profile</code>。绝对路径视图名以单斜线或双斜线开始。如果以单斜线开头，视图文件将在当前活动模块的视图路径搜寻，否则，将从应用根视图目录开始搜寻。</p>
<h3>访问视图所处环境（控制器、小部件）</h3>
<p>视图通常由控制器或小部件使用。这两种情况视图渲染对象通过 <code>$this-&gt;context</code> 在视图中都生效。如，需要在控制器渲染的视图中打印当前内部请求路径，可以使用以下代码：</p>
<pre class="brush: php;toolbar: false">
echo $this->context->getRoute();
</pre>
<h3>缓存页面片段</h3>
<p>更多有关页面片段缓存的内容请参考本指南的<a href="#">缓存</a>部分。</p>
<p>&nbsp;</p>
<h2>定制视图组件</h2>
<p>既然视图已经是名为 <code>view</code> 的应用组件，现在可以用继承自[[yii\base\View]] 或 [[yii\web\View]]的自定义组件类来替换。通过<code>config/web.php</code>这样的配置文件就可以实现：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        'view' => [
            'class' => 'app\components\View',
        ],
        // ...
    ],
];
</pre>

