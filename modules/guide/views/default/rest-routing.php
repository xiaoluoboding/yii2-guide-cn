<h1>路由</h1>
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