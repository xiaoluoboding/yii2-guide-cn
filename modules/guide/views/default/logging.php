<h1>日志记录（Logging）</h1>
<p>Yii 提供了一个灵活可扩展的日志功能，可以基于不同的日志严格级别和分类来处理。 你可以通过设立不同的标准来过滤分拣这些信息，并把他们存进不同的的文件，邮件或者调试器，等等。</p>
<p>&nbsp;</p>
<h2>基础</h2>
<p>最基本的日志记录就像普通调用一个方法一样简单：</p>
<pre class="brush: php;toolbar: false">
\Yii::info('Hello, I am a test log message');
</pre>
<p>&nbsp;</p>
<h3>消息分类（Message category）</h3>
<p>可以给一个消息附加一个消息分类的信息，从而使得这些消息可以被过滤，或者分别用不同的方式处理。 消息分类是日志记录方法的第二个参数，它默认为<code> application </code>。</p>
<h3>严格级别（Severity levels）</h3>
<p>有多种严格级别和相应方法可供选择：</p>
<ul class="task-list">
	<li>[[Yii::trace]] 主要是用于开发目的，用以标明某些代码的运作流程。注意：它只在开发模式下才起效， 也就是 <code>YII_DEBUG</code> 是 <code>true</code> 的时候。</li>
	<li>[[Yii::error]] 用以记录那些不可恢复的错误。</li>
	<li>[[Yii::warning]] 在错误发生后，运行仍可继续执行时记录。</li>
	<li>[[Yii::info]] 用以在重要事件执行时保存记录，比如管理员的登陆。</li>
</ul>
<p>&nbsp;</p>
<h2>日志目的地（Log targets）</h2>
<p>当一个日志记录方法被调用时，消息被传递到了 [[yii\log\Logger]] （日志记录器）组件。可以这样访问：<code>Yii::getLogger()</code>。 Logger 在内存中积攒消息，并在累积足够多的消息时，或 request （访问请求）结束后，再把他们一起存入不同的&ldquo;日志目的地&rdquo; ，比如文件或邮件。</p>
<p>你可以在应用配置中设置这些目的地，比如这样：</p>
<pre class="brush: php;toolbar: false">
[
    'components' => [
        'log' => [
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'info'],
                    'categories' => ['yii\*'],
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'to' => ['admin@example.com', 'developer@example.com'],
                        'subject' => '来自 example.com 的新日志消息',
                    ],
                ],
            ],
        ],
    ],
]
</pre>
<p>在上面的配置中，我们定义了两个目的地：[[yii\log\FileTarget|file]] 和 [[yii\log\EmailTarget|email]]。 这两者都把信息按照严格级别分别过滤分类到了他们的目的地。同时在&ldquo;文件&ldquo;目的地那里，我们还增加了&ldquo;按类别分类&ldquo;。 <code>yii\*</code> 指所有以 <code>yii\</code> 开头的类别.</p>
<p>每一个日志目的地都可以拥有一个名字，并可以被通过 [[yii\log\Logger::targets|targets]] 属性来引用，比如：</p>
<pre class="brush: php;toolbar: false">
Yii::$app->log->targets['file']->enabled = false;
</pre>
<p>当应用结束，或者 [[yii\log\Logger::flushInterval|flushInterval]] 方法被访问时，Logger 会调用 [[yii\log\Logger::flush()|flush()]] （原意指冲厕所的&rdquo;冲&ldquo;。根据英汉双解计算机词典的说法，flush 指将所有 I/O 缓冲器的内容写入一个文件中的一种记录操作。）方法 发送记录下来的消息到不同的日志目的地，比如文件，email，web等。</p>
<p>&nbsp;</p>
<h2>性能剖析（Profiling）</h2>
<pre class="brush: php;toolbar: false">
<p>性能剖析类消息是一种特殊的日志消息，它被用于测量某段代码块执行所需的时间，并试图寻找当前的性能瓶颈是什么。</p>
<p>要使用它，我们需要定位那些代码块是需要被剖析的。然后我们需要标记出每段代码块的起始和终止位置，通过插入以下两句方法实现：</p>
</pre>
<pre class="brush: php;toolbar: false">
\Yii::beginProfile('myBenchmark');
...code block being profiled...
\Yii::endProfile('myBenchmark');
</pre>
<p><code>myBenchmark</code>标记，唯一地标识着该代码块。（译者注：就是代码块的标示符，名字随便起，别重复。）</p>
<p>注意，多重代码块应该像这样被合理地嵌套：</p>
<pre class="brush: php;toolbar: false">
\Yii::beginProfile('block1');
    // 一些用于分析的测试代码
    \Yii::beginProfile('block2');
        // 另外一些用于分析的测试代码
    \Yii::endProfile('block2');
\Yii::endProfile('block1');	
</pre>
<p><p>剖析结果可以在  <a href="http://www.yiiframework.com/doc-2.0/guide-module-debug.html">debugger</a> 中显示出来.</p></p>
