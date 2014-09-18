<h1>输入验证</h1>
<p>一般来说，程序猿永远不应该信任从最终用户直接接收到的数据，并且使用它们之前应始终先验证其可靠性。</p>
<p>要给<a href="0307.html"> model </a>填充其所需的用户输入数据，你可以调用 [[yii\base\Model::validate()]] 方法验证它们。该方法会返回一个布尔值，指明是否通过验证。若没有通过，你能通过 [[yii\base\Model::errors]] 属性获取相应的报错信息。比如，</p>
<pre class="brush: php;toolbar:false;">
$model = new \app\models\ContactForm;

// 用用户输入来填充模型的特性
$model->attributes = \Yii::$app->request->post('ContactForm');

if ($model->validate()) {
    // 若所有输入都是有效的
} else {
    // 有效性验证失败：$errors 属性就是存储错误信息的数组
    $errors = $model->errors;
}
</pre>
<p><code>validate()</code>方法，在幕后为执行验证操作，进行了以下步骤：</p>
<ul>
	<li style="list-style: decimal;">通过从 [[yii\base\Model::scenarios()]] 方法返回基于当前 [[yii\base\Model::scenario|场景（scenario）]] 的特性属性列表，算出哪些特性应该进行有效性验证。这些属性被称作 active attributes（激活特性）。</li>
	<li style="list-style: decimal;">通过从 [[yii\base\Model::rules()]] 方法返回基于当前 [[yii\base\Model::scenario|场景（scenario）]] 的验证规则列表，这些规则被称作 active rules（激活规则）。</li>
	<li style="list-style: decimal;">用每个激活规则去验证每个与之关联的激活特性。若失败，则记录下对应模型特性的错误信息。</li>
</ul>
<p>&nbsp;</p><h2>声明规则（Rules）</h2>
<p>要让<code>validate()</code>方法起作用，你需要声明与需验证模型特性相关的验证规则。为此，需要重写 [[yii\base\Model::rules()]] 方法。下面的例子展示了如何声明用于验证<code>ContactForm</code>模型的相关验证规则：</p>
<pre class="brush: php;toolbar:false;">
public function rules()
{
    return [
        // name，email，subject 和 body 特性是 `require`（必填）的
        [['name', 'email', 'subject', 'body'], 'required'],

        // email 特性必须是一个有效的 email 地址
        ['email', 'email'],
    ];
}
</pre>
<p>[[yii\base\Model::rules()|rules()]] 方法应返回一个由规则所组成的数组，每一个规则都呈现为以下这类格式的小数组：</p>
<pre class="brush: php;toolbar:false;">
[
    // 必须项，用于指定那些模型特性需要通过此规则的验证。
    // 对于只有一个特性的情况，可以直接写特性名，而不必用数组包裹。
    ['attribute1', 'attribute2', ...],

    // 必填项，用于指定规则的类型。
    // 它可以是类名，验证器昵称，或者是验证方法的名称。
    'validator',

    // 可选项，用于指定在场景（scenario）中，需要启用该规则
    // 若不提供，则代表该规则适用于所有场景
    // 若你需要提供除了某些特定场景以外的所有其他场景，你也可以配置 "except" 选项
    'on' => ['scenario1', 'scenario2', ...],

    // 可选项，用于指定对该验证器对象的其他配置选项
    'property1' => 'value1', 'property2' => 'value2', ...
]
</pre>
<p>对于每个规则，你至少需要指定该规则适用于哪些特性，以及本规则的类型是什么。你可以指定以下的规则类型之一：</p>
<ul>
	<li>核心验证器的昵称，比如<code>required</code>、<code>in</code>、<code>date</code>，等等。请参考<a href="1404.html">核心验证器</a>章节查看完整的核心验证器列表。</li>
	<li>模型类中的某个验证方法的名称，或者一个匿名方法。请参考行内验证器小节了解更多。</li>
	<li>验证器类的名称。请参考本章独立验证器小节了解更多。</li>
