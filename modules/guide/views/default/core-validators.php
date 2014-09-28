<h1>核心验证器（Core Validators）</h1>
<p>Yii 提供一系列常用的核心验证器，主要存在于<code>yii\validators</code>命名空间之下。为了避免使用冗长的类名，你可以直接用<em>别名</em>来指定相应的核心验证器。比如你可以用<code>required</code><strong>别名</strong>代指 [[yii\validators\RequiredValidator]] 类：</p>
<pre class="brush: php;toolbar:false;">
public function rules()
{
    return [
        [['email', 'password'], 'required'],
    ];
}
</pre>
<p>[[yii\validators\Validator::builtInValidators]] 属性声明了所有被支持的验证器别名。</p>
<p>下面，我们将详细介绍每一种验证器的主要用法和属性。</p>
<p>&nbsp;</p><h2>布尔型（boolean）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "selected" 是否为 0 或 1，无视数据类型
    ['selected', 'boolean'],

    // 检查 "deleted" 是否为布尔类型，即 true 或 false
    ['deleted', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => true],
]
</pre>
<p>该验证器检查输入值是否为一个布尔值。</p>
<ul>
	<li><code>trueValue</code>： 代表真的值。默认为<code>'1'</code>。</li>
	<li><code>falseValue</code>：代表假的值。默认为<code> '0'</code>。</li>
	<li><code>strict</code>：是否要求待测输入必须严格匹配<code>trueValue</code>或<code>falseValue</code>。默认为<code>false</code>。</li>
</ul>
<blockquote>
	<p>注意：因为通过 HTML 表单传递的输入数据都是字符串类型，所以一般情况下你都需要保持 [[yii\validators\BooleanValidator::strict|strict]] 属性为假。</p>
</blockquote>
<p>&nbsp;</p><h2>验证码（captcha）</h2>
<pre class="brush: php;toolbar:false;">
[
    ['verificationCode', 'captcha'],
]
</pre>
<p>该验证器通常配合 [[yii\captcha\CaptchaAction]] 以及 [[yii\captcha\Captcha]] 使用，以确保某一输入与 [[yii\captcha\Captcha|CAPTCHA]] 小部件所显示的验证代码（verification code）相同。</p>
<ul>
	<li><code>caseSensitive</code>：对验证代码的比对是否要求大小写敏感。默认为 false。</li>
	<li><code>captchaAction</code>：指向用于渲染 CAPTCHA 图片的 [[yii\captcha\CaptchaAction|CAPTCHA action]] 的路由。默认为 <code>'site/captcha'</code>。</li>
	<li><code>skipOnEmpty</code>：当输入为空时，是否跳过验证。默认为 false，也就是输入值为必需项。</li>
</ul>
<p>&nbsp;</p><h2>比较（compare）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "password" 特性的值是否与 "password_repeat" 的值相同
    ['password', 'compare'],

    // 检查年龄是否大于等于 30
    ['age', 'compare', 'compareValue' => 30, 'operator' => '>='],
]
</pre>
<p>该验证器比较两个特定输入值之间的关系是否与<code>operator</code>属性所指定的相同。</p>
<ul>
	<li><code>compareAttribute</code>：用于与原特性相比较的特性名称。当该验证器被用于验证某目标特性时，该属性会默认为目标属性加后缀<code>_repeat</code>。举例来说，若目标特性为<cdoe>password</cdoe>，则该属性默认为<code>password_repeat</code>。</li>
	<li><code>compareValue</code>：用于与输入值相比较的常量值。当该属性与<code>compareAttribute</code>属性同时被指定时，该属性优先被使用。</li>
	<li><code>operator</code>：比较操作符。默认为<code>==</code>，意味着检查输入值是否与<code>compareAttribute</code> 或<code>compareValue</code>的值相等。该属性支持如下操作符：
		<ul>
			<li><code>==</code>：检查两值是否相等。比对为非严格模式。</li>
			<li><code>===</code>：检查两值是否全等。比对为严格模式。</li>
			<li><code>!=</code>：检查两值是否不等。比对为非严格模式。</li>
			<li><code>!==</code>：检查两值是否不全等。比对为严格模式。</li>
			<li><code>></code>：检查待测目标值是否大于给定被测值。</li>
			<li><code></code>：检查待测目标值是否大于等于给定被测值。</li>
			<li><code>&lt;</code>：检查待测目标值是否小于给定被测值。</li>
			<li><code>&lt;=</code>：检查待测目标值是否小于等于给定被测值。</li>
		</ul>
	</li>
