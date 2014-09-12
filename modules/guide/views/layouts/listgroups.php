<?php
use yii\helpers\Html;
use app\models\SideMenuModel;
use kartik\widgets\SideNav;
use yii\filters\AccessControl;
/* 判定菜单 */
$active = $_GET ["id"];
$sideMenu = ( array ) SideMenuModel::getGuideListMenu ( $active );
$menuname = $sideMenu ['menuname'];

if ($sideMenu ['flag'] !== '0') {
	$r = $menuname;
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
										'label' => '从 Version 1.1 升级',
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
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '运行应用',
										'url' => 'index.php/guide/0202.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Say Hello',
										'url' => 'index.php/guide/0203.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '使用表单',
										'url' => 'index.php/guide/0204.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '使用数据库',
										'url' => 'index.php/guide/0205.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '用Gii生成代码',
										'url' => 'index.php/guide/0206.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '展望未来',
										'url' => 'index.php/guide/0207.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '应用结构',
						'items' => [ 
								[ 
										'label' => '结构总览',
										'url' => 'index.php/guide/0301.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '入口脚本',
										'url' => 'index.php/guide/0302.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '应用',
										'url' => 'index.php/guide/0303.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '应用组件',
										'url' => 'index.php/guide/0304.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '控制器（Controller）',
										'url' => 'index.php/guide/0305.html',
										'active' => $r === "controller" ? true : false 
								],
								[ 
										'label' => '视图（View）',
										'url' => 'index.php/guide/0306.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '模型（Model）',
										'url' => 'index.php/guide/0307.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '过滤器',
										'url' => 'index.php/guide/0309.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '小部件（Widget）',
										'url' => 'index.php/guide/0310.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '模块（Module）',
										'url' => 'index.php/guide/0311.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '资源管理（Asset）',
										'url' => 'index.php/guide/0312.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '扩展（extensions）',
										'url' => 'index.php/guide/0313.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '请求处理',
						'items' => [ 
								[ 
										'label' => 'TBD（Bootstrapping）',
										'url' => 'index.php/guide/0401.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（Routing）',
										'url' => 'index.php/guide/0402.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（Requests）',
										'url' => 'index.php/guide/0403.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（Responses）',
										'url' => 'index.php/guide/0404.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（Sessions and Cookies）',
										'url' => 'index.php/guide/0405.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'URL 解析和生成',
										'url' => 'index.php/guide/0406.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '错误处理',
										'url' => 'index.php/guide/0407.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '日志（Logging）',
										'url' => 'index.php/guide/0408.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '关键概念',
						'items' => [ 
								[ 
										'label' => '组件（Component）',
										'url' => 'index.php/guide/0501.html',
										'active' => $r === "components" ? true : false 
								],
								[ 
										'label' => '属性（Property）',
										'url' => 'index.php/guide/0502.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '事件（Event）',
										'url' => 'index.php/guide/0503.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '行为（Behavior）',
										'url' => 'index.php/guide/0504.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '配置（Configurations）',
										'url' => 'index.php/guide/0505.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '类自动加载',
										'url' => 'index.php/guide/0506.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '别名（Alias）',
										'url' => 'index.php/guide/0507.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '服务定位器',
										'url' => 'index.php/guide/0508.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '依赖注入容器',
										'url' => 'index.php/guide/0509.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '配合数据库工作',
						'items' => [ 
								[ 
										'label' => '数据访问对象',
										'url' => 'index.php/guide/0601.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '查询生成器',
										'url' => 'index.php/guide/0602.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Active Record',
										'url' => 'index.php/guide/0603.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '数据迁移',
										'url' => 'index.php/guide/0604.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（Sphinx）',
										'url' => 'index.php/guide/0605.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（Redis）',
										'url' => 'index.php/guide/0606.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（MongoDB）',
										'url' => 'index.php/guide/0607.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD（ElasticSearch）',
										'url' => 'index.php/guide/0608.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '接收用户数据',
						'items' => [ 
								[ 
										'label' => '创建表单',
										'url' => 'index.php/guide/0701.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '输入验证',
										'url' => 'index.php/guide/0702.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 文件上传',
										'url' => 'index.php/guide/0703.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 获取多模型数据',
										'url' => 'index.php/guide/0704.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '显示数据',
						'items' => [ 
								[ 
										'label' => 'TBD 格式化数据',
										'url' => 'index.php/guide/0801.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 分页',
										'url' => 'index.php/guide/0802.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 排序',
										'url' => 'index.php/guide/0803.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '数据提供器',
										'url' => 'index.php/guide/0804.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '数据小部件',
										'url' => 'index.php/guide/0805.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '使用脚本',
										'url' => 'index.php/guide/0806.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '主题（Theming）',
										'url' => 'index.php/guide/0807.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '安全',
						'items' => [ 
								[ 
										'label' => '验证（Authentication）',
										'url' => 'index.php/guide/0901.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '授权（Authorization）',
										'url' => 'index.php/guide/0902.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 使用密码',
										'url' => 'index.php/guide/0902.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 客户端认证',
										'url' => 'index.php/guide/0902.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'TBD 最佳实践',
										'url' => 'index.php/guide/0902.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '缓存',
						'items' => [ 
								[ 
										'label' => '概述',
										'url' => 'index.php/guide/1001.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '数据缓存',
										'url' => 'index.php/guide/1002.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '片段缓存',
										'url' => 'index.php/guide/1003.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '页面缓存',
										'url' => 'index.php/guide/1004.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'HTTP 缓存',
										'url' => 'index.php/guide/1005.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => 'RESTful Web 服务',
						'items' => [ 
								[ 
										'label' => '快速入门',
										'url' => 'index.php/guide/1101.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '资源',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '路由',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '格式化响应',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '授权验证',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '速率限制',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '版本化',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '错误处理',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => '测试',
										'url' => 'index.php/guide/1102.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '开发工具',
						'items' => [ 
								[ 
										'label' => 'About Yii',
										'url' => 'index.php/guide/1201.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Upgrading from Version 1.1',
										'url' => 'index.php/guide/1202.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '测试',
						'items' => [ 
								[ 
										'label' => 'About Yii',
										'url' => 'index.php/guide/1301.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Upgrading from Version 1.1',
										'url' => 'index.php/guide/1302.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '高级专题',
						'items' => [ 
								[ 
										'label' => 'About Yii',
										'url' => 'index.php/guide/1401.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Upgrading from Version 1.1',
										'url' => 'index.php/guide/1402.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '小部件',
						'items' => [ 
								[ 
										'label' => 'About Yii',
										'url' => 'index.php/guide/1501.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Upgrading from Version 1.1',
										'url' => 'index.php/guide/1502.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				],
				[ 
						'label' => '助手类',
						'items' => [ 
								[ 
										'label' => 'About Yii',
										'url' => 'index.php/guide/1601.html',
										'active' => $r === "maintran" ? true : false 
								],
								[ 
										'label' => 'Upgrading from Version 1.1',
										'url' => 'index.php/guide/1602.html',
										'active' => $r === "maintran" ? true : false 
								] 
						] 
				] 
		] 
] );
?>
</div>
