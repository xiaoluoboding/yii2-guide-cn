<h1>使用表单</h1>
<p>本章节将介绍如何创建一个从用户那搜集数据的表单页。该页将显示一个包含<code>name</code>输入框和<code>email</code>输入框的表单。当搜集完这两部分信息后，页面将会显示用户输入的信息。</p>
<p>为了实现这个目标，除了创建一个<a href="0305.html">动作</a>和两个<a href="0306.html">视图</a>外，还需要创建一个<a href="0307.html">模型</a>。</p>
<p>贯穿整个小节，你将会学到：</p>
<ul>
	<li>创建一个<a href="0307.html">模型</a>代表用户通过表单输入的数据</li>
	<li>声明规则去验证输入的数据</li>
	<li>在<a href="0306.html">视图</a>中生成一个 HTML 表单</li>
</ul>
<p>&nbsp;</p><h2>创建模型</h2><hr>
<p>模型类<code>EntryForm</code>代表从用户那请求的数据，该类如下所示并存储在<code>models/EntryForm.php</code>文件中。请参考<a href="">类自动加载</a>章节获取更多关于类命名约定的介绍。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php

namespace app\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}
</pre>
<p>该类继承自 [[yii\base\Model]]，Yii 提供的一个基类，通常用来表示数据。</p>
<blockquote>
	<p>补充：[[yii\base\Model]] 被用于普通模型类的父类并与数据表无关。[[yii\db\ActiveRecord]] 通常是普通模型类的父类但与数据表有关联（译者注：[[yii\db\ActiveRecord]] 类其实也是继承自 [[yii\base\Model]]，增加了数据库处理）。</p>
</blockquote>
<p><code>EntryForm</code>类包含<code>name</code>和<code>email</code>两个公共成员，用来储存用户输入的数据。它还包含一个名为<code>rules()</code>的方法，用来返回数据验证规则的集合。上面声明的验证规则表示：</p>
<ul>
	<li><code>name</code>和<code>email</code>值都是必须的</li>
	<li><code>email</code>的值必须满足 email 地址验证</li>
</ul>
<p>如果你有一个从用户那搜集数据的<code>EntryForm</code>对象，你可以调用它的 [[yii\base\Model::validate()|validate()]] 方法触发数据验证。如果有数据验证失败，将把 [[yii\base\Model::hasErrors|hasErrors]] 属性设为 ture，想要知道具体发生什么错误就调用 [[yii\base\Model::getErrors|getErrors]]。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php
$model = new EntryForm();
$model->name = 'Qiang';
$model->email = 'bad';
if ($model->validate()) {
    // 验证成功！
} else {
    // 失败！
    // 使用 $model->getErrors() 获取错误详情
}
</pre>
<p>&nbsp;</p><h2>创建动作</h2><hr>
<p>下面你得在<code>site</code>控制器中创建一个<code>entry</code>动作用于新建的模型。动作的创建和使用已经在<a href="0203.html">说声 Hello</a>小节中解释了。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\EntryForm;

class SiteController extends Controller
{
    // ...其它代码...

    public function actionEntry()
    {
        $model = new EntryForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据

            // 做些有意义的事 ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // 无论是初始化显示还是数据验证错误
            return $this->render('entry', ['model' => $model]);
        }
    }
}
</pre>
<p>该动作首先创建了一个<code>EntryForm</code>对象。然后尝试从<code>$_POST</code>搜集用户提交的数据，由 Yii 的 [[yii\web\Request::post()]] 方法负责搜集。如果模型被成功填充数据（也就是说用户已经提交了 HTML 表单），动作将调用 [[yii\base\Model::validate()|validate()]] 去确保用户提交的是有效数据。</p>
<blockquote>
	<p>补充：表达式 Yii::$app 代表应用实例，它是一个全局可访问的单例。同时它也是一个<a href="0508.html">服务定位器</a>，能提供<code>request</code>，response，db 等等特定功能的组件。在上面的代码里就是使用<code>request</code>组件来访问应用实例收到的<code>$_POST</code>数据。</p>
</blockquote>
<p>用户提交表单后，动作将会渲染一个名为<code>entry-confirm</code>的视图去确认用户输入的数据。如果没填表单就提交，或数据包含错误（译者：如 email 格式不对），<code>entry</code>视图将会渲染输出，连同表单一起输出的还有验证错误的详细信息</p>
<blockquote>
	<p>注意：在这个简单例子里我们只是呈现了有效数据的确认页面。实践中你应该考虑使用 [[yii\web\Controller::refresh()|refresh()]] 或 [[yii\web\Controller::redirect()|redirect()]] 去避免表单重复提交问题。</p>
