
<p>接下来的章节中，我们将讨论更多的服务接口实现细节。</p>
<p>&nbsp;</p>
<h2>总体架构</h2>
<p>在 Yii RESTful API 框架中，你依据一个控制器的动作（action）来实现一个API终端（endpoint），并使用控制器为单个类型的资源（Resource）组织这些终端。</p>
<p>资源通过继承自 [[yii\base\Model]] 的数据模型来表达。如果你使用数据库（无论关系型还是NoSQL），则建议你使用ActiveRecord 来表达资源。</p>
<p>你可以使用 [[yii\rest\UrlRule]] 来简化API终端路由。</p>
<p>最 好将RESTful APIs实现为一个单独的应用，和你的Web前后台区分开。（译注：分开有好处，便于单独部署，分散负载。为了同时满足代码复用和应用分开的需求，一个比 较好的方法是项目代码并不分开，在Web应用和RESTful服务接口之下提取公共服务层，然后在部署时分开）。</p>
<p>&nbsp;</p>
<h2>创建资源类</h2>
<p>RESTful APIs 就是用来访问和操作资源的。在Yii中，资源可以是任意类的一个对象。不过，如果你的资源类扩展自yii\base\Model 或其子类（比如 yii\db\ActiveRecord），你可以获得以下好处：</p>
<ul>
	<li> 输入数据验证；</li>
	<li>查询，创建，更新和删除数据的功能，如果是从 yii\db\ActiveRecord 扩展的话。</li>
	<li>可定制数据格式（将在接下来的章节进行描述）。</li>
</ul>
<p>&nbsp;</p>
<h2>格式化应答数据</h2>
<p>缺省情况下，Yii支持两种应答数据格式：JSON 和 XML。如果你想支持其他格式，你应该在你的REST控制器中配置<code> contentNegotiator </code>行为，如下所示：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\ArrayHelper;

public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        'contentNegotiator' => [
            'formats' => [
                // ... other supported formats ...
            ],
        ],
    ]);
}
</pre>
<p>格式化应答数据，通常包含两个步骤：</p>
<ol>
<li>应答数据中的对象（包括嵌入对象）被&nbsp;&nbsp;yii\rest\Serializer&nbsp;转换为数组；</li>
<li>这个数组数据被&nbsp;response formatters&nbsp;转换为不同的格式（如JSON/XML）。</li>
</ol>
<p>步骤 2 是一个机械化数据转换过程，由内置应答格式化器来自动处理。步骤 1 需要多花些功夫如下所述：</p>
<p>当 serializer&nbsp;转换一个对象为一个数组时，它将调用该对象的&nbsp;<code>toArray()</code> &nbsp;方法，如果该对象实现了&nbsp;yii\base\Arrayable&nbsp;接口。如果该对象没有实现这个接口，将返回其公共属性。</p>
<p>对于扩展自&nbsp;&nbsp;yii\base\Model&nbsp;或 [[yii\db\ActiveRecord]] 的类，除了直接覆盖&nbsp;<code>toArray()</code>&nbsp;&nbsp;方法外，你还可以覆盖&nbsp;<code>fields()</code>&nbsp;方法和&nbsp;<code>extraFields()</code>&nbsp;方法来定制化返回数据。</p>
<p>[[yii\base\Model::fields()]] 方法声明了哪些字段 fields 要被包含进结果中。一个字段就是一个命名数据项。在结果数组中，数组的keys是字段名，而values是相应字段的值。[[yii\base\Model::fields()]] 的缺省实现返回模型所有属性；而 [[yii\db\ActiveRecord::fields()]] 缺省情况下返回那些已经被导入到该对象中的属性的名称。</p>
<p>你可以覆盖&nbsp;<code>fields()</code>&nbsp;方法来添加，删除，重命名或重定义字段。比如：</p>
<pre class="brush: php;toolbar: false">
// explicitly list every field, best used when you want to make sure the changes
// in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
public function fields()
{
    return [
        // field name is the same as the attribute name
        'id',
        // field name is "email", the corresponding attribute name is "email_address"
        'email' => 'email_address',
        // field name is "name", its value is defined by a PHP callback
        'name' => function () {
            return $this->first_name . ' ' . $this->last_name;
        },
    ];
}

