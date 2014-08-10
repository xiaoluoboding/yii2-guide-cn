<h1>从 Yii 1.1 升级</h1>
<p>2.0 版框架是完全重写的，在 1.1 和 2.0 两个版本之间存在相当多差异。因此从 1.1 版升级并不像小版本间的跨越那么简单，通过本指南你将会了解两个版本间主要的不同之处。</p>
<p>请注意，Yii 2.0 引入了很多本章并没有涉及到的新功能。强烈建议你通读整部权威指南来了解所有新特性。这样有可能会发现一些以前你要自己开发的功能，而现在已经被包含在核心代码中了。</p>
<p>&nbsp;</p>
<h2>安装</h2>
<p>Yii 2.0 完全拥抱 <a href="https://getcomposer.org/">Composer</a>，它是PHP中的一个依赖管理工具。核心框架以及扩展的安装都通过 Composer 来处理。想要了解更多如何安装 Yii 2.0 请参阅本指南的 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/start-installation.md">安装 Yii</a> 章节。如果你想创建新扩展，或者把你已有的 Yii 1.1 的扩展改写成兼容 2.0 的版本，你可以参考 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/extend-creating-extensions.md">创建扩展</a> 章节。</p>
<p>&nbsp;</p>
<h2>PHP 需求</h2>
<p>Yii 2.0 需要 PHP 5.4 或更高版本，该版本相对于 Yii 1.1 所需求的 PHP 5.2 而言有巨大的改进。因此在语言层面上有很多的值得注意的不同之处。下面是 PHP 层的主要变化汇总：</p>
<ul class="task-list">
<li><a href="http://php.net/manual/zh/language.namespaces.php">命名空间</a></li>
<li><a href="http://php.net/manual/zh/functions.anonymous.php">匿名函数</a></li>
<li>数组短语法 <code>[...元素...]</code> 用于取代 <code>array(...元素...)</code></li>
<li>视图文件中的短格式 echo 标签 <code>&lt;?=</code>，自 PHP 5.4 起总会被识别并且合法，无论 short_open_tag 的设置是什么，可以安全使用。</li>
<li><a href="http://php.net/manual/zh/book.spl.php">SPL 类和接口</a></li>
<li><a href="http://php.net/manual/zh/language.oop5.late-static-bindings.php">延迟静态绑定</a></li>
<li><a href="http://php.net/manual/zh/book.datetime.php">日期和时间</a></li>
<li><a href="http://php.net/manual/zh/language.oop5.traits.php">Traits</a></li>
<li><a href="http://php.net/manual/zh/book.intl.php">intl</a> Yii 2.0 使用 PHP 扩展 <code>intl</code> 来支持国际化的相关功能。</li>
</ul>
<p>&nbsp;</p>
<h2>命名空间</h2>
<p>Yii 2.0 里最明显的改动就数命名空间的使用了。几乎每一个核心类都引入了命名空间，比如 <code>yii\web\Request</code>。1.1 版用于类名前的字母 &ldquo;C&rdquo; 已经不再使用。当前的命名规范与目录结构相吻合。例如，<code>yii\web\Request</code> 就表明对应的类文件是 Yii 框架文件夹下的 <code>web/Request.php</code> 文件。</p>
<p>（有了 Yii 的类自动加载器，你可以直接使用全部核心类而不需要显式包含具体文件。）</p>
<p>&nbsp;</p>
<h2>组件（Component）与对象（Object）</h2>
<p>Yii 2.0 把 1.1 里的 <code>CComponent</code> 类拆分成了两个类：[[yii\base\Object]] 和 [[yii\base\Component]]。[[yii\base\Object|Object]] 类是一个轻量级的基类，你可以通过 getters 和 setters 来定义 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/concept-properties.md">object 的属性</a>。[[yii\base\Component|Component]] 类继承自 [[yii\base\Object|Object]]，同时进一步支持 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/concept-events.md">事件</a> 和 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/concept-behaviors.md">行为</a>。</p>
<p>如果你不需要用到事件或行为，应该考虑使用 [[yii\base\Object|Object]] 类作为基类。这通常是表示基本数据结构的类。</p>
<p>&nbsp;</p>
<h2>对象的配置</h2>
<p>[[yii\base\Object|Object]] 类引入了一种统一对象配置的方法。所有 [[yii\base\Object|Object]] 的子类都应该用以下方法声明它的构造方法（如果需要的话），以正确配置它自身：</p>
<pre class="brush: php;toolbar: false">
class MyClass extends \yii\base\Object
{
    public function __construct($param1, $param2, $config = [])
    {
        // ... 配置生效前的初始化过程

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        // ...配置生效后的初始化过程
    }
}
</pre>
<p>在上面的例子里，构造方法的最后一个参数必须输入一个配置数组，包含一系列用于在方法结尾初始化相关属性的键值对。你可以重写 [[yii\base\Object::init()|init()]] 方法来执行一些需要在配置生效后进行的初始化工作。</p>
<p>你可以通过遵循以下约定俗成的编码习惯，来使用配置数组创建并配置新的对象：</p>
<pre class="brush: php;toolbar: false">
$object = Yii::createObject([
    'class' => 'MyClass',
    'property1' => 'abc',
    'property2' => 'cde',
], [$param1, $param2]);
</pre>
<p>更多有关配置的细节可以在<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/concept-configurations.md">配置</a>章节找到。</p>
<p>&nbsp;</p>
<h2>事件（Event）</h2>
<p>在 Yii 1 中，通常通过定义 <code>on</code> 开头的方法（例如 <code>onBeforeSave</code>）来创建事件。而在 Yii 2 中，你可以使用任意的事件名了。同时通过调用 [[yii\base\Component::trigger()|trigger()]] 方法来触发相关事件：</p>
<pre class="brush: php;toolbar: false">
$event = new \yii\base\Event;
$component->trigger($eventName, $event);
</pre>
<p>要给事件附加一个事件句柄（Event Handler 或者叫事件处理器），需要使用 [[yii\base\Component::on()|on()]] 方法：</p>
<pre class="brush: php;toolbar: false">
$component->on($eventName, $handler);
// 要解除相关句柄，使用 off 方法：
// $component->off($eventName, $handler);
</pre>
<p>事件功能还有更多增强之处。要了解它们，请查看<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/concept-events.md">事件</a>章节。</p>
<p>&nbsp;</p>
<h2>路径别名（Path Alias）</h2>
<p>Yii 2.0 将路径别名的应用扩大至文件/目录路径和 URL。Yii 2.0 中路径别名必须以 <code>@</code> 符号开头，以区别于普通文件目录路径或 URL。例如 <code>@yii</code> 就是指向 Yii 安装目录的别名。绝大多数 Yii 核心代码都支持别名。例如 [[yii\caching\FileCache::cachePath]] 就同时支持路径别名或普通的目录地址。</p>
<p>路径别名也和类的命名空间密切相关。建议给每一个根命名空间定义一个路径别名，从而无须额外配置，便可启动 Yii 的类自动加载机制。例如，因为有 <code>@yii</code> 指向 Yii 安装目录，那类似 <code>yii\web\Request</code> 的类就能被 Yii 自动加载。同理，若你用了一个第三方的类库，如 Zend Framework，你只需定义一个名为 <code>@Zend</code> 的路径别名指向该框架的安装目录。之后 Yii 就可以自动加载任意 Zend Framework 中的类了。</p>
<p>更多路径别名信息请参阅<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/concept-aliases.md">路径别名</a>章节。</p>
<p>&nbsp;</p>
<h2>视图（View）</h2>
<p>Yii 2 中视图最明显的改动是视图内的特殊变量 <code>$this</code> 不再指向当前控制器或小部件，而是指向<strong>视图</strong>对象，它是 2.0 中引入的全新概念。<strong>视图</strong>对象为 [[yii\web\View]] 的实例，他代表了 MVC 模式中的视图部分。如果你想要在视图中访问一个控制器或小部件，可以使用 <code>$this-&gt;context</code>。</p>
<p>要在其他视图里渲染一个局部视图，使用 <code>$this-&gt;render()</code>，而不是 <code>$this-&gt;renderPartial()</code>。<code>render()</code> 现在只返回渲染结果，而不是直接显示它，所以现在你必须显式地把它 <strong>echo</strong> 出来。像这样：</p>
<pre class="brush: php;toolbar: false">
echo $this->render('_item', ['item' => $item]);
</pre>
<p>除了使用 PHP 作为主要的模板语言，Yii 2.0 也装备了两种流行模板引擎的官方支持：Smarty 和 Twig。过去的 Prado 模板引擎不再被支持。要使用这些模板引擎，你需要配置 <code>view</code> 应用组件，给它设置 [[yii\base\View::$renderers|View::$renderers]] 属性。具体请参阅<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/tutorial-template-engines.md">模板引擎</a>章节。</p>
<p>&nbsp;</p>
<h2>模型（Model）</h2>
<p>Yii 2.0 使用 [[yii\base\Model]] 作为模型基类，类似于 1.1 的 <code>CModel</code> 。<code>CFormModel</code> 被完全弃用了，现在要创建表单模型类，可以通过继承 [[yii\base\Model]] 类来实现。</p>
<p>Yii 2.0 引进了名为 [[yii\base\Model::scenarios()|scenarios()]] 的新方法来声明支持的场景，并指明在哪个场景下某属性必须经过验证，可否被视为安全值等等。如：</p>
<pre class="brush: php;toolbar: false">
public function scenarios()
{
    return [
        'backend' => ['email', 'role'],
        'frontend' => ['email', '!role'],
    ];
}
</pre>
<p>上面的代码声明了两个场景：<code>backend</code> 和 <code>frontend</code> 。对于 <code>backend</code> 场景，<code>email</code> 和 <code>role</code> 属性值都是安全的，且能进行批量赋值。对于 <code>frontend</code> 场景，<code>email</code> 能批量赋值而 <code>role</code> 不能。 <code>email</code> 和 <code>role</code> 都必须通过规则验证。</p>
<p>[[yii\base\Model::rules()|rules()]] 方法仍用于声明验证规则。注意，由于引入了 [[yii\base\Model::scenarios()|scenarios()]]，现在已经没有 <code>unsafe</code> 验证器了。</p>
<p>大多数情况下，如果 [[yii\base\Model::rules()|rules()]] 方法内已经完整地指定场景了，那就不必覆写 [[yii\base\Model::scenarios()|scenarios()]]，也不必声明 <code>unsafe</code> 属性值。</p>
<p>要了解更多有关模型的细节，请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/structure-models.md">模型</a>章节。</p>
<p>&nbsp;</p>
<h2>控制器（Controller）</h2>
<p>Yii 2.0 使用 [[yii\web\Controller]] 作为控制器的基类，类似于 1.1 的 <code>CWebController</code>。使用 [[yii\base\Action]] 作为操作类的基类。</p>
<p>这些变化最明显的影响是，当你在写控制器操作的代码时，应该返回（return）要渲染的内容而不是输出（echo）它：</p>
<pre class="brush: php;toolbar: false">
public function actionView($id)
{
    $model = \app\models\Post::findOne($id);
    if ($model) {
        return $this->render('view', ['model' => $model]);
    } else {
        throw new \yii\web\NotFoundHttpException;
    }
}
</pre>
<p>请查看 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/structure-controllers.md">控制器（Controller）</a> 章节了解有关控制器的更多细节。</p>
<p>&nbsp;</p>
<h2>小部件（Widget）</h2>
<p>Yii 2.0 使用 [[yii\base\Widget]] 作为小部件基类，类似于 1.1 的 <code>CWidget</code>。</p>
<p>为了让框架获得更好的 IDE 支持，Yii 2.0 引进了一个调用小部件的新语法。包含 [[yii\base\Widget::begin()|begin()]]，[[yii\base\Widget::end()|end()]] 和 [[yii\base\Widget::widget()|widget()]] 三个静态方法，用法如下：</p>
<pre class="brush: php;toolbar: false">
use yii\widgets\Menu;
use yii\widgets\ActiveForm;

