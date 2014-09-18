<?php
$this->title = 'Yii框架2.0中文开发文档';
require "title.php";
?>
<p>&nbsp;</p>
<h2>介绍</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0101.html">概述</a> - Yii及其特点</li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0102.html">从Yii 1.1.x 版本升级到 Yii 2.0 </a></li>
</ul>
<p>&nbsp;</p>
<h2>入门</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0201.html">安装 Yii</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0202.html">运行应用</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0203.html">说声 Hello</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0204.html">使用表单</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0205.html">使用数据库</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0206.html">用 Gii 生成代码</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0207.html">进阶资料</a></li>
</ul>
<p>&nbsp;</p>
<h2>应用结构</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0301.html">结构概述</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0302.html">入口脚本</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0303.html">应用（Applications）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0304.html">应用组件</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0305.html">控制器（Controllers）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0306.html">视图（Views）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0307.html">模型（Models）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0308.html">模块（Modules）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0309.html">过滤器（Filters）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0310.html">小部件（Widgets）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0311.html">资源管理（Assets）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0312.html">扩展（Extensions）</a></li>
</ul>
<p>&nbsp;</p>
<h2>请求处理</h2>
<ul>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0401.html"></a>Bootstrapping</li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0402.html"></a>Routing</li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0403.html"></a>Requests</li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0404.html"></a>Responses</li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0405.html"></a>Sessions and Cookies</li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0406.html">Url 解析和生成</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0407.html">错误处理（Error Handling）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0408.html">日志（Logging）</a></li>
</ul>
<p>&nbsp;</p>
<h2>关键概念</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0501.html">组件（Components）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0502.html">属性（Properties）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0503.html">事件（Events）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0504.html">行为（Behaviors）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0505.html">配置（Configurations）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0506.html">类自动加载（Autoloading）</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0507.html">别名（Alias）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0508.html">服务定位器（Service Locator）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0509.html">依赖注入容器（DI Container）</a></li>
</ul>
<p>&nbsp;</p>
<h2>使用数据库</h2>
<ul>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0601.html">数据访问对象（DAO）</a> - 连接数据库，基础查询，事务和模式操作</li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0602.html">查询生成器</a> - 使用一个简单的抽象层来查询数据库</li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0603.html">活动记录（Active Record）</a> - Yii对active record ORM的实现，获取和操做记录并定义数据关联</li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0604.html">数据库迁移（Database Migration）</a> - 使用数据库迁移对数据库进行版本管理</li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0605.html">Sphinx</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0606.html">Redis</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0607.html">MongoDB</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0608.html">ElasticSearch</a></li>
</ul>
<p>&nbsp;</p>
<h2>获取用户数据</h2>
<ul>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0701.html">创建表单</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="0702.html">输入验证</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0703.html">文件上传</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0704.html">获取多模型数据</a></li>
</ul>
<p>&nbsp;</p>
<h2>显示数据</h2>
<ul>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0801.html">格式化数据</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0802.html">分页</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0803.html">排序</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0804.html">数据提供器</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0805.html">数据小部件</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0806.html">使用客户端脚本</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0807.html">主题（Theming）</a></li>
</ul>
<p>&nbsp;</p>
<h2>安全和访问控制</h2>
<ul>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0901.html">验证（Authentication）</a> - 识别用户</li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0902.html">授权（Authorization）</a> - 访问控制和RBAC（角色访问控制）</li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="0903.html">使用密码</a> - 哈希和验证密码，加密</li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0904.html">客户端认证</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="0905.html">最佳实践</a></li>
</ul>
<p>&nbsp;</p>
<h2>缓存</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1001.html">概述</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1002.html">数据缓存（Data Caching）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1003.html">片段缓存（Fragment Caching）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1004.html">页面缓存（Page Caching）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1005.html">HTTP 缓存（HTTP Caching）</a></li>
</ul>
<p>&nbsp;</p>
<h2>RESTful Web 服务</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1101.html">快速入门</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1102.html">资源</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1103.html">控制器</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1104.html">路由</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1105.html">格式化响应</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1106.html">授权验证</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1107.html">速率限制</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1108.html">版本化</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1109.html">错误处理</a></li>
</ul>
<p>&nbsp;</p>
<h2>开发工具</h2>
<ul>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1201.html">调试工具栏以及调试器（Debug toolbar and debugger）</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1202.html">自动代码生成（Gii工具）</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1203.html">生成 API 文档</a></li>
</ul>
<p>&nbsp;</p>
<h2>测试</h2>
<ul>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1301.html">概述</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1302.html">测试环境设置</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1303.html">单元测试</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1304.html">功能测试</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1305.html">验收测试</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1306.html">测试固件</a></li>
</ul>
<p>&nbsp;</p>
<h2>高级专题</h2>
<ul>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1401.html">高级应用模板</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1402.html">从头构建应用</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1403.html">控制台命令</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1404.html">核心验证器</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1405.html">国际化</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1406.html">收发邮件</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1407.html">性能优化</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1408.html">共享主机环境</a></li>
	<li><i class="glyphicon glyphicon-pencil" style="color: #dd0000;">&nbsp;</i><a href="1409.html">模板引擎</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1410.html">集成第三方代码</a></li>
</ul>
<p>&nbsp;</p>
<h2>小部件</h2>
<ul>
	<li><a href="1501.html"></a>表格视图 - GridView（Demo）</li>
	<li><a href="1502.html"></a>列表视图 - ListView（Demo）</li>
	<li><a href="1503.html"></a>详情视图 - DeatilView（Demo）</li>
	<li><a href="1504.html"></a>活动表单 - ActiveForm（Demo）</li>
	<li><a href="1505.html"></a>Pjax（Demo）</li>
	<li><a href="1506.html"></a>菜单 - Menu（Demo）</li>
	<li><a href="1507.html"></a>分页 - LinkPager（Demo）</li>
	<li><a href="1508.html"></a>排序 - LinkSorter（Demo）</li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1509.html">Bootstrap 小部件</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1510.html">Jquery UI 小部件</a></li>
</ul>
<p>&nbsp;</p>
<h2>帮助类</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="1601.html">概述</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1602.html">ArrayHelper</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1603.html">Html</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1604.html">Url</a></li>
	<li><i class="glyphicon glyphicon-paperclip">&nbsp;</i><a href="1605.html">Security</a></li>
</ul>
<p>&nbsp;</p>
<h2>参考资料</h2>
<ul>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="2001.html">基础应用模板</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="2002.html">基本概念</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="2003.html">数据表格（GridView）</a></li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="2004.html">Composer</a> - Composer是PHP的应用程序依赖管理工具</li>
	<li><i class="glyphicon glyphicon-ok" style="color: green">&nbsp;</i><a href="https://getcomposer.org/doc/" target="_blank">Composer官方文档</a></li>
</ul>