// filter out some fields, best used when you want to inherit the parent implementation
// and blacklist some sensitive fields.
public function fields()
{
    $fields = parent::fields();

    // remove fields that contain sensitive information
    unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

    return $fields;
}
</pre>
<p><code>fields()</code>&nbsp;返回值应该是一个数组。数组keys是字段名，而数组values是相应的字段定义，这可以是属性名或者返回相应字段数值的匿名函数。</p>
<blockquote>
<p>提醒: 由于缺省情况下，一个模型的所有属性都将被包含在API结果中，你应该检查你的数据以免包含敏感数据。如果有敏感数据，你应该覆盖&nbsp;<code>fields()</code>&nbsp;或&nbsp;<code>toArray()</code>&nbsp;方法来把它们过滤掉。上述的例子中，我们选择把&nbsp;<code>auth_key</code>, <code>password_hash</code>&nbsp;和&nbsp;<code>password_reset_token</code>&nbsp;过滤掉。</p>
</blockquote>
<p>你可以使用&nbsp;<code>fields</code>&nbsp;查询参数来指定哪些&nbsp;&nbsp;<code>fields()</code>&nbsp;中的字段需要被包含在结果中。如果未指定，则返回所有字段。</p>
<p>yii\base\Model::extraFields()&nbsp;和&nbsp;yii\base\Model::fields()&nbsp;很相似。差异在于后者定义了默认返回的字段，而前者只有用户在 <code>expand</code>&nbsp;方法查询参数中指定的字段才会返回。</p>
<p>比如，<code>http://localhost/users?fields=id,email&amp;expand=profile</code>&nbsp;会返回类似下面的JSON数据：</p>
<pre class="brush: php;toolbar: false">
[
    {
        "id": 100,
        "email": "100@example.com",
        "profile": {
            "id": 100,
            "age": 30,
        }
    },
    ...
]
</pre>
<p>你可能想知道当动作返回对象或对象集合时，究竟谁执行了对象到数组的转换呢? 答案是 [[yii\rest\Controller::$serializer]] 的 [[afterAction()]] 方法。缺省情况下，[[yii\rest\Serializer]] 可以识别从&nbsp;yii\base\Model&nbsp;扩展的资源对象以及实现了接口 [[yii\data\DataProviderInterface]] 的集合（collection）对象，并对它们做序列化。这个序列化器（serializer）将调用这些对象的&nbsp;<code>toArray()</code> 方法并传递&nbsp;<code>fields</code> 和 <code>expand</code>&nbsp;用户参数给这个方法。如果有嵌入对象，它们将被递归转换为数组。</p>
<p>如果你所有的资源对象都是 [[yii\base\Model]] 类或其子类如 [[yii\db\ActiveRecord]]，而且你仅使用 [[yii\data\DataProviderInterface]] 作为资源集合，缺省格式化功能可以很好的工作。但是，如果你想引入一些不是从 [[yii\base\Model]] 派生的新的资源类，又或者你想使用一些新的集合类，你将需要定制化这个序列化类（serializer） 并配置 [[yii\rest\Controller::$serializer]] 来使用它。新的资源类可以使用特征 [[yii\base\ArrayableTrait]] 来支持可选字段输出。</p>
<h3>分页<a href="#pagination" name="pagination"></a></h3>
<p>对于资源集合的 API 终端，如果你使用&nbsp;<a href="guidelist?id=18">数据提供器</a>&nbsp;来处理应答数据，分页（Pagination）是一个既有（out-of-box）功能。甚至，通过查询参数&nbsp;<code>page</code> 和 <code>per-page</code>，一个API使用者可以指定数据页以及每页数据的数目。相应的应答将在HTTP头中包含这个分页信息（请参考本章第一个例子）：</p>
<ul>
<li><code>X-Pagination-Total-Count</code>: 数据项总数；</li>
<li><code>X-Pagination-Page-Count</code>: 页面总数；</li>
<li><code>X-Pagination-Current-Page</code>: 当前页面（基于1）；</li>
<li><code>X-Pagination-Per-Page</code>: 每页数据项数目；</li>
<li><code>Link</code>: 允许用户对资源数据进行页面遍历的一系列导航链接。</li>
</ul>
<p>HTTP应答的body部分将包含请求页的数据项列表。</p>
<p>有时候你可能想通过直接在body中包含分页信息来帮助简化客户端开发工作，那么你也可以配置 [[yii\rest\Serializer::$collectionEnvelope]] 属性如下：</p>
<pre class="brush: php;toolbar: false">
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}
</pre>
<p>然后，你请求 <code>http://localhost/users</code> 时返回数据会类似下面这样：</p>
<pre class="brush: php;toolbar: false">
HTTP/1.1 200 OK
Date: Sun, 02 Mar 2014 05:31:43 GMT
Server: Apache/2.2.26 (Unix) DAV/2 PHP/5.4.20 mod_ssl/2.2.26 OpenSSL/0.9.8y
X-Powered-By: PHP/5.4.20
X-Pagination-Total-Count: 1000
X-Pagination-Page-Count: 50
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 20
Link: &lt;http://localhost/users?page=1>; rel=self, 
      &lt;http://localhost/users?page=2>; rel=next, 
      &lt;http://localhost/users?page=50>; rel=last
