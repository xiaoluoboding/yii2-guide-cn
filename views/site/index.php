<?php
$this->title = 'Yii框架2.0中文开发文档';
?>
<h1>
	Yii 2.0权威指南 <a href="#the-definitive-guide-to-yii-20" name="the-definitive-guide-to-yii-20">¶</a>
</h1>
本指南发布遵循
<a href="http://www.yiiframework.com/doc/terms/">Yii 文档使用许可</a>
<br />
<br />
All Rights Reserved.
<br />
<br />
2014 (c) Yii Software LLC.
<br />
<br />
<h2>介绍<a href="#introduction" name="introduction"> ¶</a></h2>
<ul>
	<li><a href="guidelist?id=50">综述</a> - Yii及其特点</li>
	<li><a href="guidelist?id=46">从Yii1.x版本升级到Yii2.0</a></li>
</ul>
<br />
<h2>安装<a href="#install" name="install"> ¶</a></h2>
<ul>
	<li><a href="">安装</a>- 下载Yii以及WEB服务器配置</li>
	<li><a href="">基础应用模板</a>- 这是一个简单的前端应用实例</li>
	<li><a href="">高级应用模板</a>- 高级应用实例，包含了前后端页面以及数据库访问</li>
	<li><a href="">创建你自己的应用程序结构</a>- 学习如何从零开始</li>
</ul>
<br />
<h2>基本概念<a href="#base-concepts" name="base-concepts"> ¶</a></h2>
<ul>
	<li><a href="guidelist?id=7">基本概念</a> - Object 和 Component 类, 路径同名Path aliases 和 自动加载autoloading</li>
	<li><a href="">配置</a> - Yii应用程序配置</li>
	<li><a href="">MVC</a> - Yii MVC的实现以及一个典型的MVC应用程序流程</li>
	<li><a href="guidelist?id=35">模型Model</a> - Yii模型提供属性Attributes，场景Scenarios 以及 数据验证Validation</li>
	<li><a href="">视图View</a> - 使用布局绘制视图，使用页面组件Widgets和资源管理asset management</li>
	<li><a href="">控制器Controller</a> - 控制器动作actions, 路由routing 以及 动作过滤器action filters</li>
	<li><a href="">事件处理Event Handling</a> - Yii事件处理机制</li>
	<li><a href="">行为Behaviors</a></li>
</ul>
<br />
<h2>数据库 <a href="#database" name="database">¶</a></h2>
<ul>
	<li><a href="">基础知识</a> - 连接数据库，基础查询，事务和 schema 操作</li>
	<li><a href="">构建查询</a> - 使用一个简单的抽象层来查询数据库</li>
	<li><a href="">ActiveRecord</a> - Yii对active record ORM的实现，获取和操做记录并定义数据关联</li>
	<li><a href="">数据库迁移Database Migration</a> - 使用数据库迁移对对数据库进行版本管理</li>
</ul>
<br />
<h2>开发者工具箱 <a href="#developers-toolbox" name="developers-toolbox">¶</a></h2>
<ul>
	<li><a href="guide">帮助类Helper Classes</a></li>
	<li><a href="guide">自动代码生成Automatic Code Generation</a></li>
	<li><a href="guide">调试工具栏以及调试器Debug toolbar and debugger</a></li>
	<li><a href="guide">错误处理Error Handling</a></li>
	<li><a href="guide">日志Logging</a></li>
</ul>
<br />
<h2>扩展和第三方库 <a href="#extensions-and-3rd-party-libraries" name="extensions-and-3rd-party-libraries">¶</a></h2>
<ul>
	<li><a href="guide">Composer</a> - Composer是PHP的应用程序依赖管理工具</li>
	<li><a href="guide">扩展Yii</a></li>
	<li><a href="guide">模板引擎</a> - 使用Smarty或者Twig模板引擎</li>
	<li><a href="guide">集成Yii和第三方系统</a> - 在第三方系统中使用Yii 以及同时使用Yii 1 和 2</li>
</ul>
<br />
<h2>安全和访问控制 <a href="#security-and-access-control" name="security-and-access-control">¶</a></h2>
<ul>
	<li><a href="guide">认证Authentication</a> - 识别用户</li>
	<li><a href="guide">鉴权Authorization</a> - 访问控制和RBAC（角色访问控制）</li>
	<li><a href="guide>安全Security</a> - 哈希和验证密码，加密</li>
	<li><a href="guide>视图安全Views security</a> - 如何防止跨站脚本攻击XSS</li>
</ul>
<br />
<h2>数据供应器, 列表 和 表格 <a href="#data-providers-lists-and-grids" name="data-providers-lists-and-grids">¶</a></h2>
<ul>
	<li><a href="guide">综述</a></li>
	<li><a href="guide">数据供应器Data providers</a></li>
	<li><a href="guide">数据组件Data widgets</a></li>
	<li><a href="">表格Grid</a></li>
</ul>
<br />
<h2>高级专题 <a href="#advanced-topics" name="advanced-topics">¶</a></h2>
<ul>
	<li><a href="">资源管理</a></li>
	<li><a href="">表单</a></li>
	<li><a href="">实现RESTful Web服务API</a></li>
	<li><a href="">Bootstrap组件</a> - 使用 <a href="http://getbootstrap.com/">twitter bootstrap</a></li>
	<li><a href="">界面主题Theming</a></li>
	<li><a href="">缓存</a> - 缓存数据，页面片段和HTTP 请求</li>
	<li><a href="">国际化</a> - 消息翻译和格式化</li>
	<li><a href="">URL管理</a> - 路由，定制化urls 和 SEO</li>
	<li><a href="">命令行应用</a></li>
	<li><a href="">性能调优</a></li>
	<li><a href="">测试</a></li>
	<li><a href="">管理测试装置Fixtures</a></li>
	<li><a href="">服务定位器和依赖注入</a></li>
</ul>
<br />
<h2>参考资料 <a href="#references" name="references">¶</a></h2>
<ul>
	<li><a href="">模型验证参考文档</a></li>
	<li><a href="https://getcomposer.org/doc/" target="_blank">Composer官方文档</a></li>
</ul>
