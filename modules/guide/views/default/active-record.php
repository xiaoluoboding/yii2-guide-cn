<h1>活动记录（Active Record）</h1>
<p><a href="http://en.wikipedia.org/wiki/Active_record_pattern" target="_blank">Active Record</a> 提供了一个面向对象的数据库访问接口，是Yii对ORM的实现。一个Active Record类和一张数据库表相关联， 一个Active Record实例则对应于表的一行，而Active Record实例的一个属性则对应于该行中的一列数据。 相比于直接编写原始的SQL语句，你可以使用面向对象的风格来操作数据库。</p>
<p>比如，假设<code>Customer</code> 是一个Active Record 类，和 <code>customer</code> 表格相关联， <code>name</code> 是 <code>customer</code> 表的一列。你可以使用如下代码来新建一条记录：</p>
<pre class="brush: php;toolbar: false">
$customer = new Customer();
$customer->name = 'Qiang';
$customer->save();
</pre>
<p>当然，也可以直接使用SQL语句，下面的代码和上面的效果相同，但是看起来不那么直观，更容易犯错，并且对于不同的DBMS可能会产生兼容性问题：</p>
<pre class="brush: php;toolbar: false">
$db->createCommand('INSERT INTO customer (name) VALUES (:name)', [
    ':name' => 'Qiang',
])->execute();
</pre>
<p>下面是所有目前被 Yii 的 AR 功能所支持的数据库列表：</p>
<ul class="task-list">
<li>MySQL 4.1 及以上：通过 [[yii\db\ActiveRecord]]</li>
<li>PostgreSQL 7.3 及以上：通过 [[yii\db\ActiveRecord]]</li>
<li>SQLite 2 和 3：通过 [[yii\db\ActiveRecord]]</li>
<li>Microsoft SQL Server 2010 及以上：通过 [[yii\db\ActiveRecord]]</li>
<li>Oracle: 通过 [[yii\db\ActiveRecord]]</li>
<li>CUBRID 9.1 及以上：通过 [[yii\db\ActiveRecord]]</li>
<li>Sphnix：通过 [[yii\sphinx\ActiveRecord]]，需求 <code>yii2-sphinx</code> 扩展</li>
<li>ElasticSearch：通过 [[yii\elasticsearch\ActiveRecord]]，需求 <code>yii2-elasticsearch</code> 扩展</li>
<li>Redis 2.6.12 及以上：通过 [[yii\redis\ActiveRecord]]，需求 <code>yii2-redis</code> 扩展</li>
<li>MongoDB 1.3.0 及以上：通过 [[yii\mongodb\ActiveRecord]]，需求 <code>yii2-mongodb</code> 扩展</li>
</ul>
<p>如你所见，Yii 不仅提供了对关系型数据库的 AR 支持，还提供了 NoSQL 数据库的支持。 在这个教程中，我们会主要描述对关系型数据库的 AR 用法。 然而，绝大多数的内容在 NoSQL 的 AR 里同样适用。</p>
<p>&nbsp;</p>
<h2>声明 AR 类</h2>
<p>要想声明一个 AR 类，你需要扩展 [[yii\db\ActiveRecord]] 基类， 并实现 <code>tableName</code> 方法，返回与之相关联的的数据表的名称：</p>
<pre class="brush: php;toolbar: false">
namespace app\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord
{
    /**
     * @return string 返回该AR类关联的数据表名
     */
    public static function tableName()
    {
        return 'customer';
    }
}
</pre>
<p>&nbsp;</p>
<h2>访问列数据</h2>
<p>AR 把相应数据行的每一个字段映射为 AR 对象的一个个特性变量（Attribute） 一个特性就好像一个普通对象的公共属性一样（public property）。 特性变量的名称和对应字段的名称是一样的，且大小姓名。</p>
<p>使用以下语法读取列的值：</p>
<pre class="brush: php;toolbar: false">
// "id" 和 "mail" 是 $customer 对象所关联的数据表的对应字段名
$id = $customer->id;
$email = $customer->email;
</pre>
<p>要改变列值，只要给关联属性赋新值并保存对象即可：</p>
<pre class="brush: php;toolbar: false">
$customer->email = 'jane@example.com';
$customer->save();
</pre>
<p>&nbsp;</p>
<h2>建立数据库连接</h2>
<p>AR 用一个 [[yii\db\Connection|DB connection]] 对象与数据库交换数据。 默认的，它使用 <code>db</code> 组件作为其连接对象。详见<a href="guidelist?id=21">数据库基础</a>章节， 你可以在应用程序配置文件中设置下 <code>db</code> 组件，就像这样，</p>
<pre class="brush: php;toolbar: false">
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=testdb',
            'username' => 'demo',
            'password' => 'demo',
        ],
    ],
];
</pre>
<p>如果在你的应用中应用了不止一个数据库，且你需要给你的 AR 类使用不同的数据库链接（DB connection） ，你可以覆盖掉 [[yii\db\ActiveRecord::getDb()|getDb()]] 方法：</p>
<pre class="brush: php;toolbar: false">
class Customer extends ActiveRecord
{
    // ...

