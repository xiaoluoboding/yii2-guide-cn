<h1>行为（Behavior）</h1>
<p>一个行为 behavior （也被称为 <em><a href="http://en.wikipedia.org/wiki/Mixin" target="_blank">Mixin</a>）</em>能被用来增强一个已有组件的功能而无需修改该组件的代码。特别是，一个行为可以注入其方法和属性到这个组件中，使得它们可以像组件自身的方法和属性一样直接访问。行为还能响应组件中触发的事件，以便截取正常的代码执行。和 <a href="http://www.php.net/traits">PHP's traits</a> 不同，行为可以在运行时被附属到类中。</p>
<p>&nbsp;</p>
<h2>使用行为</h2>
<p>行为可以被附属到任何从组件 [[yii\base\Component]] 派生的类中，通过代码或者应用程序配置。</p>
<h3>通过 <code>behaviors</code> 方法附属行为</h3>
<p>为了把一个行为附属到一个类中，你可以实现这个component的 <code>behaviors</code> 方法。作为示例，Yii提供了 [[yii\behaviors\TimestampBehavior]] 行为，用于在保存或更新 <a href="0603.html">Active Record </a>模型时自动更新时间相关字段：</p>
<pre class="brush: php;toolbar: false">
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord
{
    // ...

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }
}
</pre>
<p>在上述代码中，名字 <code>timestamp</code> 可以被用来在整个component中引用这个行为。比如，<code>$user-&gt;timestamp</code> 就是这个被附属的timestamp行为实例。相应的数组被用来创建这个<code>TimestampBehavior</code>对象。</p>
<p>除了响应ActiveRecord的插入和更新事件外，<code>TimestampBehavior</code> 还提供了一个方法 <code>touch()</code> ，可以用来把当前timestamp 赋值给一个指定字段。如前面提到的，你可以通过组件直接访问这个方法，如下：</p>
<pre class="brush: php;toolbar: false">$user->touch('login_time');</pre>
<p>如果你不需要访问一个behavior对象，或者behavior不需要定制，你可以使用如下简单格式来指定这个behavior：</p>
<pre class="brush: php;toolbar: false">
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord
{
    // ...

    public function behaviors()
    {
        return [
        	//匿名行为，只有行为类名
            TimestampBehavior::className(),
            //命名行为，只有行为类名
            'timestamp' => TimestampBehavior::className(),
        ];
    }
}
</pre>
<p>通过指定行为配置数组相应的键可以给行为关联一个名称。这种行为称为<strong>命名行为</strong>。如果行为没有指定名称就是<strong>匿名行为</strong>。</p>
<h3>动态附属行为</h3>
<p>还可以通过调用 <code>attachBehavior</code> 方法来把行为附属给一个组件：</p>
<pre class="brush: php;toolbar: false">
use app\components\MyBehavior;

// 附加行为对象
$component->attachBehavior('myBehavior1', new MyBehavior);

// 附加行为类
$component->attachBehavior('myBehavior2', MyBehavior::className());

// 附加配置数组
$component->attachBehavior('myBehavior3', [
    'class' => MyBehavior::className(),
    'prop1' => 'value1',
    'prop2' => 'value2',
]);
</pre>
<p>附加行为到组件时的命名行为，可以使用这个名称来访问行为对象，如下所示：</p>
<pre class="brush: php;toolbar: false">$behavior = $component->getBehavior('myBehavior');</pre> 
<p>也能获取附加到这个组件的所有行为：</p>
<pre class="brush: php;toolbar: false">$behaviors = $component->getBehaviors();</pre>  
<h3>通过配置附属行为</h3>
<p>我们还可以通过配置来附属行为，语法如下：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        'myComponent' => [
            // ...
            'as tree' => [
                'class' => 'Tree',
                'root' => 0,
            ],
        ],
    ],
];
</pre>
<p>如上配置中 <code>as tree</code> 代表附属一个名称为 <code>tree</code> 的行为，并且这个数组将被传递给 Yii::createObject() 来创建这个行为对象。</p>
<p>&nbsp;</p>
<h2>创建你自己的行为</h2>
<p>为了创建你自己的行为，你必须定义一个 yii\base\Behavior 的派生类：</p>
<pre class="brush: php;toolbar: false">
namespace app\components;

