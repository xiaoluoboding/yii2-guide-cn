<h1>授权</h1>
<p>授权是验证用户是否有足够权限做一些事情的过程。Yii 提供了两种方法来管理授权：</p>
<ul>
	<li><strong>访问控制过滤器（Access Control Filter，简称 ACF）</strong></li>
	<li><strong>基于角色的访问控制（Role-Based Access Control，简称 RBAC）</strong></li>
</ul>
<p>&nbsp;</p>
<h2>访问控制过滤器（ACF）</h2>
<p>访问控制过滤器（Access Control Filter，简称 ACF）是一种简单的授权验证方法， 最适用于那些只需要一些基本访问控制的应用。正如其名，ACF 是一个动作过滤器， 可以定义为一个 <strong><a href="guidelist?id=8">行为（Behavior）</a></strong>被附加到一个控制器或者模块上。 ACF 会检查一系列的 [[yii\filters\AccessControl::rules|access rules]]，来确认当前用户是否有权限访问当前被请求的动作。</p>
<p>下面这段代码展示类如何使用 ACF，通过 [[yii\filters\AccessControl]] 组件实现：</p>
<pre class="brush: php;toolbar: false">
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    // ...
}
</pre>
<p>在上面的代码中，ACF 被定义为一个行为，并附加到了 <code>site</code> 控制器上。这是一种典型的使用动作过滤器的方法。</p>
<p><code>only</code> 选项指定了当前 ACF 只应被应用在 <code>login</code>、<code>logout</code> 和 <code>signup</code> 这三个动作上。 <code>rules</code>选项指定了 [[yii\filters\AccessRule|access rules]]（访问规则），可以解读成以下自然语言：</p>
<ul class="task-list">
<li>允许所有游客（未登陆的用户）访问 'login'（登陆）和 'signup'（注册）两个动作。<code>roles</code> 选项包含一个问号 <code>?</code> ，问号是一个代指&ldquo;游客&rdquo;的指示符。</li>
<li>允许所有已登录用户访问 'logout'（登出）动作。<code>@</code> 符号是另外一个特殊指示符，他的意思是所有已登录用户。</li>
</ul>
<p>当 ACF 允许授权检测时，他会自顶向下逐条检查各项访问规则，直到它发现与用户身份相吻合的那个条目。 紧接着它会判断，相吻合规则的 <code>allow</code> 值，以判断用户是否有权限。 如果没有任何一条规则符合用户的身份的话，则意味着该用户 <em>没有</em>访问的资格，ACF 会终止动作的继续执行。</p>
<p>缺省状态下，ACF 在判定用户无权访问当前动作时，只会执行以下操作：</p>
<ul class="task-list">
<li>若用户是游客，他会调用 [[yii\web\User::loginRequired()]] 方法，使浏览器跳转到登陆页面。</li>
<li>若用户已登录，他会抛出一个 [[yii\web\ForbiddenHttpException]]（禁用HTTP异常）。</li>
</ul>
<p>你可以通过配置 [[yii\filters\AccessControl::denyCallback]] 属性，来自定义这种行为：</p>
<pre class="brush: php;toolbar: false">
[
    'class' => AccessControl::className(),
    'denyCallback' => function ($rule, $action) {
        throw new \Exception('您无权访问该页面');
    }
]
</pre>
<p>[[yii\filters\AccessRule|Access rules]] 支持很多选项。以下是受支持选项的总结。 你也可以扩展 [[yii\filters\AccessRule]] 类来创建一个您自定义的访问控制规则类。</p>
<ul class="task-list">
<li>
<p>[[yii\filters\AccessRule::allow|allow]]：指定了这是一个&ldquo;准许&rdquo;还是&ldquo;拒绝&rdquo;访问的规则。</p>
</li>
<li>
<p>[[yii\filters\AccessRule::actions|actions]]：指定了哪些动作受该规则影响。对应值应该是一个存储这些动作 ID 的数组。 这种比对是大小写敏感的。如果该选项为空或未设置，则意味着规则适用于全体动作。（译者注：也就是不过滤或全过滤，取决于 <code>allow</code> 的值）</p>
</li>
<li>
<p>[[yii\filters\AccessRule::controllers|controllers]]：指定哪些控制器受此规则影响。对应值应该是存储控制器 ID 的数组。 同样比对是大小写敏感的。若为空或未设置则应用于全体控制器。</p>
</li>
<li>
<p>[[yii\filters\AccessRule::roles|roles]]：指定了该规则适用于哪些用户组（角色）。 有两种通过 [[yii\web\User::isGuest]] 检查的特殊用户组标识符：</p>
<ul class="task-list">
<li><code>?</code>：对应游客用户（还未登录验证的用户）</li>
<li><code>@</code>：对应已登录用户 使用其他用户角色（组）需要 RBAC 的支持（会在下个板块详述），且会调用 [[yii\web\User::can()]] 方法。 若该选项为空或未设置，则意味着该选项应用于所有用户角色（组）。</li>
</ul>
</li>
<li>
<p>[[yii\filters\AccessRule::ips|ips]]：指定该规则匹配哪些 [[yii\web\Request::userIP|client IP addresses]] （客户端 IP 地址） 一个 IP地址可以在结尾处包含一个通配符 <code>*</code> ，这样它可以匹配所有有相同前缀的 IP 地址。 比如说，'192.168.*' 匹配所有前缀为 '192.168.' 的 IP 地址。 若该选项为空或未设置，则该规则匹配所有 IP 地址。</p>
</li>
<li>
<p>[[yii\filters\AccessRule::verbs|verbs]]：指定该规则匹配哪些 request 请求方法（<code>GET</code>、<code>POST</code> 之类的） 同样比对是大小写敏感的。</p>
</li>
<li>
<p>[[yii\filters\AccessRule::matchCallback|matchCallback]]：指定当规则符合时调用哪个 PHP callable 对象 （可调用接口的对象，也就是函数对象，各种各样的函数对象）。</p>
</li>
<li>
<p>[[yii\filters\AccessRule::denyCallback|denyCallback]]: 指定当规则需要拒绝相关访问时，应该调用哪个 PHP callable 对象。</p>
</li>
</ul>
<p>下面是一个例子，叫你如何使用 <code>matchCallback</code> 选项，这将允许你写出非常随意的访问检测逻辑：</p>
<pre class="brush: php;toolbar: false">
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['special-callback'],
                'rules' => [
                    [
                        'actions' => ['special-callback'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return date('d-m') === '11-11';
                        }
                    ],
                ],
            ],
        ];
    }

    // 匹配的回调函数被调用！当前页只能每个11月11号才能访问
    public function actionSpecialCallback()
    {
        return $this->render('happy-singles-day');
    }
}
</pre>
<p>&nbsp;</p>
<h2>基于角色的访问控制（RBAC）</h2>
<p>基于角色的访问控制（Role-Based Access Control，简称 RBAC） 提供一个简单且强大的集中式访问控制。</p>
<p>TBD</p>