// 注意必须 **"echo"** 结果以显示内容
echo Menu::widget(['items' => $items]);

// 传递一个用于初始化对象属性的数组
$form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => ['inputOptions' => ['class' => 'input-xlarge']],
]);
... 表单输入栏都在这里 ...
ActiveForm::end();
</pre>
<p>更多细节请参阅<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/structure-widgets.md">小部件</a>章节。</p>
<p>&nbsp;</p>
<h2>主题（Theme）</h2>
<p>2.0 主题的运作方式跟以往完全不同了。它们现在基于<strong>路径映射机制</strong>，该机制会把一个源视图文件的路径映射到一个主题视图文件路径。举例来说，如果路径映射为 <code>['/web/views' =&gt; '/web/themes/basic']</code>，那么 <code>/web/views/site/index.php</code> 视图经过主题修饰的版本就会是 <code>/web/themes/basic/site/index.php</code>。也因此让主题现在可以应用在任何视图文件之上，甚至是渲染控制器上下文环境之外的视图文件或小部件。</p>
<p>同样，<code>CThemeManager</code> 组件已经被移除了。取而代之的 <code>theme</code> 成为了 <code>view</code> 应用组件的一个可配置属性。</p>
<p>更多细节请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/output-theming.md">主题</a>章节。</p>
<p>&nbsp;</p>
<h2>控制台应用（Console Application）</h2>
<p>控制台应用现在如普通的 Web 应用程序一样，由控制器组成，控制台的控制器继承自 [[yii\console\Controller]]，类似于 1.1 的 <code>CConsoleCommand</code>。</p>
<p>运行控制台命令使用 <code>yii &lt;route&gt;</code>，其中 <code>&lt;route&gt;</code> 代表控制器的路由（如 <code>sitemap/index</code>）。额外的匿名参数传递到对应的控制器操作方法，而有名的参数根据 [[yii\console\Controller::options()]] 的声明来解析。</p>
<p>Yii 2.0 支持基于代码注释自动生成相的关命令行帮助（help）信息。</p>
<p>更多细节请参阅<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/tutorial-console.md">控制台命令</a>章节。</p>
<p>&nbsp;</p>
<h2>国际化（I18N）</h2>
<p>Yii 2.0 移除了原来内置的日期格式器和数字格式器，为了支持 <a href="http://pecl.php.net/package/intl">PECL intl PHP module</a>（PHP 的国际化扩展）的使用。</p>
<p>消息翻译现在由 <code>i18n</code> 应用组件执行。该组件管理一系列消息源，允许使用基于消息类别的不同消息源。</p>
<p>更多细节请参阅<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/tutorial-i18n.md">国际化（Internationalization）</a>章节。</p>
<p>&nbsp;</p>
<h2>操作过滤器（Action Filters）</h2>
<p>操作的过滤现在通过行为（behavior）来实现。要定义一个新的，自定义的过滤器，请继承 [[yii\base\ActionFilter]] 类。要使用一个过滤器，需要把过滤器类作为一个 <code>behavior</code> 绑定到控制器上。例如，要使用 [[yii\filters\AccessControl]] 过滤器，你需要在控制器内添加如下代码：</p>
<pre class="brush: php;toolbar: false">
public function behaviors()
{
    return [
        'access' => [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                ['allow' => true, 'actions' => ['admin'], 'roles' => ['@']],
            ],
        ],
    ];
}
</pre>
<p>更多细节请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/structure-filters.md">过滤器</a>章节。</p>
<p>&nbsp;</p>
<h2>前端资源（Assets）</h2>
<p>Yii 2.0 引入了一个新的概念，称为<strong>资源包</strong>（Asset Bundle），以代替 1.1 的脚本包概念。</p>
<p>一个资源包是一个目录下的资源文件集合（如 JavaScript 文件、CSS 文件、图片文件等）。每一个资源包被表示为一个类，该类继承自 [[yii\web\AssetBundle]]。用 [[yii\web\AssetBundle::register()]] 方法注册一个资源包后，就使它的资源可被 Web 访问了，注册了资源包的页面会自动包含和引用资源包内指定的 JS 和 CSS 文件。</p>
<p>更多细节请参阅 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/structure-assets.md">前端资源管理（Asset）</a> 章节。</p>
<p>&nbsp;</p>
<h2>助手类（Helpers）</h2>
<p>Yii 2.0 很多常用的静态助手类，包括：</p>
<ul class="task-list">
<li>[[yii\helpers\Html]]</li>
<li>[[yii\helpers\ArrayHelper]]</li>
<li>[[yii\helpers\StringHelper]]</li>
<li>[[yii\helpers\FileHelper]]</li>
<li>[[yii\helpers\Json]]</li>
</ul>
<p>请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/helper-overview.md">助手一览</a> 章节来了解更多。</p>
<p>&nbsp;</p>
<h2>表单</h2>
<p>Yii 2.0 引进了<strong>表单栏（field）</strong>的概念，用来创建一个基于 [[yii\widgets\ActiveForm]]的表单。一个表单栏是一个由标签、输入框、错误消息（可能还有提示文字）组成的容器，被表示为 [[yii\widgets\ActiveField|ActiveField]] 对象。使用表单栏建立表单的过程比以前更整洁利落：</p>
<pre class="brush: php;toolbar: false"> 
&lt;?php $form = yii\widgets\ActiveForm::begin(); ?>
    &lt;?= $form->field($model, 'username') ?>
    &lt;?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        &lt;?= Html::submitButton('Login') ?>
    </div>
