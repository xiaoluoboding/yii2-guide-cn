<h1>MVC 概述</h1>
<p>Yii 实现了 模型-视图-控制器（model-view-controller (MVC)）设计模式。MVC 用于分离业务逻辑和用户界面。这样开发人员可以简单的修改其中之一，而不会影响到另外的部分。</p>
<p>在 MVC 中，<em>model</em>&nbsp;代表数据以及数据校验规则。<em>view</em>&nbsp;包含用户界面元素，如文本、图片和表单。<em>controller</em>&nbsp;用来管理模型和视图之间的通信，处理动作和请求。</p>
<p>除了实现 MVC 设计模式，Yii 还引入一个前台控制器（<em>front-controller</em>），称之为应用程序（<em>application</em>）。这个前台控制器封装了一个请求处理的执行上下文。这意味着这个前台控制器首先收集用户请求信息，然后分发给合适的控制器来处理这个请求。换句话说，这个前台控制器是主应用程序管理器，处理所有的请求并委托给相应的动作。</p>
<p>下图显示了 Yii 应用程序的静态结构：</p>
<p>&nbsp;</p>
<p><img src="http://www.yiiframework.com/doc-2.0/images/structure.png" alt="Static structure of Yii application" /></p>
<p>&nbsp;</p>
<h1>典型的工作流</h1>
<p>下图展示了Yii应用处理用户请求的典型的请求生命周期：</p>
<p><img src="http://www.yiiframework.com/doc-2.0/images/flow.png" alt="Typical workflow of a Yii application" /></p>
<ol class="task-list">
<li>用户发出了访问 URL <code>http://www.example.com/index.php?r=post/show&amp;id=1</code> 的请求， Web 服务器通过执行入口脚本 <code>index.php</code> 处理此请求。</li>
<li>入口脚本创建了一个应用实例并执行。</li>
<li>应用从一个叫做 <code>request</code> 的 <a href="guidelist?id=52">应用组件</a> 中获得了用户请求的详细信息。</li>
<li>应用在一个名叫 <code>urlManager</code> 的应用组件的帮助下，决定请求的<a href="guidelist?id=14">控制器</a>和动作 。在这个例子中，控制器是 <code>post</code>，它代表 <code>PostController</code> 类； 动作是 <code>show</code> ，其实际含义由控制器决定。</li>
<li>应用创建了一个所请求控制器的实例以进一步处理用户请求。控制器决定了动作 <code>show</code> 指向控制器类中的一个名为 <code>actionShow</code> 的方法。然后它创建并持行了与动作关联的过滤器（例如访问控制，基准测试）。 如果过滤器允许，动作将被执行。</li>
<li>动作从数据库中读取一个 ID 为 <code>1</code> 的 <code>Post</code> <a href="guidelist?id=35">模型</a>。</li>
<li>动作通过 <code>Post</code> 模型渲染一个名为 <code>show</code> 的 <a href="guidelist?id=49">视图</a>。</li>
<li>视图读取并显示 <code>Post</code> 模型的属性。</li>
<li>视图执行一些小部件</a>。</li>
<li>视图的渲染结果被插入一个布局。</li>
<li>动作完成视图渲染并将其呈现给用户。</li>
</ol>