</ul>
<p>一个规则可用于验证一个或多个模型特性，且一个特性可以被一个或多个规则所验证。一个规则可以施用于特定<a href="0307.html">场景（scenario）</a>，只要指定<code>on</code>选项。如果你不指定<code>on</code>选项，那么该规则会适配于所有场景。</p>
<p>当调用<code>validate()</code>方法时，它将运行以下几个具体的验证步骤：</p>
<ul>
	<li style="list-style: decimal;">检查从声明自 [[yii\base\Model::scenarios()]] 方法的场景中所挑选出的当前[[yii\base\Model::scenario|场景]]的信息，从而确定出那些特性需要被验证。这些特性被称为激活特性。</li>
	<li style="list-style: decimal;">检查从声明自 [[yii\base\Model::rules()]] 方法的众多规则中所挑选出的适用于当前[[yii\base\Model::scenario|场景]]的规则，从而确定出需要验证哪些规则。这些规则被称为激活规则。</li>
	<li style="list-style: decimal;">用每个激活规则去验证每个与之关联的激活特性。</li>
</ul>
<p>基于以上验证步骤，有且仅有声明在<code>scenarios()</code>方法里的激活特性，且它还必须与一或多个声明自<code>rules()</code>里的激活规则相关联才会被验证。</p>
<p>&nbsp;</p><h3>自定义错误信息</h3>
<p>大多数的验证器都有默认的错误信息，当模型的某个特性验证失败的时候，该错误信息会被返回给模型。比如，用 [[yii\validators\RequiredValidator|required]] 验证器的规则检验 username 特性失败的话，会返还给模型 "Username cannot be blank." 信息。</p>
<p>你可以通过在声明规则的时候同时指定 message 属性，来定制某个规则的错误信息，比如这样：</p>
<pre class="brush: php;toolbar:false;">
public function rules()
{
    return [
        ['username', 'required', 'message' => 'Please choose a username.'],
    ];
}
</pre>
<p>一些验证器还支持用于针对不同原因的验证失败返回更加准确的额外错误信息。比如：[[yii\validators\NumberValidator|number]] 验证器就支持 [[yii\validators\NumberValidator::tooBig|tooBig]] 和 [[yii\validators\NumberValidator::tooSmall|tooSmall]] 两种错误消息用于分别返回输入值是太大还是太小。 你也可以像配置验证器的其他属性一样配置它们俩各自的错误信息。</p>
<p>&nbsp;</p><h3>验证事件</h3>
<p>当调用 [[yii\base\Model::validate()]] 方法的过程里，它同时会调用两个特殊的方法，把它们重写掉可以实现自定义验证过程的目的：</p>
<ul>
	<li>[[yii\base\Model::beforeValidate()]]：在默认的实现中会触发 [[yii\base\Model::EVENT_BEFORE_VALIDATE]] 事件。你可以重写该方法或者响应此事件，来在验证开始之前，先进行一些预处理的工作。（比如，标准化数据输入）该方法应该返回一个布尔值，用于标明验证是否通过。</li>
	<li>[[yii\base\Model::afterValidate()]]：在默认的实现中会触发 [[yii\base\Model::EVENT_AFTER_VALIDATE]] 事件。你可以重写该方法或者响应此事件，来在验证结束之后，再进行一些收尾的工作。</li>
</ul>
<p>&nbsp;</p><h3>条件式验证</h3>
<p>若要只在某些条件满足时，才验证相关特性，比如：是否验证某特性取决于另一特性的值，你可以通过 [[yii\validators\Validator::when|when]] 属性来定义相关条件。举例而言，</p>
<pre class="brush: php;toolbar:false;">
[
    ['state', 'required', 'when' => function($model) {
        return $model->country == 'USA';
    }],
]
</pre>
<p>[[yii\validators\Validator::when|when]] 属性会读入一个如下所示结构的 PHP callable 函数对象：</p>
<pre class="brush: php;toolbar:false;">
/**
 * @param Model $model 要验证的模型对象
 * @param string $attribute 待测特性名
 * @return boolean 返回是否启用该规则
 */
