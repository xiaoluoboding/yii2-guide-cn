<h1>模型</h1>
<p>Yii遵循MVC设计结构，在Yii中模型的作用是存储或表示应用暂存的数据。Yii模型有以下基本特征：</p>
<ul>
	<li>特性定义：模型定义了什么看作特性。</li>
	<li>特性标签：出于显示目的每个特性可能和一个标签关联。</li>
	<li>批量填充特性：一次填充多个模型特性的能力。</li>
	<li>基于场景的数据校验。</li>
</ul>
<p>Yii 的模型继承自[[yii\base\Model]]类。模型通常用来保持数据何定义数据的验证规则（又称为业务逻辑）。业务逻辑通过提供验证和错误报告极大地简化了 从复杂 web 表单到生成模型的过程。</p>
<p>模型类也是更多多功能高级模型的基类，如<a href="0603.html">活动记录Active Record</a>。</p>
<p>&nbsp;</p>
<h2>属性</h2>
<p>模型所代表的实际数据保存在属性 <em>attributes </em>中。模型属性可以像任意对象的成员变量一样来访问。比如，一个 <code>Post</code> 模型可能包含一个 <code>title</code> 属性和一个 <code>content</code> 属性，访问方法如下：</p>
<pre class="brush: php;toolbar:false;">
$post = new Post();
$post->title = 'Hello, world';
$post->content = 'Something interesting is happening.';
echo $post->title;
echo $post->content;
</pre>
<p>由于Model实现了ArrayAccess接口，你也可以像数组元素一样访问这些属性（译注：这个是很方便的，因为我们通常可能会忘记这是一个对象还是一个数组，有了这个接口，就不要考虑这个）：</p>
<pre class="brush: php;toolbar:false;">
$post = new Post();
$post['title'] = 'Hello, world';
$post['content'] = 'Something interesting is happening';
echo $post['title'];
echo $post['content'];
</pre>
<p>缺省情况，Model 需要属性被声明为 <em>public</em>和<em>non-static </em> 类成员变量。下面的例子中， LoginForm 模型类声明了两个属性：<code>username</code>和<code>password</code>。</p>
<pre class="brush: php;toolbar:false;">
// LoginForm 有两个属性: username and password
class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;
}
</pre>
<p>派生的模型类可以通过覆盖 attributes() 方法来声明属性。比如，yii\db\ActiveRecord 使用数据库表的字段名来定义关联类的属性。</p>
<p>&nbsp;</p>
<h2>属性标签</h2>
<p>属性标签主要用来显示。比如，对于一个属性<code>firstName</code>，我们可以声明一个更加用户友好的标签名 <code>First Name</code> ，用于在用户端表单输入字段名和错误信息中显示。你可以根据属性名获取到其标签名：yii\base\Model::getAttributeLabel()。</p>
<p>要声明属性标签，可以覆盖 yii\base\Model::attributeLabels() 方法。该方法返回一个属性及其标签的映射表，如下例所示。如果映射表没有某个属性，其显示标签将使用 yii\base\Model::generateAttributeLabel() 方法来自动生成。大多数情况下，yii\base\Model::generateAttributeLabel() 都将产生合理的标签（比如 username 为 Username, orderNumber 为 Order Number）。</p>
<pre class="brush: php;toolbar:false;">
// LoginForm 有两个属性: username and password
class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;

    public function attributeLabels()
    {
        return [
            'username' => 'Your name',
            'password' => 'Your password',
        ];
    }
}
</pre>
<p>&nbsp;</p>
<h2>场景</h2>
<p>模型可能会被用于不同的场景（<em>scenarios</em>）。比如，一个 <code>User</code> 模型可以用于收集用户登录输入，也可以用户注册。一个场景下，需要完整数据，而另一个场景，只需要用户名和密码。</p>
<p>为了简单的实现不同场景不同的业务逻辑，每个模型都有一个名为 <code>scenarios</code> 的属性用来保存当前使用的场景名称。如同将在接下来的章节中描述的那样，场景主要用于数据验证和批属性赋值（或称之为：块赋值）。</p>
<p>和每个场景关联的是一个活跃（<em>active</em>）属性集合。比如，在 <code>login</code> 场景中，只有 <code>username</code> 和 <code>password</code> 属性是激活的；而对于 <code>register</code> 场景，额外的属性如 <code>email</code> 也是激活的。一个属性是 <em>active</em>，意味着这个数据将参与验证。</p>
<p>可能的场景应该被列举在 <code>scenarios()</code> 方法中。这个方法返回一个数组，键（keys）是场景名，而值（values）是一系列应该激活的关联属性：</p>
<pre class="brush: php;toolbar:false;">
class User extends \yii\db\ActiveRecord
{
    public function scenarios()
    {
        return [
            'login' => ['username', 'password'],
            'register' => ['username', 'email', 'password'],
        ];
    }
}
</pre>
<p>如果 <code>scenarios</code> 方法未被定义，将使用缺省场景。这意味着所有包含验证规则的属性都被认为是激活的。</p>
<p>如果你想在自定义场景之外还能使用这个缺省场景，你可以用继承的方法来包含它，如下：</p>
<pre class="brush: php;toolbar:false;">
class User extends \yii\db\ActiveRecord
{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['username', 'password'];
        $scenarios['register'] = ['username', 'email', 'password'];
        return $scenarios;
    }
}
</pre>
<p>有时候，我们想把某个属性标记为不适用于块赋值（massive assignment），但仍然想校验这个属性。我们可以在属性名前使用一个感叹号（exclamation），比如：</p>
<pre class="brush: php;toolbar:false;">['username', 'password', '!secret']</pre>
<p>在这个例子中 <code>username</code>，<code>password</code> 和 <code>secret</code> 都是活跃属性但只有 <code>username</code> 和 <code>password</code> 会被认为适合块赋值。</p>
<p>识别当前模型场景，可以通过以下方法之一：</p>
<pre class="brush: php;toolbar:false;">
class EmployeeController extends \yii\web\Controller
{
    public function actionCreate($id = null)
    {
        // 第一种方法
        $employee = new Employee(['scenario' => 'managementPanel']);

        // 第二种方法
        $employee = new Employee();
        $employee->scenario = 'managementPanel';

        // 第三种方法
        $employee = Employee::find()->where('id = :id', [':id' => $id])->one();
        if ($employee !== null) {
            $employee->scenario = 'managementPanel';
        }
    }
}
</pre>
<p>上述例子假设你的模型基于活动记录（<a href="0603.html">Active Record</a>）。对于基本表单模型，很少使用场景，因为基本表单模型通常和某单个表单紧密结合。如上所说明， <code>scenarios()</code> 缺省实现返回每个具有验证规则的属性，这样就总是可以使用块赋值和验证。</p>
<p>&nbsp;</p>
<h2>验证</h2>
<p>当模型用于以特性收集用户输入数据时，通常需要验证受影响的特性以确保这些特性满足特定要求，如特性不能为空，必须只包含字母等。如验证发现错误，就会显示出来提示用户改正。以下示例演示了验证如何履行：</p>
<pre class="brush: php;toolbar: false">
$model = new LoginForm();
$model->username = $_POST['username'];
$model->password = $_POST['password'];
if ($model->validate()) {
    // ... 用户登录 ...
} else {
    $errors = $model->getErrors();
    // ... 显示错误信息给用户 ...
}
</pre>
<p>模型可用的验证规则列于 <code>rules()</code> 方法。一条验证规则适用于一个或多个特性并作用于一个或多个场景。一条规则可使用验证器对象&mdash;&mdash;[[yii\validators\Validator]]子类实例或以下格式的数组指定：</p>
<pre class="brush: php;toolbar: false">
[
    ['特性1', '特性2', ...],
    '验证器类或别名',
    // 指定规则适用的场景
    // 未指定场景则适用于所有场景
    'on' => ['场景1', '场景2', ...],
    // 以下键值对将用于初始化验证器属性
    'property1' => 'value1',
    'property2' => 'value2',
    // ...
]
</pre>
<p>调用 <code>validate()</code> 时，真正执行的验证规则取决于以下两个准则：</p>
<ul class="task-list">
<li>规则必须关联至少一个活动的特性；</li>
<li>规则必须在当前场景是活动的。</li>
</ul>
<h3>自建验证器 (内联验证方法)</h3>
<p>如果内置验证器不能满足你的需求，可以通过在模型类创建一个方法来建立你自己的验证器。这个方法可由[[yii\validators \InlineValidator|InlineValidator]]包裹并在验证时调用，然后用于验证特性并在验证失败时以[[yii\base \Model::addError()|add errors]]添加错误到模型。</p>
<p>自定义验证方法可以 <code>public function myValidator($attribute, $params)</code> 来识别，方法名可自由选择。</p>
<p>以下示例实现了一个用于验证用户年龄的验证器：</p>
<pre class="brush: php;toolbar: false">
public function validateAge($attribute, $params)
{
    $value = $this->$attribute;
    if (strtotime($value) > strtotime('now - ' . $params['min'] . ' years')) {
        $this->addError($attribute, 'You must be at least ' . $params['min'] . ' years old to register for this service.');
    }
}

