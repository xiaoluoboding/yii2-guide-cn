<h1>属性（Property）</h1>
<p>在 PHP 中，类的成员变量也被称为<strong>属性（properties）</strong>。它们是类定义的一部分，用来表现一个实例的状态（也就是区分类的不同实例）。在具体实践中，常常会想用一个稍微特殊些的方法实现属性的读写。例如，要对 <code>label</code> 属性执行 trim 操作，可以用以下代码实现：</p>
<pre class="brush: php;toolbar: false">
$object->label = trim($label);
</pre>
<p>上述代码的缺点是只要修改 <code>label</code> 属性就必须再次调用 <code>trim()</code> 函数。若将来需要用其它方式处理 <code>label</code> 属性，比如首字母大写，就不得不修改所有给 <code>label</code> 属性赋值的代码。这种代码的重复会导致 bug，这种实践显然需要尽可能避免。</p>
<p>为解决该问题，Yii 引入了一个名为 [[yii\base\Object]] 的基类，它支持基于类内的 <strong>getter</strong> 和 <strong>setter</strong>（读取器和设定器）方法来定义属性。如果某类需要支持这个特性，只需要继承 [[yii\base\Object]] 或其子类即可。</p>
<blockquote>
<p>补充：几乎每个 Yii 框架的核心类都继承自 [[yii\base\Object]] 或其子类。这意味着只要在核心类中见到 getter 或 setter 方法，就可以像调用属性一样调用它。</p>
</blockquote>
<p>getter 方法是名称以 <code>get</code> 开头的方法，而 setter 方法名以 <code>set</code> 开头。方法名中 <code>get</code> 或 <code>set</code> 后面的部分就定义了该属性的名字。如下面代码所示，getter 方法 <code>getLabel()</code> 和 setter 方法 <code>setLabel()</code> 操作的是 <code>label</code> 属性，：</p>
<pre class="brush: php;toolbar: false">
namespace app\components;

use yii\base\Object;

class Foo extend Object
{
    private $_label;

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel($value)
    {
        $this->_label = trim($value);
    }
}
</pre>
<p>（详细解释：getter 和 setter 方法创建了一个名为 <code>label</code> 的属性，在这个例子里，它指向一个私有的内部属性 <code>_label</code>。）</p>
<p>getter/setter 定义的属性用法与类成员变量一样。两者主要的区别是：当这种属性被读取时，对应的 getter 方法将被调用；而当属性被赋值时，对应的 setter 方法就调用。如：</p>
<pre class="brush: php;toolbar: false">
// 等效于 $label = $object->getLabel();
$label = $object->label;

// 等效于 $object->setLabel('abc');
$object->label = 'abc';
</pre>
<p>只定义了 getter 没有 setter 的属性是<strong>只读属性</strong>。尝试赋值给这样的属性将导致 [[yii\base\InvalidCallException|InvalidCallException]] （无效调用）异常。类似的，只有 setter 方法而没有 getter 方法定义的属性是<strong>只写属性</strong>，尝试读取这种属性也会触发异常。使用只写属性的情况几乎没有。</p>
<p>通过 getter 和 setter 定义的属性也有一些特殊规则和限制：</p>
<ul class="task-list">
<li>这类属性的名字是<strong>不区分大小写</strong>的。如，<code>$object-&gt;label</code> 和 <code>$object-&gt;Label</code> 是同一个属性。因为 PHP 方法名是不区分大小写的。</li>
<li>如果此类属性名和类成员变量相同，以后者为准。例如，假设以上 <code>Foo</code> 类有个 <code>label</code> 成员变量，然后给 <code>$object-&gt;label = 'abc'</code> 赋值，将赋给成员变量而不是 setter <code>setLabel()</code> 方法。</li>
<li>这类属性不支持可见性（访问限制）。定义属性的 getter 和 setter 方法是 public、protected 还是 private 对属性的可见性没有任何影响。</li>
<li>这类属性的 getter 和 setter 方法只能定义为<strong>非静态</strong>的，若定义为静态方法（static）则不会以相同方式处理。</li>
</ul>
<p>回到开头提到的问题，与其处处要调用 <code>trim()</code> 函数，现在我们只需在 setter <code>setLabel()</code> 方法内调用一次。如果 label 首字母变成大写的新要求来了，我们只需要修改<code>setLabel()</code> 方法，而无须接触任何其它代码。</p>