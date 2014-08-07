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
<br>
业务逻辑通过提供验证和错误报告极大地简化了 从复杂 web 表单到生成模型的过程。
<br>
<br>
模型类也是更多多功能高级模型的基类，如<a href="guidelist?id=2">活动记录Active Record</a>。
<br>
<br>
<h2>属性 <a href="#attributes" name="attributes">¶</a></h2>
模型所代表的实际数据保存在属性 <em>attributes </em>中。模型属性可以像任意对象的成员变量一样来访问。
<br>比如，一个 <code>Post</code> 模型可能包含一个 <code>title</code> 属性和一个 <code>content</code> 属性，访问方法如下：
<br>
<pre class="brush: php;">
$post = new Post();
$post->title = 'Hello, world';
$post->content = 'Something interesting is happening.';
echo $post->title;
echo $post->content;
</pre>