Transfer-Encoding: chunked
Content-Type: application/json; charset=UTF-8

{
    "items": [
        {
            "id": 1,
            ...
        },
        {
            "id": 2,
            ...
        },
        ...
    ],
    "_links": {
        "self": "http://localhost/users?page=1", 
        "next": "http://localhost/users?page=2", 
        "last": "http://localhost/users?page=50"
    },
    "_meta": {
        "totalCount": 1000,
        "pageCount": 50,
        "currentPage": 1,
        "perPage": 20
    }
}
</pre>
<h3>HATEOAS 支持<a href="#hateoas-support" name="hateoas-support"></a></h3>
<p><a href="http://en.wikipedia.org/wiki/HATEOAS" target="_blank">HATEOAS</a>,&nbsp;（&ldquo;Hypermedia as the Engine of Application State&rdquo; 的缩写，意思是 &ldquo;超媒体即应用程序状态引擎&rdquo;），提倡 RESTful APIs 应该返回服务器资源支持哪些操作的信息。HATEOAS 的关键是返回一系列包含关联信息的超链接。</p>
<p>你可以让你的模型类实现 [[yii\web\Linkable]] 接口来支持 HATEOAS。实现了这个接口的类需要返回一个&nbsp;links&nbsp;列表。通常，你至少需要返回自身链接&nbsp;&nbsp;<code>self</code>，比如：</p>
<pre class="brush: php;toolbar: false">
use yii\db\ActiveRecord;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

class User extends ActiveRecord implements Linkable
{
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user', 'id' => $this->id], true),
        ];
    }
}
</pre>
<p>当返回一个&nbsp;<code>User</code>&nbsp;对象时，它将包含一个&nbsp;<code>_links</code>&nbsp;元素表示user资源相关的访问链接，比如：</p>
<pre class="brush: php;toolbar: false">
{
    "id": 100,
    "email": "user@example.com",
    ...,
    "_links" => [
        "self": "https://example.com/users/100"
    ]
}
</pre>
<p>&nbsp;</p>

