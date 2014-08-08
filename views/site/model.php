<h1>模型<a href="#model" name="model"> ¶</a></h1>
Yii遵循MVC设计结构，在Yii中模型的作用是存储或表示应用暂存的数据。Yii模型有以下基本特征：
<br>
<br>
<ul>
	<li>特性定义：模型定义了什么看作特性。</li>
	<li>特性标签：出于显示目的每个特性可能和一个标签关联。</li>
	<li>批量填充特性：一次填充多个模型特性的能力。</li>
	<li>基于场景的数据校验。</li>
</ul>
Yii 的模型继承自[[yii\base\Model]]类。模型通常用来保持数据何定义数据的验证规则（又称为业务逻辑）。
业务逻辑通过提供验证和错误报告极大地简化了 从复杂 web 表单到生成模型的过程。
<br>
模型类也是更多多功能高级模型的基类，如<a href="guidelist?id=2">活动记录Active Record</a>。
<br /><br />
<h2>属性 <a href="#attributes" name="attributes">¶</a></h2>
模型所代表的实际数据保存在属性 <em>attributes </em>中。模型属性可以像任意对象的成员变量一样来访问。比如，一个 <code>Post</code> 模型可能包含一个 <code>title</code> 属性和一个 <code>content</code> 属性，访问方法如下：
<br>
<pre class="brush: php;toolbar:false;">
$post = new Post();
$post->title = 'Hello, world';
$post->content = 'Something interesting is happening.';
echo $post->title;
echo $post->content;
</pre>
由于Model实现了ArrayAccess接口，你也可以像数组元素一样访问这些属性（译注：这个是很方便的，因为我们通常可能会忘记这是一个对象还是一个数组，有了这个接口，就不要考虑这个）：
<pre class="brush: php;toolbar:false;">
$post = new Post();
$post['title'] = 'Hello, world';
$post['content'] = 'Something interesting is happening';
echo $post['title'];
echo $post['content'];
</pre>
缺省情况，Model 需要属性被声明为 <em>public</em>和<em>non-static </em> 类成员变量。下面的例子中， LoginForm 模型类声明了两个属性：<code>username</code>和<code>password</code>。
<pre class="brush: php;toolbar:false;">
// LoginForm 有两个属性: username and password
class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;
}
</pre>
派生的模型类可以通过覆盖 attributes() 方法来声明属性。比如，yii\db\ActiveRecord 使用数据库表的字段名来定义关联类的属性。
<<br /><br />
<h2>属性标签 <a href="#attributes-labels" name="attributes-labels">¶</a></h2>
属性标签主要用来显示。比如，对于一个属性<code>firstName</code>，我们可以声明一个更加用户友好的标签名 <code>First Name</code> ，用于在用户端表单输入字段名和错误信息中显示。你可以根据属性名获取到其标签名：yii\base\Model::getAttributeLabel()。
<br /><br />
要声明属性标签，可以覆盖 yii\base\Model::attributeLabels() 方法。该方法返回一个属性及其标签的映射表，如下例所示。如果映射表没有某个属性，其显示标签将使用 yii\base\Model::generateAttributeLabel() 方法来自动生成。大多数情况下，yii\base\Model::generateAttributeLabel() 都将产生合理的标签（比如 username 为 Username, orderNumber 为 Order Number）。
<pre class="brush: php;toolbar:false;">
// LoginForm has two attributes: username and password
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
<br /><br />
<h2>场景 <a href="#scenario" name="scenario">¶</a></h2>
模型可能会被用于不同的场景（<em>scenarios</em>）。比如，一个 <code>User</code> 模型可以用于收集用户登录输入，也可以用户注册。一个场景下，需要完整数据，而另一个场景，只需要用户名和密码。
<br /><br />
为了简单的实现不同场景不同的业务逻辑，每个模型都有一个名为 <code>scenario</code> 的属性用来保存当前使用的场景名称。如同将在接下来的章节中描述的那样，场景主要用于数据验证和批属性赋值（或称之为：块赋值）。
<br /><br />
和每个场景关联的是一个活跃（<em>active</em>）属性集合。比如，在 <code>login</code> 场景中，只有 <code>username</code> 和 <code>password</code> 属性是激活的；而对于 <code>register</code> 场景，额外的属性如 <code>email</code> 也是激活的。一个属性是 <em>active</em>，意味着这个数据将参与验证。
<br /><br />
可能的场景应该被列举在 <code>scenarios()</code> 方法中。这个方法返回一个数组，键（keys）是场景名，而值（values）是一系列应该激活的关联属性：
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
如果 <code>scenarios</code> 方法未被定义，将使用缺省场景。这意味着所有包含验证规则的属性都被认为是激活的。
<br />
如果你想在自定义场景之外还能使用这个缺省场景，你可以用继承的方法来包含它，如下：
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
有时候，我们想把某个属性标记为不适用于块赋值（massive assignment），但仍然想校验这个属性。我们可以在属性名前使用一个感叹号（exclamation），比如：
<pre class="brush: php;toolbar:false;">['username', 'password', '!secret']</pre>
在这个例子中 <code>username</code>，<code>password</code> 和 <code>secret</code> 都是活跃属性但只有 <code>username</code> 和 <code>password</code> 会被认为适合块赋值。
<br />
识别当前模型场景，可以通过以下方法之一：
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
上述例子假设你的模型基于活动记录（<a href="guidelist?id=2">Active Record</a>）。对于基本表单模型，很少使用场景，因为基本表单模型通常和某单个表单紧密结合。如上所说明， <code>scenarios()</code> 缺省实现返回每个具有验证规则的属性，这样就总是可以使用块赋值和验证。
