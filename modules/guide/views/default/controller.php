<h1>控制器</h1>
<p>控制器是应用程序的核心部分之一。决定如何处理请求和创建一个应答。</p>
<p>通常控制器接收HTTP请求数据，返回HTML、JSON或XML格式数据作为应答。</p>
<p>&nbsp;</p>
<h2>基础</h2>
<p>控制器位于应用的 <code>controllers</code> 目录，命名规范为 <code>SiteController.php</code>(控制器名+Controller)， <code>Site</code> 部分包括一系列动作。</p>
<p>基本的 web 控制器通常继承自[[yii\web\Controller]]：</p>
<pre class="brush: php;toolbar: false">
namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        // 将渲染 "views/site/index.php"
        return $this->render('index');
    }

    public function actionTest()
    {
        // 仅打印 "test" 到浏览器
        return 'test';
    }
}
</pre>
<p>如你所见，控制器通常包括一系列动作，这些动作是公开的类方法，以<code>actionSomething</code>(action+动作名) 形式命名。 动作的输出结果，就是这些方法返回的结果：可以是字符串或[[yii\web\Response]]的实例，<a href="#">示例</a>。 返回值将被 <code>response</code> 应用组件处理，该组件可以把输出转变为不同格式，如 JSON,XML。默认行为是输出原始的值（不改变输出值）。</p>
<p>&nbsp;</p>
<h2>路由（路径）</h2>
<p>每个控制器动作有相应的内部路径。上例中 <code>actionIndex</code> 的路径是 <code>site/index</code> ，而 <code>actionTest</code> 的路径是 <code>site/test</code> 。在这个路径中 <code>site</code> 是指控制器 ID ，而 <code>test</code> 是动作 ID 。</p>
<p>访问确定控制器和动作的默认 URL 格式是<code>http://example.com/?r=controller/action</code> 。这个行为可以 完全自定义。更多细节请参考<a href="#">URL 管理</a>。</p>
<p>如果控制器位于模块内，其动作的路径格式是 <code>module/controller/action</code> 。</p>
<p>控制器可以位于应用或模块的控制器目录的子目录，这样路径将在前面加上相应的目录名。如，有个 <code>UserController</code> 控制器位于 <code>controllers/admin</code> 目录下，该控制器的 <code>actionIndex</code> 动作的路径 将是 <code>admin/user/index</code> ， <code>admin/user</code> 是控制器 ID 。</p>
<p>如指定的模块、控制器或动作未找到，Yii 将返回&ldquo;未找到&rdquo;的页面和 HTTP 状态码 404 。</p>
<blockquote>
<p>注意：如果模块名、控制器名或动作名包含驼峰式单词，内部路径将使用破折号。如<code>DateTimeController::actionFastForward</code> 的路径将是 <code>date-time/fast-forward</code>。</p>
</blockquote>
<h3>预设值</h3>
<p>如用户未指定任何路由，如使用 <code>http://example.com/</code> 这样的 URL ，Yii 将启用默认路径。默认路径由[[yii\web\Application::defaultRoute]]方法定义，且 <code>site</code> 即 <code>SiteController</code> 将默认加载。</p>
<p>控制器有默认执行的动作。当用户请求未指明需要执行的动作时，如使用 <code>http://example.com/?r=site</code> 这样的 URL ，则默认的动作将被执行。当前预设的默认动作是 <code>index</code> 。 设置[[yii\base\Controller::defaultAction]]属性可以改变预设动作。</p>
<p>&nbsp;</p>
<h2>动作参数</h2>
<p>如前所述，一个简单的动作只是以 <code>actionSomething</code> 命名的公开方法。现在来回顾一下动作从 HTTP 获取参数的途径。</p>
<h3>动作参数</h3>
<p>可以为动作定义具名实参，会自动填充相应的 <code>$_GET</code> 值。这非常方便，不仅因为短语法，还因为有能力指定预设值：</p>
<pre class="brush: php;toolbar: false">
namespace app\controllers;

use yii\web\Controller;

class BlogController extends Controller
{
    public function actionView($id, $version = null)
    {
        $post = Post::find($id);
        $text = $post->text;

        if ($version) {
            $text = $post->getHistory($version);
        }

        return $this->render('view', [
            'post' => $post,
            'text' => $text,
        ]);
    }
}
</pre>
<p>上述动作可以用<code>http://example.com/?r=blog/view&amp;id=42</code> 或<code>http://example.com/?r=blog/view&amp;id=42&amp;version=3</code> 访问。前者 <code>version</code> 没有指定，将使用默认参数值填充。</p>
<h3>从请求获取数据</h3>
<p>如果动作运行的数据来自 HTTP请求的POST 或有太多的GET 参数，可以依靠 request 对象以 <code>\Yii::$app-&gt;request</code> 的方式来访问：</p>
<pre class="brush: php;toolbar: false">namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;