</ul>
<p>&nbsp;</p><h2>日期（date）</h2>
<pre class="brush: php;toolbar:false;">
[
    [['from', 'to'], 'date'],
]
</pre>
<p>该验证器检查输入值是否为适当格式的 date，time，或者 datetime。另外，它还可以帮你把输入值转换为一个 UNIX 时间戳并保存到 [[yii\validators\DateValidator::timestampAttribute|timestampAttribute]] 属性所指定的特性里。</p>
<ul>
	<li><code>format</code>：待测的 日期/时间 格式。请参考<a href="http://www.php.net/manual/zh/datetime.createfromformat.php" target="_blank"> date_create_from_format() </a>相关的 PHP 手册了解设定格式字符串的更多细节。默认值为<code>'Y-m-d'</code>。</li>
	<li><code>timestampAttribute</code>：用于保存用输入时间/日期转换出来的 UNIX 时间戳的特性。	</li>
</ul>
<p>&nbsp;</p><h2>默认值（default）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 若 "age" 为空，则将其设为 null
    ['age', 'default', 'value' => null],

    // 若 "country" 为空，则将其设为 "USA"
    ['country', 'default', 'value' => 'USA'],

    // 若 "from" 和 "to" 为空，则分别给他们分配自今天起，3 天后和 6 天后的日期。
    [['from', 'to'], 'default', 'value' => function ($model, $attribute) {
        return date('Y-m-d', strtotime($attribute === 'to' ? '+3 days' ：'+6 days'));
    }],
]
</pre>
<p>该验证器并不进行数据验证。而是，给为空的待测特性分配默认值。</p>
<p><code>value</code>：默认值，或一个返回默认值的 PHP Callable 对象（即回调函数）。它们会分配给检测为空的待测特性。PHP 回调方法的样式如下：</p>
<pre class="brush: php;toolbar:false;">
function foo($model, $attribute) {
    // ... 计算 $value ...
    return $value;
}
</pre>
<p>&nbsp;</p><h2>双精度浮点型（double）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "salary" 是否为浮点数
    ['salary', 'double'],
]
</pre>
<p>该验证器检查输入值是否为双精度浮点数。他等效于number验证器。</p>
<ul>
	<li><code>max</code>：上限值（含界点）。若不设置，则验证器不检查上限。</li>
	<li><code>min</code>：下限值（含界点）。若不设置，则验证器不检查下限。</li>
</ul>
<p>&nbsp;</p><h2>电子邮件（email）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "email" 是否为有效的邮箱地址
    ['email', 'email'],
]
</pre>
<p>该验证器检查输入值是否为有效的邮箱地址。</p>
<ul>
	<li><code>allowName</code>：检查是否允许带名称的电子邮件地址 (e.g. 张三 <code>&lt;John.san@example.com></code>)。 默认为 false。</li>
	<li><code>checkDNS</code>：检查邮箱域名是否存在，且有没有对应的 A 或 MX 记录。不过要知道，有的时候该项检查可能会因为临时性 DNS 故障而失败，哪怕它其实是有效的。默认为 false。</li>
	<li>enableIDN：验证过程是否应该考虑 IDN（internationalized domain names，国际化域名，也称多语种域名，比如中文域名）。默认为 false。要注意但是为使用 IDN 验证功能，请先确保安装并开启 <code>intl</code> PHP 扩展，不然会导致抛出异常。</li>