use yii\base\Behavior;

class MyBehavior extends Behavior
{
}
</pre>
<p>为了能够可定制，如同 yii\behaviors\TimestampBehavior, 添加公共属性：</p>
<pre class="brush: php;toolbar: false">
namespace app\components;

use yii\base\Behavior;

class MyBehavior extends Behavior
{
    public $attr;
}
</pre>
<p>现在，当行为被附属时，你可以设置这个属性到附属了该行为的类中。</p>
<pre class="brush: php;toolbar: false">
namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    // ...

    public function behaviors()
    {
        return [
            'mybehavior' => [
                'class' => 'app\components\MyBehavior',
                'attr' => 'member_type'
            ],
        ];
    }
}
</pre>
<p>&nbsp;</p>
<h2>处理事件</h2>
<p>行为通常被用于处理一些特定事件。下面我们实现 <code>events</code>方法来对事件处理器赋值：</p>
<pre class="brush: php;toolbar: false">
namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class MyBehavior extends Behavior
{
    public $attr;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeInsert() {
        $model = $this->owner;
        // Use $model->$attr
    }

    public function beforeUpdate() {
        $model = $this->owner;
        // Use $model->$attr
    }
}
</pre>
<p>[[yii\base\Behavior::events()|events()]] 方法返回事件列表和相应的处理器。上例声明了 [[yii\db\ActiveRecord::EVENT_BEFORE_INSERT|EVENT_BEFORE_INSERT]] 事件和它的处理器 <code>beforeInsert()</code> 。当指定一个事件处理器时，要使用以下格式之一：</p>
<ul class="task-list">
<li>指向行为类的方法名的字符串，如上例所示；</li>
<li>对象或类名和方法名的数组，如 <code>[$object, 'methodName']</code>；</li>
<li>匿名方法。</li>
</ul>
<p>处理器的格式如下，其中 <code>$event</code> 指向事件参数。关于事件的更多细节请参考<a href="0503.html">事件</a>：</p>
<pre class="brush: php;toolbar: false">
function ($event) {
}
</pre>
<p>&nbsp;</p>
<h2>移除行为</h2>
<p>要移除行为，可以调用 [[yii\base\Component::detachBehavior()]] 方法用行为相关联的名字实现：</p>
<pre class="brush: php;toolbar: false">
$component->detachBehavior('myBehavior');
</pre> 
<p>也可以移除<strong>全部</strong>行为：</p>
<pre class="brush: php;toolbar: false">
$component->detachBehaviors();
</pre>  
<p>&nbsp;</p>
<h2>与 PHP traits 的比较</h2>
<p>尽管行为在 "注入" 属性和方法到主类方面类似于 <a href="http://www.php.net/traits">traits</a> ，它们在很多方面却不相同。如上所述，它们各有利弊。它们更像是互补的而不是相互替代。</p>
<h3>行为的优势</h3>
<p>行为类像普通类支持继承。另一方面，traits 可以视为 PHP 语言支持的复制粘贴功能，它不支持继承。</p>
<p>行为无须修改组件类就可动态附加到组件或移除。要使用 traits，必须修改使用它的类。</p>
<p>行为是可配置的而 traits 不能。</p>
<p>行为以响应事件来自定义组件的代码执行。</p>
<p>当不同行为附加到同一组件产生命名冲突时，这个冲突通过先附加行为的优先权自动解决。而由不同 traits 引发的命名冲突需要通过手工重命名冲突属性或方法来解决。</p>
<h3>traits 的优势</h3>
<p>traits 比起行为更高效，因为行为是对象，消耗时间和内存。</p>
<p>IDE 对 traits 更友好，因为它们是语言结构。</p>