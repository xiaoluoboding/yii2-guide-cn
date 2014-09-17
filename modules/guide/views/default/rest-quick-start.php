<h1>快速入门</h1>
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
<p>&nbsp;</p><h2>创建一个控制器</h2>
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
<p>&nbsp;</p><h2>配置 URL 规则</h2>
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
<p>上面的配置主要是为<code>user</code>控制器增加一个URL规则。这样， 用户的数据就能通过美化的URL和有意义的http动词进行访问和操作。</p>
<p>&nbsp;</p><h2>尝试一下</h2>
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
<p>&nbsp;</p><h2>总结</h2>
<p>使用Yii框架的RESTful风格的API， 在控制器的操作中实现API末端， 使用控制器来组织末端接口为一个单一的资源类型。</p>
<p>从 [[yii\base\Model]] 类扩展的资源被表示为数据模型。 如果你在使用（关系或非关系）数据库，推荐您使用 [[yii\db\ActiveRecord|ActiveRecord]] 来表示资源。</p>
<p>你可以使用 [[yii\rest\UrlRule]] 简化路由到你的API末端。</p>
<p>虽然不是必须的，为了方便维护您的WEB前端和后端， 建议您开发接口作为一个单独的应用程序。</p>