</ul>
<p>&nbsp;</p><h2>存在性（exist）</h2>
<pre class="brush: php;toolbar:false;">
[
    // a1 需要在 "a1" 特性所代表的字段内存在
    ['a1', 'exist'],

    // a1 必需存在，但检验的是 a1 的值在字段 a2 中的存在性
    ['a1', 'exist', 'targetAttribute' => 'a2'],

    // a1 和 a2 的值都需要存在，且它们都能收到错误提示
    [['a1', 'a2'], 'exist', 'targetAttribute' => ['a1', 'a2']],

    // a1 和 a2 的值都需要存在，只有 a1 能接收到错误信息
    ['a1', 'exist', 'targetAttribute' => ['a1', 'a2']],

    // 通过同时在 a2 和 a3 字段中检查 a2 和 a1 的值来确定 a1 的存在性
    ['a1', 'exist', 'targetAttribute' => ['a2', 'a1' => 'a3']],

    // a1 必需存在，若 a1 为数组，则其每个子元素都必须存在。
    ['a1', 'exist', 'allowArray' => true],
]
</pre>
<p>该验证器检查输入值是否在某表字段中存在。它只对<a href="0603.html"> 活动记录 </a>类型的模型类特性起作用，能支持对一个或多过字段的验证。</p>
<ul>
	<li><code>argetClass</code>：用于查找输入值的目标 AR 类。若不设置，则会使用正在进行验证的当前模型类。</li>
	<li><code>targetAttribute</code>：用于检查输入值存在性的<code>targetClass</code>的模型特性。
		<ul>
			<li>若不设置，它会直接使用待测特性名（整个参数数组的首元素）。</li>
			<li>除了指定为字符串以外，你也可以用数组的形式，同时指定多个用于验证的表字段，数组的键和值都是代表字段的特性名，值表示<code>targetClass</code>的待测数据源字段，而键表示当前模型的待测特性名。</li>
			<li>若键和值相同，你可以只指定值。（如:<code>['a2']</code>就代表<code>['a2'=>'a2']</code>）</li>
		</ul>
	</li>
	<li><code>filter</code>：用于检查输入值存在性必然会进行数据库查询，而该属性为用于进一步筛选该查询的过滤条件。可以为代表额外查询条件的字符串或数组（关于查询条件的格式，请参考 [[yii\db\Query::where()]]）；或者样式为<code>function ($query)</code>的匿名函数，<code>$query</code>参数为你希望在该函数内进行修改的 [[yii\db\Query|Query]] 对象。</li>
	<li><code>allowArray</code>：是否允许输入值为数组。默认为 false。若该属性为 true 且输入值为数组，则数组的每个元素都必须在目标字段中存在。值得注意的是，若用吧<code>targetAttribute</code>设为多元素数组来验证被测值在多字段中的存在性时，该属性不能设置为 true。</li>
</ul>
<blockquote>
	<p>译者注：exist 和 unique 验证器的机理和参数都相似，有点像一体两面的阴和阳。</p>
	<ul>
		<li>他们的区别是 exist 要求<code>targetAttribute</code>键所代表的的属性在其值所代表字段中找得到；而 unique 正相反，要求键所代表的的属性不能在其值所代表字段中被找到。</li>
		<li>从另一个角度来理解：他们都会在验证的过程中执行数据库查询，查询的条件即为where $v=$k (假设<code>targetAttribute</code>的其中一对键值对为<code>$k => $v</code>)。unique 要求查询的结果数<code>$count==0</code>，而<code>exist</code>则要求查询的结果数<code> $count>0</code></li>
		<li>最后别忘了，unique 验证器不存在<code>allowArray</code>属性哦。</li>
	</ul>
</blockquote>
<p>&nbsp;</p><h2>文件（file）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "primaryImage" 是否为 PNG, JPG 或 GIF 格式的上传图片。
    // 文件大小必须小于  1MB
    ['primaryImage', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024*1024],
]
</pre>
<p>该验证器检查输入值是否为一个有效的上传文件。</p>
<ul>
	<li><code>extensions</code>：可接受上传的文件扩展名列表。它可以是数组，也可以是用空格或逗号分隔各个扩展名的字符串 (e.g. "gif, jpg")。 扩展名大小写不敏感。默认为 null，意味着所有扩展名都被接受。</li>
	<li><code>mimeTypes</code>：可接受上传的 MIME 类型列表。它可以是数组，也可以是用空格或逗号分隔各个 MIME 的字符串 (e.g. "image/jpeg, image/png")。 Mime 类型名是大小写不敏感的。默认为 null，意味着所有 MIME 类型都被接受。</li>
	<li><code>minSize</code>：上传文件所需最少多少 Byte 的大小。默认为 null，代表没有下限。</li>
	<li><code>maxSize</code>：上传文件所需最多多少 Byte 的大小。默认为 null，代表没有上限。</li>
	<li><code>maxFiles</code>：给定特性最多能承载多少个文件。默认为 1，代表只允许单文件上传。若值大于一，那么输入值必须为包含最多 maxFiles 个上传文件元素的数组。</li>
	<li><code>checkExtensionByMimeType</code>：是否通过文件的 MIME 类型来判断其文件扩展。若由 MIME 判定的文件扩展与给定文件的扩展不一样，则文件会被认为无效。默认为 true，代表执行上述检测。</li>
