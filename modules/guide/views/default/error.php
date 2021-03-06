<h1>错误处理</h1>
<p>Yii 的错误处理与原生 PHP 是不一样的。首先，Yii 会把所有非致命（non-fatal）的错误转换为<em>exceptions</em>（异常）：</p>
<pre class="brush: php;toolbar: false">
use yii\base\ErrorException;
use Yii;

try {
    10/0;
} catch (ErrorException) {
    Yii::warning("Tried dividing by zero.");
}

// 执行仍可能继续
</pre>
<p>如上所示，你可以用 <code>try</code>-<code>catch</code> 处理这些错误。</p>
<p>其次，即使是 fatal（致命的）错误，在 Yii 中也会以一种更好的方式渲染一下。也就是&mdash;&mdash;&ldquo;debugging mode&rdquo;（调试模式），你可以探查是什么导致了这些致命错误，从而更高效地定位故障原因。</p>
<p>&nbsp;</p>
<h2>用专门的控制器动作渲染错误页面</h2>
<p>Yii 默认的错误页面在开发一个网站时是很棒的，并且如果在引导脚本里关闭了 <code>YII_DEBUG</code> 的话，它再说生产环境的样子也不差。但是，你仍旧可能有自定义错误页面需要，使其更适应你的项目。</p>
<p>最简单的自定义错误页面的方式就是用一个专门的控制器动作渲染错误页面。 首先，你需要在应用的配置文件中设置下 <code>errorHandler</code> 组件：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        // ...
        'errorHandler' => [
            'errorAction' => 'site/error',
    ],
</pre>
<p>在上面的配置中，当错误发生时，Yii 会执行 &ldquo;site&rdquo; 控制器的 &ldquo;error&rdquo; 动作。 这个动作应该会尝试捕获一个异常，且如果真有，就会渲染一个合适的视图文件，把异常传递进去：</p>
<pre class="brush: php;toolbar: false">
public function actionError()
{
    if (\Yii::$app->exception !== null) {
        return $this->render('error', ['exception' => \Yii::$app->exception]);
    }
}
</pre>
<p>之后，你会创建 <code>views/site/error.php</code> 文件，他会读取这个异常。 异常对象有如下属性：</p>
<ul class="task-list">
	<li><code>statusCode</code>: HTTP 状态代码（e.g. 403、500）。该属性仅存在于 HTTP 异常。</li>
	<li><code>code</code>: 这个异常的代码。</li>
	<li><code>type</code>: 错误类型（e.g. HttpException, PHP Error 等）。</li>
	<li><code>message</code>: 错误信息。</li>
	<li><code>file</code>: 引起错误发生的 PHP 脚本文件的名字。</li>
	<li><code>line</code>: 引起错误发生的代码的行号。</li>
	<li><code>trace</code>: 该错误的方法调用堆栈。</li>
	<li><code>source</code>: 引起错误的地方附近的源代码。</li>
</ul>
<p>&nbsp;</p>
<h2>用专门的控制器动作渲染错误页面</h2>
<p>不必专门创建一个的动作来处理错误，你可以直接向 Yii 指定 一个用于处理错误的类：</p>
<pre class="brush: php;toolbar: false">
public function actions()
{
    return [
        'error' => [
            'class' => 'yii\web\ErrorAction',
        ],
    ];
}
</pre>
<p>如上面代码所示，在把这个类与错误相关联之后，定义 <code>views/site/error.php</code> 文件，这个视图会被自动使用。 这个视图可以被传入三个变量：</p>
<ul class="task-list">
<li><code>$name</code>: 错误名</li>
<li><code>$message</code>: 错误信息</li>
<li><code>$exception</code>: 被处理的异常本身</li>
</ul>
<p>这个 <code>$exception</code> 对象会包含有跟刚刚上面列出来的那些一样的属性值。</p>