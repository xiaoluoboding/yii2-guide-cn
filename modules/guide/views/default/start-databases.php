<h1>使用数据库</h1>
<p>本章节将介绍如何如何创建一个从数据表<code>country</code>中获取国家数据并显示出来的页面。为了实现这个目标，你将会配置一个数据库连接，创建一个<a href="0603.html">活动记录</a>类，并且创建一个<a href="0305.html">动作</a>及一个<a href="0306.html">视图</a>。</p>
<p>贯穿整个章节，你将会学到：</p>
<ul>
	<li>配置一个数据库连接</li>
	<li>定义一个活动记录类</li>
	<li>使用活动记录从数据库中查询数据</li>
	<li>以分页方式在视图中显示数据</li>
</ul>
<p>请注意，为了掌握本章你应该具备最基本的数据库知识和使用经验。尤其是应该知道如何创建数据库，如何通过数据库终端执行 SQL 语句。</p>
<p>&nbsp;</p><h2>准备数据库</h2><hr>
<p>首先创建一个名为的数据库，应用将从这个数据库中获取数据。你可以创建 SQLite，MySQL，PostregSQL，MSSQL 或 Oracle 数据库，Yii 内置多种数据库支持。简单起见后面的内容将以 MySQL 为例做演示。</p>
<p>然后在数据库中创建一个名为<code>country</code>的表并插入简单的数据。可以执行下面的语句：</p>
<pre class="brush: sql;toolbar:false;">
CREATE TABLE `country` (
  `code` CHAR(2) NOT NULL PRIMARY KEY,
  `name` CHAR(52) NOT NULL,
  `population` INT(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Country` VALUES ('AU','Australia',18886000);
INSERT INTO `Country` VALUES ('BR','Brazil',170115000);
INSERT INTO `Country` VALUES ('CA','Canada',1147000);
INSERT INTO `Country` VALUES ('CN','China',1277558000);
INSERT INTO `Country` VALUES ('DE','Germany',82164700);
INSERT INTO `Country` VALUES ('FR','France',59225700);
INSERT INTO `Country` VALUES ('GB','United Kingdom',59623400);
INSERT INTO `Country` VALUES ('IN','India',1013662000);
INSERT INTO `Country` VALUES ('RU','Russia',146934000);
INSERT INTO `Country` VALUES ('US','United States',278357000);
</pre>
<p>于是便有了一个名为<code>yii2basic</code>的数据库，在这个数据库中有一个包含三个字段的数据表<code>country</code>，表中有十行数据。</p>
<p>&nbsp;</p><h2>配置数据库连接</h2><hr>
<p>开始之前，请确保你已经安装了 PHP PDO 扩展和你所使用的数据库的 <a href="http://www.php.net/manual/en/book.pdo.php" target="_blank">PDO</a> 驱动（例如 MySQL 的<code>pdo_mysql</code>）。对于使用关系型数据库来讲，这是基本要求。</p>
<p>驱动和扩展安装可用后，打开<code>config/db.php</code>修改里面的配置参数对应你的数据库配置。该文件默认包含这些内容：</p>
<pre class="brush: sql;toolbar:false;">
&lt;?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
</pre>
<p><code>config/db/php</code>是一个典型的基于文件的<a href="0505.html">配置</a>工具。这个文件配置了数据库连接 [[yii\db\Connection]] 的创建和初始化参数，应用的 SQL 查询正是基于这个数据库。</p>
<p>上面配置的数据库连接可以在应用中通过<code>Yii::$app->db</code>访问。</p>
<block>
	<p>补充：<code>config/db.php</code>将被包含在应用配置文件<code>config/web.php</code>中，后者指定了整个应用如何初始化。请参考配置章节了解更多信息。</p>
</block>
<p>&nbsp;</p><h2>创建活动记录（AR）</h2><hr>
<p>创建一个继承自<a href="0603.html">活动记录</a>类的类<code>Country</code>，把它放在<code>models/Country.php</code>，去表示和获取<code>country.php</code>表的数据。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php

namespace app\models;

use yii\db\ActiveRecord;

class Country extends ActiveRecord
{
}
</pre>
<p>这个<code>Country</code>类继承自 [[yii\db\ActiveRecord]]。你不用在里面写任何代码。只需要像现在这样，Yii 就能根据类名去猜测对应的数据表名。</p>
<blockquote>
	<p>补充：如果类名和数据表名不能直接对应，可以重写 [[yii\db\ActiveRecord::tableName()|tableName()]] 方法去显式指定相关表名。</p>
</blockquote>
<p>使用<code>Country</code>类可以很容易地动作<code>country</code>表数据，就像这段代码：</p>
<pre class="brush: php;toolbar:false;">
use app\models\Country;

// 获取 country 表的所有行并以 name 排序
$countries = Country::find()->orderBy('name')->all();

// 获取主键为 “US” 的行
$country = Country::findOne('US');

// 输出 “United States”
echo $country->name;

// 修改 name 为 “U.S.A.” 并在数据库中保存更改
$country->name = 'U.S.A.';
$country->save();
</pre>
<blockquote>
	<p>补充：活动记录是面向对象、功能强大的访问和动作数据库数据的方式。你可以在<a href="0603.html">活动记录</a>章节了解更多信息。除此之外你还可以使用另一种更原生的称做<a href="<0601></0601>.html">数据访问对象</a>的方法动作数据库数据。</p>
</blockquote>
<p>&nbsp;</p><h2>创建动作</h2><hr>
<p>为了向最终用户显示国家数据，你需要创建一个动作。相比之前小节掌握的在<code>site</code>控制器中创建动作，在这里为所有和国家有关的数据新建一个控制器更加合理。新控制器名为<code>CountryController</code>，并在其中创建一个<code>index</code>动作，如下：</p>
<pre class="brush: php;toolbar:false;">
&lt;?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Country;

class CountryController extends Controller
{
    public function actionIndex()
    {
        $query = Country::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
    }
}
</pre>
<p>把上面的代码保存在<code>controllers/CountryController.php</code>。</p>
<p><code>index</code>动作调用了活动记录<code>Country::find()</code>方法，去生成查询语句并从<code>country</code>表中取回所有数据。为了限定每个请求所返回的国家数量，查询在 [[yii\data\Pagination]] 对象的帮助下进行分页。 <code>Pagination</code>对象的使命主要有两点：</p>
<ul>
	<li>为 SQL 查询语句设置<code>offset</code>和<code>limit</code>从句，确保每个请求只需返回一页数据（本例中每页是 5 行）。</li>
	<li>在视图中显示一个由页码列表组成的分页器，这点将在后面的段落中解释。</li>
</ul>
<p>在代码末尾，<code>index</code>动作渲染一个名为<code>index</code>的视图，并传递国家数据和分页信息进去。</p>
<p>&nbsp;</p><h2>创建视图</h2><hr>
<p>在<code>views</code>目录下先创建一个名为<code>country</code>的子目录。这个目录存储所有由<code>country</code>控制器渲染的视图。在<code>views/country</code>目录下创建一个名为<code>index.php</code>的视图文件，内容如下：</p>
<pre class="brush: php;toolbar:false;">
&lt;?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
&lt;h1>Countries&lt;/h1>
&lt;ul>
&lt;?php foreach ($countries as $country): ?>
    &lt;li>
        &lt;?= Html::encode("{$country->name} ({$country->code})") ?>:
        &lt;?= $country->population ?>
    &lt;/li>
&lt;?php endforeach; ?>
&lt;/ul>

&lt;?= LinkPager::widget(['pagination' => $pagination]) ?>
</pre>
<p>&nbsp;</p><h2>尝试一下</h2><hr>
<p>浏览器访问下面的 URL 看看能否工作：</p>
<pre class="brush: php;toolbar:false;">
http://hostname/index.php?r=country/index
</pre>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/start-country-list.png" alt="form-validation"  width="800" height="600" /></p>
<p>首先你会看到显示着五个国家的列表页面。在国家下面，你还会看到一个包含四个按钮的分页器。如果你点击按钮 “2”，将会跳转到显示另外五个国家的页面，也就是第二页记录。如果观察仔细点你还会看到浏览器的 URL 变成了：</p>
<pre class="brush: php;toolbar:false;">
http://hostname/index.php?r=country/index&page=2
</pre>
<p>在这个场景里，[[yii\data\Pagination|Pagination]] 提供了为数据结果集分页的所有功能：</p>
<ul>
	<li>首先 [[yii\data\Pagination|Pagination]] 把 SELECT 的子查询<code> LIMIT 5 OFFSET 0</code>数据表示成第一页。因此开头的五条数据会被取出并显示。</li>
	<li>然后小部件 [[yii\widgets\LinkPager|LinkPager]] 使用 [[yii\data\Pagination::createUrl()|Pagination::createUrl()]] 方法生成的 URL 去渲染翻页按钮。URL 中包含必要的参数<code>page</code>才能查询不同的页面编号。</li>
	<li>如果你点击按钮 “2”，将会发起一个路由为<code>country/index</code>的新请求。[[yii\data\Pagination|Pagination]] 接收到 URL 中的<code>page</code>参数把当前的页码设为 2。新的数据库请求将会以<code>LIMIT 5 OFFSET 5</code>查询并显示。</li>
</ul>
<p>&nbsp;</p><h2>总结</h2><hr>
<p>本章节中你学到了如何使用数据库。你还学到了如何取出并使用 [[yii\data\Pagination]] 和 [[yii\widgets\LinkPager]] 显示数据。</p>
<p>下一章中你会学到如何使用 Yii 中强大的代码生成器<a href="0206.html">Gii</a>，去帮助你实现一些常用的功能需求，例如增查改删（CRUD）数据表中的数据。事实上你之前所写的代码全部都可以由 Gii 自动生成。</p>