    public static function getDb()
    {
        return \Yii::$app->db2;  // 使用名为 "db2" 的应用组件
    }
}
</pre>
<p>&nbsp;</p>
<h2>查询数据</h2>
<p>AR 提供了两种方法来构建 DB 查询并向 AR 实例里填充数据：</p>
<ul class="task-list">
<li>[[yii\db\ActiveRecord::find()]]</li>
<li>[[yii\db\ActiveRecord::findBySql()]]</li>
</ul>
<p>以上两个方法都会返回 [[yii\db\ActiveQuery]] 实例，该类继承自[[yii\db\Query]]， 因此，他们都支持同一套灵活且强大的 DB 查询方法，如 <code>where()</code>，<code>join()</code>，<code>orderBy()</code>，等等。 下面的这些案例展示了一些可能的玩法：</p>
<pre class="brush: php;toolbar: false">
// 取回所有活跃客户(状态为 *active* 的客户）并以他们的 ID 排序：
$customers = Customer::find()
    ->where(['status' => Customer::STATUS_ACTIVE])
    ->orderBy('id')
    ->all();

// 返回ID为1的客户：
$customer = Customer::find()
    ->where(['id' => 1])
    ->one();

// 取回活跃客户的数量：
$count = Customer::find()
    ->where(['status' => Customer::STATUS_ACTIVE])
    ->count();

// 以客户ID索引结果集：
$customers = Customer::find()->indexBy('id')->all();
// $customers 数组以 ID 为索引

// 用原生 SQL 语句检索客户：
$sql = 'SELECT * FROM customer';
$customers = Customer::findBySql($sql)->all();
</pre>
<blockquote>
<p>小技巧：在上面的代码中，<code>Customer::STATUS_ACTIVE</code> 是一个在 <code>Customer</code> 类里定义的常量。（译者注：这种常量的值一般都是tinyint）相较于直接在代码中写死字符串或数字，使用一个更有意义的常量名称是一种更好的编程习惯。</p>
</blockquote>
<p>有两个快捷方法：<code>findOne</code> 和 <code>findAll()</code> 用来返回一个或者一组<code>ActiveRecord</code>实例。前者返回第一个匹配到的实例，后者返回所有。 例如：</p>
<pre class="brush: php;toolbar: false">
// 返回 id 为 1 的客户
$customer = Customer::findOne(1);

// 返回 id 为 1 且状态为 *active* 的客户
$customer = Customer::findOne([
    'id' => 1,
    'status' => Customer::STATUS_ACTIVE,
]);

// 返回id为1、2、3的一组客户
$customers = Customer::findAll([1, 2, 3]);

// 返回所有状态为 "deleted" 的客户
$customer = Customer::findAll([
    'status' => Customer::STATUS_DELETED,
]);
</pre>
<h3>以数组形式获取数据</h3>
<p>有时候，我们需要处理很大量的数据，这时可能需要用一个数组来存储取到的数据， 从而节省内存。你可以用<code> asArray() </code>函数做到这一点：</p>
<pre class="brush: php;toolbar: false">
// 以数组而不是对象形式取回客户信息：
$customers = Customer::find()
    ->asArray()
    ->all();
// $customers 的每个元素都是键值对数组
</pre>
<h3>批量获取数据</h3>
<p>在 <a href="guidelist?id=38">Query Builder（查询生成器）</a> 里，我们已经解释了当需要从数据库中查询大量数据时，你可以用 <em>batch query（批量查询）</em>来限制内存的占用。 你可能也想在 AR 里使用相同的技巧，比如：</p>
<pre class="brush: php;toolbar: false">
// 一次提取 10 个客户信息
foreach (Customer::find()->batch(10) as $customers) {
    // $customers 是 10 个或更少的客户对象的数组
}
// 一次提取 10 个客户并一个一个地遍历处理
foreach (Customer::find()->each(10) as $customer) {
    // $customer 是一个 ”Customer“ 对象
}
// 贪婪加载模式的批处理查询
foreach (Customer::find()->with('orders')->each() as $customer) {
}
</pre>
<h3>操作数据库数据</h3>
<p>AR 提供以下方法插入、更新和删除与 AR 对象关联的那张表中的某一行：</p>
<ul class="task-list">
<li>[[yii\db\ActiveRecord::save()|save()]]</li>
<li>[[yii\db\ActiveRecord::insert()|insert()]]</li>
<li>[[yii\db\ActiveRecord::update()|update()]]</li>
<li>[[yii\db\ActiveRecord::delete()|delete()]]</li>
</ul>
<p>AR 同时提供了一下静态方法，可以应用在与某 AR 类所关联的整张表上。 用这些方法的时候千万要小心，因为他们作用于整张表！ 比如，<code>deleteAll()</code> 会删除掉表里<strong>所有</strong>的记录。</p>
<ul class="task-list">
<li>[[yii\db\ActiveRecord::updateCounters()|updateCounters()]]</li>
<li>[[yii\db\ActiveRecord::updateAll()|updateAll()]]</li>
<li>[[yii\db\ActiveRecord::updateAllCounters()|updateAllCounters()]]</li>
<li>[[yii\db\ActiveRecord::deleteAll()|deleteAll()]]</li>
</ul>
<p>下面的这些例子里，详细展现了如何使用这些方法：</p>
<pre class="brush: php;toolbar: false">
// 插入新客户的记录
$customer = new Customer();
$customer->name = 'James';
$customer->email = 'james@example.com';
$customer->save();  // 等同于 $customer->insert();

