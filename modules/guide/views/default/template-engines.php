<h1>使用模板引擎</h1>
<p>Yii 默认使用PHP作为模板语言，但可以通过配置Yii来支持其他模版引擎，如<a href="http://twig.sensiolabs.org/" target="_blank">Twig</a> 或 <a href="http://www.smarty.net/" target="_blank">Smarty</a>。</p>
<p><code>view</code> 组件负责渲染视图。您可以通过重新配置该组件的行为 <code>behavior</code> 来添加自定义的模板引擎：</p>
<pre class="brush: php;toolbar:false;">
[
    'components' => [
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    //'cachePath' => '@runtime/Twig/cache',
                    //'options' => [], /*  Array of twig options */
                    'globals' => ['html' => '\yii\helpers\Html'],
                ],
                // ...
            ],
        ],
    ],
]
</pre>
<p>以上代码配置了Smarty和Twig模板引擎，现在它们都是可用的。但是，为了让你的项目自动获取这些扩展文件，你还需要在你的<code>composer.json</code>文件的 <code>require</code> 部分添加如下代码：</p>
<pre class="brush: php;toolbar:false;">
"yiisoft/yii2-smarty": "*",
"yiisoft/yii2-twig": "*",
</pre>
<p>修改并保存文件后，您就可以通过运行命令 composer update --preder-dist 来安装扩展了。</p>
<p>&nbsp;</p>
<h2>Twig</h2>
<p>要使用Twig，你需要创建一个以 <code>.twig</code> 为扩展名的模版文件（要使用其他扩展名，请在配置组件做相应的修改）。 不同于标准的视图文件，使用 Twig 需要在控制器调用方法<code>$this-&gt;render()</code> 或 <code>$this-&gt;renderPartial()</code> 包含(<code>include</code> )扩展：</p>
<pre class="brush: php;toolbar:false;">
echo $this->render('renderer.twig', ['username' => 'Alex']);
</pre>
<h3>新增方法</h3>
<p>Yii在标准的Twig语法中增加了以下的构造：</p>
<pre class="brush: php;toolbar:false;">
<a href="{{ path('blog/view', {'alias' : post.alias}) }}">{{ post.title }}</a>
</pre>
<p><code>path()</code> 函数内部调用了Yii的 <code>Url::to()</code> 方法。</p>
<h3>表单</h3>
<pre class="brush: php;toolbar:false;">
{% set form = form_begin({ ... }) %}
{{ form.field(...) }}
{% form.end() %}
</pre>
<h4>生成路由URL链接地址</h4>
<p>针对URL链接，有两个可供使用的函数:</p>
<pre class="brush: php;toolbar:false;">
<a href="{{ path('blog/view', {'alias' : post.alias}) }}">{{ post.title }}</a>
<a href="{{ url('blog/view', {'alias' : post.alias}) }}">{{ post.title }}</a>
</pre>
<h3>新增变量</h3>
<p>Twig模板可以使用这些变量：</p>
<ul class="task-list">
<li><code>app</code>，相当于 <code>\Yii::$app</code></li>
<li><code>this</code>, 相当于当前的 <code>View</code> 对象</li>
</ul>
<h3>全局</h3>
<p>您可以设置应用配置文件的<code> globals </code>变量来添加全局辅助方法或全局变量值，也可以同时添加：</p>
<pre class="brush: php;toolbar:false;">
'globals' => [
    'html' => '\yii\helpers\Html',
    'name' => 'Carsten',
],
</pre>
<p>配置完成后，就可以在模板中这样使用全局变量：</p>
<pre class="brush: php;toolbar:false;">
Hello, {{name}}! {{ html.a('Please login', 'site/login') | raw }}.
</pre>
<h3>新增过滤器</h3>
<p>配置应用配置文件的<code> filters </code>选项来添加额外的过滤器：</p>
<pre class="brush: php;toolbar:false;">
'filters' => [
    'jsonEncode' => '\yii\helpers\Json::encode',
],
</pre>
<p>然后在模板中可以使用：</p>
<pre class="brush: php;toolbar:false;">
{{ model|jsonEncode }}
</pre>
<p>&nbsp;</p>
<h2>Smarty</h2>
<p>要使用Smarty，你需要创建以 <code>.tpl</code> 为扩展名的模版文件（要使用其他扩展名，请在配置组件中做相应修改）。不同于标准的视图文件，使用Smarty的时候你必须在控制器调用方法<code>$this-&gt;render()</code> 或 <code>$this-&gt;renderPartial()</code> <code>include</code>(包含) 扩展：</p>
<pre class="brush: php;toolbar:false;">
echo $this->render('renderer.tpl', ['username' => 'Alex']);
</pre>
<h3>新增方法</h3>
<p>Yii添加了以下的构造到标准的Smarty语法中：</p>
<pre class="brush: php;toolbar:false;">
&lt;a href="{path route='blog/view' alias=$post.alias}">{$post.title}&lt;/a>
</pre>
<p><code>path()</code> 函数内部调用了Yii的 <code>Url::to()</code> 方法。</p>
<h3>新增变量</h3>
<p>在Smarty模板中，您还可以使用这些变量：</p>
<ul class="task-list">
<li><code>$app</code>，相当于 <code>\Yii::$app</code></li>
<li><code>$this</code>，相当于当前的 <code>View</code> 对象</li>
</ul>

