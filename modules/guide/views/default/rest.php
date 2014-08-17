<h1>RESTful Web 服务</h1>
<p>Yii 提供了一整套用来简化实现RESTful风格的Web Service服务的API。 特别是，Yii支持以下关于RESTful风格的API：</p>
<ul class="task-list">
<li>支持 <a href="guidelist?id=2">Active Record</a> 类的通用API的快速原型;</li>
<li>涉及的响应格式（在默认情况下支持JSON 和 XML）;</li>
<li>支持可选输出字段的 可定制对象序列化；</li>
<li>适当的格式的数据采集和验证错误;</li>
<li>支持 <a href="http://en.wikipedia.org/wiki/HATEOAS" target="_blank">HATEOAS</a>;</li>
<li>有适当HTTP动词检查的高效的路由;</li>
<li>内置<code>OPTIONS</code>和<code>HEAD</code>动词的支持;</li>
<li>认证和授权;</li>
<li>数据缓存和HTTP缓存;</li>
<li>速率限制;</li>
</ul>
<p>&nbsp;</p>
<h2>一个简单的例子</h2>
<p>我们用一个例子来说明如何用最少的编码来建立一套RESTful风格的API。假设你想通过RESTful风格的API来展示用户数据。用户数据被存储在用户DB表， 你已经创建了 [[yii\db\ActiveRecord|ActiveRecord]] 类<code> app\models\User </code>来访问该用户数据.</p>
<p>首先，创建一个控制器类 <code>app\controllers\UserController</code> 如下：</p>
<pre class="brush: php;toolbar: false">
namespace app\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
}
</pre>
<p>然后，修改应用的配置文件config中的 <code>urlManager</code> 配置项：</p>
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
<p>你已经完成RESTful接口的创建任务了，就这么简单 ! 下面是默认创建的接口列表：</p>
<ul>
<li><code>GET /users</code>: 按页列举所有用户；</li>
<li><code>HEAD /users</code>: 显示用户列表的总览信息；</li>
<li><code>POST /users</code>: 创建一个新用户；</li>
<li><code>GET /users/123</code>: 返回用户标识为123的用户数据；</li>
<li><code>HEAD /users/123</code>: 显示用户123的总览信息；</li>
<li><code>PATCH /users/123</code> 和 <code>PUT /users/123</code>: 更新用户123；</li>
<li><code>DELETE /users/123</code>: 删除用户123；</li>
<li><code>OPTIONS /users</code>: 显示终端 <code>/users</code> 所支持的动作（Verbs）；</li>
<li><code>OPTIONS /users/123</code>: 显示终端 <code>/users/123</code> 所支持的动作；</li>
</ul>
<p>你可以使用如下 <code>curl</code> 命令来访问服务接口：</p>
<pre class="brush: php;toolbar: false">
curl -i -H "Accept:application/json" "http://localhost/users"
</pre>
<p>将返回类似如下数据：</p>
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

[
    {
        "id": 1,
        ...
    },
    {
        "id": 2,
        ...
    },
    ...
]
</pre>
<p>修改可接受内容类型为<code> application/xml </code>，可以返回XML格式的数据：</p>
<pre class="brush: php;toolbar: false">
curl -i -H "Accept:application/xml" "http://localhost/users"
</pre>
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
Content-Type: application/xml

&lt;?xml version="1.0" encoding="UTF-8"?>
&lt;response>
    &lt;item>
        &lt;id>1&lt;/id>
        ...
    &lt;/item>
    &lt;item>
        &lt;id>2&lt;/id>
        ...
    &lt;/item>
    ...