public function rules()
{
    return [
        // ...
        [['birthdate'], 'validateAge', 'params' => ['min' => '12']],
    ];
}
</pre> 
<p>也可在规则定义中设置[[yii\validators\InlineValidator|InlineValidator]]的其他属性。以[[yii \validators\InlineValidator::$skipOnEmpty|skipOnEmpty]]属性为例：</p>
<pre class="brush: php;toolbar: false">
[['birthdate'], 'validateAge', 'params' => ['min' => '12'], 'skipOnEmpty' => false],
</pre>
<h3>条件验证</h3>
<p>当某条件应用时才验证特性，如一个字段的验证依赖另一个字段的值，可以使用[[yii\validators\Validator::when|the <code>when</code> property]]来定义这个条件：</p>
<pre class="brush: php;toolbar: false">
['state', 'required', 'when' => function($model) { return $model->country == Country::USA; }],
['stateOthers', 'required', 'when' => function($model) { return $model->country != Country::USA; }],
['mother', 'required', 'when' => function($model) { return $model->age < 18 && $model->married != true; }],
</pre>
<p>如下这样写条件更易读：</p>
<pre class="brush: php;toolbar: false">
public function rules()
{
    $usa = function($model) { return $model->country == Country::USA; };
    $notUsa = function($model) { return $model->country != Country::USA; };
    $child = function($model) { return $model->age < 18 && $model->married != true; };
    return [
        ['state', 'required', 'when' => $usa],
        ['stateOthers', 'required', 'when' => $notUsa], // 注意不是 !$usa
        ['mother', 'required', 'when' => $child],
    ];
}
</pre>
<p>&nbsp;</p>
<h2>批量特性检索和赋值</h2>
<p>特性可以通过 <code>attributes</code> 属性批量检索。以下代码返回了 <em>所有</em> <code>$post</code> 模型的键值对数组形式的特性。</p>
<pre class="brush: php;toolbar: false">
$post = Post::find(42);
if ($post) {
    $attributes = $post->attributes;
    var_dump($attributes);
}
</pre>
<p>使用 <code>attributes</code>属性还可以从关联数组批量赋值到模型特性：</p>
<pre class="brush: php;toolbar: false">
$post = new Post();
$attributes = [
    'title' => 'Massive assignment example',
    'content' => 'Never allow assigning attributes that are not meant to be assigned.',
];
$post->attributes = $attributes;
var_dump($attributes);
</pre>
<p>以上代码赋值到相应的模型特性，特性名作为数组的键。和对所有特性总是有效的批量检索的关键区别是赋值的特性必须是 <strong>安全的</strong>，否则会被忽略。</p>
<p>&nbsp;</p>
<h2>验证规则和批量赋值</h2>
<p>Yii 2 的验证规则是和批量赋值分离的，这和 1.x 是不一样的。验证规则描述在模型的<code>rules()</code> 方法，而什么是安全的批量赋值描述在 <code>scenarios</code> 方法：</p>
<pre class="brush: php;toolbar: false">
class User extends ActiveRecord
{
    public function rules()
    {
        return [
            // 当相应的字段是“安全的”，规则启用
            ['username', 'string', 'length' => [4, 32]],
            ['first_name', 'string', 'max' => 128],
            ['password', 'required'],

            // 当场景是“注册”，无论字段是否“安全的”，规则启用
            ['hashcode', 'check', 'on' => 'signup'],
        ];
    }

