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