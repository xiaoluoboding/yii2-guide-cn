<h1>资源</h1>
<p>RESTful APIs 就是用来访问和操作资源的。在Yii中，资源可以是任意类的一个对象。不过，如果你的资源类扩展自yii\base\Model 或其子类（比如 yii\db\ActiveRecord），你可以获得以下好处：</p>
<ul>
	<li> 输入数据验证；</li>
	<li>查询，创建，更新和删除数据的功能，如果是从 yii\db\ActiveRecord 扩展的话。</li>
	<li>可定制数据格式（将在接下来的章节进行描述）。</li>
</ul>