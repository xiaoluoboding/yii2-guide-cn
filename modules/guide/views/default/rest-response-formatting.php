<h1>格式化应答数据</h1>
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
<h2>分页<a href="#pagination" name="pagination"></a></h2>
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
<h2>HATEOAS 支持<a href="#hateoas-support" name="hateoas-support"></a></h2>
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