</ul>
<p><code>FileValidator</code>通常与 [[yii\web\UploadedFile]] 共同使用。请参考 文件上传章节来了解有关文件上传与上传文件的检验的全部内容。</p>
<p>&nbsp;</p><h2>过滤器（filter）</h2>
<pre class="brush: php;toolbar:false;">
[
    // trim 掉 "username" 和 "email" 输入
    [['username', 'email'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],

    // 标准化 "phone" 输入
    ['phone', 'filter', 'filter' => function ($value) {
        // 在此处标准化输入的电话号码
        return $value;
    }],
]
</pre>
<p>该验证器并不进行数据验证。而是，给输入值应用一个滤镜，并在检验过程之后把它赋值回特性变量。</p>
<ul>
	<li><code>filter</code>：用于定义滤镜的 PHP 回调函数。可以为全局函数名，匿名函数，或其他。该函数的样式必须是 <code>function ($value) { return $newValue; }</code>。该属性不能省略，必须设置。</li>
	<li><code>skipOnArray</code>：是否在输入值为数组时跳过滤镜。默认为 false。请注意如果滤镜不能处理数组输入，你就应该把该属性设为 true。否则可能会导致 PHP Error 的发生。</li>
</ul>
<blockquote>
	<p>技巧：如果你只是想要用 trim 处理下输入值，你可以直接用 trim 验证器的。</p>
</blockquote>
<p>&nbsp;</p><h2>图片（image）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "primaryImage" 是否为适当尺寸的有效图片
    ['primaryImage', 'image', 'extensions' => 'png, jpg',
        'minWidth' => 100, 'maxWidth' => 1000,
        'minHeight' => 100, 'maxHeight' => 1000,
    ],
]
</pre>
<p>该验证器检查输入值是否为代表有效的图片文件。它继承自 file 验证器，并因此继承有其全部属性。除此之外，它还支持以下为图片检验而设的额外属性：</p>
<ul>
	<li><code>minWidth</code>：图片的最小宽度。默认为 null，代表无下限。</li>
	<li><code>maxWidth</code>：图片的最大宽度。默认为 null，代表无上限。</li>
	<li><code>minHeight</code>：图片的最小高度。 默认为 null，代表无下限。</li>
	<li><code>maxHeight</code>：图片的最大高度。默认为 null，代表无上限。</li>
</ul>
<p>&nbsp;</p><h2>范围（in）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "level" 是否为 1、2 或 3 中的一个
    ['level', 'in', 'range' => [1, 2, 3]],
]
</pre>
<p>该验证器检查输入值是否存在于给定列表的范围之中。</p>
<ul>
	<li><code>range</code>：用于检查输入值的给定值列表。</li>
	<li><code>strict</code>：输入值与给定值直接的比较是否为严格模式（也就是类型与值都要相同，即全等）。默认为 false。</li>
	<li><code>not</code>：是否对验证的结果取反。默认为 false。当该属性被设置为 true，验证器检查输入值是否<strong>不在</strong>给定列表内。</li>
	<li><code>allowArray</code>：是否接受输入值为数组。当该值为 true 且输入值为数组时，数组内的每一个元素都必须在给定列表内存在，否则返回验证失败。</li>
</ul>
<p>&nbsp;</p><h2>整数（integer）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "age" 是否为整数
    ['age', 'integer'],
]
</pre>
<p>该验证器检查输入值是否为整形。</p>
<ul>
	<li><code>max</code>：上限值（含界点）。若不设置，则验证器不检查上限。</li>
	<li><code>min</code>：下限值（含界点）。若不设置，则验证器不检查下限。</li>