&lt;/response>
</pre>
<blockquote>
<p>提示: 你当然还可以直接通过浏览器访问这些接口，比如 <code>http://localhost/users</code>.</p>
</blockquote>
<p>如你所见，应答头部信息包含记录总数和页数，等等。还包括了其他页面的链接。比如，Link <code>http://localhost/users?page=2</code> 指向了下一页用户数据。</p>
<p>通过使用 <code>fields</code> 和 <code>expand</code> 参数，你也可以请求返回数据子集。URL <code>http://localhost/users?fields=id,email</code> 将只返回 <code>id</code> 和 <code>email</code> 字段数据。</p>
<blockquote>
<p>信息: 你可能还注意到 <code>http://localhost/users</code> 的返回数据包含了一些敏感数据如 <code>password_hash</code>, <code>auth_key</code>。你当然不想把这些信息通过公共服务接口暴露出去，你可以且应该把这些字段过滤掉，接下来的章节将对此进行详细说明。</p>
</blockquote>
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
<h2>创建控制器和动作</h2>
<p>现在你有了资源数据并指定了数据格式化的方式，下一步就是如何创建控制器动作来把资源数据暴露给终端用户。</p>
<p>Yii 提供两个基础控制器类来简化RESTful动作的创建：[[yii\rest\Controller]] 和 [[yii\rest\ActiveController]]。两者之间的区别在于后者提供了一系列处理ActiveRecord资源的缺省动作。所以如果你使用了ActiveRecord 而且内置的动作也能满足你的需求，你可以从后者派生控制器类。否则，从 [[yii\rest\Controller]] 扩展将便于你自行创建动作。</p>
<p>[[yii\rest\Controller]] 和 [[yii\rest\ActiveController]] 提供下述功能，这些功能将在后续章节中进行详细描述：</p>
<ul>
<li>应答格式协商；</li>
<li>API 版本协商；</li>
<li>HTTP 方法检验；</li>
<li>用户认证；</li>
<li>速率控制；</li>
</ul>
<p>[[yii\rest\ActiveController]] 还额外提供了和ActiveRecord相关的下述功能： </p>
<ul>
<li>一系列通用动作： <code>index</code>, <code>view</code>, <code>create</code>, <code>update</code>, <code>delete</code>, <code>options</code> ；</li>
<li>根据请求动作和资源进行用户鉴权。</li>
</ul>
<p>当创建一个新控制器类时，控制器类的命名约定是使用资源名称并使用单数形式。比如，为了提供user信息，控制器可以被命名为 <code>UserController</code>。</p>
<p>创建新的动作和Web应用中一样。唯一的不同是在Web应用中通常是调用 <code>render()</code> 方法来绘制视图，而 RESTful actions 直接返回数据。serializer 和 response object 将自动处理格式转换。比如：</p>
<pre class="brush: php;toolbar: false">
public function actionSearch($keyword)
{
    $result = SolrService::search($keyword);
    return $result;
}
</pre>
<p>如果你的控制器类是从 [[yii\rest\ActiveController]] 扩展的，你应该设置它的 $modelClass 属性为资源类的名字。这个类必须实现 [[yii\db\ActiveRecordInterface]] 接口。</p>
<p>使用 [[yii\rest\ActiveController]], 你可能想禁用某些内置动作或者定制化它们。那你可以覆盖 <code>actions()</code> 方法如下：</p>
<pre class="brush: php;toolbar: false">
public function actions()
{
    $actions = parent::actions();

    // disable the "delete" and "create" actions
    unset($actions['delete'], $actions['create']);

    // customize the data provider preparation with the "prepareDataProvider()" method
    $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

    return $actions;
}

