<h1>Gii 代码生成器</h1>
<p>Yii 包含一个非常便利的工具，名字叫做Gii，它提供了一个通过生成常用的代码段的方式，实现了快速生成应用原型的目的。</p>
<blockquote><p>译者注：如果你使用过Yii1.x版本的话，你一定会熟悉Gii，Yii2版本的Gii和Yii1版本的Gii主要区别在于界面更友好方面，以及加入了扩展（Extension）生成器。</p></blockquote>
<p>&nbsp;</p>
<h2>安装和配置</h2>
<p>Gii 是个官方的 Yii 扩展，建议通过<a href="https://getcomposer.org/download/" target="_blank">Composer</a>来安装这个扩展。</p>
<p>你可以输入如下命令来安装Gii：</p>
<pre class="brush: php;toolbar:false;">
php composer.phar require --prefer-dist yiisoft/yii2-gii "*"
</pre>
<p>或者在你的<code> composer.json </code>文件中的require部分添加如下代码：</p>
<pre class="brush: php;toolbar:false;">
"yiisoft/yii2-gii": "*"
</pre>
<p>一旦 Gii 扩展被正确安装，你可以通过在应用配置文件中添加下面这块代码来启用它：</p>
<pre class="brush: php;toolbar:false;">
'modules' => [
    'gii' => [
        'class' => 'yii\gii\Module',
    ],
]
</pre>
<p>启用Gii之后，你就可以通过如下URL访问Gii：</p>
<pre class="brush: php;toolbar:false;">
http://localhost/path/to/index.php?r=gii
</pre>
<p>如果你开启了<code> pretty URLs </code>，你可能需要通过如下URL访问Gii：</p>
<pre class="brush: php;toolbar:false;">
http://localhost/path/to/index.php/gii
</pre>
<blockquote>
<p>注意：如果你通过不是本地 localhost 的 IP 地址访问gii，默认状态下，那这个访问会被拒绝。如果要规避这条默认的规则，你需要在配置中，添加其他被允许的 IP 地址到如下位置：</p>
<pre class="brush: php;toolbar:false;">
'gii' => [
    'class' => 'yii\gii\Module',
    'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'] // 把这行改为你所需的
],
</pre>
</blockquote>
<h3>基础应用模板</h3>
<p>在基本应用模版中，配置架构略显不同，所以Gii应该被配置在<code> config/web.php </code>文件中：</p>
<pre class="brush: php;toolbar:false;">
// ...
if (YII_ENV_DEV)
{
    // 针对‘dev’（开发）环境的配置调整。
    $config['preload'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = 'yii\gii\Module'; // <--- 这儿
}
</pre>
<p>这样，你需要这样来调整 IP 地址：</p>
<pre class="brush: php;toolbar:false;">
if (YII_ENV_DEV)
{
    // 针对‘dev’（开发）环境的配置调整。
    $config['preload'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],
    ];
}
</pre>
<p>&nbsp;</p>
<h2>如何使用Gii</h2>
<p>When you open Gii you first see the entry page that lets you choose a generator.</p>
<p>当你打开Gii时，你会看到这样一个入口界面，可以选择一个生成器（generator）来生成代码段。</p>
<p><img src="http://www.yiiframework.com/doc-2.0/images/gii-entry.png" width="821" height="540" alt="Gii entry page" /></p>
<p>默认有如下的生成器可供选择：</p>
<ul class="task-list">
<li><strong>Model Generator（模型生成器）</strong> - 这个生成器用于基于特定的数据表生成相对应的ActiveRecord（活动记录）类。</li>
<li><strong>CRUD Generator（增删改查生成器）</strong> - 这个生成器会生成一个控制器（Controller）与一系列视图（View） 以提供对某个数据模型基本的增删改查的操作。</li>
<li><strong>Controller Generator（控制器生成器）</strong> - 这个生成器可以帮你快速生成一个全新的控制器类，包括一个或多个 控制器的动作，与这些动作相对应的视图。</li>
<li><strong>Form Generator（表单生成器）</strong> - 这个生成器生成一个视图脚本文件，显示一个表单用以 收集针对某个模型类的用户输入</li>
<li><strong>Module Generator（子模块生成器）</strong> - 这个生成器帮你生成一个Yii 子模块所需的代码骨架。</li>
</ul>
<p>选择一个生成器通过单击"开始"按钮你会看到表单， 它允许您配置生成器的参数。根据您的需要填写完表单，然后按"Preview"（预览）按钮以获取 一个 Gii 马上会生成的代码的一个预览。根据你所选择的生成器和这些文件是否已经存在的不同， 你会看到一个好像下面这个图片所示那样的返回结果：</p>
<p><img src="http://www.yiiframework.com/doc-2.0/images/gii-preview.png" width="821" height="360" alt="Gii preview" /></p>
<p>点击文件名，你会看到即将被生成的这个文件的代码预览。 若文件已经存在，gii 同样会提供一个 diff （英文difference的简写）视图显示了已存在的文件和即将生成的文件的代码对比。 这种状况下，你就可以很方便地选择那些文件会被覆盖，而哪些不会。</p>
<blockquote>
<p>小技巧：当在数据库被修改之后使用Model Generator重新生成模型的时候，你可以从 Gii 的预览中复制那些代码， 并把这些改变与你已有的代码融合。你可以用 IDE 的一些功能来实现这一点，比如PHPStorms所提供的 <a href="http://www.jetbrains.com/phpstorm/webhelp/comparing-files.html" target="_blank">compare with clipboard（英文，与剪贴板作对比）</a>。 他可以帮助你把相关修改合并起来，并把那些可能回滚你原来代码的那些改变跳过。（译者注：相比较PHPStorm强大的功能，其个人许可的费用算是很便宜了。靠PHP吃饭的各位有条件的话应该入正）</p>
</blockquote>
<p>你一讲审查完这些代码了之后，你可以选择需要生产的文件，然后点击 "Generate" 按钮以创建这些文件。 如果一切正常，那么就结束了。如果你看到有错误，提示说gii不能生成那些文件（ gii is not able to generate the files）， 则你只能自己去检查下服务器是否有目录的写权限。</p>
<blockquote>
<p>注意：Gii生成的代码只是一个模版而已，你需要自行修改以满足你的需求。 他只能帮你加速创建新东西的速度，但他不是直接拿来即用的产物。 我们经常看到一些开发者，把 gii生成的模型不加修改，只是简单继承了一下， 然后在继承类里扩展某些功能。这并不是他被设计的初衷。被 Gii 生成的代码可能并不完整或并不正确 并且必须要在使用之前，经过修改，才能符合你的要求。</p>
</blockquote>
<p>&nbsp;</p>
<h2>创建你自己的模板</h2>
<p>每一个生成器都有一个文本框，允许你自己选择用以生成代码的模版。 Gii 默认只提供一套模版，但是你可以创建你自己的模版来调整成你需要的样子。</p>
<p>如果你进入到文件夹<code>@app\vendor\yiisoft\yii2-gii\generators</code>，你会看到6个生成器文件夹：</p>
<ul>
	<li>controller</li>
	<li>curd</li>
	<li>extension</li>
	<li>form</li>
	<li>model</li>
	<li>module</li>