</ul>
<p>&nbsp;</p><h2>正则表达式（match）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "username" 是否由字母开头，且只包含单词字符
    ['username', 'match', 'pattern' => '/^[a-z]\w*$/i']
]
</pre>
<p>该验证器检查输入值是否匹配指定正则表达式。</p>
<ul>
	<li><code>pattern</code>：用于检测输入值的正则表达式。该属性是必须的，若不设置则会抛出异常。</li>
	<li><code>not</code>：是否对验证的结果取反。默认为 false，代表输入值匹配正则表达式时验证成功。如果设为 true，则输入值不匹配正则时返回匹配成功。</li>
</ul>
<p>&nbsp;</p><h2>数字（number）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "salary" 是否为数字
    ['salary', 'number'],
]
</pre>
<p>该验证器检查输入值是否为数字。他等效于 double 验证器。</p>
<ul>
	<li><code>min</code>：上限值（含界点）。若不设置，则验证器不检查上限。</li>
	<li><code>min</code>：下限值（含界点）。若不设置，则验证器不检查下限。</li>
</ul>
<p>&nbsp;</p><h2>必填（required）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "username" 与 "password" 是否为空
    [['username', 'password'], 'required'],
]
</pre>
<p>该验证器检查输入值是否为空，还是已经提供了。</p>
<ul>
	<li><code>requiredValue</code>：所期望的输入值。若没设置，意味着输入不能为空。</li>
	<li><code>strict</code>：检查输入值时是否检查类型。默认为 false。当没有设置<code>requiredValue</code>属性时，若该属性为 true，验证器会检查输入值是否严格为 null；若该属性设为 false，该验证器会用一个更加宽松的规则检验输入值是否为空。</li>
</ul>
<p>当设置<code>requiredValue</code>属性时，若该属性为 true，输入值与<code>requiredValue</code>的比对会同时检查数据类型。</p>
<blockquote>
	<p>补充：如何判断待测值是否为空，被写在另外一个话题的处理空输入章节。</p>
</blockquote>
<p>&nbsp;</p><h2>安全（safe）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 标记 "description" 为安全特性
    ['description', 'safe'],
]
</pre>
<p>该验证器并不进行数据验证。而是把一个特性标记为安全特性。</p>
<p>&nbsp;</p><h2>字符串（string）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "username" 是否为长度 4 到 24 之间的字符串
    ['username', 'string', 'length' => [4, 24]],
]
</pre>
<p>该验证器检查输入值是否为特定长度的字符串。并检查特性的值是否为某个特定长度。</p>
<ul>
	<li>length：指定待测输入字符串的长度限制。该属性可以被指定为以下格式之一：
		<ul>
			<li>证书：the exact length that the string should be of;</li>
			<li>单元素数组：代表输入字符串的最小长度 (e.g. <code>[8]</code>)。这会重写<code>min</code>属性。</li>
			<li>包含两个元素的数组：代表输入字符串的最小和最大长度(e.g. <code>[8, 128]</code>)。 这会同时重写<code>min</code>和<code>max</code>属性。</li>
		</ul>
	</li>
	<li><code>min</code>：输入字符串的最小长度。若不设置，则代表不设下限。</li>
	<li><code>max</code>：输入字符串的最大长度。若不设置，则代表不设上限。</li>
	<li><code>encoding</code>：待测字符串的编码方式。若不设置，则使用应用自身的 [[yii\base\Application::charset|charset]] 属性值，该值默认为<code>UTF-8</code>。</li>