// 更新现有客户记录
$customer = Customer::findOne($id);
$customer->email = 'james@example.com';
$customer->save();  // 等同于 $customer->update();

// 删除已有客户记录
$customer = Customer::findOne($id);
$customer->delete();

// 删除多个年龄大于20，性别为男（Male）的客户记录
Customer::deleteAll('age > :age AND gender = :gender', [':age' => 20, ':gender' => 'M']);

// 所有客户的age（年龄）字段加1：
Customer::updateAllCounters(['age' => 1]);
</pre>
<blockquote>
<p>须知：<code>save()</code> 方法会调用 <code>insert()</code> 和 <code>update()</code> 中的一个， 用哪个取决于当前 AR 对象是不是新对象（在函数内部，他会检查 [[yii\db\ActiveRecord::isNewRecord]] 的值）。 若 AR 对象是由 <code>new</code> 操作符 初始化出来的，<code>save()</code> 方法会在表里<em>插入</em>一条数据； 如果一个 AR 是由 <code>find()</code> 方法获取来的， 则 <code>save()</code> 会<em>更新</em>表里的对应行记录。</p>
</blockquote>
<h3>数据输入与有效性验证</h3>
<p>由于AR继承自[[yii\base\Model]]，所以它同样也支持<a href="guidelist?id=35">Model</a>的 数据输入、验证等特性。例如，你可以声明一个rules方法用来覆盖掉[[yii\base\Model::rules()|rules()]]里的；你 也可以给AR实例批量赋值；你也可以通过调用[[yii\base\Model::validate()|validate()]]执行数据验证。</p>
<p>当你调用 <code>save()</code>、<code>insert()</code>、<code>update()</code> 这三个方法时，会自动调用[[yii\base\Model::validate()|validate()]]方法。如果验证失败，数据将不会保存进数据库。</p>
<p>下面的例子演示了如何使用AR 获取/验证用户输入的数据并将他们保存进数据库：</p>
<pre class="brush: php;toolbar: false">
// 新建一条记录
$model = new Customer;
if ($model->load(Yii::$app->request->post()) && $model->save()) {
    // 获取用户输入的数据，验证并保存
}

// 更新主键为$id的AR
$model = Customer::findOne($id);
if ($model === null) {
    throw new NotFoundHttpException;
}
if ($model->load(Yii::$app->request->post()) && $model->save()) {
    // 获取用户输入的数据，验证并保存
}
</pre>
<h3>读取缺省数据</h3>
<p>你的表列也许定义了默认值。有时候，你可能需要在使用web表单的时候给AR预设一些值。如果你需要这样做，可以在显示表单内容前通过调用<code>loadDefaultValues()</code>方法来实现：</p>
<pre class="brush: php;toolbar: false">
$customer = new Customer();
$customer->loadDefaultValues();
// ... 渲染 $customer 的 HTML 表单 ...
</pre>
<p>&nbsp;</p>
<h2>AR的生命周期</h2>
<p>理解AR的生命周期对于你操作数据库非常重要。生命周期通常都会有些典型的事件存在。对于开发AR的behaviors来说非常有用。</p>
<p>当你实例化一个新的AR对象时，我们将获得如下的生命周期：</p>
<ol class="task-list">
<li>constructor</li>
<li>[[yii\db\ActiveRecord::init()|init()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_INIT|EVENT_INIT]] 事件</li>
</ol>
<p>当你通过 [[yii\db\ActiveRecord::find()|find()]] 方法查询数据时，每个AR实例都将有以下生命周期：</p>
<ol class="task-list">
<li>constructor</li>
<li>[[yii\db\ActiveRecord::init()|init()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_INIT|EVENT_INIT]] 事件</li>
<li>[[yii\db\ActiveRecord::afterFind()|afterFind()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_AFTER_FIND|EVENT_AFTER_FIND]] 事件</li>
</ol>
<p>当通过 [[yii\db\ActiveRecord::save()|save()]] 方法写入或者更新数据时, 我们将获得如下生命周期：</p>
<ol class="task-list">
<li>[[yii\db\ActiveRecord::beforeValidate()|beforeValidate()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_BEFORE_VALIDATE|EVENT_BEFORE_VALIDATE]] 事件</li>
<li>[[yii\db\ActiveRecord::afterValidate()|afterValidate()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_AFTER_VALIDATE|EVENT_AFTER_VALIDATE]] 事件</li>
<li>[[yii\db\ActiveRecord::beforeSave()|beforeSave()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_BEFORE_INSERT|EVENT_BEFORE_INSERT]] 或 [[yii\db\ActiveRecord::EVENT_BEFORE_UPDATE|EVENT_BEFORE_UPDATE]] 事件</li>
<li>执行实际的数据写入或更新</li>
<li>[[yii\db\ActiveRecord::afterSave()|afterSave()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_AFTER_INSERT|EVENT_AFTER_INSERT]] 或 [[yii\db\ActiveRecord::EVENT_AFTER_UPDATE|EVENT_AFTER_UPDATE]] 事件</li>
</ol>
<p>最后，当调用 [[yii\db\ActiveRecord::delete()|delete()]] 删除数据时, 我们将获得如下生命周期：</p>
<ol class="task-list">
<li>[[yii\db\ActiveRecord::beforeDelete()|beforeDelete()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_BEFORE_DELETE|EVENT_BEFORE_DELETE]] 事件</li>
<li>执行实际的数据删除</li>
<li>[[yii\db\ActiveRecord::afterDelete()|afterDelete()]]: 会触发一个 [[yii\db\ActiveRecord::EVENT_AFTER_DELETE|EVENT_AFTER_DELETE]] 事件</li>
</ol>
<p>&nbsp;</p>
<h2>关联查询</h2>
<p>使用 AR 方法也可以查询数据表的关联数据（如，选出表A的数据可以拉出表B的关联数据）。 有了 AR， 返回的关联数据连接就像连接关联主表的 AR 对象的属性一样。</p>
<p>建立关联关系后，通过 <code>$customer-&gt;orders</code> 可以获取 一个 <code>Order</code> 对象的数组，该数组代表当前客户对象的订单集。</p>
<p>定义关联关系使用一个可以返回 [[yii\db\ActiveQuery]] 对象的 getter 方法， [[yii\db\ActiveQuery]]对象有关联上下文的相关信息，因此可以只查询关联数据。</p>
<p>例如：</p>
<pre class="brush: php;toolbar: false">
class Customer extends \yii\db\ActiveRecord
{
    public function getOrders()
    {
        // 客户和订单通过 Order.customer_id -> id 关联建立一对多关系
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }
}

