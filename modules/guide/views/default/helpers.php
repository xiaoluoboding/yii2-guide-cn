<h1>帮助类</h1>
<p>Yii 提供了很多类来帮助简化一些通用的编码任务，比如字符串或数组操作，HTML代码生成，等等。这些帮助类统一放在 <code>yii\helpers</code> 命名空间中，并且全部是静态类（也就是它们仅包含静态属性和方法，不应该被实例化）。</p>
<p>你可以通过直接调用其静态方法来使用一个帮助类：</p>
<pre class="brush: php;toolbar:false;">
use yii\helpers\ArrayHelper;

$c = ArrayHelper::merge($a, $b);
</pre>
<p>&nbsp;</p>
<h2>扩展帮助类</h2>
<p>为了便于扩展帮助类，Yii 把每个 helper 拆分为两个类：一个基类（比如 <code>BaseArrayHelper</code>）和 一个具体类（比如 <code>ArrayHelper</code>）。你使用时只应该用具体类（concrete），不要使用基类。</p>
<p>如果你想定制一个helper，执行以下步骤（以 <code>ArrayHelper</code> 为例）：</p>
<ol>
<li>使用和Yii提供的具体类相同的命名，包含命名空间：<code>yii\helpers\ArrayHelper</code></li>
<li>从基类扩展你的帮助类：<code>class ArrayHelper extends \yii\helpers\BaseArrayHelper</code>.</li>
<li>在你的类中，按照你的需要覆盖任何的方法或属性，或者添加新的方法或属性。</li>
<li>让应用程序使用你的帮助类版本，通过在bootstrap脚本中包含如下代码行：</li>
</ol>
<pre class="brush: php;toolbar:false;">
Yii::$classMap['yii\helpers\ArrayHelper'] = 'path/to/ArrayHelper.php';
</pre>
<p>上述步骤 4 将指定 Yii 类自动加载器来加载你的版本而不是Yii的内置版本。</p>
<blockquote>
<p>提示：你可以使用 <code>Yii::$classMap</code> 来把任何 Yii 核心类替换为你自己的定制版本，不仅仅是帮助类。</p>
</blockquote>