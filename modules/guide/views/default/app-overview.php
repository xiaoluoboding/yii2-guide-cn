<h1>应用结构概述</h1>
<p>Yii 应用遵循 模型-视图-控制器（model-view-controller (MVC)）设计模式。</p>
<p>在 MVC 中，<a href="0307.html">Models</a>代表数据、业务逻辑，以及数据校验规则。<a href="0306.html">Views</a>包含用户界面元素，如文本、图片和表单。<a href="0305.html">Controllers</a>用来管理模型和视图之间的通信，处理动作和请求。</p>
<p>除了 MVC，Yii 还包含以下应用结构：</p>
<ul>
	<li><a href="0302.html">入口脚本：</a>由终端用户直接访问的PHP脚本，负责开始一个请求处理周期。</li>
	<li><a href="0303.html">应用：</a>全局管理应用程序组件，协调访问请求的对象。</li>
	<li><a href="0304.html">应用组件：</a>应用程序注册对象和提供各种服务。</li>
	<li><a href="0310.html">模块：</a>独立的软件单元，包含全部 MVC 组件，应用程序可以创建多个模块。</li>
	<li><a href="0308.html">过滤器：</a>控制器实际处理每个请求之前或之后要被调用的动作。</li>
	<li><a href="0309.html">小部件：</a>嵌入在<a href="0306.html"> 视图 </a>中的对象，包含控制器业务逻辑，并且可以在不同的视图中复用。</li>
</ul>
<p>以下图表展示了一个应用的静态结构：</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/application-structure.png" alt="应用结构" /></p>