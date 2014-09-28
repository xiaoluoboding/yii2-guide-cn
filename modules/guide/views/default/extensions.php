<h1>Yii 扩展</h1>
<p>Yii 框架设计得易于扩展。新增特性可以添加到你的项目，然后给你自己复用于其他项目或作为正式的 Yii 扩展分享给其他人。</p>
<p>&nbsp;</p>
<h2>代码风格</h2>
<p>为和 Yii 核心代码的约定保持一致，你的扩展应当遵循特定的代码风格：</p>
<ul class="task-list">
<li>使用<a href="https://github.com/yiisoft/yii2/wiki/Core-framework-code-style" target="_blank">框架核心的代码风格</a>.</li>
<li>使用<a href="http://www.phpdoc.org/" target="_blank">phpdoc</a>记录类、方法和属性。</li>
<li>扩展类 <em>不要</em> 使用前缀。不要使用 <code>TbNavBar</code>, <code>EMyWidget</code> 这样的格式。</li>
</ul>
<blockquote>
<p>注意从文档输出考虑可以在代码中使用 Markdown 。用 Markdown 可使用这样的语法 <code>[[name()]]</code>, <code>[[namespace\MyClass::name()]]</code>链接到属性和方法。</p>
</blockquote>
<h3>命名空间</h3>
<p>Yii 2 依赖命名空间来组织代码（PHP 5.3 以上版本支持命名空间）。如果你要在你的扩展使用命名空间：</p>
<ul class="task-list">
<li>命名空间的任何地方都不要使用 <code>yiisoft</code>。</li>
<li>不要使用 <code>\yii</code>, <code>\yii2</code> 或 <code>\yiisoft</code> 作为根命名空间。</li>
<li>命名空间应使用这样的语法： <code>vendorName\uniqueName</code> 。</li>
</ul>
<p>选定唯一命名空间对避免命名冲突是非常重要的，也会使类自动加载更快。唯一和一致的命名例子是：</p>
<ul class="task-list">
<li><code>samdark\wiki</code></li>
<li><code>samdark\debugger</code></li>
<li><code>samdark\googlemap</code></li>
</ul>
<p>&nbsp;</p>
<h2>发布扩展</h2>
<p>除了代码本身，整个扩展的发布也应当有这些特定的东西。</p>
<p>扩展应该有一个英文版的 <code>readme.md</code> 文件，该文件应清楚描述扩展能做什么、环境要求、如何安装和使用。 README 应使用 Markdown 写作。如果想提供 README 文件的翻译版本，以 <code>readme_ru.md</code> 这样的格式命名，其中 <code>ru</code> 是你要翻译的目标语言（在这个例子中是 Russian 俄国）。</p>
<p>包括一些屏幕截图作为文档的部分是个好主意，特别是你的扩展作为小部件发布。</p>
<p>推荐在<a href="https://github.com" target="_blank">Github</a>托管你的扩展。</p>
<p>扩展也应在<a href="https://packagist.org" target="_blank">Packagist</a>注册以便能够通过 Composer 安装。</p>
<h3>Composer 包命名</h3>
<p>应明智地选择你的扩展包命名，因为你不应该以后再更改包名（更改包名会导致失去 Composer 统计数据，使别人无法通过旧名安装这个包）。</p>
<p>如果扩展是特别为 Yii2 制作的（如，不能用作单独的 PHP 库），推荐命名如下：</p>
<pre class="brush: php;toolbar:false;">
yii2-my-extension-name-type
</pre>
<p>其中：</p>
<ul class="task-list">
<li><code>yii2-</code> 是前缀。</li>
<li>扩展名以<code>-</code> 分隔单词并尽量简短。</li>
<li><code>-type</code> 后缀可以是 <code>widget</code>, <code>behavior</code>, <code>module</code> 等，根据你的扩展功能确定后缀类型。</li>
</ul>
<h3>依赖关系</h3>
<p>你开发的一些扩展可能有其依赖关系，如依赖其他扩展或第三方库。当依赖关系存在，需要在你的扩展的 <code>composer.json</code> 文件导入（require）依赖关系。肯定也会使用相应版本的约束条件，如<code>1.*</code>, <code>@stable</code> 等要求。</p>
<p>最后，当你的扩展以文档版本发布时，必须再次确认必要环境没有导入不包含 <code>stable</code> 版本的 <code>dev</code> 包。换言之，扩展发布稳定版本只应依靠稳定的依赖关系。</p>
<h3>版本管理</h3>
<p>当你维护和升级扩展时：</p>
<ul class="task-list">
<li>使用<a href="http://semver.org" target="_blank">语义明确的版本管理</a>规则。</li>
<li>使用格式一致的版本库标记，因为 composer 把标记看作为版本的字符串，如 <code>0.2.4</code>, <code>0.2.5</code>,<code>0.3.0</code>,<code>1.0.0</code> 。</li>
</ul>
<h3>composer.json</h3>
<p>Yii2 使用 Composer 来安装 Yii2 和管理 Yii2 的扩展。为实现这一目标：</p>
<ul class="task-list">
<li>如果你的扩展是为 Yii2 定制的，请在 <code>composer.json</code> 文件使用 <code>yii2-extension</code> 类型。</li>
<li>不要使用 <code>yii</code> 或 <code>yii2</code> 作为 Composer vendor 名。</li>
<li>在 Composer 包名或 Composer vendor 名都不要使用 <code>yiisoft</code> 。</li>
</ul>
<p>如果扩展类直接放在版本库根目录内，可以在你的 <code>composer.json</code> 文件以以下方式使用 PSR-4 自动加载器：</p>
<pre class="brush: php;toolbar:false;">
{
    "name": "myname/mywidget",
    "description": "My widget is a cool widget that does everything",
    "keywords": ["yii", "extension", "widget", "cool"],
    "homepage": "https://github.com/myname/yii2-mywidget-widget",
    "type": "yii2-extension",
    "license": "BSD-3-Clause",
    "authors": [
        {
            "name": "John Doe",
            "email": "doe@example.com"
        }
    ],
    "require": {
        "yiisoft/yii2": "*"
    },
    "autoload": {
        "psr-4": {
            "myname\\mywidget\\": ""
        }
    }
}
</pre>
<p>以上代码中， <code>myname/mywidget</code> 是包名，将注册到<a href="https://packagist.org" target="_blank">Packagist</a>。通常包名和Github 的版本名是一致的。同样， <code>psr-4</code> 自动加载器会映射 <code>myname\mywidget</code> 命名空间到这些类所处的根目录。</p>
<p>更多该语法的细节内容请参考<a href="http://getcomposer.org/doc/04-schema.md#autoload" target="_blank">Composer 文档</a>.</p>
<h3>引导扩展</h3>
<p>有时，希望扩展在应用的引导阶段执行一些代码。如，扩展要响应应用的<code>beginRequest</code> 事件，可以要求扩展使用者显性附加扩展的事件处理器到应用事件。当然更好的方式是自动完成这些事。为实现该目标，可以通过实现[[yii\base\BootstrapInterface]]接口来创建一个引导类。</p>
<pre class="brush: php;toolbar:false;">
namespace myname\mywidget;

