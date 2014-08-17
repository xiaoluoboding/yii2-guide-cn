<h1>性能优化</h1>
<p> web 应用的性能取决于两方面。首先是框架性能，其次是应用本身的性能。Yii 框架在你应用上的性能损耗非常小并能为生产环境进一步优化。而针对应用本身的性能，我们提供一些如何在 Yii 使用的最佳实践例子。</p>
<p>&nbsp;</p>
<h2>准备环境</h2>
<p>配置良好的环境来运行 PHP 应用是真正重要的。要获得最高性能：</p>
<ul class="task-list">
<li>总是使用 PHP 最新的稳定版本。PHP 的每个主要版本的发布都带来显著的性能改进和降低内存消耗。</li>
<li>在 PHP 5.4 以下使用 <a href="http://ru2.php.net/apc" target="_blank">APC</a>而在 PHP 5.5 以上使用<a href="http://php.net/opcache" target="_blank">Opcache</a>，它提供了非常好的性能提升。</li>
</ul>
<h2>准备生产环境框架</h2>
<h3>禁用调式模式</h3>
<p>在部署应用到生产环境前首要做的是禁用调试模式。 Yii 应用的 <code>index.php</code> 常量<code>YII_DEBUG</code> 如果定义为 <code>true</code> 就以调试模式运行，所以禁用调试要如下在 <code>index.php</code> 设置：</p>
<pre class="brush: php;toolbar:false;">
defined('YII_DEBUG') or define('YII_DEBUG', false);
</pre>
<p>调试模式在开发阶段非常有用，但它会影响性能，因为有些组件在调试模式会引起性能的额外消耗。例如，消息记录器会记录日志消息的更多有关调试的信息。</p>
<h3>启用 PHP 操作码缓存（opcode cache）</h3>
<p>启用 PHP opcode 缓存能改善任何 PHP 应用的性能并能显著降低内存使用，Yii 应用也不例外。<a href="http://php.net/manual/en/book.opcache.php" target="_blank">PHP 5.5 OPcache</a>和<a href="http://php.net/manual/en/book.apc.php" target="_blank">APC PHP 扩展</a>都已测试。这两种都能缓存和优化 PHP 中间代码并避免为每个传入的请求解析 PHP 脚本花费时间。</p>
<h3>打开活动记录数据库模式缓存</h3>
<p>如果应用使用活动记录，我们应打开模式缓存来节省解析数据库模式的时间。通过设置<code>Connection::enableSchemaCache</code> 属性为 <code>true</code> 能打开模式缓存，在应用配置文件<code>protected/config/main.php</code>设置：</p>
<pre class="brush: php;toolbar:false;">
return [
    // ...
    'components' => [
        // ...
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=mydatabase',
            'username' => 'root',
            'password' => '',
            'enableSchemaCache' => true,

            // 模式缓存持续时间
            // 'schemaCacheDuration' => 3600,

            // 使用的缓存组件名，缺省为 'cache'
            //'schemaCache' => 'cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
</pre>
<p>注意<code> cache </code>应用组件要配置好。</p>
<h3>合并和最小化资源</h3>
<p>合并和最小化资源文件，通常指 JavaScript 和 CSS ,是可行的，为的是稍微提高页面加载速度，以此为应用的终端用户提供更好的体验。</p>
<p>要学习如何实现这一目标，请参考本指南的<a href="guidelist?id=34">资源管理</a>部分。</p>
<h3>给会话（sessions）使用更好的存储</h3>
<p>默认 PHP 使用文件处理会话。开发和小项目是 OK 的，但在处理同时发生多个请求时最好转用其他存储器如数据库。配置应用的 <code>protected/config/main.php</code> 来实现：</p>
<pre class="brush: php;toolbar:false;">
return [
    // ...
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',

            // 不想用默认 'db' ，而要使用别的 DB 组件就设置以下属性
            // 'db' => 'mydb',

            // 覆写默认会话表就设置以下属性
            // 'sessionTable' => 'my_session',
        ],
    ],
];
</pre>
<p>也可使用 <code>CacheSession</code> 来缓存会话，注意有些缓存存储器如 memcached 不保证会话数据意外退出时不会丢失。</p>
<p>服务器有<a href="http://redis.io/" target="_blank">Redis</a>的话，Redis 就是高度推荐的会话存储器。</p>
<p>&nbsp;</p>
<h2>改进应用</h2>
<h3>使用服务器端的缓存技术</h3>
<p>如缓存章节所描述的，Yii 提供了好几个缓存方案来明显改善 Web 应用的性能。如果某些数据生成花费太长时间，可以使用数据缓存来减少数据生成次数；如果页面片段保持相对静态，可以使用片段缓存来减少渲染次数；如果整个页面保持相对静态，可以使用页面缓存来节约整个页面的渲染消耗。</p>
<h3>利用 HTTP 来节省处理时间和带宽</h3>
<p>HTTP 缓存能显著地节省处理时间、带宽及资源，在应用响应中发送<code>ETag</code> 或 <code>Last-Modified</code> 就可实现。如果浏览器根据 HTTP 规范执行（大多数浏览器是的），内容将只在和之前页面不同的情况下才获取新的页面。</p>
<p>形成适当的头部（header）是非常耗时的任务，因此 Yii 提供了控制器过滤器[[yii\filters\HttpCache]]形式的快捷方式。使用它是非常简单的，在控制器中如下执行<code>behaviors</code> 方法：</p>
<pre class="brush: php;toolbar:false;">
public function behaviors()
{
    return [
        'httpCache' => [
            'class' => \yii\filters\HttpCache::className(),
            'only' => ['list'],
            'lastModified' => function ($action, $params) {
                $q = new Query();
                return strtotime($q->from('users')->max('updated_timestamp'));
            },
            // 'etagSeed' => function ($action, $params) {
                // return // 这里生成 etag 种子
            //}
        ],
    ];
}
</pre>
<p>以上代码使用 <code>etagSeed</code> 或 <code>lastModified</code> 其一即可。两者都执行没有必要。我们的目标是确定内容修改在某种程度上是否比获取和渲染内容更少消耗。 <code>lastModified</code> 返回最新修改内容的 unix 时间戳，而 <code>etagSeed</code> 返回一个字符串，该字符串用于生成 <code>ETag</code> header 值。</p>
<h3>数据库优化</h3>
<p>从数据库获取数据通常是 Web 应用主要的性能瓶颈。尽管使用<a href="guidelist?id=10">缓存</a>能缓解性能损失，但它不能完全解决性能问题。当数据库包括大量数据和缓存数据无效时，如果没有良好的数据库和查询设计，获取最新数据将是非常昂贵的。</p>
<p>在数据库设计索引是明智的。索引能使 SELECT 查询更快，但它会降低INSERT, UPDATE 和 DELETE 的速度。</p>
<p>对于复杂查询，推荐为它创建数据库视图而不是在 PHP 代码嵌入复杂查询语句并让 DBMS 重复解析。</p>
<p>不要过度使用活动记录。尽管活动记录善于以面向对象的风格来建立数据模型，但它实际上会降低性能，因为活动记录必须建立一个或多个对象来代表查询结果的每一行。对于数据密集型应用，使用 DAO 或底层使用数据库 API 是更好的选择。</p>
<p>最后但同样重要的是，在 <code>SELECT</code> 查询语句使用 <code>LIMIT</code> ，这能避免从数据库获取海量数据并耗尽分配给 PHP 的内存。</p>
<h3>使用 asArray</h3>
<p>在只读页节省内存和处理时间的好方法是使用 ActiveRecord 的 <code>asArray</code> 方法：</p>
<pre class="brush: php;toolbar:false;">
class PostController extends Controller
{
    public function actionIndex()
    {
        $posts = Post::find()->orderBy('id DESC')->limit(100)->asArray()->all();
        return $this->render('index', ['posts' => $posts]);
    }
}
</pre>
<p>在视图以数组形式从<code> $posts </code>获取每个单独记录的字段：</p>
<h3>后台数据处理</h3>
<p>要更快响应用户请求，不需要马上响应的大部分可以稍后再处理。</p>
<ul class="task-list">
<li>定时作业（Cron jobs） + 控制台</li>
<li>队列 + 处理器</li>
</ul>
<p>TBD</p>
<h3>如果没有东西能帮助</h3>
<p>如果没有东西提供帮助，永远不要假设什么可以解决性能问题。相反在改变任何东西前要持续分析代码。以下工具可能是有用的：</p>
<ul class="task-list">
<li><a href="guidelist?id=22">Yii 调试工具栏和调试器</a></li>
<li><a href="http://xdebug.org/docs/profiler" target="_blank">XDebug 分析器</a></li>
<li><a href="http://www.php.net/manual/en/book.xhprof.php" target="_blank">XHProf</a></li>
</ul>