</blockquote>
<p>&nbsp;</p><h2>创建视图</h2><hr>
<p>最后创建两个视图文件<code>entry-confirm</code>和<code>entry</code>。他们会被刚才创建的<code>entry</code>动作渲染。</p>
<p><code>entry-confirm</code>视图简单地显示提交的<code>name</code>和<code>email</code>数据。视图文件保存在<code>views/site/entry-confirm.php</code>。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php
use yii\helpers\Html;
?>
&lt;p>You have entered the following information:&lt;/p>

&lt;ul>
    &lt;li>&lt;label>Name&lt;/label>: &lt;?= Html::encode($model->name) ?>&lt;/li>
    &lt;li>&lt;label>Email&lt;/label>: &lt;?= Html::encode($model->email) ?>&lt;/li>
&lt;/ul>
</pre>
<p><code>entry</code>视图显示一个 HTML 表单。视图文件保存在<code>views/site/entry.php</code>。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
&lt;?php $form = ActiveForm::begin(); ?>

    &lt;?= $form->field($model, 'name') ?>

    &lt;?= $form->field($model, 'email') ?>

    &lt;div class="form-group">
        &lt;?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    &lt;/div>

&lt;?php ActiveForm::end(); ?>
</pre>
<p>视图使用了一个功能强大的<a href="0309.html">小部件 </a>[[yii\widgets\ActiveForm|ActiveForm]] 去生成 HTML 表单。其中的<code>begin()</code>和<code>end()</code>分别用来渲染表单的开始和关闭标签。在这两个方法之间使用了 [[yii\widgets\ActiveForm::field()|field()]] 方法去创建输入框。第一个输入框用于 “name”，第二个输入框用于 “email”。之后使用 [[yii\helpers\Html::submitButton()]] 方法生成提交按钮。</p>
<p>&nbsp;</p><h2>尝试一下</h2><hr>
<p>用浏览器访问下面的 URL 看它能否工作：</p>
<pre class="brush: php;toolbar:false;">
http://hostname/index.php?r=site/entry
</pre>
<p>你会看到一个包含两个输入框的表单的页面。每个输入框的前面都有一个标签指明应该输入的数据类型。如果什么都不填就点击提交按钮，或填入格式不正确的 email 地址，将会看到在对应的输入框下显示错误信息。</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-form-validation.png" alt="form-validation"  width="800" height="600" /></p>
<p>输入有效的<code>name</code>和<code>email</code>信息并提交后，将会看到一个显示你所提交数据的确认页面。</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-entry-confirmation.png" alt="entry-confirm"  width="800" height="600" /></p>
<p>&nbsp;</p><h2>效果说明</h2><hr>
<p>你可能会好奇 HTML 表单暗地里是如何工作的呢，看起来它可以为每个输入框显示文字标签，而当你没输入正确的信息时又不需要刷新页面就能给出错误提示，似乎有些神奇。</p>
<p>是的，其实数据首先由客户端 JavaScript 脚本验证，然后才会提交给服务器通过 PHP 验证。[[yii\widgets\ActiveForm]] 足够智能到把你在<code>EntryForm</code>模型中声明的验证规则转化成客户端 JavaScript 脚本去执行验证。如果用户浏览器禁用了 JavaScript， 服务器端仍然会像<code>actionEntry()</code>方法里这样验证一遍数据。这保证了任何情况下用户提交的数据都是有效的。</p>
<blockquote>
	<p>警告：客户端验证是提高用户体验的手段。无论它是否正常启用，服务端验证则都是必须的，请不要忽略它。</p>
</blockquote>
<p>输入框的文字标签是<code>field()</code>方法生成的，内容就是模型中该数据的属性名。例如模型中的<code>name</code>属性生成的标签就是<code>Name</code>。</p>
<p>你可以在视图中自定义标签：</p>
<pre class="brush: php;toolbar:false;">
&lt;?= $form->field($model, 'name')->label('自定义 Name') ?>
&lt;?= $form->field($model, 'email')->label('自定义 Email') ?>
</pre>
<blockquote>
	<p>补充：Yii 提供了相当多类似的小部件去帮你生成复杂且动态的视图。在后面你还会了解到自己写小部件是多么简单。你可能会把自己的很多视图代码转化成小部件以提高重用，加快开发效率。</p>
</blockquote>
<p>&nbsp;</p><h2>总结</h2><hr>
<p>本章节指南中你接触了 MVC 设计模式的每个部分。学到了如何创建一个模型代表用户数据并验证它的有效性。</p>
<p>你还学到了如何从用户那获取数据并在浏览器上回显给用户。这本来是开发应用的过程中比较耗时的任务，好在 Yii 提供了强大的小部件让它变得如此简单。</p>
<p>下一章你将学习如何<a href="0205.html">使用数据库</a>，几乎每个应用都需要数据库。</p>