function ($model, $attribute)
</pre>
<p>若你需要支持客户端的条件验证，你应该配置 [[yii\validators\Validator::whenClient|whenClient]] 属性，它会读入一条包含有 JavaScript 函数的字符串。这个函数将被用于确定该客户端验证规则是否被启用。比如，</p>
<pre class="brush: php;toolbar:false;">
[
    ['state', 'required', 'when' => function ($model) {
        return $model->country == 'USA';
    }, 'whenClient' => "function (attribute, value) {
        return $('#country').value == 'USA';
    }"],
]
</pre>
<p>&nbsp;</p><h3>数据预处理</h3>
<p>用户输入经常需要进行数据过滤，或者叫预处理。比如你可能会需要先去掉<code>username</code>输入的收尾空格。你可以通过使用验证规则来实现此目的。</p>
<p>下面的例子展示了如何去掉输入信息的首尾空格，并将空输入返回为 null。具体方法为通过调用<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/tutorial-core-validators.md#trim" target="_blank"> trim </a>和<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/tutorial-core-validators.md#default" target="_blank"> default </a> 核心验证器：</p>
<pre class="brush: php;toolbar:false;">
[
    [['username', 'email'], 'trim'],
    [['username', 'email'], 'default'],
]
</pre>
<p>也还可以用更加通用的 <code>filter</code>（过滤器） <a href="1404.html"> 核心验证器 </a>来执行更加复杂的数据过滤。</p>
<p>如你所见，这些验证规则并不真的对输入数据进行任何验证。而是，对输入数据进行一些处理，然后把它们存回当前被验证的模型特性。</p>
<p>&nbsp;</p><h3>处理空输入</h3>
<p>当输入数据是通过 HTML 表单，你经常会需要给空的输入项赋默认值。你可以通过调整 <a href="1404.html"> default </a>验证器来实现这一点。举例来说，</p>
<pre class="brush: php;toolbar:false;">
[
    // 若 "username" 和 "email" 为空，则设为 null
    [['username', 'email'], 'default'],

    // 若 "level" 为空，则设其为 1
    ['level', 'default', 'value' => 1],
]
</pre>
<p>默认情况下，当输入项为空字符串，空数组，或 null 时，会被视为“空值”。你也可以通过配置 [[yii\validators\Validator::isEmpty]] 属性来自定义空值的判定规则。比如，</p>
<pre class="brush: php;toolbar:false;">
[
    ['agree', 'required', 'isEmpty' => function ($value) {
        return empty($value);
    }],
]
</pre>
<blockquote>
	<p>注意：对于绝大多数验证器而言，若其 [[yii\base\Validator::skipOnEmpty]] 属性为默认值 true，则它们不会对空值进行任何处理。也就是当他们的关联特性接收到空值时，相关验证会被直接略过。在<a href="1404.html"> 核心验证器 </a>之中，只有 <code>captcha</code>（验证码），<code>default</code>（默认值），<code>filter</code>（过滤器），<code>required</code>（必填），以及 <code>trim</code>（去首尾空格），这几个验证器会处理空输入。</p>
</blockquote>
<p>&nbsp;</p><h2>临时验证</h2>
<p>有时，你需要对某些没有绑定任何模型类的值进行<strong> 临时验证</strong>。</p>
<p>若你只需要进行一种类型的验证 (e.g. 验证邮箱地址)，你可以调用所需验证器的 [[yii\validators\Validator::validate()|validate()]] 方法。像这样：</p>
<pre class="brush: php;toolbar:false;">
$email = 'test@example.com';
$validator = new yii\validators\EmailValidator();

if ($validator->validate($email, $error)) {
    echo '有效的 Email 地址。';
} else {
    echo $error;
}
</pre>
<blockquote>
	<p>注意：不是所有的验证器都支持这种形式的验证。比如 unique（唯一性）核心验证器就就是一个例子，它的设计初衷就是只作用于模型类内部的。</p>
