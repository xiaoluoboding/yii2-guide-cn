<?php
use app\models\SideMenuModel;
use kartik\widgets\SideNav;

/* 判定菜单 */
$active = $_GET ["id"];
$Nameidx = Yii::$app->controller->Nameidx;
$Flag = Yii::$app->controller->Flag;

if ($Flag == '1') {
	$r = $Nameidx;
} else {
	$r = false;
}

?>
<div class="list-group">
<?php
echo SideNav::widget ( [ 
	'type' => SideNav::TYPE_DEFAULT,
	'heading' => false,
	'items' => [ 
		[ 
			'label' => '介绍',
			'items' => [ 
				[ 
					'label' => '关于 Yii',
					'url' => 'index.php/guide/0101.html',
					// 'icon' => 'chevron-right',
					'active' => $r === "overview" ? true : false 
				],
				[ 
					'label' => '从Yii 1.1 升级',
					'url' => 'index.php/guide/0102.html',
					// 'icon' => 'chevron-right',
					'active' => $r === "upgrade-from-v1" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '入门',
			'items' => [ 
				[ 
					'label' => '安装 Yii',
					'url' => 'index.php/guide/0201.html',
					'active' => $r === "installation" ? true : false 
				],
				[ 
					'label' => '运行应用',
					'url' => 'index.php/guide/0202.html',
					'active' => $r === "start-workflow" ? true : false 
				],
				[ 
					'label' => '说声 Hello',
					'url' => 'index.php/guide/0203.html',
					'active' => $r === "start-hello" ? true : false 
				],
				[ 
					'label' => '使用表单',
					'url' => 'index.php/guide/0204.html',
					'active' => $r === "start-forms" ? true : false 
				],
				[ 
					'label' => '使用数据库',
					'url' => 'index.php/guide/0205.html',
					'active' => $r === "start-databases" ? true : false 
				],
				[ 
					'label' => '用Gii生成代码',
					'url' => 'index.php/guide/0206.html',
					'active' => $r === "start-gii" ? true : false 
				],
				[ 
					'label' => '进阶资料',
					'url' => 'index.php/guide/0207.html',
					'active' => $r === "looking-ahead" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '应用结构',
			'items' => [ 
				[ 
					'label' => '结构概述',
					'url' => 'index.php/guide/0301.html',
					'active' => $r === "app-overview" ? true : false 
				],
				[ 
					'label' => '入口脚本',
					'url' => 'index.php/guide/0302.html',
					'active' => $r === "entry-scripts" ? true : false 
				],
				[ 
					'label' => '应用（Applications）',
					'url' => 'index.php/guide/0303.html',
					'active' => $r === "applications" ? true : false 
				],
				[ 
					'label' => '应用组件',
					'url' => 'index.php/guide/0304.html',
					'active' => $r === "app-component" ? true : false 
				],
				[ 
					'label' => '控制器（Controllers）',
					'url' => 'index.php/guide/0305.html',
					'active' => $r === "controller" ? true : false 
				],
				[ 
					'label' => '视图（Views）',
					'url' => 'index.php/guide/0306.html',
					'active' => $r === "view" ? true : false 
				],
				[ 
					'label' => '模型（Models）',
					'url' => 'index.php/guide/0307.html',
					'active' => $r === "model" ? true : false 
				],
		
				[
					'label' => '模块（Modules）',
					'url' => 'index.php/guide/0308.html',
					'active' => $r === "modules" ? true : false
				],
				[ 
					'label' => '过滤器（Filters）',
					'url' => 'index.php/guide/0309.html',
					'active' => $r === "filters" ? true : false 
				],
				[ 
					'label' => '小部件（Widgets）',
					'url' => 'index.php/guide/0310.html',
					'active' => $r === "widgets" ? true : false 
				],
				[ 
					'label' => '资源管理（Assets）',
					'url' => 'index.php/guide/0311.html',
					'active' => $r === "assets" ? true : false 
				],
				[ 
					'label' => '扩展（extensions）',
					'url' => 'index.php/guide/0312.html',
					'active' => $r === "extensions" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '请求处理',
			'items' => [
				/* 
				[ 
					'label' => 'TBD（Bootstrapping）',
					'url' => 'index.php/guide/0401.html',
					'active' => $r === "bootstarpping" ? true : false 
				],
				[ 
					'label' => 'TBD（Routing）',
					'url' => 'index.php/guide/0402.html',
					'active' => $r === "routing" ? true : false 
				],
				[ 
					'label' => 'TBD（Requests）',
					'url' => 'index.php/guide/0403.html',
					'active' => $r === "requests" ? true : false 
				],
				[ 
					'label' => 'TBD（Responses）',
					'url' => 'index.php/guide/0404.html',
					'active' => $r === "responses" ? true : false 
				],
				[ 
					'label' => 'TBD（Sessions and Cookies）',
					'url' => 'index.php/guide/0405.html',
					'active' => $r === "sessions-cookies" ? true : false 
				],*/
				[ 
					'label' => 'URL 解析和生成',
					'url' => 'index.php/guide/0406.html',
					'active' => $r === "url" ? true : false 
				],
				[ 
					'label' => '错误处理',
					'url' => 'index.php/guide/0407.html',
					'active' => $r === "error" ? true : false 
				],
				[ 
					'label' => '日志（Logging）',
					'url' => 'index.php/guide/0408.html',
					'active' => $r === "logging" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '关键概念',
			'items' => [ 
				[ 
					'label' => '组件（Components）',
					'url' => 'index.php/guide/0501.html',
					'active' => $r === "components" ? true : false 
				],
				[ 
					'label' => '属性（Properties）',
					'url' => 'index.php/guide/0502.html',
					'active' => $r === "properties" ? true : false 
				],
				[ 
					'label' => '事件（Events）',
					'url' => 'index.php/guide/0503.html',
					'active' => $r === "events" ? true : false 
				],
				[ 
					'label' => '行为（Behaviors）',
					'url' => 'index.php/guide/0504.html',
					'active' => $r === "behaviors" ? true : false 
				],
				[ 
					'label' => '配置（Configurations）',
					'url' => 'index.php/guide/0505.html',
					'active' => $r === "configuration" ? true : false 
				],
				[ 
					'label' => '类自动加载',
					'url' => 'index.php/guide/0506.html',
					'active' => $r === "autoloading" ? true : false 
				],
				[ 
					'label' => '别名（Alias）',
					'url' => 'index.php/guide/0507.html',
					'active' => $r === "alias" ? true : false 
				],
				[ 
					'label' => '服务定位器',
					'url' => 'index.php/guide/0508.html',
					'active' => $r === "service-locator" ? true : false 
				],
				[ 
					'label' => '依赖注入容器',
					'url' => 'index.php/guide/0509.html',
					'active' => $r === "di" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '使用数据库',
			'items' => [ 
				[ 
					'label' => '数据访问对象',
					'url' => 'index.php/guide/0601.html',
					'active' => $r === "database-basics" ? true : false 
				],
				[ 
					'label' => '查询生成器',
					'url' => 'index.php/guide/0602.html',
					'active' => $r === "query-builder" ? true : false 
				],
				[ 
					'label' => '活动记录',
					'url' => 'index.php/guide/0603.html',
					'active' => $r === "active-record" ? true : false 
				],
				[ 
					'label' => '数据库迁移',
					'url' => 'index.php/guide/0604.html',
					'active' => $r === "console-migrate" ? true : false 
				],
				/* [ 
					'label' => 'TBD（Sphinx）',
					'url' => 'index.php/guide/0605.html',
					'active' => $r === "sphinx" ? true : false 
				],
				[ 
					'label' => 'TBD（Redis）',
					'url' => 'index.php/guide/0606.html',
					'active' => $r === "redis" ? true : false 
				],
				[ 
					'label' => 'TBD（MongoDB）',
					'url' => 'index.php/guide/0607.html',
					'active' => $r === "mongodb" ? true : false 
				],
				[ 
					'label' => 'TBD（ElasticSearch）',
					'url' => 'index.php/guide/0608.html',
					'active' => $r === "elasticsearch" ? true : false 
				] */ 
			] 
		],
		[ 
			'label' => '获取用户数据',
			'items' => [ 
				[ 
					'label' => '创建表单',
					'url' => 'index.php/guide/0701.html',
					'active' => $r === "form" ? true : false 
				],
				[ 
					'label' => '输入验证',
					'url' => 'index.php/guide/0702.html',
					'active' => $r === "validating-input" ? true : false 
				],
				[ 
					'label' => '文件上传',
					'url' => 'index.php/guide/0703.html',
					'active' => $r === "uploading-files" ? true : false 
				],
				/*
				[ 
					'label' => 'TBD 获取多模型数据',
					'url' => 'index.php/guide/0704.html',
					'active' => $r === "get-mult-data" ? true : false 
				] */ 
			] 
		],
		[ 
			'label' => '显示数据',
			'items' => [ 
				/* [ 
					'label' => 'TBD 格式化数据',
					'url' => 'index.php/guide/0801.html',
					'active' => $r === "data-formatting" ? true : false 
				],
				[ 
					'label' => 'TBD 分页',
					'url' => 'index.php/guide/0802.html',
					'active' => $r === "pagination" ? true : false 
				],
				[ 
					'label' => 'TBD 排序',
					'url' => 'index.php/guide/0803.html',
					'active' => $r === "sorting" ? true : false 
				], */
				[ 
					'label' => '数据提供器',
					'url' => 'index.php/guide/0804.html',
					'active' => $r === "data-providers" ? true : false 
				],
				[ 
					'label' => '数据小部件',
					'url' => 'index.php/guide/0805.html',
					'active' => $r === "data-widgets" ? true : false 
				],
				[ 
					'label' => '使用客户端脚本',
					'url' => 'index.php/guide/0806.html',
					'active' => $r === "client-scripts" ? true : false 
				],
				[ 
					'label' => '主题（Theming）',
					'url' => 'index.php/guide/0807.html',
					'active' => $r === "theming" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '安全',
			'items' => [ 
				[ 
					'label' => '验证（Authentication）',
					'url' => 'index.php/guide/0901.html',
					'active' => $r === "authentication" ? true : false 
				],
				[ 
					'label' => '授权（Authorization）',
					'url' => 'index.php/guide/0902.html',
					'active' => $r === "authorization" ? true : false 
				],
				/* [ 
					'label' => 'TBD 使用密码',
					'url' => 'index.php/guide/0903.html',
					'active' => $r === "security" ? true : false 
				],
				[ 
					'label' => 'TBD 客户端认证',
					'url' => 'index.php/guide/0904.html',
					'active' => $r === "auth-clients" ? true : false 
				],
				[ 
					'label' => 'TBD 最佳实践',
					'url' => 'index.php/guide/0905.html',
					'active' => $r === "best-practices" ? true : false 
				] */ 
			] 
		],
		[ 
			'label' => '缓存',
			'items' => [ 
				[ 
					'label' => '概述',
					'url' => 'index.php/guide/1001.html',
					'active' => $r === "caching-overview" ? true : false 
				],
				[ 
					'label' => '数据缓存',
					'url' => 'index.php/guide/1002.html',
					'active' => $r === "caching-data" ? true : false 
				],
				[ 
					'label' => '片段缓存',
					'url' => 'index.php/guide/1003.html',
					'active' => $r === "caching-fragment" ? true : false 
				],
				[ 
					'label' => '页面缓存',
					'url' => 'index.php/guide/1004.html',
					'active' => $r === "caching-page" ? true : false 
				],
				[ 
					'label' => 'HTTP 缓存',
					'url' => 'index.php/guide/1005.html',
					'active' => $r === "caching-http" ? true : false 
				] 
			] 
		],
		[ 
			'label' => 'RESTful Web 服务',
			'items' => [ 
				[ 
					'label' => '快速入门',
					'url' => 'index.php/guide/1101.html',
					'active' => $r === "rest-quick-start" ? true : false 
				],
				[ 
					'label' => '资源',
					'url' => 'index.php/guide/1102.html',
					'active' => $r === "rest-resources" ? true : false 
				],
				[
					'label' => '控制器',
					'url' => 'index.php/guide/1103.html',
					'active' => $r === "rest-controllers" ? true : false
				],
				[ 
					'label' => '路由',
					'url' => 'index.php/guide/1104.html',
					'active' => $r === "rest-routing" ? true : false 
				],
				[ 
					'label' => '格式化响应',
					'url' => 'index.php/guide/1105.html',
					'active' => $r === "rest-response-formatting" ? true : false 
				],
				[ 
					'label' => '授权验证',
					'url' => 'index.php/guide/1106.html',
					'active' => $r === "rest-authentication" ? true : false 
				],
				[ 
					'label' => '速率限制',
					'url' => 'index.php/guide/1107.html',
					'active' => $r === "rest-rate-limiting" ? true : false 
				],
				[ 
					'label' => '版本控制',
					'url' => 'index.php/guide/1108.html',
					'active' => $r === "rest-versioning" ? true : false 
				],
				[ 
					'label' => '错误处理',
					'url' => 'index.php/guide/1109.html',
					'active' => $r === "rest-error" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '开发工具',
			'items' => [ 
				[ 
					'label' => '调试工具栏与调试器',
					'url' => 'index.php/guide/1201.html',
					'active' => $r === "module-debug" ? true : false 
				],
				[ 
					'label' => '代码生成器（Gii）',
					'url' => 'index.php/guide/1202.html',
					'active' => $r === "gii" ? true : false 
				],
				/* [ 
					'label' => '生成 API 文档',
					'url' => 'index.php/guide/1203.html',
					'active' => $r === "tool-api-doc" ? true : false 
				] */ 
			] 
		],
		[ 
			'label' => '测试',
			'items' => [ 
				[ 
					'label' => '概述',
					'url' => 'index.php/guide/1301.html',
					'active' => $r === "test-overview" ? true : false 
				],
				[ 
					'label' => '测试环境设置',
					'url' => 'index.php/guide/1302.html',
					'active' => $r === "test-env-setup" ? true : false 
				],
				[ 
					'label' => '单元测试',
					'url' => 'index.php/guide/1303.html',
					'active' => $r === "test-unit" ? true : false 
				],
				[ 
					'label' => '功能测试',
					'url' => 'index.php/guide/1304.html',
					'active' => $r === "test-functional" ? true : false 
				],
				[ 
					'label' => '验收测试',
					'url' => 'index.php/guide/1305.html',
					'active' => $r === "test-acceptance" ? true : false 
				],
				[ 
					'label' => '测试固件',
					'url' => 'index.php/guide/1306.html',
					'active' => $r === "test-fixtures" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '高级专题',
			'items' => [ 
				[ 
					'label' => '高级应用模板',
					'url' => 'index.php/guide/1401.html',
					'active' => $r === "apps-advanced" ? true : false 
				],
				[ 
					'label' => '从头构建应用',
					'url' => 'index.php/guide/1402.html',
					'active' => $r === "start-from-scratch" ? true : false 
				],
				[ 
					'label' => '控制台命令',
					'url' => 'index.php/guide/1403.html',
					'active' => $r === "console" ? true : false 
				],
				[ 
					'label' => '核心验证器',
					'url' => 'index.php/guide/1404.html',
					'active' => $r === "core-validators" ? true : false 
				],
				[ 
					'label' => '国际化',
					'url' => 'index.php/guide/1405.html',
					'active' => $r === "i18n" ? true : false 
				],
				[ 
					'label' => '收发邮件',
					'url' => 'index.php/guide/1406.html',
					'active' => $r === "mailing" ? true : false 
				],
				[ 
					'label' => '性能优化',
					'url' => 'index.php/guide/1407.html',
					'active' => $r === "performance" ? true : false 
				],
				/* [ 
					'label' => '共享主机环境',
					'url' => 'index.php/guide/1408.html',
					'active' => $r === "shared-hosting" ? true : false 
				], */
				[ 
					'label' => '模板引擎',
					'url' => 'index.php/guide/1409.html',
					'active' => $r === "template-engines" ? true : false 
				],
				[ 
					'label' => '集成第三方代码',
					'url' => 'index.php/guide/1410.html',
					'active' => $r === "integration" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '小部件',
			'items' => [
				/* 
				[ 
					'label' => 'GridView（Demo）',
					'url' => 'index.php/guide/1501.html',
					'active' => $r === "widget-girdview" ? true : false 
				],
				[ 
					'label' => 'ListView（Demo）',
					'url' => 'index.php/guide/1502.html',
					'active' => $r === "widget-listview" ? true : false 
				],
				[ 
					'label' => 'DetailView（Demo）',
					'url' => 'index.php/guide/1503.html',
					'active' => $r === "widget-detailview" ? true : false 
				],
				[ 
					'label' => 'ActiveForm（Demo）',
					'url' => 'index.php/guide/1504.html',
					'active' => $r === "widget-activeform" ? true : false 
				],
				[ 
					'label' => 'Pjax（Demo）',
					'url' => 'index.php/guide/1505.html',
					'active' => $r === "widget-pjax" ? true : false 
				],
				[ 
					'label' => 'Menu（Demo）',
					'url' => 'index.php/guide/1506.html',
					'active' => $r === "widget-menu" ? true : false 
				],
				[ 
					'label' => 'LinkPager（Demo）',
					'url' => 'index.php/guide/1507.html',
					'active' => $r === "widget-linkpager" ? true : false 
				],
				[ 
					'label' => 'LinkSorter（Demo）',
					'url' => 'index.php/guide/1508.html',
					'active' => $r === "widget-linksorter" ? true : false 
				],
				*/
				[ 
					'label' => 'Bootstrap 小部件',
					'url' => 'index.php/guide/1509.html',
					'active' => $r === "widget-bootstrap" ? true : false 
				],
				[ 
					'label' => 'Jquery UI 小部件',
					'url' => 'index.php/guide/1510.html',
					'active' => $r === "widget-jquery-ui" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '助手类',
			'items' => [ 
				[ 
					'label' => '概述',
					'url' => 'index.php/guide/1601.html',
					'active' => $r === "helper-overview" ? true : false 
				],
				[ 
					'label' => 'ArrayHelper',
					'url' => 'index.php/guide/1602.html',
					'active' => $r === "helper-arrayhelper" ? true : false 
				],
				[ 
					'label' => 'Html',
					'url' => 'index.php/guide/1603.html',
					'active' => $r === "helper-html" ? true : false 
				],
				[ 
					'label' => 'Url',
					'url' => 'index.php/guide/1604.html',
					'active' => $r === "helper-url" ? true : false 
				],
				[ 
					'label' => 'Security',
					'url' => 'index.php/guide/1605.html',
					'active' => $r === "helper-security" ? true : false 
				] 
			] 
		],
		[ 
			'label' => '参考资料',
			'items' => [ 
				[ 
					'label' => '基础应用模板',
					'url' => 'index.php/guide/2001.html',
					'active' => $r === "apps-basic" ? true : false 
				],
				[ 
					'label' => '基本概念',
					'url' => 'index.php/guide/2002.html',
					'active' => $r === "basics" ? true : false 
				],
				[ 
					'label' => '数据表格',
					'url' => 'index.php/guide/2003.html',
					'active' => $r === "data-grid" ? true : false 
				],
				[ 
					'label' => 'Composer',
					'url' => 'index.php/guide/2004.html',
					'active' => $r === "composer" ? true : false 
				] 
			] 
		] 
	] 
] );
?>
</div>
