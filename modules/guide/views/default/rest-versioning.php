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