public function prepareDataProvider()
{
    // prepare and return a data provider for the "index" action
}
</pre>
<p>下面列出了 [[yii\rest\ActiveController]] 所支持的内置动作：</p>
<ul>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-rest-indexaction.html">index</a>: 按页列出资源；</li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-rest-viewaction.html">view</a>: 返回指定资源的详细信息；</li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-rest-createaction.html">create</a>: 创建一个资源；</li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-rest-updateaction.html">update</a>: 更新一个已有资源；</li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-rest-deleteaction.html">delete</a>: 删除指定资源；</li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-rest-optionsaction.html">options</a>: 返回支持的HTTP方法。</li>
</ul>
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
<h2>速率限制</h2>
<p>为防止滥用，你应该考虑增加速率限制到您的API。 例如，您可以限制每个用户的API的使用是在10分钟内最多100次的API调用。 如果一个用户同一个时间段内太多的请求被接收， 将返回响应状态代码 429 (这意味着过多的请求)。</p>
<p>要启用速率限制, [[yii\web\User::identityClass|user identity class]] 应该实现 [[yii\filters\RateLimitInterface]]. 这个接口需要实现以下三个方法：</p>
<ul class="task-list">
<li><code>getRateLimit()</code>: 返回允许的请求的最大数目及时间，例如，<code>[100, 600]</code> 表示在600秒内最多100次的API调用。</li>
<li><code>loadAllowance()</code>: 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。</li>
<li><code>saveAllowance()</code>: 保存允许剩余的请求数和当前的UNIX时间戳。</li>
</ul>
<p>你可以在user表中使用两列来记录容差和时间戳信息。 <code>loadAllowance()</code> 和 <code>saveAllowance()</code> 可以通过实现对符合当前身份验证的用户 的这两列值的读和保存。为了提高性能，你也可以 考虑使用缓存或NoSQL存储这些信息。</p>
<p>一旦 identity 实现所需的接口， Yii 会自动使用 [[yii\filters\RateLimiter]] 为 [[yii\rest\Controller]] 配置一个行为过滤器来执行速率限制检查。 如果速度超出限制 该速率限制器将抛出一个 [[yii\web\TooManyRequestsHttpException]]。 你可以在你的 REST 控制器类里配置速率限制，</p>
<pre class="brush: php;toolbar: false">
public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
    return $behaviors;
}
</pre>
<p>当速率限制被激活，默认情况下每个响应将包含以下HTTP头发送 目前的速率限制信息：</p>
<ul class="task-list">
<li><code>X-Rate-Limit-Limit</code>: 同一个时间段所允许的请求的最大数目;</li>
<li><code>X-Rate-Limit-Remaining</code>: 在当前时间段内剩余的请求的数量;</li>
<li><code>X-Rate-Limit-Reset</code>: 为了得到最大请求数所等待的秒数。</li>
</ul>
<p>你可以禁用这些头信息通过配置 [[yii\filters\RateLimiter::enableRateLimitHeaders]] 为false, 就像在上面的代码示例所示。</p>
<p>&nbsp;</p>
<h2>错误处理</h2>
<p>处理一个 RESTful API 请求时， 如果有一个用户请求错误或服务器发生意外时， 你可以简单地抛出一个异常来通知用户出错了。 如果你能找出错误的原因 (例如，所请求的资源不存在)，你应该 考虑抛出一个适当的HTTP状态代码的异常 (例如， [[yii\web\NotFoundHttpException]] 意味着一个404 HTTP状态代码)。 Yii 将通过HTTP状态码和文本 发送相应的响应。 它还将包括在响应主体异常的 序列化表示形式。 例如，</p>
<pre class="brush: php;toolbar: false">
HTTP/1.1 404 Not Found
Date: Sun, 02 Mar 2014 05:31:43 GMT
Server: Apache/2.2.26 (Unix) DAV/2 PHP/5.4.20 mod_ssl/2.2.26 OpenSSL/0.9.8y
Transfer-Encoding: chunked
Content-Type: application/json; charset=UTF-8