<p>&nbsp;</p>
<h2>路由</h2>
<p>随着资源和控制器类准备，您可以使用URL如 <code>http://localhost/index.php?r=user/create</code>访问资源，类似于你可以用正常的Web应用程序做法。</p>
<p>在实践中，你通常要用美观的URL并采取有优势的HTTP动词。 例如，请求<code>POST /users</code>意味着访问<code>user/create</code>动作。 这可以很容易地通过配置<code>urlManager</code>应用程序组件来完成 如下所示：</p>
<pre class="brush: php;toolbar: false">
'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
    ],
]
</pre>
<p>相比于URL管理的Web应用程序，上述主要的新东西是通过RESTful API 请求[[yii\rest\UrlRule]]。这个特殊的URL规则类将会 建立一整套子URL规则来支持路由和URL创建的指定的控制器。 例如， 上面的代码中是大致按照下面的规则:</p>
<pre class="brush: php;toolbar: false">
[
    'PUT,PATCH users/&lt;id>' => 'user/update',
    'DELETE users/&lt;id>' => 'user/delete',
    'GET,HEAD users/&lt;id>' => 'user/view',
    'POST users' => 'user/create',
    'GET,HEAD users' => 'user/index',
    'users/&lt;id>' => 'user/options',
    'users' => 'user/options',
]
</pre>
<p>该规则支持下面的API末端:</p>
<ul class="task-list">
<li><code>GET /users</code>: 逐页列出所有用户；</li>
<li><code>HEAD /users</code>: 显示用户列表的概要信息；</li>
<li><code>POST /users</code>: 创建一个新用户；</li>
<li><code>GET /users/123</code>: 返回用户为123的详细信息;</li>
<li><code>HEAD /users/123</code>: 显示用户 123 的概述信息;</li>
<li><code>PATCH /users/123</code> and <code>PUT /users/123</code>: 更新用户123;</li>
<li><code>DELETE /users/123</code>: 删除用户123;</li>
<li><code>OPTIONS /users</code>: 显示关于末端 <code>/users</code> 支持的动词;</li>
<li><code>OPTIONS /users/123</code>: 显示有关末端 <code>/users/123</code> 支持的动词。</li>
</ul>
<p>您可以通过配置 <code>only</code> 和 <code>except</code> 选项来明确列出哪些行为支持， 哪些行为禁用。例如，</p>
<pre class="brush: php;toolbar: false">
[
    'class' => 'yii\rest\UrlRule',
    'controller' => 'user',
    'except' => ['delete', 'create', 'update'],
],
</pre>
<p>您也可以通过配置 <code>patterns</code> 或 <code>extraPatterns</code> 重新定义现有的模式或添加此规则支持的新模式。 例如，通过末端 <code>GET /users/search</code> 可以支持新行为 <code>search</code>， 按照如下配置 <code>extraPatterns</code> 选项，</p>
<pre class="brush: php;toolbar: false">
[
    'class' => 'yii\rest\UrlRule',
    'controller' => 'user',
    'extraPatterns' => [
        'GET search' => 'search',
],
</pre>
<p>您可能已经注意到控制器ID<code>user</code>以复数形式出现在<code>users</code>末端。 这是因为 [[yii\rest\UrlRule]] 能够为他们使用的末端全自动复数化控制器ID。 您可以通过设置 [[yii\rest\UrlRule::pluralize]] 为false 来禁用此行为，如果您想 使用一些特殊的名字您可以通过配置 [[yii\rest\UrlRule::controller]] 属性。</p>
<p>&nbsp;</p>
<h2>验证</h2>
<p>和Web应用程序不同，RESTful APIs 应该是无状态的（stateless），这意味着不能使用 sessions 或 cookies。因此，每个请求应该要携带某种认证证书来实现访问的安全性控制。一个通用的方法是在每个请求中发送一个秘密访问令牌（secret access token）来进行用户认证。由于一个访问令牌可以被用来唯一的识别和认证一个用户，<strong>API 请求应该总是通过 HTTPS 发送以防止 中间人（man-in-the-middle (MitM)）攻击。</strong></p>
<p>有一些不同的方法来发送访问令牌：</p>
<ul>
<li><a href="http://en.wikipedia.org/wiki/Basic_access_authentication" target="_blank">HTTP Basic Auth</a>: 访问令牌被当作用户名来发送。这个仅当访问令牌能安全保存在API消费者侧的情况下使用。比如，API 消费者（consumer）是一个服务器程序。</li>
<li>查询参数：访问令牌通过API URL中的一个查询参数来发送，比如 <code>https://example.com/users?access-token=xxxxxxxx</code>。由于大多数Web服务器将记录查询参数在服务器访问日志中，这个方法应该主要被用来服务于 <code>JSONP</code> 请求（不能使用 HTTP headers 来发送访问令牌access tokens）。</li>
<li><a href="http://oauth.net/2/" target="_blank">OAuth 2</a>: OAuth2协议，API 消费者通过一个认证服务器获取访问令牌并通过 <a href="http://tools.ietf.org/html/rfc6750" target="_blank">HTTP Bearer Tokens</a> 发送给API服务器。</li>
</ul>
<p>Yii 支持上述所有认证方式。你还可以很简单的创建新的认证方法。</p>
<p>启用API认证有两个步骤：</p>
<ol>
<li>通过配置REST控制器类的 <code>authenticator</code> 行为来指定认证方法。</li>
<li>在你的 用户识别类 中实现接口 <a href="http://www.yiiframework.com/doc-2.0/yii-web-identityinterface.html#findIdentityByAccessToken%28%29-detail">yii\web\IdentityInterface::findIdentityByAccessToken()</a>。</li>
</ol>
<p>例如，要使用 HTTP Basic Auth，你可以配置 <code>authenticator</code> 如下：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBasicAuth;

public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        'authenticator' => [
            'class' => HttpBasicAuth::className(),
        ],
    ]);
}
</pre>
<p>如果你想支持所有上述3种认证方法，你可以使用复合认证 <code>CompositeAuth</code> 如下：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        'authenticator' => [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ],
    ]);
}
</pre>
<p>每个 <code>authMethods</code> 元素都应该是一个 auth 方法的类名或者是一个配置数组。</p>
<p>实现 <code>findIdentityByAccessToken()</code> 方法是和具体应用程序相关的。比如，对于简单应用场景，每个用户只拥有一个访问令牌，你可以把访问令牌保存在user表的一个 <code>access_token</code> 列中。然后可以像下面这样方便的实现：</p>
<pre class="brush: php;toolbar: false">
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function findIdentityByAccessToken($token)
    {
        return static::findOne(['access_token' => $token]);
    }
}
</pre>
<p>如上在认证启用后，对于每个API请求，被请求的控制器会在它的 <code>beforeAction()</code> 方法中进行用户认证。</p>
<p>如果认证成功，控制器将执行其他检查（比如访问速率限制、鉴权）并执行受访动作。认证用户的标识信息可以通过 <code>Yii::$app-&gt;user-&gt;identity</code> 来获取。</p>
<p>如果认证失败，将返回HTTP状态码为401的应答，以及其它合适的头信息（比如对于HTTP Basic Auth 会返回一个 <code>WWW-Authenticate</code> 头）。</p>
<p>&nbsp;</p>
<h2>授权</h2>
<p>在用户认证通过后，你可能想检查他是否有足够的权限来访问请求资源的这个动作。这个过程被称为鉴权 <em>authorization</em> ，在 <a href="guidelist?id=5">授权</a> 章节有过详细描述。</p>
<p>你可以使用角色访问控制（Role-Based Access Control (RBAC)）组件来实现鉴权。</p>
<p>为了简化访问权限检查，你还可以覆盖 [[yii\rest\Controller::checkAccess()]] 方法然后在需要鉴权的地方调用它。缺省情况，[[yii\rest\ActiveController]] 的内置动作将在运行时调用这个方法：</p>
<pre class="brush: php;toolbar: false">
/**
 * Checks the privilege of the current user.
 *
 * This method should be overridden to check whether the current user has the privilege
 * to run the specified action against the specified data model.
 * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
 *
 * @param string $action the ID of the action to be executed
 * @param \yii\base\Model $model the model to be accessed. If null, it means no specific model is being accessed.
 * @param array $params additional parameters
 * @throws ForbiddenHttpException if the user does not have access
 */
public function checkAccess($action, $model = null, $params = [])
{
}
</pre>
<p>&nbsp;</p>


<p>&nbsp;</p>
<p>&nbsp;</p>
<h2>缓存</h2>
<p>TBD</p>
<p>&nbsp;</p>
<h2>API 文档</h2>
<p>TBD</p>
<p>&nbsp;</p>
<h2>测试</h2>
<p>TBD</p>