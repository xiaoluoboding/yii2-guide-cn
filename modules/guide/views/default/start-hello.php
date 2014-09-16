<h1>说声 Hello</h1>
<p>本章节描述了如何在你的应用中创建一个新的 “Hello” 页面。为了做到这点，将会创建一个<a href="0305.html">动作</a>和一个<a href="0306.html">视图</a>：</p>
<ul>
	<li>应用将会分派页面请求给动作</li>
	<li>动作将会依次渲染视图呈现 “Hello” 给最终用户</li>
</ul>
<p>动作将会依次渲染视图呈现 “Hello” 给最终用户</p>
<ul>
	<li style="list-style: decimal;">如何创建一个<a href="0305.html">动作</a>去响应请求，</li>
	<li style="list-style: decimal;">如何创建一个<a href="0306.html">视图</a>去构造响应内容，</li>
	<li style="list-style: decimal;">以及一个应用如何分派请求给动作。</li>
</ul>
<p>&nbsp;</p><h2>创建动作</h2><hr>
<p>为了实现“说声 Hello”，需要创建一个名为<code>say</code>的动作，从请求中接收<code>message</code>参数并显示给最终用户。如果请求没有提供<code>message</code>参数，动作将显示默认参数“Hello”。</p>
<blockquote>
	<p>补充：动作是最终用户可以直接访问并执行的对象。动作被组织在<a href="0305.html">控制器</a>中。一个动作的执行结果就是最终用户收到的响应内容。</p>
</blockquote>
<p>动作必须声明在控制器中。为了简单起见，你可以直接在<code>SiteController</code>控制器里声明<code>say</code>动作。这个控制器是由文件<code>controllers/SiteController.php</code>定义的。以下是一个动作的声明：</p>
<pre class="brush: php;toolbar:false;">
&lt;?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    // ...其它代码...

    public function actionSay($message = '你好')
    {
        return $this->render('say', ['message' => $message]);
    }
}
</pre>
<p>在上述<code>SiteController</code>代码中，<code>say</code>动作被定义为<code>actionSay</code>方法。Yii 使用<code>action</code>前缀区分普通方法和动作。<code>action</code>前缀后面的名称被映射为动作的 ID。</p>
<p>涉及到给动作命名时，你应该理解 Yii 如何处理动作 ID。动作 ID 总是被以小写处理，如果一个动作 ID 由多个单词组成，单词之间将由连字符连接（如 <code>create-comment</code>）。动作 ID 映射为方法名时移除了连字符，将每个单词首字母大写，并加上<code>action</code>前缀。 例子：动作 ID <code>create-comment</code>相当于方法名<code>actionCreateComment</code>。</p>
<p>上述代码中的动作方法接受一个参数<code>$message</code>，它的默认值是<code>“Hello”</code>（就像你设置 PHP 中其它函数或方法的默认值一样）。当应用接收到请求并确定由<code>say</code>动作来响应请求时，应用将从请求的参数中寻找对应值传入进来。换句话说，如果请求包含一个<code>message</code>参数，它的值是<code>“Goodybye”</code>， 动作方法中的<code>$message</code>变量也将被填充为<code>“Goodbye”</code>。</p>
<p>在动作方法中，[[yii\web\Controller::render()|render()]] 被用来渲染一个名为<code>say</code>的<a href="0306.html">视图</a>文件。 <code>message</code>参数也被传入视图，这样就可以在里面使用。动作方法会返回渲染结果。结果会被应用接收并显示给最终用户的浏览器（作为整页 HTML 的一部分）。</p>
<p>&nbsp;</p><h2>创建视图</h2><hr>
<p>视图是你用来生成响应内容的脚本。为了“说声 Hello”，你需要创建一个<code>say</code>视图，以便显示从动作方法中传来的<code>message</code>参数。</p>
<pre class="brush: php;toolbar:false;">
&lt;?php
use yii\helpers\Html;
?>
&lt;?= Html::encode($message) ?>
</pre>
<p><code>say</code>视图应该存为<code>views/site/say.php</code>文件。当一个动作中调用了 [[yii\web\Controller::render()|render()]] 方法时，它将会按<code>views/控制器 ID/视图名.php</code>路径加载 PHP 文件。</p>
<p>注意以上代码，<code>message</code>参数在输出之前被 [[yii\helpers\Html::encode()|HTML-encoded]] 方法处理过。这很有必要，当参数来自于最终用户时，参数中可能隐含的恶意<code>JavaScript</code>代码会导致<a href="http://en.wikipedia.org/wiki/Cross-site_scripting" target="_blank">跨站脚本（XSS）攻击</a>。</p>
<p>当然了，你大概会在<code>say</code>视图里放入更多内容。内容可以由<code>HTML</code>标签，纯文本，甚至 PHP 语句组成。实际上<code>say</code>视图就是一个由 [[yii\web\Controller::render()|render()]] 执行的 PHP 脚本。视图脚本输出的内容将会作为响应结果返回给应用。应用将依次输出结果给最终用户。</p>
<p>&nbsp;</p><h2>尝试一下</h2><hr>
<p>创建完动作和视图后，你就可以通过下面的 URL 访问新页面了：</p>
<pre class="brush: php;toolbar:false;">
http://hostname/index.php?r=site/say&message=Hello+World
</pre>
<p>这个 URL 将会输出包含 &ldquo;Hello World&rdquo; 的页面，页面和应用里的其它页面使用同样的头部和尾部。</p>
<p>如果你省略 URL 中的<code>message</code>参数，将会看到页面只显示<code> “Hello”</code>。这是因为<code>message</code>被作为一个参数传给<code>actionSay()</code>方法，当省略它时，参数将使用默认的 <code> “Hello”</code>代替。</p>
<blockquote>
	<p>补充：新页面和其它页面使用同样的头部和尾部是因为 [[yii\web\Controller::render()|render()]] 方法会自动把<code>say</code>视图执行的结果嵌入称为布局的文件中，本例中是<code>views/layouts/main.php</code>。</p>
</blockquote>
<p>上面 URL 中的参数<code>r</code>需要更多解释。它代表<a href="#">路由</a>，是整个应用级的，指向特定动作的独立 ID。路由格式是 <code>控制器 ID/动作 ID</code>。应用接受请求的时候会检查参数，使用控制器 ID 去确定哪个控制器应该被用来处理请求。然后相应控制器将使用动作 ID 去确定哪个动作方法将被用来做具体工作。上述例子中，路由<code>site/say</code>将被解析至<code>SiteController</code>控制器和其中的<code>say</code>动作。因此<code>SiteController::actionSay()</code>方法将被调用处理请求。</p>
<blockquote>
	<p>补充：与动作一样，一个应用中控制器同样有唯一的 ID。<code>控制器 ID</code>和<code>动作 ID</code>使用同样的命名规则。控制器的类名源自于控制器 ID，移除了连字符，每个单词首字母大写，并加上<code>Controller</code>后缀。例子：控制器 ID<code>post-comment</code>相当于控制器类名<code>PostCommentController</code>。</p>
</blockquote>
<p>&nbsp;</p><h2>总结</h2><hr>
<p>通过本章节你接触了 MVC 设计模式中的控制器和视图部分。创建了一个动作作为控制器的一部分去处理特定请求。然后又创建了一个视图去构造响应内容。在这个小例子中，没有模型调用，唯一涉及到数据的地方是<code>message</code>参数。</p>
<p>你同样学习了 Yii 路由的相关内容，它是用户请求与控制器动作之间的桥梁。</p>
<p>下一章，你将学习如何创建一个模型，以及添加一个包含 HTML 表单的页面。</p>