&lt;?php yii\widgets\ActiveForm::end(); ?>
</pre>
<p>请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/input-forms.md">创建表单</a>章节来了解更多细节。</p>
<p>&nbsp;</p>
<h2>查询生成器（Query Builder）</h2>
<p>Yii 1.1 中，查询语句的生成分散在多个类中，包括 <code>CDbCommand</code>，<code>CDbCriteria</code> 以及 <code>CDbCommandBuilder</code>。Yii 2.0 以 [[yii\db\Query|Query]] 对象的形式表示一个数据库查询，这个对象使用 [[yii\db\QueryBuilder|QueryBuilder]] 在幕后生成 SQL 语句。例如：</p>
<pre class="brush: php;toolbar: false">
$query = new \yii\db\Query();
$query->select('id, name')
      ->from('user')
      ->limit(10);

$command = $query->createCommand();
$sql = $command->sql;
$rows = $command->queryAll();
</pre>
<p>最重要的是，这些查询生成方法还可以和<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/db-active-record.md">活动记录</a>配合使用。</p>
<p>请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/db-query-builder.md">查询生成器（Query Builder）</a>章节了解更多内容。</p>
<p>&nbsp;</p>
<h2>活动记录（Active Record）</h2>
<p>Yii 2.0 的<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/db-active-record.md">活动记录</a>改动了很多。两个最显而易见的改动分别涉及查询语句的生成（query building）和关联查询的处理（relational query handling）。</p>
<p>1.1 中的 <code>CDbCriteria</code> 类在 Yii 2 中被 [[yii\db\ActiveQuery]] 所替代。这个类是继承自 [[yii\db\Query]]，因此也继承了所有查询生成方法。开始拼装一个查询可以调用 [[yii\db\ActiveRecord::find()]] 方法进行：</p>
<pre class="brush: php;toolbar: false">
// 检索所有 *活动的* 客户和订单，并以 ID 排序：
$customers = Customer::find()
    ->where(['status' => $active])
    ->orderBy('id')
    ->all();