class Order extends \yii\db\ActiveRecord
{
    // 订单和客户通过 Customer.id -> customer_id 关联建立一对一关系
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
</pre>
<p>以上使用了 [[yii\db\ActiveRecord::hasMany()]] 和 [[yii\db\ActiveRecord::hasOne()]] 方法。 以上两例分别是关联数据多对一关系和一对一关系的建模范例。 如，一个客户有很多订单，一个订单只归属一个客户。 两个方法都有两个参数并返回 [[yii\db\ActiveQuery]] 对象。</p>
<ul class="task-list">
<li><code>$class</code>：关联模型类名，它必须是一个完全合格的类名。</li>
<li><code>$link</code>: 两个表的关联列，应为键值对数组的形式。 数组的键是 <code>$class</code> 关联表的列名， 而数组值是关联类 $class 的列名。 基于表外键定义关联关系是最佳方法。</li>
</ul>
<p>建立关联关系后，获取关联数据和获取组件属性一样简单， 执行以下相应getter方法即可：</p>
<pre class="brush: php;toolbar: false">
// 取得客户的订单
$customer = Customer::findOne(1);
$orders = $customer->orders; // $orders 是 Order 对象数组
</pre>
<p>以上代码实际执行了以下两条 SQL 语句：</p>
<pre class="brush: php;toolbar: false">
SELECT * FROM customer WHERE id=1;
SELECT * FROM order WHERE customer_id=1;
</pre>
<blockquote>
<p>提示:再次用表达式 <code>$customer-&gt;orders</code>将不会执行第二次 SQL 查询， SQL 查询只在该表达式第一次使用时执行。 数据库访问只返回缓存在内部前一次取回的结果集，如果你想查询新的 关联数据，先要注销现有结果集：<code>unset($customer-&gt;orders);</code>。</p>
</blockquote>
<p>有时候需要在关联查询中传递参数，如不需要返回客户全部订单， 只需要返回购买金额超过设定值的大订单， 通过以下getter方法声明一个关联数据 <code>bigOrders</code> ：</p>
<pre class="brush: php;toolbar: false">
class Customer extends \yii\db\ActiveRecord
{
    public function getBigOrders($threshold = 100)
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id'])
            ->where('subtotal > :threshold', [':threshold' => $threshold])
            ->orderBy('id');
    }
}
</pre>
<p><code>hasMany()</code> 返回 [[yii\db\ActiveQuery]] 对象，该对象允许你通过 [[yii\db\ActiveQuery]] 方法定制查询。</p>
<p>如上声明后，执行<code>$customer-&gt;bigOrders</code> 就返回 总额大于100的订单。使用以下代码更改设定值：</p>
<pre class="brush: php;toolbar: false">
$orders = $customer->getBigOrders(200)->all();
</pre>
<blockquote>
<p>注意：关联查询返回的是 [[yii\db\ActiveQuery]] 的实例，如果像特性（如类属性）那样连接关联数据， 返回的结果是关联查询的结果，即 [[yii\db\ActiveRecord]] 的实例， 或者是数组，或者是 null ，取决于关联关系的多样性。如，<code>$customer-&gt;getOrders()</code> 返回 <code>ActiveQuery</code> 实例，而 <code>$customer-&gt;orders</code> 返回<code>Order</code> 对象数组 （如果查询结果为空则返回空数组）。</p>
</blockquote>
<p>&nbsp;</p>
<h2>中间表关联查询</h2>
<p>有时，两个表通过中间表关联，定义这样的关联关系， 可以通过调用 [[yii\db\ActiveQuery::via()|via()]] 方法或 [[yii\db\ActiveQuery::viaTable()|viaTable()]] 方法来定制 [[yii\db\ActiveQuery]] 对象 。</p>
<p>举例而言，如果 <code>order</code> 表和 <code>item</code> 表通过中间表 <code>order_item</code> 关联起来， 可以在 <code>Order</code> 类声明 <code>items</code> 关联关系取代中间表：</p>
<pre class="brush: php;toolbar: false">
class Order extends \yii\db\ActiveRecord
{
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])
            ->viaTable('order_item', ['order_id' => 'id']);
    }
}
</pre>
<p>两个方法是相似的，除了 [[yii\db\ActiveQuery::via()|via()]] 方法的第一个参数是使用 AR 类中定义的关联名。 以上方法取代了中间表，等价于：</p>
<pre class="brush: php;toolbar: false">
class Order extends \yii\db\ActiveRecord
{
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])
            ->via('orderItems');
    }
}
</pre>
<p>&nbsp;</p>
<h2>延迟加载和即时加载（又称惰性加载与贪婪加载）</h2>
<p>如前所述，当你第一次连接关联对象时， AR 将执行一个数据库查询 来检索请求数据并填充到关联对象的相应属性。 如果再次连接相同的关联对象，不再执行任何查询语句，这种数据库查询的执行方法称为“延迟加载”。如：</p>
<pre class="brush: php;toolbar: false">
// SQL executed: SELECT * FROM customer WHERE id=1
$customer = Customer::findOne(1);
// SQL executed: SELECT * FROM order WHERE customer_id=1
$orders = $customer->orders;
// 没有 SQL 语句被执行
$orders2 = $customer->orders; //取回上次查询的缓存数据
</pre>
<p>延迟加载非常实用，但是，在以下场景中使用延迟加载会遭遇性能问题：</p>
<pre class="brush: php;toolbar: false">
// SQL executed: SELECT * FROM customer LIMIT 100
$customers = Customer::find()->limit(100)->all();