</blockquote>
<p>若你需要针对一系列值执行多项验证，你可以使用 [[yii\base\DynamicModel]] 。它支持即时添加特性和验证规则的定义。它的使用规则是这样的：</p>
<pre class="brush: php;toolbar:false;">
public function actionSearch($name, $email)
{
    $model = DynamicModel::validateData(compact('name', 'email'), [
        [['name', 'email'], 'string', 'max' => 128],
        ['email', 'email'],
    ]);

    if ($model->hasErrors()) {
        // 验证失败
    } else {
        // 验证成功
    }
}
</pre>
<p>[[yii\base\DynamicModel::validateData()]] 方法会创建一个<code>DynamicModel</code>的实例对象，并通过给定数据定义模型特性（以<code>name</code>和<code>email</code>为例），之后用给定规则调用 [[yii\base\Model::validate()]] 方法。</p>
<p>除此之外呢，你也可以用如下的更加“传统”的语法来执行临时数据验证：</p>
<pre class="brush: php;toolbar:false;">
public function actionSearch($name, $email)
{
    $model = new DynamicModel(compact('name', 'email'));
    $model->addRule(['name', 'email'], 'string', ['max' => 128])
        ->addRule('email', 'email')
        ->validate();

    if ($model->hasErrors()) {
        // 验证失败
    } else {
        // 验证成功
    }
}
</pre>
<p>验证之后你可以通过调用 [[yii\base\DynamicModel::hasErrors()|hasErrors()]] 方法来检查验证通过与否，并通过 [[yii\base\DynamicModel::errors|errors]] 属性获得验证的错误信息，过程与普通模型类一致。你也可以访问模型对象内定义的动态特性，就像： <code>$model->name</code>和<code>$model->email</code>。</p>
<p>&nbsp;</p><h2>创建验证器（Validators）</h2>
<p>除了使用 Yii 的发布版里所包含的核心验证器之外，你也可以创建你自己的验证器。自定义的验证器可以是<strong>行内验证器</strong>，也可以是<strong>独立验证器</strong>。</p>
<p>&nbsp;</p><h3>行内验证器</h3>
<p>行内验证器是一种以模型方法或匿名函数的形式定义的验证器。这些方法/函数的结构如下：</p>
<pre class="brush: php;toolbar:false;">
/**
 * @param string $attribute 当前被验证的特性
 * @param array $params 以名-值对形式提供的额外参数
 */
function ($attribute, $params)
</pre>
<p>若某特性的验证失败了，该方法/函数应该调用 [[yii\base\Model::addError()]] 保存错误信息到模型内。这样这些错误就能在之后的操作中，被读取并展现给终端用户</p>
<p>下面是一些例子：</p>
<pre class="brush: php;toolbar:false;">
use yii\base\Model;

class MyForm extends Model
{
    public $country;
    public $token;

    public function rules()
    {
        return [
            // 以模型方法 validateCountry() 形式定义的行内验证器
            ['country', 'validateCountry'],

            // 以匿名函数形式定义的行内验证器
            ['token', function ($attribute, $params) {
                if (!ctype_alnum($this->$attribute)) {
                    $this->addError($attribute, '令牌本身必须包含字母或数字。');
                }
            }],
        ];
    }

    public function validateCountry($attribute, $params)
    {
        if (!in_array($this->$attribute, ['兲朝', '墙外'])) {
            $this->addError($attribute, '国家必须为 "兲朝" 或 "墙外" 中的一个。');
        }
    }
}
</pre>
<blockquote>
	<p>注意：缺省状态下，行内验证器不会在关联特性的输入值为空或该特性已经在其他验证中失败的情况下起效。若你想要确保该验证器始终启用的话，你可以在定义规则时，酌情将 [[yii\validators\Validator::skipOnEmpty|skipOnEmpty]] 以及 [[yii\validators\Validator::skipOnError|skipOnError]] 属性设为 false，比如，</p>
	<pre class="brush: php;toolbar:false;">
	[
	    ['country', 'validateCountry', 'skipOnEmpty' => false, 'skipOnError' => false],
	]
	</pre>
</blockquote>
<p>&nbsp;</p><h3>独立验证器（Standalone Validators）</h3>
<p>独立验证器是继承自 [[yii\validators\Validator]] 或其子类的类。你可以通过重写 [[yii\validators\Validator::validateAttribute()]] 来实现它的验证规则。若特性验证失败，可以调用 [[yii\base\Model::addError()]] 以保存错误信息到模型内，操作与 inline validators 所需操作完全一样。比如，</p>
<pre class="brush: php;toolbar:false;">
namespace app\components;

use yii\validators\Validator;

class CountryValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (!in_array($model->$attribute, ['兲朝', '墙外'])) {
            $this->addError($attribute, '国家必须为 "兲朝" 或 "墙外" 中的一个。');
        }
    }
}
</pre>
<p>若你想要验证器支持不使用 model 的数据验证，你还应该重写 [[yii\validators\Validator::validate()]] 方法。你也可以通过重写 [[yii\validators\Validator::validateValue()]] 方法替代<code>validateAttribute()</code>和<code>validate()</code>，因为默认状态下，后两者的实现使用过调用<code>validateValue()</code>实现的。</p>
<p>&nbsp;</p><h2>客户端验证器（Client-Side Validation）</h2>
<p>当终端用户通过 HTML 表单提供相关输入信息时，我们可能会需要用到基于 JavaScript 的客户端验证。因为，它可以让用户更快速的得到错误信息，也因此可以提供更好的用户体验。你可以使用或自己实现除服务器端验证之外，<strong>还能额外</strong>客户端验证功能的验证器。</p>
<blockquote>
	<p>补充：尽管客户端验证为加分项，但它不是必须项。它存在的主要意义在于给用户提供更好的客户体验。正如“永远不要相信来自终端用户的输入信息”，也同样永远不要相信客户端验证。基于这个理由，你应该始终如前文所描述的那样，通过调用 [[yii\base\Model::validate()]] 方法执行服务器端验证。</p>