</ul>
<p>在这6个生成器文件夹下，你都会看到有一个名为<code>default</code>的文件夹，<code>default</code>文件夹下面就是模板文件了。 </p>
<p>例如：拷贝文件夹<code>@app\vendor\yiisoft\yii2-gii\generators\crud\default</code>到<code>@app\myTemplates\crud\</code>，现在你可以根据你的喜好任意修改模板文件了。比如：在<code>views\_form.php</code>文件中加入<code>errorSummary</code></p>
<pre class="brush: php;toolbar:false;">
&lt;?php
//...
&lt;div class="&lt;?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    &lt;?= "&lt;?php " ?>$form = ActiveForm::begin(); ?>
    &lt;?= "&lt;?=" ?> $form->errorSummary($model) ?> <!-- 在这里加入 -->
    &lt;?php foreach ($safeAttributes as $attribute) {
        echo "    &lt;?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    } ?>
//..
</pre>
<p>你需要在配置文件中加入以下配置让你修改的模板文件生效：</p>
<pre class="brush: php;toolbar:false;">
// config/web.php for basic app
// ...
if (YII_ENV_DEV) {    
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',      
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],  
        'generators' => [ //在这里加入配置
            'crud' => [ //生成器名称
                'class' => 'yii\gii\generators\crud\Generator', //生成器类名
                'templates' => [ //setting for out templates
                    'myCrud' => '@app\myTemplates\crud\default', //模板名称 => 模板路径
                ]
            ]
        ],
    ];
}
</pre>
<p>再次进入CRUD生成器你会在<p>Code Template</p>栏位看到你新建的模板。</p>
<p>&nbsp;</p>
<h2>创建你自己的生成器</h2>
<p>打开任意生成器文件夹，你会看到两个文件<code>form.php</code>和<code>Generator.php</code>。一个是表单，一个是生成器类文件。为了创建你自己的生成器，你需要在任意文件夹下新建或者覆盖这些类文件。重复上述的自定义模板配置过程。</p>
<pre class="brush: php;toolbar:false;">
//config/web.php for basic app
//..
if (YII_ENV_DEV) {    
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',      
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],  
         'generators' => [
            'myCrud' => [
                'class' => 'app\myTemplates\crud\Generator',
                'templates' => [
                    'my' => '@app/myTemplates/crud/default',
                ]
            ]
        ],
    ];
}
</pre>
<pre class="brush: php;toolbar:false;">
// @app/myTemplates/crud/Generator.php
&lt;?php
namespace app\myTemplates\crud;

class Generator extends \yii\gii\Generator
{
    public function getName()
    {
        return 'MY CRUD Generator';
    }

    public function getDescription()
    {
        return 'My crud generator. 生成器的说明...';
    }
    
    // ...
}
</pre>
<p>打开Gii，你会看到一个你新建的生成器。</p>
<blockquote>
<p>Yii2使用Gii图文教程，参见我的博文：<a href="http://www.xlbd.net/xlbd/2059.html" target="_blank">Yii2 快速生成代码工具 Gii 的使用</a></p>
</blockquote>