use yii\base\BootstrapInterface;
use yii\base\Application;

class MyBootstrapClass implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
             // 这里处理一些事情
        });
    }
}
</pre>
<p>然后把这个 bootstrap 类列入<code> composer.json </code>：</p>
<pre class="brush: php;toolbar:false;">
{
    "extra": {
        "bootstrap": "myname\\mywidget\\MyBootstrapClass"
    }
}
</pre>
<p>当扩展在应用中安装后，Yii 将自动挂钩（hook up）这个引导类并在为每个请求初始化应用时调用其<code> bootstrap() </code>方法。</p>
<p>&nbsp;</p>
<h2>使用数据库</h2>
<p>扩展有时必须使用它们自己的数据库表，这种情况：</p>
<ul class="task-list">
<li>如果扩展建立或更改了数据库模式，应该一直使用 Yii 数据库迁移而不是 SQL 文件或定制脚本。</li>
<li>数据库迁移应应用于不同的数据库系统。</li>
<li>不要在数据库迁移中使用 Active Record 模型。</li>
</ul>
<p>&nbsp;</p>
<h2>资源</h2>
<ul class="task-list">
<li>通过<a href="0311.html"> bundles </a>注册资源.</li>
</ul>
<p>&nbsp;</p>
<h2>事件</h2>
<p>TBD</p>
<p>&nbsp;</p>
<h2>国际化</h2>
<p>&nbsp;</p>
<ul class="task-list">
<li>如果扩展输出信息用于终端用户，它们应使用 <code>Yii::t()</code> 包裹以便翻译。</li>
<li>异常和其他面向开发者的信息不需要翻译。</li>
<li>考虑为 <code>yii message</code> 命令提供 <code>config.php</code> 以简化翻译。</li>
</ul>
<p>&nbsp;</p>
<h2>测试扩展</h2>
<ul class="task-list">
<li>为 PHPUnit 添加单元测试。</li>
</ul>