{
    "type": "yii\\web\\NotFoundHttpException",
    "name": "Not Found Exception",
    "message": "The requested resource was not found.",
    "code": 0,
    "status": 404
}
</pre>
<p>下面的列表总结了Yii的REST框架的HTTP状态代码:</p>
<ul class="task-list">
<li><code>200</code>: OK。一切正常。</li>
<li><code>201</code>: 响应 <code>POST</code> 请求时成功创建一个资源。<code>Location</code> header 包含的URL指向新创建的资源。</li>
<li><code>204</code>: 该请求被成功处理，响应不包含正文内容 (类似 <code>DELETE</code> 请求)。</li>
<li><code>304</code>: 资源没有被修改。可以使用缓存的版本。</li>
<li><code>400</code>: 错误的请求。可能通过用户方面的多种原因引起的，例如在请求体内有无效的JSON 数据，无效的操作参数，等等。</li>
<li><code>401</code>: 验证失败。</li>
<li><code>403</code>: 已经经过身份验证的用户不允许访问指定的 API 末端。</li>
<li><code>404</code>: 所请求的资源不存在。</li>
<li><code>405</code>: 不被允许的方法。 请检查 <code>Allow</code> header 允许的HTTP方法。</li>
<li><code>415</code>: 不支持的媒体类型。 所请求的内容类型或版本号是无效的。</li>
<li><code>422</code>: 数据验证失败 (例如，响应一个 <code>POST</code> 请求)。 请检查响应体内详细的错误消息。</li>
<li><code>429</code>: 请求过多。 由于限速请求被拒绝。</li>
<li><code>500</code>: 内部服务器错误。 这可能是由于内部程序错误引起的。</li>
</ul>
<p>&nbsp;</p>
<h2>API 版本控制</h2>
<p>你的APIs应该版本化。和Web应用不同（你可以同时控制客户端和服务端代码），对于APIs你通常不能控制客户端行为。因此后向兼容性 （backward compatibility (BC) ）应该尽可能的被实现。并且如果一些破坏兼容性（BC-breaking）的变化必须引入到APIs中，你应该升级版本号。你可以参考语义版本控制（<a href="http://semver.org/" target="_blank">Symantic Versioning</a>）以了解更多关于如何设置API版本号的更多信息。</p>
<p>一个通常的做法是把版本号嵌入在API URLs中。比如&nbsp;<code>http://example.com/v1/users</code>&nbsp;表示&nbsp;<code>/users</code>&nbsp;服务接口版本1。另外一个最近发展迅猛的API版本控制方法是把版本号放在HTTP请求头中，通常通过&nbsp;<code>Accept</code>&nbsp;头，如下所示：</p>
<pre class="brush: php;toolbar: false">
// via a parameter
Accept: application/json; version=v1
// via a vendor content type
Accept: application/vnd.company.myapp-v1+json
</pre>
<p>两种方法各有优缺点，并引起很多争论。下面我们描述一个API版本控制的实用策略，某种程度上是两种方法的一个综合：</p>
<ul>
<li>把每一个 API 大版本通过不同的模块（module）来实现，模块ID就是大版本号（比如：&nbsp;<code>v1</code>, <code>v2</code>）。自然，API URLs将包含这些大版本号。</li>
<li>在每个主版本（major verion）中（即每个相应模块中），使用&nbsp;<code>Accept</code> HTTP 请求头来判定小版本（minor version）号并编写针对各小版本的条件语句。（译注：请注意这里大版本、小版本的区别）</li>
</ul>
<p>对于每个模块（版本），应该包含服务于该特定版本的资源类和控制器类。为了更好的分离代码职责以及复用，你可以维护一个基础资源和控制器类集合，然后针对不同的版本子类化这些基类。通过这些子类来实现具体的代码比如&nbsp;<code>Model::fields()</code>。</p>
<p>代码结构类似如下：</p>
<pre class="brush: php;toolbar: false">
api/
    common/
        controllers/
            UserController.php
            PostController.php
        models/
            User.php
            Post.php
    modules/
        v1/
            controllers/
                UserController.php
                PostController.php
            models/
                User.php
                Post.php
        v2/
            controllers/
                UserController.php
                PostController.php
            models/
                User.php
                Post.php
</pre>
<p>应用程序配置类似如下：</p>
<pre class="brush: php;toolbar: false">
return [
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/user', 'v1/post']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v2/user', 'v2/post']],
            ],
        ],
    ],
];
</pre>
<p>这样，<code>http://example.com/v1/users</code> 将返回版本1的用户列表，而 <code>http://example.com/v2/users</code> 返回版本2的数据。</p>
<p>使用模块，不同大版本的代码可以被很好的隔离，便于简化代码维护和管理。而且仍然可以通过公共部分来在子类间复用代码。</p>
<p>为了处理小版本号，你可以利用 <a href="http://www.yiiframework.com/doc-2.0/yii-filters-contentnegotiator.html">contentNegotiator</a> 行为提供的内容协商特性，这个 <code>contentNegotiator</code> 行为将在判定支持的内容类型时设置 [[yii\web\Response::$acceptParams]] 属性。</p>
<p>例如，如果一个请求的HTTP header 为 <code>Accept: application/json; version=v1</code>，经过内容协商，[[yii\web\Response::$acceptParams]] 将包含：<code>['version' =&gt; 'v1']</code>。</p>
<p>基于 <code>acceptParams</code> 中的版本信息，你可以在动作、资源类以及序列化器中编写相应的条件语句。</p>
<p>小版本需要维护后向兼容性。小版本应该主要是错误修复和特性增强（比如优化性能），尽量不要出现服务接口协议上的变动，这样代码中不会出现过多的版本检查。否则你可能需要创建一个大版本来进行开发。</p>
<p>&nbsp;</p>
<h2>缓存</h2>
<p>TBD</p>
<p>&nbsp;</p>
<h2>API 文档</h2>
<p>TBD</p>
<p>&nbsp;</p>
<h2>测试</h2>
<p>TBD</p>