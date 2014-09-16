<h1>用 Gii 生成代码</h1>
<p>
	本章节将介绍如何使用<a href="1202.html"> Gii </a>去自动生成 Web 站点常用功能的代码。使用 Gii 生成代码非常简单，只要按照 Gii 页面上的介绍输入正确的信息即可。
</p>
<p>贯穿本章节，你将会学到：</p>
<ul>
	<li>在你的应用中开启 Gii</li>
	<li>使用 Gii 去生成活动记录类</li>
	<li>使用 Gii 去生成数据表操作的增查改删（CRUD）代码</li>
	<li>自定义 Gii 生成的代码</li>
</ul>
<p>&nbsp;</p><h2>开始 Gii</h2><hr>
<p><a href="1202.html">Gii</a>是 Yii 中的一个<a href="">模块</a>。可以通过配置应用的 [[yii\base\Application::modules|modules]] 属性开启它。通常来讲<code> config/web.php</code>文件中会有以下配置代码：</p>
<pre class="brush: php;toolbar:false;">
$config = [ ... ];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
</pre>
<p>这段配置的意思是如果当前是开发环境，应用会包含<code>gii</code>模块，模块类是 [[yii\gii\Module]]。</p>
<p>如果你检查应用的<a href="0302.html">入口脚本</a><code>web/index.php</code>，将看到这行代码将<code>YII_ENV_DEV</code>设为 true：</p>
<pre class="brush: php;toolbar:false;">
defined('YII_ENV') or define('YII_ENV', 'dev');
</pre>
<p>代码设置应用处于开发模式下，按照上面的配置会打开 Gii 模块。你可以直接通过 URL 访问 Gii：</p>
<pre class="brush: php;toolbar:false;">
http://hostname/index.php?r=gii
</pre>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii.png" alt="start-gii"  width="800" height="600" /></p>
<p>&nbsp;</p><h2>生成活动记录类</h2><hr>
<p>选择 “Model Generator” （点击 Gii 首页的链接）去生成活动记录类。并像这样填写表单：</p>
<ul>
	<li>Table Name: <code>country</code></li>
	<li>Model Class: <code>Country</code></li>
</ul>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii-model.png" alt="estart-gii-model"  width="800" height="600" /></p>
<p>然后点击 “Preview” 按钮。你会看到<code>models/Country.php</code>被列在将要生成的文件列表中。可以点击文件名预览内容。</p>
<p>如果你已经创建过同样的文件，使用 Gii 可以覆写它，点击文件名旁边的<code>diff</code>能查看现有文件与将要生成的文件的内容区别。</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii-model-preview.png" alt="start-gii-model-preview"  width="800" height="600" /></p>
<p>想要覆写已存在文件，选中 “overwrite” 下的复选框然后点击 “Generator”。如果是新文件，只点击 “Generator” 就好。</p>
<p>接下来你会看到一个包含已生成文件的说明页面。如果生成过程中覆写过文件，还会有一条信息说明代码是重新生成覆盖的。</p>
<p>&nbsp;</p><h2>生成 CRUD 代码</h2><hr>
<p>CRUD 代表增，查，改，删操作，这是绝大多数 Web 站点常用的数据处理方式。选择 Gii 中的 “CRUD Generator” （点击 Gii 首页的链接）去创建 CRUD 功能。之前的 “country” 例子需要像这样填写表单：</p>
<ul>
	<li>Model Class: <code>app\models\Country</code></li>
	<li>Search Model Class: <code>app\models\CountrySearch</code></li>
	<li>Controller Class: <code>app\controllers\CountryController</code></li>
</ul>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii-crud.png" alt="start-gii-crud"  width="800" height="600" /></p>
<p>然后点击 “Preview” 按钮。你会看到下述将要生成的文件列表。</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii-crud-preview.png" alt="start-gii-crud-preview"  width="800" height="600" /></p>
<p>如果你之前创建过<code>controllers/CountryController.php</code>和<code>views/country/index.php</code>文件（在指南的使用数据库小节），选中 “overwrite” 下的复选框覆写它们（之前的文件没能全部支持 CRUD）。</p>
<p>&nbsp;</p><h2>尝试一下</h2><hr>
<p>用浏览器访问下面的 URL 查看生成代码的运行：</p>
<pre class="brush: php;toolbar:false;">
http://hostname/index.php?r=country/index
</pre>
<p>可以看到一个栅格显示着从数据表中获取的国家数据。支持在列头对数据进行排序，输入筛选条件进行筛选。</p>
<p>可以浏览详情，编辑，或删除栅格中的每个国家。还可以点击栅格上方的 “Create Country” 按钮通过表单创建新国家。</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii-country-grid.png" alt="start-gii-country-grid"  width="800" height="600" /></p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-gii-country-update.png" alt="start-gii-country-update"  width="800" height="600" /></p>
<p>下面列出由 Gii 生成的文件，以便你研习功能和实现，或修改它们。</p>
<ul>
	<li>控制器：<code>controllers/CountryController.php</code></li>
	<li>模型：<code>models/Country.php</code>和<code>models/CountrySearch.php</code></li>
	<li>视图：<code>views/country/*.php</code></li>
</ul>
<blockquote>
	<p>补充：Gii 被设计成高度可定制和可扩展的代码生成工具。使用它可以大幅提高应用开发速度。请参考 Gii 小节了解更多内容。</p>
</blockquote>
<p>&nbsp;</p><h2>总结</h2><hr>
<p>本章学习了如何使用 Gii 去生成为数据表中数据实现完整 CRUD 功能的代码。</p>