</blockquote>
<p>&nbsp;</p><h3>使用客户端验证</h3>
<p>许多<a href="1404.html"> 核心验证器 </a>都支持开箱即用的客户端验证。你只需要用 [[yii\widgets\ActiveForm]] 的方式构建 HTML 表单即可。比如，下面的<code>LoginForm</code>（登录表单）声明了两个规则：其一为<code>required</code>核心验证器，它同时支持客户端与服务器端的验证；另一个则采用<code>validatePassword</code>行内验证器，它只支持服务器端。</p>
<pre class="brush: php;toolbar:false;">
namespace app\models;

use yii\base\Model;
use app\models\User;

class LoginForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            // username 和 password 都是必填项
            [['username', 'password'], 'required'],

            // 用 validatePassword() 验证 password
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword()
    {
        $user = User::findByUsername($this->username);

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Incorrect username or password.');
        }
    }
}
</pre>
<p>使用如下代码构建的 HTML 表单包含两个输入框<code>username</code>以及<code>password</code>。如果你在没有输入任何东西之前提交表单，就会在没有任何与服务器端的通讯的情况下，立刻收到一个要求你填写空白项的错误信息。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php $form = yii\widgets\ActiveForm::begin(); ?>
    &lt;?= $form->field($model, 'username') ?>
    &lt;?= $form->field($model, 'password')->passwordInput() ?>
    &lt;?= Html::submitButton('Login') ?>
&lt;?php yii\widgets\ActiveForm::end(); ?>
</pre>
<p>幕后的运作过程是这样的：[[yii\widgets\ActiveForm]] 会读取声明在模型类中的验证规则，并生成那些支持支持客户端验证的验证器所需的 JavaScript 代码。当用户修改输入框的值，或者提交表单时，就会触发相应的客户端验证 JS 代码。</p>
<p>若你需要完全关闭客户端验证，你只需配置 [[yii\widgets\ActiveForm::enableClientValidation]] 属性为 false。你同样可以关闭各个输入框各自的客户端验证，只要把它们的 [[yii\widgets\ActiveField::enableClientValidation]] 属性设为 false。</p>
<p>&nbsp;</p><h3>实现自己的客户端验证</h3>
<p>要穿件一个支持客户端验证的验证器，你需要实现 [[yii\validators\Validator::clientValidateAttribute()]] 方法，用于返回一段用于运行客户端验证的 JavaScript 代码。在这段 JavaScript 代码中，你可以使用以下预定义的变量：</p>
<ul>
	<li><code>attribute</code>：正在被验证的模型特性的名称。</li>
	<li><code>value</code>：进行验证的值。</li>
	<li><code>messages</code>：一个用于暂存模型特性的报错信息的数组。</li>
</ul>
<p>在下面的例子里，我们会创建一个<code>StatusValidator</code>，它会通过比对现有的状态数据，验证输入值是否为一个有效的状态。该验证器同时支持客户端以及服务器端验证。</p>
<pre class="brush: php;toolbar:false;">
namespace app\components;

use yii\validators\Validator;
use app\models\Status;

class StatusValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = '无效的状态输入。';
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (!Status::find()->where(['id' => $value])->exists()) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $statuses = json_encode(Status::find()->select('id')->asArray()->column());
        $message = json_encode($this->message);
        return &lt;&lt;&lt;JS
if (!$.inArray(value, $statuses)) {
    messages.push($message);
}
JS;
    }
}
</pre>
<blockquote>
	<p>技巧：上述代码主要是演示了如何支持客户端验证。在具体实践中，你可以使用 in 核心验证器来达到同样的目的。比如这样的验证规则：</p>
	<pre class="brush: php;toolbar:false;">
	[
    	['status', 'in', 'range' => Status::find()->select('id')->asArray()->column()],
	]
	</pre>
</blockquote>