foreach ($customers as $customer) {
    // SQL executed: SELECT * FROM order WHERE customer_id=...
    $orders = $customer->orders;
    // ...处理 $orders...
}
</pre>
<p>假设数据库查出的客户超过100个，以上代码将执行多少条 SQL 语句？ 101 条！第一条 SQL 查询语句取回100个客户，然后， 每个客户要执行一条 SQL 查询语句以取回该客户的所有订单。</p>
<p>为解决以上性能问题，可以通过调用 [[yii\db\ActiveQuery::with()]] 方法使用即时加载解决。</p>
<pre class="brush: php;toolbar: false">
// SQL executed: SELECT * FROM customer LIMIT 100;
//               SELECT * FROM orders WHERE customer_id IN (1,2,...)
$customers = Customer::find()->limit(100)
    ->with('orders')->all();

foreach ($customers as $customer) {
    // 没有 SQL 语句被执行
    $orders = $customer->orders;
    // ...处理 $orders...
}
</pre>
<p>如你所见，同样的任务只需要两个 SQL 语句。</p>
<blockquote>
<p>须知：通常，即时加载 N 个关联关系而通过 via() 或者 viaTable() 定义了 M 个关联关系， 将有 1+M+N 条 SQL 查询语句被执行：一个查询取回主表行数， 一个查询给每一个 (M) 中间表，一个查询给每个 (N) 关联表。 注意:当用即时加载定制 select() 时，确保连接 到关联模型的列都被包括了，否则，关联模型不会载入。如：</p>
</blockquote>
<pre class="brush: php;toolbar: false">
$orders = Order::find()->select(['id', 'amount'])->with('customer')->all();
// $orders[0]->customer 总是空的，使用以下代码解决这个问题：
$orders = Order::find()->select(['id', 'amount', 'customer_id'])->with('customer')->all();
</pre>
<p>有时候，你想自由的自定义关联查询，延迟加载和即时加载都可以实现，如：</p>
<pre class="brush: php;toolbar: false">
$customer = Customer::findOne(1);
// 延迟加载: SELECT * FROM order WHERE customer_id=1 AND subtotal>100
$orders = $customer->getOrders()->where('subtotal>100')->all();

// 即时加载: SELECT * FROM customer LIMIT 100
//          SELECT * FROM order WHERE customer_id IN (1,2,...) AND subtotal>100
$customers = Customer::find()->limit(100)->with([
    'orders' => function($query) {
        $query->andWhere('subtotal>100');
    },
])->all();
</pre>
<p>&nbsp;</p>
<h2>反向关系</h2>
<p>关系通常是成对定义的。比如，<code>Customer</code> 可以有一个<code>orders</code>关系，同时 <code>Order</code> 可以有一个 <code>customer</code> 关系：</p>
<pre class="brush: php;toolbar: false">
class Customer extends ActiveRecord
{
    ....
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }
}