    public function scenarios()
    {
        return [
            // 注册场景允许 username 的批量赋值
            'signup' => ['username', 'password'],
            'update' => ['username', 'first_name'],
        ];
    }
}
</pre>
<p>以上代码在严格遵守 <code>scenarios()</code> 后才允许批量赋值：</p>
<pre class="brush: php;toolbar: false">
$user = User::find(42);
$data = ['password' => '123'];
$user->attributes = $data;
print_r($user->attributes);
</pre>
<p>以上将返回空数组，因为在 <code>scenarios()</code>未定义默认场景。</p>
<pre class="brush: php;toolbar: false">
$user = User::find(42);
$user->scenario = 'signup';
$data = [
    'username' => 'samdark',
    'password' => '123',
    'hashcode' => 'test',
];
$user->attributes = $data;
print_r($user->attributes);
</pre>
<p>以上代码将返回下面结果：</p>
<pre class="brush: php;toolbar: false">
array(
    'username' => 'samdark',
    'first_name' => null,
    'password' => '123',
    'hashcode' => null, // 该特性未在场景方法中定义
)
</pre>
<p>防止未定义 <code>scenarios</code> 方法的措施：</p>
<pre class="brush: php;toolbar: false">
class User extends ActiveRecord
{
    public function rules()
    {
        return [
            ['username', 'string', 'length' => [4, 32]],
            ['first_name', 'string', 'max' => 128],
            ['password', 'required'],
        ];
    }
}
</pre>
<p>以上代码假设了默认场景所以批量赋值将对所有定义过 <code>rules</code> 的字段生效：</p>
<pre class="brush: php;toolbar: false">
$user = User::find(42);
$data = [
    'username' => 'samdark',
    'first_name' => 'Alexander',
    'last_name' => 'Makarov',
    'password' => '123',
];
$user->attributes = $data;
print_r($user->attributes);
</pre>
<p>以上代码将返回：</p>
<pre class="brush: php;toolbar: false">
array(
    'username' => 'samdark',
    'first_name' => 'Alexander',
    'password' => '123',
)
</pre>
<p>如果希望对默认场景设置一些字段是不安全的：</p>
<pre class="brush: php;toolbar: false">
class User extends ActiveRecord
{
    function rules()
    {
        return [
            ['username', 'string', 'length' => [4, 32]],
            ['first_name', 'string', 'max' => 128],
            ['password', 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['username', 'first_name', '!password']
        ];
    }
}
</pre>
<p>批量赋值默认仍可用：</p>
<pre class="brush: php;toolbar: false">
$user = User::find(42);
$data = [
    'username' => 'samdark',
    'first_name' => 'Alexander',
    'password' => '123',
];
$user->attributes = $data;
print_r($user->attributes);
</pre>
<p>以上代码输出：</p>
<pre class="brush: php;toolbar: false">
array(
    'username' => 'samdark',
    'first_name' => 'Alexander',
    'password' => null, // 因为场景中该字段名前面有 !
)</pre>