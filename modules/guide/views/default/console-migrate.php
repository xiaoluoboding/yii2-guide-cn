<h1>数据库迁移（Database Migration）</h1>
<p>和源码相同，数据库结构也像数据库驱动的应用那样逐步形成，慢慢成熟，可持续维护。例如，开发阶段，可能添加新表；或在应用上线后，发现需要另一个索引。可持续追踪数据库结构的变化是非常重要的（这称为 <em>迁移</em> ），正如源码的变化用版本控制来追踪一样。如果源码和数据库不同步，bugs (错误)就会产生，或整个应用终止运行。因为如此，Yii 提供了数据库迁移工具来保持追踪数据库迁移的历史，应用新的迁移版本，或恢复之前的迁移版本。</p>
<p>以下步骤展示了一个开发团队在开发阶段如何使用数据库迁移：</p>
<ol class="task-list">
<li>Tim 建立了新的迁移版本（如建立新表、更改一列的定义等）。</li>
<li>Tim 提交新的迁移版本到代码控制系统（如 Git、Mercurial）。</li>
<li>Doug 从代码控制系统升级他的版本库，接收到新的数据库迁移版本。</li>
<li>Doug 应用该迁移版本到他的本地开发数据库，从而同步他的数据库以反映 Tim 所做的改变。</li>
</ol>
<p>Yii 用 <code>yii migrate</code> 命令行工具来支持数据库迁移。这个工具支持：</p>
<ul class="task-list">
<li>建立新迁移版本</li>
<li>应用、回退或重做迁移</li>
<li>显示迁移历史和新的迁移</li>
</ul>
<p>&nbsp;</p>
<h2>建立迁移</h2>
<p>建立新的迁移请运行以下命令：</p>
<pre class="brush: php;toolbar: false">yii migrate/create <name></pre>
<p>必须的 <code>name</code> 参数指定了迁移的简要描述。例如，如果迁移建立名为 <em>news</em> 的新表，使用以下命令：</p>
<pre class="brush: php;toolbar: false">yii migrate/create create_news_table</pre>
<p>你很快将看到，<code>name</code> 参数用作迁移版本中 PHP 类名的一部分。因此，这个参数只能够是包含字母、数字或下划线的字符。</p>
<p>以上命令将建立一个名为 <code>m101129_185401_create_news_table.php</code> 的新文件。该文件将创建在<code>@app/migrations</code> 目录内。刚生成的迁移文件就是下面的代码：</p>
<pre class="brush: php;toolbar: false">
class m101129_185401_create_news_table extends \yii\db\Migration
{
    public function up()
    {
    }

    public function down()
    {
        echo "m101129_185401_create_news_table cannot be reverted.\n";
        return false;
    }
}
</pre>
<p>注意类名和文件名相同，都遵循 <code>m&lt;timestamp&gt;_&lt;name&gt;</code> 模式，其中：</p>
<ul class="task-list">
<li><code>&lt;timestamp&gt;</code> 指迁移创建时的 UTC 时间戳 (格式是 <code>yymmdd_hhmmss</code>)，</li>
<li><code>&lt;name&gt;</code> 从命令中的 <code>name</code> 参数获取。</li>
</ul>
<p>这个类中。 <code>up()</code> 方法应包括实际实现数据库迁移的代码。换言之， <code>up()</code> 方法执行了实际改变数据库的代码。<code>down()</code> 方法包括回退前版本的代码。</p>
<p>有时，用 <code>down()</code> 撤销数据库迁移是不可能的。例如，如果迁移删除表的某些行或整个表，那些数据将不能在 <code>down()</code> 方法里恢复。这种情况，该迁移称为不可逆迁移，即数据库不能回退到前一状态。当迁移是不可逆的，在以上生成代码的 <code>down()</code> 方法将返回 <code>false</code> 来表明这个迁移版本不能回退。</p>
<p>下面举例说明迁移如何建立新表：</p>
<pre class="brush: php;toolbar: false">
use yii\db\Schema;

