<h1>事件（Event）</h1>
<p>Yii 使用事件来注入定制代码到既有代码中的特定执行点。比如，当用户评论一篇文章时，可以触发一个评论对象添加（&ldquo;add&rdquo;）事件。</p>
<p>又比如，邮件程序对象成功发出消息时可触发 messageSent 事件。如想追踪成功发送的消息，可以附加相应追踪代码到 messageSent 事件。</p>
<p>基于两个原因，事件是很有帮助的。首先，可以使得你的组件更为灵活。其次，你可以在框架和第三方扩展的常规流程中挂靠定制处理的代码。</p>
<p>&nbsp;</p>
<h2>附属事件处理器<a href="#attaching-event-handlers" name="attaching-event-handlers"></a></h2>
<p>可以把单个或多个PHP回调（callbacks），即事件处理器（<em>event handlers</em>），附属给一个事件。当事件发生时，事件处理器将按照附属时的顺序而自动、依次被触发。</p>
<p>有两个主要的方式来附属事件处理器。或者使用内联代码或者使用配置文件。</p>
<blockquote>
<p>提示：为了获取最新的事件列表，在框架代码中搜索<code>-&gt;trigger</code>.</p>
</blockquote>
<h3>通过代码来附属事件处理器 <a href="#attaching-event-handlers-via-code" name="attaching-event-handlers-via-code"></a></h3>
<p>你可以在代码中使用组件对象的&nbsp;<code>on</code> 方法来赋值事件处理器。这个方法的第一个参数是要侦听的事件名称；第二个参数就是事件发生时要被调用的处理器（也就是函数）：</p>
<pre class="brush: php;toolbar: false">
$component->on($eventName, $handler);
</pre>
<p>事件处理器是一个<a href="http://www.php.net/manual/en/language.types.callable.php">PHP 回调函数</a>，当它所附加到的事件被触发时它就会执行。可以使用以下回调函数之一：</p>
<ul>
<li>全局函数名</li>
<li>一个包含模型名称和方法名称的数组</li>
<li>一个包含对象和方法名的数组</li>
<li>一个匿名函数</li>
</ul>
<pre class="brush: php;toolbar: false">
$foo = new Foo;

// 处理器是全局函数
$foo->on(Foo::EVENT_HELLO, 'function_name');

// 处理器是对象方法
$foo->on(Foo::EVENT_HELLO, [$object, 'methodName']);

// 处理器是静态类方法
$foo->on(Foo::EVENT_HELLO, ['app\components\Bar', 'methodName']);

// 处理器是匿名函数
$foo->on(Foo::EVENT_HELLO, function ($event) {
    //事件处理逻辑
});
</pre>
<p>如匿名函数示例所示，事件处理函数必须定义为接收一个&nbsp;[[yii\base\Event]]对象的参数。</p>
<p>为了传递其他参数给这个事件处理器，可以把数据作为&nbsp;<code>on</code>&nbsp;方法的第三个参数进行传递。在处理器中，这个附加数据将可以通过&nbsp;<code>$event-&gt;data</code>&nbsp;来获取：</p>
<pre class="brush: php;toolbar: false">
// 当事件被触发时以下代码显示 $extraData
// 因为 $event->data 包括被传递到 "on" 方法的数据
$component->on($eventName, function ($event) {
}, $extraData);
</pre>
<h3>通过配置来附属事件处理器<a href="#attaching-event-handlers-via-config" name="attaching-event-handlers-via-config"></a></h3>
<p>你还可以在配置文件中附属一个事件处理器。为此，可以给要附属事件处理器的组件添加一个元素。语法是&nbsp;<code>"on &lt;event&gt;" =&gt; handler</code>：</p>
<pre class="brush: php;toolbar: false">
return [
    // ...
    'components' => [
        'db' => [
            // ...
            'on afterOpen' => function ($event) {
                // do something right after connected to database
            }
        ],
    ],
];
</pre>
<p>&nbsp;</p>
<h2>触发事件</h2>
<p>大多数事件通过正常工作流来触发。比如，"beforeSave" 事件在一个活动记录模型被保存前发生。</p>
<p>不过你还可以手动触发一个事件，使用&nbsp;<code>trigger</code>&nbsp;方法，在被附属了事件处理器的组件上调用。</p>
<pre class="brush: php;toolbar: false">
$this->trigger('myEvent');

// or

$event = new CreateUserEvent(); // extended from yii\base\Event
$event->userName = 'Alexander';
$this->trigger('createUserEvent', $event);
</pre>
<p>事件名必须在它的定义类中是唯一的。事件名称是大小写敏感的，把事件名定义为类的常量是一个好的用法：</p>
<pre class="brush: php;toolbar: false"> 
class Mailer extends Component
{
    const EVENT_SEND_EMAIL = 'sendEmail';

    public function send()
    {
        // ...
        $this->trigger(self::EVENT_SEND_EMAIL);
    }
}
</pre>
<p>当使用这个方法来附属事件处理器时，这个处理器必须是一个匿名函数。</p>
<p>&nbsp;</p>
<h2>删除事件处理器</h2>
<p>相应的&nbsp;<code>off</code>&nbsp;方法删除一个事件处理器：</p>
<pre class="brush: php;toolbar: false">$component->off($eventName);</pre> 
<p>Yii 支持为单个事件关联多个事件处理器。当执行上述&nbsp;<code>off</code>&nbsp;调用时，所有的事件处理器都将被删除。要删除某个特定的处理器，在第二个参数中进行指定：</p>
<pre class="brush: php;toolbar: false">$component->off($eventName, $handler);</pre> 
<p><code>$handler</code>&nbsp;在&nbsp;<code>off</code>&nbsp;方法中应该和&nbsp;<code>on</code>&nbsp;中一样，这样才能被正确删除。</p>
<blockquote>
<p>提示：对于需要稍后被删除的事件，你可能不想使用匿名函数。</p>
</blockquote>
<p>&nbsp;</p>
<h2>全局事件<a href="#global-events" name="global-events"></a></h2>
<p>你可以使用 "global" 事件而不是组件范围的事件。一个全局事件可以用于任意的组件类型。</p>
<p>为了把一个处理器附属到一个全局事件中，在应用程序实例上调用&nbsp;<code>on</code>&nbsp;方法：</p>
<pre class="brush: php;toolbar: false">Yii::$app->on($eventName, $handler);</pre>
<p>全局事件的触发也是通过应用程序实例来调用：</p>
<pre class="brush: php;toolbar: false">Yii::$app->trigger($eventName);</pre>
<p>&nbsp;</p>
<h2>类事件<a href="#class-events" name="class-events"></a></h2>
<p>可以把事件处理器附属到一个类上，而不仅仅是某个实例。使用静态的&nbsp;<code>Event::on</code>&nbsp;方法如下：</p>
<pre class="brush: php;toolbar: false">
Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
    Yii::trace(get_class($event->sender) . ' is inserted.');
});
</pre>
<p>上述代码定义了一个处理器，将在每个Active Record对象的&nbsp;<code>EVENT_AFTER_INSERT</code>&nbsp;事件上被触发。</p>