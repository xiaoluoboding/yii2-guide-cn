<h1>数据表格（GridView）</h1>
<p>数据表格或表格视图是 Yii 最强大的小部件之一。如需快速建立系统的管理后台部分，表格视图特别有用。表格视图从<a href="guidelist?id=18">数据提供器</a>获取数据并渲染每行，每行的列展现数据表的表单数据。</p>
<p>数据表的一行代表单个数据项的数据，一列通常表示数据项的一个特性（有些列会对应特性或静态文本的复杂表达式）。</p>
<p>表格视图支持数据项的排序和分页。排序和分页能以 AJAX 模式或标准页面请求两种方式实现。使用表格视图类（GridView）的好处之一是用户禁止 JavaScript 时，排序和分页能自动降级到标准页面请求且功能还能符合期望值。</p>
<p>使用 GridView 的最简代码示例如下：</p>
<pre class="brush: php;toolbar: false">
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$dataProvider = new ActiveDataProvider([
    'query' => Post::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
]);
</pre>
<p>以上代码首先建立一个数据提供器，然后使用 GridView 展现从数据供应器取出的每行数据的每个特性。被显示的表配备了排序和分页的功能。</p>
<p>&nbsp;</p>
<h2>网格列（Grid columns）</h2>
<p>Yii 网格由许多列组成。根据列类型和设置就能够呈现不同的数据。</p>
<p>GridView 的列配置可定义如下：</p>
<pre class="brush: php;toolbar: false">
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // 通过 $dataProvider 包括的数据定义了一个简单列
        // 模型列1 的数据将被使用
        'id',
        'username',
        // 更多复杂列
        [
            'class' => 'yii\grid\DataColumn', // 默认可省略
            'value' => function ($data) {
                return $data->name;
            },
        ],
    ],
]);
</pre>
<blockquote>注意config的columns部分没有指定，Yii将显示数据提供器模型所有可用的列。</blockquote>
<p>&nbsp;</p>
<h2>列类（Column classes）</h2>
<p>网格列（grid column）可通过使用不同列类（column class）来自定义：</p>
<pre class="brush: php;toolbar: false">
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn', // <-- 这里
            // 你可以在这里定义其他属性
        ],
</pre>
<p>除了Yii提供的列类外，我们还可以创建自己的列类，下面将详细阐述。</p>
<p>每个列类都继承自 [[yii\grid\Column]] 类，这样有一些公共选项可以设置：</p>
<ul>
<li><code>header</code> 用来设置表格头部。</li>
<li><code>footer</code> 用来设置表格底部。</li>
<li><code>visible</code> 这个列时候可见。</li>
<li><code>content</code> 传递一个有效的PHP回调函数来为1行返回数据。格式如下：</li>
</ul>
<pre class="brush: php;toolbar: false">
function ($model, $key, $index, $grid) {
    return 'a string';
}
</pre>
<p>可以传递数组来指定不同容器的 HTML 选项：</p>
<ul class="task-list">
<li><code>headerOptions</code></li>
<li><code>contentOptions</code></li>
<li><code>footerOptions</code></li>
<li><code>filterOptions</code></li>
</ul>
<h3>数据列（Data column）</h3>
<p>数据列用于数据显示和排序，这是默认列类型，使用它的话可以省略类的指定。</p>
TBD
<h3>动作列（Action column）</h3>
<p>动作列显示动作按钮，如每行的更新或删除按钮。</p>
<p>可配置属性：</p>
<ul class="task-list">
<li><code>controller</code> 是处理动作的控制器 ID ，如果未设置，将使用当前活动控制器。</li>
<li><code>template</code> 用来组成动作列元素的模板，大括号内的内容将视作控制器的动作 ID （也称为动作列的 <em>按钮名</em>）。它们将被指定在[[yii\grid\ActionColumn::$buttons|buttons]]内相应的按钮渲染回调函数取代。如， <code>{view}</code> 将被回调函数 <code>buttons['view']</code> 的结果取代。如果未找到回调函数，将被空字符串取代。默认 <code>{view} {update} {delete}</code> 。</li>
<li><code>buttons</code> 是按钮渲染回调函数的数组，数组键是按钮名（没有大括号），而数组值是相应的按钮渲染回调函数。回调函数使用以下格式：</li>
</ul>
<pre class="brush: php;toolbar: false">
function ($url, $model) {
    // 返回按钮 HTML 代码
}
</pre>
<p>以上代码中的 <code>$url</code> 是为创建按钮的列类的 URL ， <code>$model</code> 是被渲染的当前行的模型对象。</p>
<ul class="task-list">
<li><code>urlCreator</code> 是使用指定模型信息建立按钮 URL 的回调函数。回调签名应该和[[yii\grid\ActionColumn::createUrl()]]相同。如果该属性未设置，按钮 URL 将使用[[yii\grid\ActionColumn::createUrl()]]创建。</li>
</ul>
<h3>复选框列（Checkbox column）</h3>
<p>复选框列显示复选框的一列。</p>
<p>要添加复选框列到[[yii\grid\GridView]]，如下添加它到[[yii\grid\GridView::$columns|columns]]配置：</p>
<pre class="brush: php;toolbar: false">
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        // ...
        [
            'class' => 'yii\grid\CheckboxColumn',
            // 在此配置其他属性
        ],
    ],
