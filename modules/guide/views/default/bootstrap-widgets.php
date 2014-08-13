<h1>Bootstrap 小部件<a href="#bootstrap-widgets" name="bootstrap-widgets"></a></h1>
<p>Yii 内置支持 <a href="http://getbootstrap.com/" target="_blank">Bootstrap 3</a> 标识markup 以及 组件框架components framework (也就是"Twitter Bootstrap")。Bootstrap is 一个出色的响应式框架，可以很好的加快前端应用的开发过程。</p>
<p>Bootstrap 的核心包含两部分：</p>
<ul>
	<li>CSS 基础，比如表格布局系统（grid layout system）、 排版（typography）、帮助类（helper classes）以及响应式 工具。</li>
	<li>实用界面组件，比如表单（forms）、菜单（menus）、分页（pagination），模式对话框（modal boxes），标签（ tabs），等等。</li>
</ul>
<p>&nbsp;</p>
<h2>基础知识<a href="#basics" name="basics"></a></h2>
<p>Yii 并没有使用PHP对 bootstrap 进行封装，因为在这样的情况下HTML本身就是最简单的方式。你可以通过阅读 <a href="http://getbootstrap.com/css/" target="_blank">bootstrap documentation website </a>来学习更多基础用法。不过Yii还是提供了一个简单的方法来在页面中包含 bootstrap 资源，只有一行代码，添加在位于 <code>assets</code> 目录下的 <code>AppAsset.php</code> 文件中：</p>
<pre class="brush: php;toolbar:false;">
public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset', // this line
    // 'yii\bootstrap\BootstrapThemeAsset' // uncomment to apply bootstrap 2 style to bootstrap 3
];
</pre>
<p>通过Yii资源管理器来使用 bootstrap ，使得你可以最小化其资源并在需要的时候进行资源整合。</p>
<p>&nbsp;</p>
<h2>Yii 小部件<a href="#yii-widgets" name="yii-widgets"></a></h2>
<p>大部分复杂的 bootstrap 组件被封装到 Yii 的界面组件（widgets）中，以便更好的和框架特性集成。所有的 widgets 都属于 <code>\yii\bootstrap</code> 命名空间：</p>
<ul>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-activeform.html">ActiveForm</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-alert.html">Alert</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-button.html">Button</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-buttondropdown.html">ButtonDropdown</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-buttongroup.html">ButtonGroup</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-carousel.html">Carousel</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-collapse.html">Collapse</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-dropdown.html">Dropdown</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-modal.html">Modal</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-nav.html">Nav</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-navbar.html">NavBar</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-progress.html">Progress</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-bootstrap-tabs.html">Tabs</a></li>
</ul>
<h2>直接使用Bootstrap的 .less 文件<a href="#using-the-less-files-of-bootstrap-directly" name="using-the-less-files-of-bootstrap-directly"></a></h2>
<p>如果你想直接把Bootstrap css直接包含到你的 less 文件中，你可能需要禁止原有的bootstrap css文件被加载。你可以通过设置 BootstrapAsset 属性为空来实现这一点。将你的 <code>assetManager</code> 应用程序组件配置如下：</p>
<pre class="brush: php;toolbar:false;">
'assetManager' => [
        'bundles' => [
            'yii\bootstrap\BootstrapAsset' => [
                'css' => [],
            ]
        ]
    ]
</pre>