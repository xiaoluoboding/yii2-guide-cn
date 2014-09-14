<h1>创建表单</h1>
<p>在Yii中使用表单主要是通过  [[yii\widgets\ActiveForm]] 这个类完成的。这种途径在当表单是建立在模型之上时特别被优先使用。 在 [[yii\helpers\Html]] 中有一些有用的方法来在表单中增加按钮和处理文本。</p>
<p>当创建基于模型的表单时，第一个步骤是定义模型本身。这个模型可以是建立在<code> Active Record </code>类之上, 也可以是建立在其它很多的通用模型类之上。下面这个“登录”的例子，用到了一个通用的模型:</p>
<pre class="brush: php;toolbar:false;">
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    /**
     * @return 数组中的验证规则。
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * 验证密码.
     * 这种方法可作为内嵌的验证密码。
     */
    public function validatePassword()
    {
        $user = User::findByUsername($this->username);
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Incorrect username or password.');
        }
    }

    /**
     * 使用提供的用户名和密码登录的用户。
     * @return 当用户成功登录返回布尔类型 。
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::findByUsername($this->username);
            return true;
        } else {
            return false;
        }
    }
}
</pre>
<p>控制器会传递这个模型的实例到用到<code> Active Form widget </code>小部件的视图中去:</p>
<pre class="brush: php;toolbar:false;">
use yii\helpers\Html;
use yii\widgets\ActiveForm;

&lt;?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    &lt;?= $form->field($model, 'username') ?>
    &lt;?= $form->field($model, 'password')->passwordInput() ?>

    &lt;div class="form-group">
        &lt;div class="col-lg-offset-1 col-lg-11">
            &lt;?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
        &lt;/div>
    &lt;/div>
 ActiveForm::end() ?>
</pre>
<p>在上面的代码中, [[ActiveForm::begin()]] 不仅仅是创建了一个表单实例, 同时注标了表单的开始位置。所有位于[[ActiveForm::begin()]] 和 [[ActiveForm::end()]] 中间的将包裹在<code>&lt;form&gt;</code>标签之中. 像在任何widget界面组件中的那样, 你可以通过传递一个数组到 <code>begin</code> 方法来对widget界面组件中进行一些指定选项的配置。在这个例子中，一个额外的CSS类和识别ID被传递并使用在<code>&lt;form&gt;</code>标签上.</p>
<p>Active Form widget小部件中的 [[ActiveForm::field()]] 方法用于<span id="result_box" class="short_text" lang="zh-CN"><span class="">在</span><span class="">表单中创建</span>一个表单元素，以及元素的标签和<span class="">应用</span><span class="">的JavaScript</span><span class="">验证</span></span>。<span id="result_box" class="short_text" lang="zh-CN"><span class="">当这个方法</span>的调用是直接回应的时候，其结果是一个普通的（<span class="">文本</span><span class="">）</span><span class="">输入</span><span class="">。如果要</span><span class="">自定义的输出</span><span class="">，</span><span class="">您可以串联</span><span class="">其他方法到这个</span><span class="">调用</span></span>:</p>
<pre class="brush: php;toolbar:false;">
&lt;?= $form->field($model, 'password')->passwordInput() ?>

// or

&lt;?= $form->field($model, 'username')->textInput()->hint('Please enter your name')->label('Name') ?>
</pre>
<p>这个将创建所有的 <code>&lt;label&gt;</code>, <code>&lt;input&gt;</code> 和其它<span id="result_box" class="short_text" lang="zh-CN"><span class="">根据</span><span class="">由表单</span><span class="">字段来定义的</span><span class="">标签。</span></span> 你可以使用<code>Html</code> 帮助类来自己添加这些标签。</p>
<p>如果你要使用HTML5的字段，你可以像下面这样直接指定输入类型：</p>
<pre class="brush: php;toolbar:false;">
&lt;?= $form->field($model, 'email')->input('email') ?>
</pre>
<blockquote>
<p><strong>提示</strong>: 为了给加"*"号的必填字段加样式，你可以用以下CSS:</p>
<pre class="brush: php;toolbar:false;">
div.required label:after {
    content: " *";
    color: red;
}
</pre>
</blockquote>
<p>&nbsp;</p>
<h2>在单个表单中使用多个模型</h2>
<p>有时候你需要在单个表单中使用多个模型，举个例子： <code>Setting</code> 模型表现有多项设置并且每项设置被保存为name-value(名称-值)的形式。下面展示了怎样用过Yii来实现。</p>
<p>让我们从控制器的动作开始：</p>
<pre class="brush: php;toolbar:false;">
namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use app\models\Setting;

class SettingsController extends Controller
{
    // ...

    public function actionUpdate()
    {
        $settings = Setting::find()->indexBy('id')->all();

        if (Model::loadMultiple($settings, Yii::$app->request->post()) && Model::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                $setting->save(false);
            }

            return $this->redirect('index');
        }

        return $this->render('update', ['settings' => $settings]);
    }
}
</pre>
<p>在上面的代码中我们在从数据库检索模型来生成模型ID索引数组时用了 <code>indexBy</code> 。这些在后面将被用于识别表单区域。<code>loadMultiple</code> 用了从POST传递过来的数据填写了多个模型，<code>validateMultiple</code> 一次性验证了所有模型。在保存过程中跳过验证时将传递 <code>false</code> 参数到 <code>save</code>。</p>
<p>现在中在 <code>update</code> 视图的Form中：</p>
<pre class="brush: php;toolbar:false;">
&lt;?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

foreach ($settings as $index => $setting) {
    echo Html::encode($setting->name) . ': ' . $form->field($setting, "[$index]value");
}

ActiveForm::end();
</pre>
<p>我们在这里为每一条设置都渲染了输入名称和赋了值的输入框。 给输入名称添加一个适应的索引很重要是因为 <code>loadMultiple</code> 是这样来定义哪个模型是填充哪些值的。</p>