</ul>
<p>&nbsp;</p><h2>去空格（trim）</h2>
<pre class="brush: php;toolbar:false;">
[
    // trim 掉 "username" 和 "email" 两侧的多余空格
    [['username', 'email'], 'trim'],
]
</pre>
<p>该验证器并不进行数据验证。而是，trim 掉输入值两侧的多余空格。注意若该输入值为数组，那它会忽略掉该验证器</p>
<p>&nbsp;</p><h2>唯一性（unique）</h2>
<pre class="brush: php;toolbar:false;">
[
    // a1 需要在 "a1" 特性所代表的字段内唯一
    ['a1', 'unique'],

    // a1 需要唯一，但检验的是 a1 的值在字段 a2 中的唯一性
    ['a1', 'unique', 'targetAttribute' => 'a2'],

    // a1 和 a2 的组合需要唯一，且它们都能收到错误提示
    [['a1', 'a2'], 'unique', 'targetAttribute' => ['a1', 'a2']],

    // a1 和 a2 的组合需要唯一，只有 a1 能接收错误提示
    ['a1', 'unique', 'targetAttribute' => ['a1', 'a2']],

    // 通过同时在 a2 和 a3 字段中检查 a2 和 a3 的值来确定 a1 的唯一性
    ['a1', 'unique', 'targetAttribute' => ['a2', 'a1' => 'a3']],
]
</pre>
<p>该验证器检查输入值是否在某表字段中唯一。它只对<a href="0603.html"> 活动记录 </a>类型的模型类特性起作用，能支持对一个或多过字段的验证。</p>
<ul>
	<li><code>targetClass</code>：用于查找输入值的目标 AR 类。若不设置，则会使用正在进行验证的当前模型类。</li>
	<li><code>targetAttribute</code>：用于检查输入值唯一性的<code>targetClass</code>的模型特性。
		<ul>
			<li>若不设置，它会直接使用待测特性名（整个参数数组的首元素）。</li>
			<li>除了指定为字符串以外，你也可以用数组的形式，同时指定多个用于验证的表字段，数组的键和值都是代表字段的特性名，值表示<code>targetClass</code>的待测数据源字段，而键表示当前模型的待测特性名。</li>
			<li>若键和值相同，你可以只指定值。（如:<code>['a2']</code>就代表<code>['a2'=>'a2']</code>）</li>
		</ul>
	</li>
	<li><code>filter</code>：用于检查输入值唯一性必然会进行数据库查询，而该属性为用于进一步筛选该查询的过滤条件。可以为代表额外查询条件的字符串或数组（关于查询条件的格式，请参考 [[yii\db\Query::where()]]）；或者样式为<code>function ($query)</code>的匿名函数，<code>$query</code>参数为你希望在该函数内进行修改的 [[yii\db\Query|Query]] 对象。</li>
</ul>
<blockquote>
	<p>译者注：exist 和 unique 验证器的机理和参数都相似，有点像一体两面的阴和阳。</p>
	<ul>
		<li>他们的区别是 exist 要求<code>targetAttribute</code>键所代表的的属性在其值所代表字段中找得到；而 unique 正相反，要求键所代表的的属性不能在其值所代表字段中被找到。</li>
		<li>从另一个角度来理解：他们都会在验证的过程中执行数据库查询，查询的条件即为where $v=$k (假设<code>targetAttribute</code>的其中一对键值对为<code>$k => $v</code>)。unique 要求查询的结果数<code>$count==0</code>，而<code>exist</code>则要求查询的结果数<code> $count>0</code></li>
		<li>最后别忘了，unique 验证器不存在<code>allowArray</code>属性哦。</li>
	</ul>
</blockquote>
<p>&nbsp;</p><h2>网址（url）</h2>
<pre class="brush: php;toolbar:false;">
[
    // 检查 "website" 是否为有效的 URL。若没有 URI 方案，则给 "website" 特性加 "http://" 前缀
    ['website', 'url', 'defaultScheme' => 'http'],
]
</pre>
<p>该验证器检查输入值是否为有效 URL。</p>
<ul>
	<li><code>validSchemes</code>：用于指定那些 URI 方案会被视为有效的数组。默认为<code>['http', 'https']</code>，代表<code>http</code>和<code>https</code>URLs 会被认为有效。</li>
	<li><code>defaultScheme</code>：若输入值没有对应的方案前缀，会使用的默认 URI 方案前缀。默认为 null，代表不修改输入值本身。</li>
	<li><code>enableIDN</code>：验证过程是否应该考虑 IDN（internationalized domain names，国际化域名，也称多语种域名，比如中文域名）。默认为 false。要注意但是为使用 IDN 验证功能，请先确保安装并开启<code>intl</code> PHP 扩展，不然会导致抛出异常。</li>
</ul>
