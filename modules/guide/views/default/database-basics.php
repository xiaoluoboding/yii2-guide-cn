<h1>数据库基础</h1>
<p>Yii 有一个建立在&nbsp;<a href="http://www.php.net/manual/en/book.pdo.php" target="_blank">PDO</a>&nbsp;之上的数据库访问层，提供统一的API并解决了一些不同DBMS间的不一致性问题。Yii 默认支持以下 DBMS：</p>
<ul>
<li><a href="http://www.mysql.com/" target="_blank">MySQL</a></li>
<li><a href="https://mariadb.com/" target="_blank">MariaDB</a></li>
<li><a href="http://sqlite.org/" target="_blank">SQLite</a></li>
<li><a href="http://www.postgresql.org/" target="_blank">PostgreSQL</a></li>
<li><a href="http://www.cubrid.org/" target="_blank">CUBRID</a>: 版本 9.1.0 或 +&nbsp;</li>
<li><a href="http://www.oracle.com/us/products/database/overview/index.html" target="_blank">Oracle</a></li>
<li><a href="https://www.microsoft.com/en-us/sqlserver/default.aspx" target="_blank">MSSQL</a>: 版本&nbsp;2012 或 +，如果你需要使用 LIMIT/OFFSET.</li>
</ul>
<p>&nbsp;</p>
<h2>数据库配置</h2>
<p>要使用数据库，你得先配置数据库连接组件，在应用程序配置中添加<code>db</code>组件如下：（对于基础Web应用程序，是在<code> config/web.php </code>文件中）</p>
<pre class="brush: php;toolbar: false"> 
return [
    // ...
    'components' => [
        // ...
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=mydatabase', // MySQL, MariaDB
            //'dsn' => 'sqlite:/path/to/database/file', // SQLite
            //'dsn' => 'pgsql:host=localhost;port=5432;dbname=mydatabase', // PostgreSQL
            //'dsn' => 'cubrid:dbname=demodb;host=localhost;port=33000', // CUBRID
            //'dsn' => 'sqlsrv:Server=localhost;Database=mydatabase', // MS SQL Server, sqlsrv driver
            //'dsn' => 'dblib:host=localhost;dbname=mydatabase', // MS SQL Server, dblib driver
            //'dsn' => 'mssql:host=localhost;dbname=mydatabase', // MS SQL Server, mssql driver
            //'dsn' => 'oci:dbname=//localhost:1521/mydatabase', // Oracle
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
    // ...
];
</pre> 
<p>当你想通过<code> ODBC </code>层使用数据库中，这会有点怪，因为连接的<code> DSN </code>属性并不会指出使用的数据库类型。这就是为什么你需要覆盖 [[yii\db\Connection]] 类的<code> driverName </code>属性来消除歧义：</p>
<pre class="brush: php;toolbar: false"> 
'db' => [
    'class' => 'yii\db\Connection',
    'driverName' => 'mysql',
    'dsn' => 'odbc:Driver={MySQL};Server=localhost;Database=test',
    'username' => 'root',
    'password' => '',
],
</pre>
<p>请参考 <a href="http://www.php.net/manual/en/function.PDO-construct.php" target="_blank">PHP manual</a> 以了解更多 DSN 字符串格式方面的细节。</p>
<p>配置好数据库连接后，你就可以通过下面的语法来使用了：</p>
<pre class="brush: php;toolbar: false">$connection = \Yii::$app->db;</pre>
<p>你可以参考 [[yii\db\Connection]] 以了解有哪些属性可以配置。而且你可以配置多个连接，在应用程序中同时使用它们：</p>
<pre class="brush: php;toolbar: false"> 
$primaryConnection = \Yii::$app->db;
$secondaryConnection = \Yii::$app->secondDb;
</pre>
<p>如果你不想把数据库连接定义为应用程序的组件，你也可以直接创建一个实例：</p>
<pre class="brush: php;toolbar: false">
$connection = new \yii\db\Connection([
    'dsn' => $dsn,
     'username' => $username,
     'password' => $password,
]);
$connection->open();
</pre>
<blockquote>
<p><strong>提示：如果你需要在建立连接时执行额外的SQL查询，你可以添加如下配置：</strong></p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        // ...
        'db' => [
            'class' => 'yii\db\Connection',
            // ...
            'on afterOpen' => function($event) {
                $event->sender->createCommand("SET time_zone = 'UTC'")->execute();
            }
        ],
    ],
    // ...
];
</pre>
</blockquote>
<p>&nbsp;</p>
<h2>基本SQL查询</h2>
<p>有了数据库连接实例，你可以使用 [[yii\db\Command]] 来执行SQL查询。</p>
<h3>SELECT</h3>
<p>返回多行数据：</p>
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('SELECT * FROM post');
$posts = $command->queryAll();
</pre>
<p>返回单行数据：</p> 
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('SELECT * FROM post WHERE id=1');
$post = $command->queryOne();
</pre>
<p>返回列数据：</p>  
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('SELECT title FROM post');
$titles = $command->queryColumn();
</pre>
<p>返回统计数：</p>  
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('SELECT COUNT(*) FROM post');
$postCount = $command->queryScalar();
</pre>
<h3>UPDATE, INSERT, DELETE etc.</h3>
<p>对于非查询语句，你可以使用[[ yii\db\Command]]的<code> execute </code>方法：</p>
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('UPDATE post SET status=1 WHERE id=1');
$command->execute();
</pre>
<p>也可以使用下面的语法，会自动处理好表名和列名引用：</p>
<pre class="brush: php;toolbar: false">
// INSERT
$connection->createCommand()->insert('user', [
    'name' => 'Sam',
    'age' => 30,
])->execute();