class BlogController extends Controller
{
    public function actionUpdate($id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new NotFoundHttpException();
        }

        if (\Yii::$app->request->isPost) {
            $post->load(Yii::$app->request->post());
            if ($post->save()) {
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }

        return $this->render('update', ['post' => $post]);
    }
}
</pre>
<p>&nbsp;</p>
<h2>独立动作类</h2>
<p>如果动作非常通用，最好用单独的类实现以便重用。创建<code>actions/Page.php</code> ：</p>
<pre class="brush: php;toolbar: false">
namespace app\actions;

class Page extends \yii\base\Action
{
    public $view = 'index';

    public function run()
    {
        return $this->controller->render($view);
    }
}
</pre>
<p>以下代码对于实现单独的动作类虽然简单，但提供了如何使用动作类的想法。实现的动作可以在控制器中如下这般使用：</p>
<pre class="brush: php;toolbar: false">class SiteController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'about' => [
                'class' => 'app\actions\Page',
                'view' => 'about',
            ],
        ];
    }
}
</pre>
如上使用后可以通过<code> http://example.com/?r=site/about</code>访问该动作。
<p>&nbsp;</p>
<h2>动作过滤器</h2>
<p>可能会对控制器动作使用一些过滤器来实现如确定谁能访问当前动作、渲染动作结果的方式等任务。</p>
<p>动作过滤器是[[yii\base\ActionFilter]]子类的实例。</p>
<p>使用动作过滤器是附加为控制器或模块的行为（behavior）。下例展示了如何为 <code>index</code> 动作开启 HTTP 缓存：</p>
<pre class="brush: php;toolbar: false">public function behaviors()
{
    return [
        'httpCache' => [
            'class' => \yii\filters\HttpCache::className(),
            'only' => ['index'],
            'lastModified' => function ($action, $params) {
                $q = new \yii\db\Query();
                return $q->from('user')->max('updated_at');
            },
        ],
    ];
}
</pre>
<p>可以同时使用多个动作过滤器。过滤器启用的顺序定义在<code>behaviors()</code>。如任一个过滤器取消动作执行，后面的过滤器将跳过。</p>
<p>过滤器附加到控制器，就被该控制器的所有动作使用；如附加到模块（或整个应用），则模块内所有控制器的所有动作都可以使用该过滤器（或应用的所有控制器的所有动作可以使用该过滤器）。</p>
<p>创建新的动作过滤器，继承[[yii\base\ActionFilter]]并覆写[[yii\base \ActionFilter::beforeAction()|beforeAction()]] 和 [[yii\base\ActionFilter::afterAction()|afterAction()]]方法，前者在动作运行前执行，而后者在 动作运行后执行。[[yii\base\ActionFilter::beforeAction()|beforeAction()]]返回值决定动作是 否执行。如果过滤器的 <code>beforeAction()</code> 返回 false ，该过滤器之后的过滤器都会跳过，且动作也不会执行。</p>
<p>本指南的<a href="#">授权</a>部分展示了如何使用[[yii\filters\AccessControl]]过滤器，<a href="#">缓存</a>部分提供有关[[yii\filters\PageCache]] 和 [[yii\filters\HttpCache]]过滤器更多细节。 这些内置过滤器是你创建自己的过滤器的良好参考。</p>
<p>&nbsp;</p>
<h2>捕获所有请求</h2>
<p>有时使用一个简单的控制器动作处理所有请求是有用的。如，当网站维护时显示一条布告。动态或通过应用配置文件配置 web 应用的 <code>catchAll</code> 属性可以实现该目的：</p>
<pre class="brush: php;toolbar: false">return [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    // ...
    'catchAll' => [ // <-- 这里配置
        'offline/notice',
        'param1' => 'value1',
        'param2' => 'value2',
    ],
]
</pre>
<p>上面 <code>offline/notice</code> 指向 <code>OfflineController::actionNotice()</code> 。 <code>param1</code> 和 <code>param2</code> 是传递给动作方法的参数。</p>
<p>&nbsp;</p>
<h2>自定义响应类</h2>
<pre class="brush: php;toolbar: false">namespace app\controllers;

use yii\web\Controller;
use app\components\web\MyCustomResponse; //继承自 yii\web\Response

class SiteController extends Controller
{
    public function actionCustom()
    {
        /*
         * 这里做你自己的事
         * 既然 Response 类继承自 yii\base\Object,
         * 可以在__constructor() 传递简单数组初始化该类的值
         */
        return new MyCustomResponse(['data' => $myCustomData]);
    }
}
</pre>
<p>&nbsp;</p>
<h2>See Also</h2>
<p><a href="1403.html">控制台命令</a></p>