class Order extends ActiveRecord
{
    ....
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
</pre>
<p>如果我们执行以下查询，可以发现订单的 customer 和 找到这些订单的客户对象并不是同一个。连接 customer->orders 将触发一条 SQL 语句 而连接一个订单的 customer 将触发另一条 SQL 语句。</p>
<pre class="brush: php;toolbar: false">
// SELECT * FROM customer WHERE id=1
$customer = Customer::findOne(1);
// 输出 "不相同"
// SELECT * FROM order WHERE customer_id=1
// SELECT * FROM customer WHERE id=1
if ($customer->orders[0]->customer === $customer) {
    echo '相同';
} else {
    echo '不相同';
}
</pre>
<p>为避免多余执行的后一条语句，我们可以为 customer或 orders 关联关系定义相反的关联关系，通过调用 [[yii\db\ActiveQuery::inverseOf()|inverseOf()]] 方法可以实现。</p>
<pre class="brush: php;toolbar: false">
class Customer extends ActiveRecord
{
    ....
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id'])->inverseOf('customer');
    }
}
</pre>
<p>现在我们同样执行上面的查询，我们将得到：</p>
<pre class="brush: php;toolbar: false">
// SELECT * FROM customer WHERE id=1
$customer = Customer::findOne(1);
// 输出相同
// SELECT * FROM order WHERE customer_id=1
if ($customer->orders[0]->customer === $customer) {
    echo '相同';
} else {
    echo '不相同';
}
</pre>
<p>以上我们展示了如何在延迟加载中使用相对关联关系， 相对关系也可以用在即时加载中：</p>
<pre class="brush: php;toolbar: false">
// SELECT * FROM customer
// SELECT * FROM order WHERE customer_id IN (1, 2, ...)
$customers = Customer::find()->with('orders')->all();
// 输出相同
if ($customers[0]->orders[0]->customer === $customers[0]) {
    echo '相同';
} else {
    echo '不相同';
}
</pre>
<blockquote>
<p>注意:相对关系不能在包含中间表的关联关系中定义。 即是，如果你的关系是通过[[yii\db\ActiveQuery::via()|via()]] 或 [[yii\db\ActiveQuery::viaTable()|viaTable()]]方法定义的， 就不能调用[[yii\db\ActiveQuery::inverseOf()]]方法了。</p>
</blockquote>
<p>&nbsp;</p>
<h2>联合查询</h2>
<p>使用关系数据库时，普遍要做的是连接多个表并明确地运用各种 JOIN 查询。 JOIN SQL语句的查询条件和参数，使用 [[yii\db\ActiveQuery::joinWith()]] 可以重用已定义关系并调用 而不是使用 [[yii\db\ActiveQuery::join()]] 来实现目标。</p>
<pre class="brush: php;toolbar: false">
// 查找所有订单并以客户 ID 和订单 ID 排序，并贪婪加载 "customer" 表
$orders = Order::find()->joinWith('customer')->orderBy('customer.id, order.id')->all();
// 查找包括书籍的所有订单，并以 `INNER JOIN` 的连接方式即时加载 "books" 表
$orders = Order::find()->innerJoinWith('books')->all();
</pre>
<p>以上，方法 [[yii\db\ActiveQuery::innerJoinWith()|innerJoinWith()]] 是访问 <code>INNER JOIN</code> 类型的 [[yii\db\ActiveQuery::joinWith()|joinWith()]] 的快捷方式。</p>
<p>可以连接一个或多个关联关系，可以自由使用查询条件到关联查询， 也可以嵌套连接关联查询。如：</p>
<pre class="brush: php;toolbar: false">
// 连接多重关系
// 找出24小时内注册客户包含书籍的订单
$orders = Order::find()->innerJoinWith([
    'books',
    'customer' => function ($query) {
        $query->where('customer.created_at > ' . (time() - 24 * 3600));
    }
])->all();
// 连接嵌套关系：连接 books 表及其 author 列
$orders = Order::find()->joinWith('books.author')->all();
</pre>
<p>代码背后， Yii 先执行一条 JOIN SQL 语句把满足 JOIN SQL 语句查询条件的主要模型查出， 然后为每个关系执行一条查询语句， bing填充相应的关联记录。</p>
<p>[[yii\db\ActiveQuery::joinWith()|joinWith()]] 和 [[yii\db\ActiveQuery::with()|with()]] 的区别是 前者连接主模型类和关联模型类的数据表来检索主模型， 而后者只查询和检索主模型类。 检索主模型</p>
<p>由于这个区别，你可以应用只针对一条 JOIN SQL 语句起效的查询条件。 如，通过关联模型的查询条件过滤主模型，如前例， 可以使用关联表的列来挑选主模型数据，</p>
<p>当使用 [[yii\db\ActiveQuery::joinWith()|joinWith()]] 方法时可以响应没有歧义的列名。 In the above examples, we use <code>item.id</code> and <code>order.id</code> to disambiguate the <code>id</code> column references 因为订单表和项目表都包括 <code>id</code> 列。</p>
<p>当连接关联关系时，关联关系默认使用即时加载。你可以 通过传参数 <code>$eagerLoading</code> 来决定在指定关联查询中是否使用即时加载。</p>
<p>默认 [[yii\db\ActiveQuery::joinWith()|joinWith()]] 使用左连接来连接关联表。 你也可以传 <code>$joinType</code> 参数来定制连接类型。 你也可以使用 [[yii\db\ActiveQuery::innerJoinWith()|innerJoinWith()]]。</p>
<p>以下是 <code>INNER JOIN</code> 的简短例子：</p>
<pre class="brush: php;toolbar: false">
// 查找包括书籍的所有订单，但 "books" 表不使用即时加载
$orders = Order::find()->innerJoinWith('books', false)->all();
// 等价于：
$orders = Order::find()->joinWith('books', false, 'INNER JOIN')->all();
</pre>
<p>有时连接两个表时，需要在关联查询的 ON 部分指定额外条件。 这可以通过调用 [[yii\db\ActiveQuery::onCondition()]] 方法实现：</p>
<pre class="brush: php;toolbar: false">
class User extends ActiveRecord
{
    public function getBooks()
    {
        return $this->hasMany(Item::className(), ['owner_id' => 'id'])->onCondition(['category_id' => 1]);
    }
}
</pre>
<p>在上面， [[yii\db\ActiveRecord::hasMany()|hasMany()]] 方法回传了一个 [[yii\db\ActiveQuery]] 对象， 当你用 [[yii\db\ActiveQuery::joinWith()|joinWith()]] 执行一条查询时，取决于正被调用的是哪个 [[yii\db\ActiveQuery::onCondition()|onCondition()]]， 返回 <code>category_id</code> 为 1 的 items</p>
<p>当你用 [[yii\db\ActiveQuery::joinWith()|joinWith()]] 进行一次查询时，&ldquo;on-condition&rdquo;条件会被放置在相应查询语句的 ON 部分， 如：</p>
<pre class="brush: php;toolbar: false">
// SELECT user.* FROM user LEFT JOIN item ON item.owner_id=user.id AND category_id=1
// SELECT * FROM item WHERE owner_id IN (...) AND category_id=1
$users = User::find()->joinWith('books')->all();
</pre>
<p>注意：如果通过 [[yii\db\ActiveQuery::with()]] 进行贪婪加载或使用惰性加载的话，则 on 条件会被放置在对应 SQL语句的 <code>WHERE</code> 部分。 因为，此时此处并没有发生 JOIN 查询。比如：</p>
<pre class="brush: php;toolbar: false">
// SELECT * FROM user WHERE id=10
$user = User::findOne(10);
// SELECT * FROM item WHERE owner_id=10 AND category_id=1
$books = $user->books;
</pre>
<p>&nbsp;</p>
<h2>关联表操作</h2>
<p>AR 提供了下面两个方法用来建立和解除两个关联对象之间的关系：</p>
<ul class="task-list">
<li>[[yii\db\ActiveRecord::link()|link()]]</li>
<li>[[yii\db\ActiveRecord::unlink()|unlink()]]</li>
</ul>
<p>例如，给定一个customer和order对象，我们可以通过下面的代码使得customer对象拥有order对象：</p>
<pre class="brush: php;toolbar: false">
$customer = Customer::findOne(1);
$order = new Order();
$order->subtotal = 100;
$customer->link('orders', $order);
</pre>
<p>[[yii\db\ActiveRecord::link()|link()]] 调用上述将设置 customer_id 的顺序是 $customer 的主键值，然后调用 [[yii\db\ActiveRecord::save()|save()]] 要将顺序保存到数据库中。</p>
<p>&nbsp;</p>
<h2>作用域</h2>
<p>当你调用[[yii\db\ActiveRecord::find()|find()]] 或 [[yii\db\ActiveRecord::findBySql()|findBySql()]]方法时，将会返回一个[[yii\db \ActiveQuery|ActiveQuery]]实例。之后，你可以调用其他查询方法，如 [[yii\db\ActiveQuery::where()|where()]]，[[yii\db \ActiveQuery::orderBy()|orderBy()]], 进一步的指定查询条件。</p>
<p>有时候你可能需要在不同的地方使用相同的查询方法。如果出现这种情况，你应该考虑定义所谓的作用域。作用域是本质上要求一组的查询方法来修改查询对象的自定义查询类中定义的方法。 之后你就可以像使用普通方法一样使用作用域。</p>
<p>只需两步即可定义一个作用域。首先给你的model创建一个自定义的查询类，在此类中定义的所需的范围方法。例如，给Comment模型创建一个 CommentQuery类，然后在CommentQuery类中定义一个active()的方法为作用域，像下面的代码：</p>
<pre class="brush: php;toolbar: false">
namespace app\models;

