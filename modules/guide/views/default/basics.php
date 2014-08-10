<h1>Yii的基本概念</h1>
<p>&nbsp;</p>
<h2>组件和对象</h2>
<p>Yii框架的类通常都是从两个基础类扩展而来：[[yii\base\Object]] 或 [[yii\base\Component]]。这两个类为扩展类自动提供了很多有用的功能。</p>
<p>Object 类提供配置和属性功能（ configuration and property feature）。Component 类扩展自 Object 并添加了事件处理和行为特性（<a href="guidelist?id-24">event handling</a> 和 <a href="guidelist?id=8">behaviors）</a>。</p>
<p>Object 通常用来创建那些表示基本数据结构的类， 而 <a href="guidelist?id=52">组件（Component）</a> 被用于应用程序组件以及具备更高逻辑的类。</p>
<p>&nbsp;</p>
<h2>对象配置</h2>
<p>Object 类引入了一个配置对象的统一方法。任何 Object 类的继承者在需要的时候都应该使用如下的方法来声明其构造函数，这样才能被正确的配置：</p>
<pre class="brush: php;toolbar: false">
class MyClass extends \yii\base\Object
{
    public function __construct($param1, $param2, $config = [])
    {
        // ... initialization before configuration is applied

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied
    }
}
</pre>
<p>在上述例子中，构造器的最后一个参数必须接受一个配置数组，包含键值对用来在构造函数的最后初始化对象的属性。你可以覆盖<code>init()</code>方法来在配置被应用后进行初始化。</p>
<p>通过遵循这样的规范，你将可以像下面这样使用一个configuration数组来创建和配置新的objects：</p>
<pre class="brush: php;toolbar: false">
$object = Yii::createObject([
    'class' => 'MyClass',
    'property1' => 'abc',
    'property2' => 'cde',
], [$param1, $param2]);
</pre>
<p>&nbsp;</p>
<h2>路径别名</h2>
<p>Yii 2.0 对路径别名进行了扩展，不仅用于文件、目录，也适用于URLs。一个同名（ alias ）必须以 <code>@</code> 符号开始，这样可以和文件、目录的路径以及URL链接区别开来。比如别名 <code>@yii</code> 是对 Yii 安装路径的引用，而 <code>@web</code> 包含当前Web应用程序的基础URL。路径别名在Yii的核心代码中被广泛支持。比如，<code>FileCache::cachePath</code> 可以同时接受一个路径别名或一个正常的路径。</p>
<p>路径别名和类命名空间紧密相连。建议为每个根命名空间定义一个路径同名，这样不需要额外的配置就可以使用Yii的类自动加载器。比如，因为 <code>@yii</code> 代表 Yii 安装路径，一个类似 <code>yii\web\Request</code> 的类可以被Yii自动加载。如果你使用了第三方库比如 Zend 框架，你可以定义一个路径别名 <code>@Zend</code> 指向其安装路径，Yii将可以自动读取该代码库中的任意类。</p>
<p>核心框架预定义了如下路径别名：</p>
<ul>
<li><code>@yii</code> - Yii框架自身所在路径。</li>
<li><code>@app</code> - 当前应用程序的基础路径。</li>
<li><code>@runtime</code> - runtime 目录。</li>
<li><code>@vendor</code> - 合成器的 vendor 目录。</li>
<li><code>@webroot</code> - 当前Web应用程序的根目录。</li>
<li><code>@web</code> - 当前Web应用程序的基础URL。</li>
</ul>
<p>&nbsp;</p>
<h2>自动加载</h2>
<p>所有的类（classes）、接口（interfaces）以及特征（traits）都只是在被使用时才自动加载的。不需要使用 <code>include</code> 或 <code>require</code>。这包括通过合成器加载的软件包（Composer-loaded packages）以及 Yii 扩展。</p>
<p>Yii的自动加载器按照PHP规范 <a href="https://github.com/php-fig/fig-standards/blob/master/proposed/psr-4-autoloader/psr-4-autoloader.md">PSR-4</a>实现。这意味着命名空间、类、接口以及特征必须分别对应于文件系统路径和文件名称，除了通过别名定义的根命名空间路径。</p>
<p>比如，如果一个标准的别名 <code>@app</code> 指向 <code>/var/www/example.com/</code> ，那么 <code>\app\models\User</code> 将会从 <code>/var/www/example.com/models/User.php</code> 中自动加载。</p>
<p>自定义别名可以通过下面的代码进行添加：</p>
<pre class="brush: php;toolbar: false">
Yii::setAlias('@shared', realpath('~/src/shared'));
</pre>
<p>其余自动加载器（autoloaders）可以通过 PHP 的标准方法 <code>spl_autoload_register</code>&nbsp; 来加载。</p>
<p>&nbsp;</p>
<h2>帮助类</h2>
<p>Helper 类通常包含了一些静态方法，可以使用如下：</p>
<pre class="brush: php;toolbar: false">
use \yii\helpers\Html;
echo Html::encode('Test > test');
</pre>
<p>框架提供一些有用的帮助类：</p>
<ul>
    <li>ArrayHelper</li>
    <li>Console</li>
    <li>FileHelper</li>
    <li>Html</li>
    <li>HtmlPurifier</li>
    <li>Image</li>
    <li>Inflector</li>
    <li>Json</li>
    <li>Markdown</li>
    <li>Security</li>
    <li>StringHelper</li>
    <li>Url</li>
    <li>VarDumper</li>
</ul>