// INSERT multiple rows at once
$connection->createCommand()->batchInsert('user', ['name', 'age'], [
    ['Tom', 30],
    ['Jane', 20],
    ['Linda', 25],
])->execute();

// UPDATE
$connection->createCommand()->update('user', ['status' => 1], 'age > 30')->execute();

// DELETE
$connection->createCommand()->delete('user', 'status = 0')->execute();
</pre>
<p>&nbsp;</p>
<h2>引用表名和列名</h2>
<p>大多数情况下，你使用如下语法引用表名和列名：</p>
<pre class="brush: php;toolbar: false">
$sql = "SELECT COUNT([[$column]]) FROM {{$table}}";
$rowCount = $connection->createCommand($sql)->queryScalar();
</pre>
<p>在上述代码中 <code>[[$column]]</code> 将被转换为合适的列名引用，而 <code>{{$table}}</code> 将被转换为表名引用。</p>
<p>对于表名，有一个特殊变量 <code>{{%$table}}</code> ，会自动为表名添加前缀（如果有的话）：</p>
<pre class="brush: php;toolbar: false">
$sql = "SELECT COUNT([[$column]]) FROM {{%$table}}";
$rowCount = $connection->createCommand($sql)->queryScalar();
</pre>
<p>上述代码将会应用于<code> tbl_table </code>，如果你在配置文件中配置了如下的表前缀的话：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        // ...
        'db' => [
            // ...
            'tablePrefix' => 'tbl_',
        ],
    ],
];
</pre>
<p>另外一个可选方法是使用[[yii\db\Connection::quoteTableName()]]和 [[yii\db\Connection::quoteColumnName()]] 方法来手动引用：</p>
<pre class="brush: php;toolbar: false">
$column = $connection->quoteColumnName($column);
$table = $connection->quoteTableName($table);
$sql = "SELECT COUNT($column) FROM $table";
$rowCount = $connection->createCommand($sql)->queryScalar();
</pre>
<p>&nbsp;</p>
<h2>预备声明（Prepared statements）</h2>
<p>为了安全传递查询参数，你可以使用预备声明（prepared statements），（译注：先声明参数，对用户输入进行escape后，进行参数替换，主要为了防止SQL注入）：</p>
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('SELECT * FROM post WHERE id=:id');
$command->bindValue(':id', $_GET['id']);
$post = $command->query();
</pre>
<p>此外，使用预备声明还可以对查询命令进行复用，如下使用不同的参数查询只需要准备一次command：</p>
<pre class="brush: php;toolbar: false">
$command = $connection->createCommand('DELETE FROM post WHERE id=:id');
$command->bindParam(':id', $id);

$id = 1;
$command->execute();

$id = 2;
$command->execute();
</pre>
<p>&nbsp;</p>
<h2>事务（Transaction）</h2>
<p>你可以向下面这样执行一个数据库事务：</p>
<pre class="brush: php;toolbar: false">
$transaction = $connection->beginTransaction();
try {
    $connection->createCommand($sql1)->execute();
     $connection->createCommand($sql2)->execute();
    // ... 执行查询语句  ...
    $transaction->commit();
} catch(Exception $e) {
    $transaction->rollBack();
}
</pre>
<p>还可以嵌套事务：</p>
<pre class="brush: php;toolbar: false">
// 外层事务
$transaction1 = $connection->beginTransaction();
try {
    $connection->createCommand($sql1)->execute();

    // 内层事务
    $transaction2 = $connection->beginTransaction();
    try {
        $connection->createCommand($sql2)->execute();
        $transaction2->commit();
    } catch (Exception $e) {
        $transaction2->rollBack();
    }

    $transaction1->commit();
} catch (Exception $e) {
    $transaction1->rollBack();
}
</pre>
<p>&nbsp;</p>
<h2>操作数据库模式（Schema）</h2>
<h3>获取模式信息</h3>
<p>可以通过如下语句获取到一个 [[yii\db\Schema]] 实例：</p> 
<pre class="brush: php;toolbar: false">$schema = $connection->getSchema();</pre>
<p>Shema包含一系列方法让你获取数据库各方面的信息，如获取所有表名：</p> 
<pre class="brush: php;toolbar: false">$tables = $schema->getTableNames();</pre>
<p>完整参考文档请查阅 <a href="#">yii\db\Schema</a>.</p>
<h3>修改模式</h3>
<p>除了基本的SQL查询外，<a href="#">yii\db\Command</a> 包含了一系列方法可以用来修改数据库schema：</p>
<ul>
<li>createTable, renameTable, dropTable, truncateTable</li>
<li>addColumn, renameColumn, dropColumn, alterColumn</li>
<li>addPrimaryKey, dropPrimaryKey</li>
<li>addForeignKey, dropForeignKey</li>
<li>createIndex, dropIndex</li>
</ul>
<p>这些方法可使用如下：</p>
<pre class="brush: php;toolbar: false">
// 新建表
$connection->createCommand()->createTable('post', [
    'id' => 'pk',
    'title' => 'string',
    'text' => 'text',
]);
</pre> 