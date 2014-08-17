<h1>国际化</h1>
<p>国际化（I18N）指软件应用设计成无须改动引擎即可应用于不同语言和地区的过程。对于 web 应用，这点特别重要，因为潜在用户是全球范围的。</p>
<p>&nbsp;</p>
<h2>地区和语言</h2>
<p>在 Yii 应用中定义了两个语言属性：[[yii\base\Application::$sourceLanguage|source language]]和[[yii\base\Application::$language|target language]]。源语言是应用消息原始编写语言：</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'I am a message!');
</pre>
<blockquote>
<p>提示：默认是英语，推荐不要更改。原因是人们翻译英语到其他语言比非英语翻译到其他语言更容易。</p>
</blockquote>
<p>目标语言是当前使用的语言，在应用配置中如下定义：</p>
<pre class="brush: php;toolbar:false;">
// ...
return [
    'id' => 'applicationID',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU' // ← 在这里！
</pre>
<p>然后就能容易地实时更改：</p>
<pre class="brush: php;toolbar:false;">
\Yii::$app->language = 'zh-CN';
</pre>
<p>格式是 <code>ll-CC</code> ，其中 <code>ll</code> 是语言的两个或三个小写字母代码，根据<a href="http://www.loc.gov/standards/iso639-2/" target="_blank">ISO-639</a>分配确定，而 <code>CC</code> 是国家代码，根据<a href="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1.html" target="_blank">ISO-3166</a>分配确定。</p>
<p>如果没有 <code>ru-RU</code> 翻译文件，Yii 将在提示失败前尝试查找 <code>ru</code> 翻译文件。</p>
<blockquote>
<p><strong>注意</strong>：你能更进一步地自定义指定语言的细节<a href="http://userguide.icu-project.org/locale#TOC-The-Locale-Concept" target="_blank">as documented in ICU project</a>.</p>
</blockquote>
<p>&nbsp;</p>
<h2>消息翻译</h2>
<h3>基础</h3>
<p>Yii 基础消息翻译在基本的变换工作中无须使用其他 PHP 扩展。它要做的只是查找从源语言翻译到目标语言的消息翻译文件。消息以<code>\Yii::t</code> 方法的第二个参数来指定：</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'This is a string to translate!');
</pre>
<p>Yii 将尝试从定义在<code> i18n </code>组件配置中的消息源加载适当的翻译：</p>
<pre class="brush: php;toolbar:false;">
'components' => [
    // ...
    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@app/messages',
                //'sourceLanguage' => 'en',
                'fileMap' => [
                    'app' => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
        ],
    ],
],
</pre>
<p>以上 <code>app*</code> 指定了该消息源处理哪些类别的消息。这个例子中我们处理以 <code>app</code>开头的所有消息。你也可以指定缺省翻译，更多消息请参考<a href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/i18n.md#examples">i18n 示例</a>.</p>
<p><code>class</code> 定义使用哪个消息源。以下消息源是可用的：</p>
<ul class="task-list">
<li>PhpMessageSource 使用 PHP 文件保存</li>
<li>GettextMessageSource 使用 GNU Gettext MO 或 PO 文件保存</li>
<li>DbMessageSource 使用数据库保存</li>
</ul>
<p><code>basePath</code> 定义当前使用消息源在哪里保存消息。该例中保存在应用的 <code>messages</code> 目录。使用数据库保存的情况要跳过这个选项。</p>
<p><code>sourceLanguage</code> 定义 <code>\Yii::t</code> 第二个参数使用的语言。如未定义，将使用应用的代码语言。</p>
<p><code>fileMap</code> 在<code>PhpMessageSource</code> 使用时定义指定在 <code>\Yii::t()</code> 第一个参数的消息类别如何映射到文件。该例中我们定义了两个类别 <code>app</code> 和 <code>app/error</code> 。</p>
<p>依靠<code>BasePath/messages/LanguageID/CategoryName.php</code> 这样约定好的翻译文件格式可省略配置 <code>fileMap</code> 。</p>
<h4>命名占位符</h4>
<p>可以添加参数到翻译消息，翻译后这些参数将被对应的值替换。格式是使用大括号包围参数名，如下所示：</p>
<pre class="brush: php;toolbar:false;">
$username = 'Alexander';
echo \Yii::t('app', 'Hello, {username}!', [
    'username' => $username,
]);
</pre>
<p>注意给参数赋值没有大括号。</p>
<h4>位置占位符</h4>
<pre class="brush: php;toolbar:false;">
$sum = 42;
echo \Yii::t('app', 'Balance: {0}', $sum);
</pre>
<blockquote>
<p><strong>提示</strong>：要努力保持消息字符串有意义和避免使用太多位置参数。记住翻译者只有源字符串，所以每个占位符替换什么必须是清晰明确的。</p>
</blockquote>
<h3>高级占位符格式</h3>
<p>要使用高级功能需要安装和启用 <a href="http://www.php.net/manual/en/intro.intl.php" target="_blank">intl</a> PHP 扩展。安装并启用这个扩展后就能够对占位符使用扩展语法。可以是默认设置的缩写形式<code>{placeholderName, argumentType}</code> ，也可以是允许指定格式风格的完整形式 <code>{placeholderName, argumentType, argumentStyle}</code> 。</p>
<p>完整参考请看<a href="http://icu-project.org/apiref/icu4c/classMessageFormat.html" target="_blank">available at ICU website</a>。但它有点晦涩，我们在下面提供自己的参考。</p>
<h4>数字</h4>
<pre class="brush: php;toolbar:false;">
$sum = 42;
echo \Yii::t('app', 'Balance: {0, number}', $sum);
</pre>
<p>你可以指定内置格式风格 (<code>integer</code>, <code>currency</code>, <code>percent</code>)的其中一个：</p>
<pre class="brush: php;toolbar:false;">
$sum = 42;
echo \Yii::t('app', 'Balance: {0, number, currency}', $sum);
</pre>
<p>或指定自定义格式：</p>
<pre class="brush: php;toolbar:false;">
$sum = 42;
echo \Yii::t('app', 'Balance: {0, number, ,000,000000}', $sum);
</pre>
<p><a href="http://icu-project.org/apiref/icu4c/classicu_1_1DecimalFormat.html" target="_blank">格式参考</a>。</p>
<h4>日期</h4>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'Today is {0, date}', time());
</pre>
<p>内置格式有 (<code>short</code>, <code>medium</code>, <code>long</code>, <code>full</code>):</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'Today is {0, date, short}', time());
</pre>
<p>自定义格式：</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'Today is {0, date, YYYY-MM-dd}', time());
</pre>
<p><a href="http://icu-project.org/apiref/icu4c/classicu_1_1SimpleDateFormat.html" target="_blank">格式参考</a>。</p>
<h4>时间</h4>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'It is {0, time}', time());
</pre>
<p>内置格式 (<code>short</code>, <code>medium</code>, <code>long</code>, <code>full</code>):</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'It is {0, time, short}', time());
</pre>
<p>自定义格式：</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'It is {0, date, HH:mm}', time());
</pre>
<p><a href="http://icu-project.org/apiref/icu4c/classicu_1_1SimpleDateFormat.html" target="_blank">格式参考</a>。</p>
<h4>拼出</h4>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', '{n,number} is spelled as {n, spellout}', ['n' => 42]);
</pre>
<h4>序数</h4>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'You are {n, ordinal} visitor here!', ['n' => 42]);
</pre>
<p>将输出 "You are 42nd visitor here!"。</p>
<h4>期间</h4>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'You are here for {n, duration} already!', ['n' => 47]);
</pre>
<p>将输出 "You are here for 47 sec. already!"。</p>
<h4>复数</h4>
<p>不同语言的复数表现形式不同。有些规则非常复杂，所以非常方便，已提供的功能不需要指定转化规则。相反它只需要在指定的位置输入转化好的单词即可。</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', 'There {n, plural, =0{are no cats} =1{is one cat} other{are # cats}}!', ['n' => 0]);
</pre>
<p>将输出 "There are no cats!"。</p>
<p>在以上的复数规则参数， <code>=0</code> 指恰好等于零， <code>=1</code> 指恰好是一个，而 <code>other</code> 是此外的所有数字。<code>#</code> 将用 <code>n</code> 参数值替换。但不是所有语言都像英语这么简单，如俄语的例子：</p>
<pre class="brush: php;toolbar:false;">
Здесь {n, plural, =0{котов нет} =1{есть один кот} one{# кот} few{# кота} many{# котов} other{# кота}}!
</pre>
<p>以上要提出的是 <code>=1</code> 精确匹配 <code>n = 1</code> 但 <code>one</code> 匹配 <code>21</code> 或 <code>101</code> 。</p>
<p>注意如果使用两次占位符，一次用来表示复数而另一处要用来表示数字，否则将会输出 "Inconsistent types declared for an argument: U_ARGUMENT_TYPE_MISMATCH" 错误：</p>
<pre class="brush: php;toolbar:false;">
Total {count, number} {count, plural, one{item} other{items}}.
</pre>
<p>了解你的语言要用哪个转化形式可以参考<a href="http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html" target="_blank">rules reference at unicode.org</a>。</p>
<h4>选集</h4>
<p>可以基于关键词挑选短语，这种例子的格式指定了怎样映射关键词到短信并提供了默认短语。</p>
<pre class="brush: php;toolbar:false;">
echo \Yii::t('app', '{name} is {gender} and {gender, select, female{she} male{he} other{it}} loves Yii!', [
    'name' => 'Snoopy',
    'gender' => 'dog',
]);
</pre>
<p>将输出 "Snoopy is dog and it loves Yii!".</p>
<p>在表达式中 <code>female</code> 和 <code>male</code> 都是可选值，而 <code>other</code> 处理那些不匹配前两者的值。大括号内的字符串是子表达式所以可以是一个字符串也可以是字符串和占位符。</p>
<h3>指定默认翻译</h3>
<p>可以指定默认翻译作为回调函数用于某些不需要匹配其他翻译的类别。该翻译要用 <code>*</code> 标记。要做到这一点需要添加以下代码到配置文件( <code>yii2-basic</code> 应用的话是 <code>web.php</code>)：</p>
<pre class="brush: php;toolbar:false;">
//配置 i18n 组件

'i18n' => [
    'translations' => [
        '*' => [
            'class' => 'yii\i18n\PhpMessageSource'
        ],
    ],
],
</pre>
<p>现在无须逐个配置就能使用类别，这和 Yii 1.1 行为是类似的。类别的消息将从默认翻译根路径（ <code>basePath</code> ）即<code>@app/messages</code> 下的文件加载：</p>
<pre class="brush: php;toolbar:false;">
echo Yii::t('not_specified_category', 'message from unspecified category');
</pre>
<p>消息将从 <code>@app/messages/&lt;LanguageCode>/not_specified_category.php</code> 加载。</p>
<h3>翻译小部件消息</h3>
<p>对小部件也使用相同规则，如：</p>
<pre class="brush: php;toolbar:false;">
&lt;?php

namespace app\widgets\menu;

use yii\base\Widget;
use Yii;

class Menu extends Widget
{

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['widgets/menu/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@app/widgets/menu/messages',
            'fileMap' => [
                'widgets/menu/messages' => 'messages.php',
            ],
        ];
    }

    public function run()
    {
        echo $this->render('index');
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('widgets/menu/' . $category, $message, $params, $language);
    }

}
</pre>
<p>要省略 <code>fileMap</code> 设置，只要简单地遵循类别和同名文件的映射约定并直接使用 <code>Menu::t('messages', 'new messages {messages}', ['{messages}' =&gt; 10])</code> 即可。</p>
<blockquote>
<p><strong>注意</strong>：小部件也可使用 i18n 视图，规则和它们应用在控制器上是一样的。</p>
</blockquote>
<h3>翻译框架消息</h3>
<p>有时你想要为你的应用校正默认的框架消息翻译文件，可以如下配置<code>i18n</code> 组件：</p>
<pre class="brush: php;toolbar:false;">
'components' => [
    'i18n' => [
        'translations' => [
            'yii' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '/path/to/my/message/files'
            ],
        ],
    ],
],
</pre>
<p>现在你可以在 <code>/path/to/my/message/files</code> 放入已调整过的翻译文件了。</p>
<h2>视图</h2>
<p>可以在视图使用 i18n 来支持不同语言。例如，给视图 <code>views/site/index.php</code> 创建俄语版本，就要在当前控制器/小部件的视图路径下创建 <code>ru-RU</code> 文件夹并放入俄语版本的视图文件 <code>views/site/ru-RU/index.php</code>。</p>
<blockquote>
<p><strong>注意</strong>：如果指定的语言为 <code>en-US</code> 且没有对应的视图， Yii 将在使用原始视图文件前查找 <code>en</code> 下的视图文件。</p>
</blockquote>
<h2>i18n 格式器</h2>
<p>i18n 格式器组件是格式器的本地化版本，支持基于当前时区的日期、时间和数字的格式化。要使用格式器须配置格式器应用组件如下：</p>
<pre class="brush: php;toolbar:false;">
return [
    // ...
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
    ],
];
</pre>
<p>配置组件后就能用 <code>Yii::$app-&gt;formatter</code> 连接格式器了。</p>
<p>注意要使用 i18n 格式器先要安装和启用<a href="http://www.php.net/manual/en/intro.intl.php" target="_blank">intl</a> PHP 扩展。</p>
<p>要了解格式器方法请参考它的 API 文档：[[yii\i18n\Formatter]]。</p>