class m101129_185401_create_news_table extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('news', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
    }

}
</pre>
<p>基类[\yii\db\Migration] 通过 <code>db</code> 属性建立一个数据库连接。可以使用它来操作数据和数据库的模式。</p>
<p>上例中使用的列类型是抽象类型，将被 Yii 用相应的数据库管理系统的类型取代。可以使用它们来编写独立于数据库的迁移。如 <code>pk</code> 在 MySQL 中将替换为 <code>int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY</code> ，而在 sqlite 中则替换为 <code>integer PRIMARY KEY AUTOINCREMENT NOT NULL</code> 。更多细节和可用的类型列表请参考[[yii\db\QueryBuilder::getColumnType()]]。也可以使用定义在[[yii\db\Schema]]中的常量来定义列类型。</p>
<p>&nbsp;</p>
<h2>事务性的迁移（整体迁移或回滚）</h2>
<p>执行复杂的 DB 迁移时，通常想确定每个完整迁移全体是成功了还是失败了，以便数据库保持一致和完整。为实现该目标，可以利用数据库事务来处理，使用专用的 <code>safeUp</code> 和 <code>safeDown</code> 方法来达到这些目的。</p>
<pre class="brush: php;toolbar: false">
use yii\db\Schema;

class m101129_185401_create_news_table extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ]);

        $this->createTable('user', [
            'id' => 'pk',
            'login' => Schema::TYPE_STRING . ' NOT NULL',
            'password' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('news');
        $this->dropTable('user');
    }

}
</pre>
<p>当代码使用多于一条查询时推荐使用 <code>safeUp</code> 和 <code>safeDown</code> 。</p>
<blockquote>
<p>注意：不是所有的 DBMS 都支持事务，并且有些 DB 查询不能用事务表示。这种情况，必须用 <code>up()</code> 和<code>down()</code> 方法替代实现。对于 MySQL，有些 SQL 语句会引发<a href="http://dev.mysql.com/doc/refman/5.1/en/implicit-commit.html" target="_blank">隐式提交</a>。</p>
</blockquote>
<p>&nbsp;</p>
<h2>应用迁移</h2>
<p>要应用所有可用的新迁移（如，升级本地数据库），运行以下命令：</p>
<pre class="brush: php;toolbar: false">yii migrate</pre>
<p>该命令将显示所有新迁移列表。如果你确认应用这些迁移，它将会按类名的时间戳一个接一个地运行每个新迁移类的 <code>up()</code> 方法。</p>
<p>应用迁移成功后，迁移工具将在名为 <code>migration</code> 的数据库表保持迁移记录。这就允许该工具区分应用和未应用的迁移。如果 <code>migration</code> 表不存在，迁移工具将通过 <code>db</code> 组件自动在数据库中创建。</p>
<p>有时，我们只想应用一个或少量的新迁移，可以使用以下命令：<code> </code></p>
<pre class="brush: php;toolbar: false">yii migrate/up 3</pre>
<p>这个命令将应用3个新的迁移，改变这个值就改变拟应用的迁移数量。</p>
<p>也可以迁移数据库到特定版本，命令如下：<code> </code></p>
<pre class="brush: php;toolbar: false">yii migrate/to 101129_185401</pre>
<p>那就是，使用迁移数据表名的时间戳部分来指定需要迁移数据库的版本。如果在最后应用的迁移和指定迁移间有多个迁移，所有这些迁移将被应用。如果指定的迁移已经被应用，那么所有在其后应用的迁移将回退（指南下一节将描述）。</p>
<p>&nbsp;</p>
<h2>迁移回退（恢复、回滚）</h2>
<p>要恢复上一个或多个已应用的迁移，可以使用以下命令：</p>
<pre class="brush: php;toolbar: false">yii migrate/down [step]</pre>
<p>其中可选项<code> step </code>参数指定多少迁移将被恢复。缺省为 <code>1</code> ，即回退上一个被应用的迁移。</p>
<p>如前所述，并不是所有的迁移都能恢复。尝试回退这些不能恢复的迁移将抛出一个异常并终止整个回退流程。</p>
<p>&nbsp;</p>
<h2>重做迁移</h2>
<p>重做迁移就是首先回退然后应用指定的迁移，用以下命令完成：</p>
<pre class="brush: php;toolbar: false">yii migrate/redo [step]</pre>
<p>其中可选项<code> step </code>参数指定了重做多少迁移。默认为<code> 1</code> ，即重做上一个迁移。</p>
<p>&nbsp;</p>
<h2>显示迁移信息</h2>
<p>除了应用和回退迁移，迁移工具还能显示迁移历史和拟应用的新迁移：</p>
<pre class="brush: php;toolbar: false">
yii migrate/history [limit]
yii migrate/new [limit]
</pre>
<p>其中可选项 <code>limit</code> 参数指定了要显示的迁移数量。如果 <code>limit</code> 未指定，将显示所有可用的迁移。</p>
<p>第一条命令显示被应用的所有迁移，而第二条命令显示没有被应用的所有新迁移。</p>
<p>&nbsp;</p>
<h2>修改迁移历史</h2>
<p>有时，想修改迁移历史到特定的迁移版本，而不要真的应用或回退相关的迁移。当开发新迁移时经常发生这种需求。使用以下命令实现该目标：</p>
<pre class="brush: php;toolbar: false">yii migrate/mark 101129_185401</pre>
<p>该命令和<code>yii migrate/to</code>命令非常相似，除了只修改迁移历史表来指定版本，而不应用或恢复该迁移。</p>
<pre class="brush: php;toolbar: false"></pre>
<p>&nbsp;</p>
<h2>自定义迁移命令</h2>
<p>自定义迁移命令有几种方法。</p>
<h3>使用命令行选项</h3>
<p>迁移命令有五（？原文是四）个可指定的命令行选项：</p>
<ul class="task-list">
<li>
<p><code>interactive</code> ：布尔值，指定交互模式中是否执行迁移。默认为 true ，即执行特定迁移时将给用户弹出提示。可设置为 false 使迁移在后台执行。</p>
</li>
<li>
<p><code>migrationPath</code> ：字符串，指定存储所有迁移类文件的目录。必须以路径别名的形式提供，且相应的目录必须存在。如未指定该选项，将使用应用根路径下的 <code>migrations</code> 子目录。</p>
</li>
<li>
<p><code>migrationTable</code>：字符串，指定存储迁移历史信息的数据表名。默认为 <code>migration</code> ，表结构是 <code>version varchar(255) primary key, apply_time integer</code> 。</p>
</li>
<li>
<p><code>connectionID</code>：字符串，指定数据库连接应用组件的 ID ，默认为 'db'。</p>
</li>
<li>
<p><code>templateFile</code>：字符串，指定用作迁移类生成模板的文件路径。必须以路径别名形式指定（如 <code>application.migrations.template</code>）。如未设置，将使用内部模板。模板内的占位符 <code>{ClassName}</code> 将用实际的迁移类名替换。</p>
</li>
</ul>
<p>要指定这些选项，执行以下格式的迁移命令：</p>
<pre class="brush: php;toolbar: false">yii migrate/up --option1=value1 --option2=value2 ...</pre>
<p>例如，如果想迁移 <code>forum</code> 模块，其迁移文件放在模块内部的 <code>migrations</code> 目录，可以使用以下命令：</p>
<pre class="brush: php;toolbar: false">yii migrate/up --migrationPath=@app/modules/forum/migrations</pre>
<h3>全局配置命令</h3>
<p>虽然命令行选项允许我们在运行时实时配置迁移命令，但有时也想一劳永逸地配置命令。例如，要用其他表来存储迁移历史，或想使用自定义迁移模板。可以如下修改控制台应用的配置文件实现：</p>
<pre class="brush: php;toolbar: false">
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationTable' => 'my_custom_migrate_table',
    ],
]
</pre>
<p>现在只要运行<code> migrate </code>命令，以上配置就会生效，无须我们每次输入命令行选项。其他命令选项也可以如此配置。</p>