</pre>
<p>用户可以点击复选框来选择网格的行。被选中的行可调用以下 JavaScript 代码获取：</p>
<pre class="brush: php;toolbar: false">
var keys = $('#grid').yiiGridView('getSelectedRows');
// keys 是键名关联到选中行的数组
</pre>
<h3>序列列（Serial column）</h3>
<p>序列列渲染行的序号以 <code>1</code> 开始逐个排序。</p>
<p>用法如下，很简单：</p>
<pre class="brush: php;toolbar: false">
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'], // <-- 这里
</pre>
<p>&nbsp;</p>
<h2>数据排序</h2>
<p><a href="https://github.com/yiisoft/yii2/issues/1576">https://github.com/yiisoft/yii2/issues/1576</a></p>
<p>&nbsp;</p>
<h2>数据筛选</h2>
<p>要筛选数据，表格视图需要一个<a href="guidelist?id=35">模型</a>从过滤的表单取得输入数据，并调整 dataprovider 的查询语句到期望的搜索条件。使用<a href="guidelist?id=2">active records</a>的惯例是建立一个搜索模型类继承活动记录类。然后用这个类定义搜索的验证规则和提供 <code>search()</code> 方法来返回 data provider 。</p>
<p>要给 <code>Post</code> 模型添加搜索能力，可以创建 <code>PostSearch</code> ，如下所示：</p>
<pre class="brush: php;toolbar: false">
&lt;?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
    public function rules()
    {
        // 只有在 rules() 的字段才能被搜索
        return [
            [['id'], 'integer'],
            [['title', 'creation_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass 父类实现的scenarios()
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // 加载搜索表单数据并验证
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // 通过添加过滤器来调整查询语句
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->name])
              ->andFilterWhere(['like', 'creation_date', $this->creation_date]);

        return $dataProvider;
    }
}
</pre>
<p>你可以在控制器使用这个方法来为表格视图获取 dataProvider ：</p>
<pre class="brush: php;toolbar: false">
$searchModel = new PostSearch();
$dataProvider = $searchModel->search($_GET);

return $this->render('myview', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
]);
</pre>
<p>然后在视图将 <code>$dataProvider</code> 和 <code>$searchModel</code> 赋值给表格视图：</p>
<pre class="brush: php;toolbar: false">
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
]);
</pre>
<p>&nbsp;</p>
<h2>使用模型关系</h2>
<p>当使用 GridView 显示活动记录（active records）时，你可能会遇到需要显示关联模型列的数值，比如想显示文章的作者的名字而不是他的 <code>id</code>。你可以在 columns 里面把这个属性名定义为 <code>author.name</code> ，当 <code>Post</code> 模型存在一个名为 <code>author</code> 的关系并且这个 author 模型拥有一个 <code>name</code> 属性，GridView将能显示作者的名字，不过缺省情况下，排序和过滤没有被启用。你得调整 <code>PostSearch</code> 模型（在最后部分介绍过）来添加这个功能。</p>
<p>为了启用关联列的排序，你得联合（join）这个关联表，并添加排序规则到数据提供器（data provider）的 Sort 组件中：</p>
<pre class="brush: php;toolbar: false">
$query = Post::find();
$dataProvider = new ActiveDataProvider([
    'query' => $query,
]);

// 连接关联 `author` 表作为 `users` 表的一个关系
// 并设置表别名为 `author`
$query->joinWith(['author' => function($query) { $query->from(['author' => 'users']); }]);
// 使关联列的排序生效
$dataProvider->sort->attributes['author.name'] = [
    'asc' => ['author.name' => SORT_ASC],
    'desc' => ['author.name' => SORT_DESC],
];

// ...
</pre>
<p>筛选也需要像上面那样调用 joinWith 。也可以定义可搜索特性和规则的列如下：</p>
<pre class="brush: php;toolbar: false">
public function attributes()
{
    // 添加关联字段到可搜索特性
    return array_merge(parent::attributes(), ['author.name']);
}

public function rules()
{
    return [
        [['id'], 'integer'],
        [['title', 'creation_date', 'author.name'], 'safe'],
    ];
}
</pre>
<p>然后在 <code>search()</code> 方法只须以 <code>$query-&gt;andFilterWhere(['LIKE', 'author.name', $this-&gt;getAttribute('author.name')]);</code>添加另一个过滤条件。</p>
<blockquote>
<p>须知：更多有关 <code>joinWith</code> 和后台执行查询的相关信息请参考 <a href="guidelist?id=2#lazy-and-eager-loading">活动记录的延迟加载和即时加载</a>.</p>
</blockquote>