<h1>数据提供器</h1>
<p>数据供应器通过 [[yii\data\DataProviderInterface]] 接口抽象了数据集（Data Set）用以处理分页及排序。 它可以被 <a href="#">grids</a>，<a href="">lists</a> 或其他<a href="#">数据小部件</a>使用。</p>
<p>在 Yii 中，存在三种内建的数据提供器，分别是：</p>
<ul>
	<li>[[yii\data\ActiveDataProvider]]</li>
	<li>[[yii\data\ArrayDataProvider]]</li>
	<li>[[yii\data\SqlDataProvider]]</li>
</ul>
<p>&nbsp;</p>
<h2>活动数据提供器（Active Data Provider）</h2>
<p><code> ActiveDataProvider </code>通过使用 [[\yii\db\Query]] 和 [[\yii\db\ActiveQuery]] 执行 DB 查询从而提供数据。</p>
<p>下面的例子演示了如何通过提供一个 ActiveRecord 实例对象来使用它：</p>
<pre class="brush: php;toolbar: false">
$provider = new ActiveDataProvider([
    'query' => Post::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

// 获取当前页所有帖子
$posts = $provider->getModels();
</pre>
<p>下面的例子演示了如何在不使用 ActiveRecord 的情况下，使用 ActiveDataProvider：</p>
<pre class="brush: php;toolbar: false">
$query = new Query();
$provider = new ActiveDataProvider([
    'query' => $query->from('post'),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

// 获取当前页所有帖子
$posts = $provider->getModels();
</pre>
<p>&nbsp;</p>
<h2>数组数据提供器（Array Data Provider）</h2>
<p>ArrayDataProvider 基于一个数据的数组来实现数据提供器的功能。</p>
<p>[[yii\data\ArrayDataProvider::$allModels]] 属性包含着所有可能需要排序或分页的数据模型。 ArrayDataProvider 会在排序或分页之后提供数据。 你可以设置 [[yii\data\ArrayDataProvider::$sort]] 和 [[yii\data\ArrayDataProvider::$pagination]] 属性， 来自定义排序和分页的行为。</p>
<p>[[yii\data\ArrayDataProvider::$allModels]] 数组中的元素可以是对象（e.g. 模型对象） 也可以是关联数组（e.g. DAO 的查询结果集）。 确保你给 [[yii\data\ArrayDataProvider::$key]] 属性设置了那个可以唯一标识一条数据记录字段的名字 或者是 <code>false</code>，如果你没有那样一个字段。</p>
<p>与 <code>ActiveDataProvider</code>相比，<code>ArrayDataProvider</code> 可能会稍微低效一些， 因为他需要预先准备下 [[yii\data\ArrayDataProvider::$allModels]] 属性。</p>
<p>ArrayDataProvider 可以这样用：</p>
<pre class="brush: php;toolbar: false">
$query = new Query();
$provider = new ArrayDataProvider([
    'allModels' => $query->from('post')->all(),
    'sort' => [
        'attributes' => ['id', 'username', 'email'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
]);

// 获取当前页的所有帖子
$posts = $provider->getModels();
</pre>
<blockquote>注意：如果你想用排序功能，你必须先设置<span style="background: #f00;">sort</span>属性 这样提供器才知道哪些字段是可以被排序的。</blockquote>
<p>&nbsp;</p>
<h2>SQL 数据提供器（SQL Data Provider）</h2>
<p>SqlDataProvider 基于一个简单的 SQL 语句实现数据提供器功能。它通过一系列的数组提供数据， 每个数组代表查询结果的一行记录。</p>
<p>像其他数据提供器一样，SqlDataProvider 也支持分页和排序。它通过修改给定的 [[yii\data\SqlDataProvider::$sql]] 语句的 "ORDER BY" 和 "LIMIT" 子句来实现。你可以设置 [[yii\data\SqlDataProvider::$sort]] 和 [[yii\data\SqlDataProvider::$pagination]] 属性 来自定义分页和排序的行为。</p>
<p><code>SqlDataProvider</code> 可以这样用：</p>
<pre class="brush: php;toolbar: false">
$count = Yii::$app->db->createCommand('
    SELECT COUNT(*) FROM user WHERE status=:status
', [':status' => 1])->queryScalar();

$dataProvider = new SqlDataProvider([
    'sql' => 'SELECT * FROM user WHERE status=:status',
    'params' => [':status' => 1],
    'totalCount' => $count,
    'sort' => [
        'attributes' => [
            'age',
            'name' => [
                'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
        ],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
]);

// 获取当前页的所有帖子
$models = $dataProvider->getModels();
</pre>
<blockquote>
注意：如果你想用分页功能，你需要设置 [[yii\data\SqlDataProvider::$totalCount]] 属性为分页之前总共有多少行。并且如果你想用排序功能，你需要设置 [[yii\data\SqlDataProvider::$sort]] 熟悉， 这样提供器就知道哪些字段可以被排序。
</blockquote>
<p>&nbsp;</p>
<h2>实现你自己的数据提供器</h2>
<p>TBD</p>