</pre>
<p>要声明一个关联关系，只需简单地定义一个 getter 方法来返回一个 [[yii\db\ActiveQuery|ActiveQuery]] 对象。getter 方法定义的属性名（译者注：即 getOrders() 中的 orders）表示关联关系名。如，以下代码声明了一个名为 <code>orders</code> 的关系（1.1 中必须在 <code>relations()</code> 方法内声明关系）：</p>
<pre class="brush: php;toolbar: false">
class Customer extends \yii\db\ActiveRecord
{
    public function getOrders()
    {
        return $this->hasMany('Order', ['customer_id' => 'id']);
    }
}
</pre>
<p>现在你就可以通过调用 <code>$customer-&gt;orders</code> 来访问关联表中某用户的订单了。你还可以用以下代码进行一场指定条件的实时关联查询：</p>
<pre class="brush: php;toolbar: false">
$orders = $customer->getOrders()->andWhere('status=1')->all();
</pre>
<p>当贪婪加载一段关联关系时，Yii 2.0 和 1.1 的运作机理并不相同。具体来说，在 1.1 中使用一条 JOIN 语句同时查询主表和关联表记录。在 Yii 2.0 中会使用两个没有 JOIN 的 SQL 语句：第一条语句取回主表记录，第二条通过主表记录经主键筛选后查询关联表记录。</p>
<p>当生成返回大量记录的查询时，可以链式书写 [[yii\db\ActiveQuery::asArray()|asArray()]] 方法，这样会以数组的形式返回查询结果，而不必返回 [[yii\db\ActiveRecord|ActiveRecord]] 对象，这能显著降低因大量记录读取所消耗的 CPU 时间和内存。如：</p>
<pre class="brush: php;toolbar: false">
$customers = Customer::find()->asArray()->all();
</pre>
<p>另一个改变是你不能再通过公共数据定属性（Attribute）的默认值了。如果你需要这么做的话，可以在你的记录类的 <code>init</code> 方法中设置它们。</p>
<div class="highlight highlight-php">
<pre class="brush: php;toolbar: false">
public function init()
{
    parent::init();
    $this->status = self::STATUS_NEW;
}
</pre>
<p>曾几何时，在 1.1 中重写一个活动记录类的构造方法（Constructor）会导致一些问题。它们不会在 2.0 中出现了。需要注意的是，如果你需要在构造方法中添加一些参数，恐怕必须重写 [[yii\db\ActiveRecord::instantiate()]] 方法。</p>
<p>活动记录方面还有很多其他的变化与改进，请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/db-active-record.md">活动记录</a>章节以了解更多细节。</p>
<p>&nbsp;</p>
<h2>用户及身份验证接口（IdentityInterface）</h2>
<p>1.1 中的 <code>CWebUser</code> 类现在被 [[yii\web\User]] 所取代，随之 <code>CUserIdentity</code> 类也不在了。与之相对的，为达到相同目的，你可以实现 [[yii\web\IdentityInterface]] 接口，它使用起来更直观。在高级应用模版里提供了一个这样的一个例子。</p>
<p>要了解更多细节请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/security-authentication.md">认证（Authentication）</a>，<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/security-authorization.md">授权（Authorization）</a>以及<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/tutorial-advanced-app.md">高级应用模版</a> 这三个章节。</p>
<p>&nbsp;</p>
<h2>URL 管理</h2>
<p>Yii 2.0 的 URL 管理跟 1.1 中很像。一个主要的改进是现在的 URL 管理支持<strong>可选参数</strong>了。比如，如果你在 2.0 中定义了一个下面这样的规则，那么它可以同时匹配 <code>post/popular</code> 和 <code>post/1/popular</code> 两种 URL。而在 1.1 中为达成相同效果，必须要使用两条规则。</p>
<pre class="brush: php;toolbar: false">
[
    'pattern' => 'post/&lt;page:\d+>/&lt;tag&gt;',
    'route' => 'post/index',
    'defaults' => ['page' => 1],
]
</pre>
<p>请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/runtime-url-handling.md">URL 解析和生成</a> 章节，以了解更多细节。.</p>
<p>&nbsp;</p>
<h2>同时使用 Yii 1.1 和 2.x</h2>
<p>如果你有一些遗留的 Yii 1.1 代码，需要跟 Yii 2.0 一起使用，可以参考 <a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/extend-using-v1-v2.md">1.1 和 2.0 共用</a>章节。</p>