use yii\db\ActiveQuery;

class CommentQuery extends ActiveQuery
{
    public function active($state = true)
    {
        $this->andWhere(['active' => $state]);
        return $this;
    }
}
</pre>
<p>要点:</p>
<ol class="task-list">
<li>类必须继承 yii\db\ActiveQuery (或者是其他的 ActiveQuery ，比如 yii\mongodb\ActiveQuery)。</li>
<li>必须是一个public类型的方法且必须返回 $this 实现链式操作。可以传入参数。</li>
<li>检查 [[yii\db\ActiveQuery]] 对于修改查询条件是非常有用的方法。</li>
</ol>
<p>其次，覆盖[[yii\db\ActiveRecord::find()]] 方法使其返回自定义的查询对象而不是常规的[[yii\db\ActiveQuery|ActiveQuery]]。对于上述例子，你需要编写如下代码：</p>
<pre class="brush: php;toolbar: false">
namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    /**
     * @inheritdoc
     * @return CommentQuery
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}
</pre>
<p>就这样，现在你可以使用自定义的作用域方法了：</p>
<pre class="brush: php;toolbar: false">
$comments = Comment::find()->active()->all();
$inactiveComments = Comment::find()->active(false)->all();
</pre>
<p>你也能在定义的关联里使用作用域方法，比如：</p>
<pre class="brush: php;toolbar: false">
class Post extends \yii\db\ActiveRecord
{
    public function getActiveComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])->active();

    }
}
</pre>
<p>或者在执行关联查询时动态使用这个作用域：</p>
<p>&nbsp;</p>
<h2>缺省作用域</h2>
如果你之前用过 Yii 1.1 就应该知道缺省作用域的概念。一个缺省作用域可以作用于所有查询。你可以很容易的通过重写[[yii\db\ActiveRecord::find()]]方法来定义一个默认作用域，例如：
<pre class="brush: php;toolbar: false">
public static function find()
{
    return parent::find()->where(['deleted' => false]);
}
</pre>
注意，你之后所有的查询都不能用 [[yii\db\ActiveQuery::where()|where()]]，但是可以用 [[yii\db\ActiveQuery::andWhere()|andWhere()]] 和 [[yii\db\ActiveQuery::orWhere()|orWhere()]]，他们不会覆盖掉缺省作用域。
<p>&nbsp;</p>
<h2>事务操作</h2>
<p>当执行几个相关联的数据库操作的时候</p>
<p>TODO: FIXME: WIP, TBD, <a href="https://github.com/yiisoft/yii2/issues/226">https://github.com/yiisoft/yii2/issues/226</a></p>
<p>,[[yii\db\ActiveRecord::afterSave()|afterSave()]], [[yii\db\ActiveRecord::beforeDelete()|beforeDelete()]] and/or [[yii\db\ActiveRecord::afterDelete()|afterDelete()]] 生命周期周期方法(life cycle methods 我觉得这句翻译成&ldquo;模板方法&rdquo;会不会更好点？)。开发者可以通过重写[[yii\db\ActiveRecord::save()|save()]]方法 然后在控制器里使用事务操作，严格地说是似乎不是一个好的做法 （召回"瘦控制器 / 肥模型"基本规则）。</p>
<p>这些方法在这里(如果你不明白自己实际在干什么，请不要使用他们)，Models：</p>
<pre class="brush: php;toolbar: false">
class Feature extends \yii\db\ActiveRecord
{
    // ...

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}

class Product extends \yii\db\ActiveRecord
{
    // ...

    public function getFeatures()
    {
        return $this->hasMany(Feature::className(), ['product_id' => 'id']);
    }
}
</pre>
<p>重写 [[yii\db\ActiveRecord::save()|save()]] 方法：</p>
<pre class="brush: php;toolbar: false">
class ProductController extends \yii\web\Controller
{
    public function actionCreate()
    {
        // FIXME: TODO: WIP, TBD
    }
}
</pre>
<p>在控制器层使用事务：</p>
<pre class="brush: php;toolbar: false">
class ProductController extends \yii\web\Controller
{
    public function actionCreate()
    {
        // FIXME: TODO: WIP, TBD
    }
}
</pre>
<p>作为这些脆弱方法的替代，你应该使用原子操作方案特性。</p>
<pre class="brush: php;toolbar: false">
class Feature extends \yii\db\ActiveRecord
{
    // ...

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'id']);
    }

    public function scenarios()
    {
        return [
            'userCreates' => [
                'attributes' => ['name', 'value'],
                'atomic' => [self::OP_INSERT],
            ],
        ];
    }
}

class Product extends \yii\db\ActiveRecord
{
    // ...

    public function getFeatures()
    {
        return $this->hasMany(Feature::className(), ['id' => 'product_id']);
    }

    public function scenarios()
    {
        return [
            'userCreates' => [
                'attributes' => ['title', 'price'],
                'atomic' => [self::OP_INSERT],
            ],
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        // FIXME: TODO: WIP, TBD
    }

    public function afterSave($insert)
    {
        parent::afterSave($insert);
        if ($this->getScenario() === 'userCreates') {
            // FIXME: TODO: WIP, TBD
        }
    }
}
</pre>
<p>Controller里的代码将变得很简洁：</p>
<pre class="brush: php;toolbar: false">
class ProductController extends \yii\web\Controller
{
    public function actionCreate()
    {
        // FIXME: TODO: WIP, TBD
    }
}
</pre>
<p>控制器非常简洁：</p>
<pre class="brush: php;toolbar: false">
class ProductController extends \yii\web\Controller
{
    public function actionCreate()
    {
        // FIXME: TODO: WIP, TBD
    }
}
</pre>
<p>&nbsp;</p>
<h2>乐观锁（Optimistic Locks）</h2>
<p>TODO</p>
<p>&nbsp;</p>
<h2>被污染属性</h2>
<p>TODO</p>
<p>&nbsp;</p>
<h2>See Also</h2>
<ul>
<li><a href="guidelist?id=35">Model</a></li>
<li><a href="http://www.yiiframework.com/doc-2.0/yii-db-activerecord.html" target="_blank">yii\db\ActiveRecord</a></li>
</ul>


