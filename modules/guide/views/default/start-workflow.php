<h1>运行应用</h1>
<p>安装 Yii 后，就有了一个可运行的应用，根据配置不同，可以通过 <code>http://hostname/basic/web/index.php</code>或<code>http://hostname/index.php</code>访问。本章节将介绍应用的内建功能，如何组织代码，以及一般情况下应用如何处理请求。</p>
<blockquote>
	<p>补充：为简单起见，在整个“入门”板块都假定你已经把 <code> basic/web </code>设为 Web 服务器根目录并配置完毕，你访问应用的地址会是<code>http://lostname/index.php</code>或类似的。请按需调整 URL。</p>
</blockquote>
<p>&nbsp;</p><h2>功能</h2><hr />
<p>一个安装完的基本应用包含四页：</p>
<ul>
	<li>"Home" 页，当你访问<code>http://hostname/index.php</code>时显示，</li>
	<li>"About" 页，</li>
	<li>"Contact" 页，显示一个联系表单，允许终端用户通过Email联系你，</li>
	<li>"Login" 页，显示一个登录表单，用来验证终端用户。试着用 “admin/admin” 登录，你可以看到当前是登录状态，已经可以“退出登录”了。</li>
</ul>
<p>这些页面使用同一个头部和尾部。头部包含了一个可以在不同页面间切换的导航栏。</p>
<p>在浏览器底部可以看到一个工具栏。这是 Yii 提供的很有用的<a href="1201.html">调试工具</a>，可以记录并显示大量的调试信息，例如日志信息，响应状态，数据库查询等等。</p>
<p>&nbsp;</p><h2>应用结构</h2><hr />
<p>应用中最重要的目录和文件（假设应用根目录是 <code>basic</code>）：</p>
<pre>
basic/                  应用根目录
    composer.json       Composer 配置文件, 描述包信息
    config/             包含应用配置及其它配置
        console.php     控制台应用配置信息
        web.php         Web 应用配置信息
    commands/           包含控制台命令类
    controllers/        包含控制器类
    models/             包含模型类
    runtime/            包含 Yii 在运行时生成的文件，例如日志和缓存文件
    vendor/             包含已经安装的 Composer 包，包括 Yii 框架自身
    views/              包含视图文件
    web/                Web 应用根目录，包含 Web 入口文件
        assets/         包含 Yii 发布的资源文件（javascript 和 css）
        index.php       应用入口文件
    yii                 Yii 控制台命令执行脚本
</pre>
<p>一般来说，应用中的文件可被分为两类：在 <code>basic/web</code> 下的和在其它目录下的。前者可以直接通过 HTTP 访问（例如浏览器），后者不能也不应该被直接访问。</p>
<p>Yii 实现了<a href="2009.html">模型-视图-控制器</a> (<code>MVC</code>)设计模式，这点在上述目录结构中也得以体现。 <code>models</code> 目录包含了所有<a href="0307.html">模型类</a>，<code>views</code> 目录包含了所有<a href="0306.html">视图脚本</a>，<code>controllers</code> 目录包含了所有<a href="0305.html">控制器类</a>。</p>
<p>以下图表展示了一个应用的静态结构：</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/application-structure.png" alt="应用结构" /></p>
<p>每个应用都有一个入口脚本 <code>web/index.php</code>，这是整个应用中唯一可以访问的 PHP 脚本。入口脚本接受一个 Web 请求并创建<a href="0303.html">应用</a>实例去处理它。 应用在它的<a href="0304.html">组建</a>辅助下解析请求，并分派请求至 MVC 元素。<a href="0306.html">视图</a>使用<a href="#">小部件</a>去创建复杂和动态的用户界面。</p>
<p>&nbsp;</p><h2>请求生命周期</h2><hr />
<p>以下图表展示了一个应用如何处理请求：</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/application-lifecycle.png" alt="请求生命周期"  width="800" height="600" /></p>
<ul>
	<li>1. 用户向<a href="0302.html">入口脚本</a> <code>web/index.php</code> 发起请求。</li>
	<li>2. 入口脚本加载应用<a href="0505.html">配置</a>并创建一个<a href="0303.html">应用</a>实例去处理请求。</li>
	<li>3. 应用通过请求组件解析请求的<a href="#">路由</a>。</li>
	<li>4. 应用创建一个<a href="0305.html">控制器</a>实例去处理请求。</li>
	<li>5. 控制器创建一个操作实例并针对操作执行过滤器。</li>
	<li>6. 如果任何一个过滤器返回失败，则操作退出。</li>
	<li>7. 如果所有过滤器都通过，操作将被执行。</li>
	<li>8. 操作会加载一个数据模型，或许是来自数据库。</li>
	<li>9. 操作会渲染一个视图，把数据模型提供给它。</li>
	<li>10. 渲染结果返回给响应组件。</li>
	<li>11. 响应组件发送渲染结果给用户浏览器。</li>
</ul>


