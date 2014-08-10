<div class="col-md-9 guide-content">
<h1>Extending Yii <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#extending-yii" name="extending-yii">&para;</a></h1>
<p>The Yii framework was designed to be easily extendable. Additional features can be added to your project and then reused, either by yourself on other projects or by sharing your work as a formal Yii extension.</p>
<h2>Code style <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#code-style" name="code-style">&para;</a></h2>
<p>To be consistent with core Yii conventions, your extensions ought to adhere to certain coding styles:</p>
<ul>
<li>Use the <a href="https://github.com/yiisoft/yii2/wiki/Core-framework-code-style">core framework code style</a>.</li>
<li>Document classes, methods and properties using <a href="http://www.phpdoc.org/">phpdoc</a>. - Extension classes should <em>not</em> be prefixed. Do not use the format <code>TbNavBar</code>, <code>EMyWidget</code>, etc.</li>
</ul>
<blockquote>
<p>Note that you can use Markdown within your code for documentation purposes. With Markdown, you can link to properties and methods using the following syntax: <code>[[name()]]</code>, <code>[[namespace\MyClass::name()]]</code>.</p>
</blockquote>
<h3>Namespace <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#namespace" name="namespace">&para;</a></h3>
<p>Yii 2 relies upon namespaces to organize code. (Namespace support was added to PHP in version 5.3.) If you want to use namespaces within your extension,</p>
<ul>
<li>Do not use <code>yiisoft</code> anywhere in your namespaces.</li>
<li>Do not use <code>\yii</code>, <code>\yii2</code> or <code>\yiisoft</code> as root namespaces.</li>
<li>Namespaces should use the syntax <code>vendorName\uniqueName</code>.</li>
</ul>
<p>Choosing a unique namespace is important to prevent name collisions, and also results in faster autoloading of classes. Examples of unique, consistent namepacing are:</p>
<ul>
<li><code>samdark\wiki</code></li>
<li><code>samdark\debugger</code></li>
<li><code>samdark\googlemap</code></li>
</ul>
<h2>Distribution <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#distribution" name="distribution">&para;</a></h2>
<p>Beyond the code itself, the entire extension distribution ought to have certain things.</p>
<p>There should be a <code>readme.md</code> file, written in English. This file should clearly describe what the extension does, its requirements, how to install it, and to use it. The README should be written using Markdown. If you want to provide translated README files, name them as <code>readme_ru.md</code> where <code>ru</code> is your language code (in this case, Russian).</p>
<p>It is a good idea to include some screenshots as part of the documentation, especially if your extension provides a widget.</p>
<p>It is recommended to host your extensions at <a href="https://github.com">Github</a>.</p>
<p>Extensions should also be registered at <a href="https://packagist.org">Packagist</a> in order to be installable via Composer.</p>
<h3>Composer package name <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#composer-package-name" name="composer-package-name">&para;</a></h3>
<p>Choose your extension's package name wisely, as you shouldn't change the package name later on. (Changing the name leads to losing the Composer stats, and makes it impossible for people to install the package by the old name.)</p>
<p>If your extension was made specifically for Yii2 (i.e. cannot be used as a standalone PHP library) it is recommended to name it like the following:</p>
<pre><code>yii2-my-extension-name-type
</code></pre>
<p>Where:</p>
<ul>
<li><code>yii2-</code> is a prefix.</li>
<li>The extension name is in all lowercase letters, with words separated by <code>-</code>.</li>
<li>The <code>-type</code> postfix may be <code>widget</code>, <code>behavior</code>, <code>module</code> etc.</li>
</ul>
<h3>Dependencies <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#dependencies" name="dependencies">&para;</a></h3>
<p>Some extensions you develop may have their own dependencies, such as relying upon other extensions or third-party libraries. When dependencies exist, you should require them in your extension's <code>composer.json</code> file. Be certain to also use appropriate version constraints, eg. <code>1.*</code>, <code>@stable</code> for requirements.</p>
<p>Finally, when your extension is released in a stable version, double-check that its requirements do not include <code>dev</code> packages that do not have a <code>stable</code> release. In other words, the stable release of your extension should only rely upon stable dependencies.</p>
<h3>Versioning <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#versioning" name="versioning">&para;</a></h3>
<p>As you maintain and upgrading your extension,</p>
<ul>
<li>Use the rules of <a href="http://semver.org">semantic versioning</a>.</li>
<li>Use a consistent format for your repository tags, as they are treated as version strings by composer, eg. <code>0.2.4</code>, <code>0.2.5</code>,<code>0.3.0</code>,<code>1.0.0</code>.</li>
</ul>
<h3>composer.json <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#composerjson" name="composerjson">&para;</a></h3>
<p>Yii2 uses Composer for installation, and extensions for Yii2 should as well. Towards that end,</p>
<ul>
<li>Use the type <code>yii2-extension</code> in <code>composer.json</code> file if your extension is Yii-specific.</li>
<li>Do not use <code>yii</code> or <code>yii2</code> as the Composer vendor name.</li>
<li>Do not use <code>yiisoft</code> in the Composer package name or the Composer vendor name.</li>
</ul>
<p>If your extension classes reside directly in the repository root directory, you can use the PSR-4 autoloader in the following way in your <code>composer.json</code> file:</p>
<pre><code class="language-json">{
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
</code></pre>
<p>In the above, <code>myname/mywidget</code> is the package name that will be registered at <a href="https://packagist.org">Packagist</a>. It is common for the package name to match your Github repository name. Also, the <code>psr-4</code> autoloader is specified in the above, which maps the <code>myname\mywidget</code> namespace to the root directory where the classes reside.</p>
<p>More details on this syntax can be found in the <a href="http://getcomposer.org/doc/04-schema.md#autoload">Composer documentation</a>.</p>
<h3>Bootstrap with extension <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#bootstrap-with-extension" name="bootstrap-with-extension">&para;</a></h3>
<p>Sometimes, you may want your extension to execute some code during the bootstrap stage of an application. For example, your extension may want to respond to the application's <code>beginRequest</code> event. You can ask the extension user to explicitly attach your event handler in the extension to the application's event. A better way, however, is to do all these automatically.</p>
<p>To achieve this goal, you can create a bootstrap class by implementing <a href="http://www.yiiframework.com/doc-2.0/yii-base-bootstrapinterface.html">yii\base\BootstrapInterface</a>.</p>
<pre><code class="language-php"><span style="color: #007700;">namespace&nbsp;</span><span style="color: #0000bb;">myname</span><span style="color: #007700;">\</span><span style="color: #0000bb;">mywidget</span><span style="color: #007700;">;<br /><br />use&nbsp;</span><span style="color: #0000bb;">yii</span><span style="color: #007700;">\</span><span style="color: #0000bb;">base</span><span style="color: #007700;">\</span><span style="color: #0000bb;">BootstrapInterface</span><span style="color: #007700;">;<br />use&nbsp;</span><span style="color: #0000bb;">yii</span><span style="color: #007700;">\</span><span style="color: #0000bb;">base</span><span style="color: #007700;">\</span><span style="color: #0000bb;">Application</span><span style="color: #007700;">;<br /><br />class&nbsp;</span><span style="color: #0000bb;">MyBootstrapClass&nbsp;</span><span style="color: #007700;">implements&nbsp;</span><span style="color: #0000bb;">BootstrapInterface<br /></span><span style="color: #007700;">{<br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;</span><span style="color: #0000bb;">bootstrap</span><span style="color: #007700;">(</span><span style="color: #0000bb;">$app</span><span style="color: #007700;">)<br />&nbsp;&nbsp;&nbsp;&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000bb;">$app</span><span style="color: #007700;">-&gt;</span><span style="color: #0000bb;">on</span><span style="color: #007700;">(</span><span style="color: #0000bb;">Application</span><span style="color: #007700;">::</span><span style="color: #0000bb;">EVENT_BEFORE_REQUEST</span><span style="color: #007700;">,&nbsp;function&nbsp;()&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #ff8000;">//&nbsp;do&nbsp;something&nbsp;here<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #007700;">});<br />&nbsp;&nbsp;&nbsp;&nbsp;}<br />}</span></code></pre>
<p>You then list this bootstrap class in <code>composer.json</code> as follows,</p>
<pre><code class="language-json">{
    "extra": {
        "bootstrap": "myname\\mywidget\\MyBootstrapClass"
    }
}
</code></pre>
<p>When the extension is installed in an application, Yii will automatically hook up the bootstrap class and call its <code>bootstrap()</code> while initializing the application for every request.</p>
<h2>Working with database <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#working-with-database" name="working-with-database">&para;</a></h2>
<p>Extensions sometimes have to use their own database tables. In such a situation,</p>
<ul>
<li>If the extension creates or modifies the database schema, always use Yii migrations instead of SQL files or custom scripts.</li>
<li>Migrations should be applicable to different database systems.</li>
<li>Do not use Active Record models in your migrations.</li>
</ul>
<h2>Assets <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#assets" name="assets">&para;</a></h2>
<ul>
<li>Register assets <a href="http://www.yiiframework.com/doc-2.0/guide-assets.html">through bundles</a>.</li>
</ul>
<h2>Events <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#events" name="events">&para;</a></h2>
<p>TBD</p>
<h2>i18n <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#i18n" name="i18n">&para;</a></h2>
<ul>
<li>If extension outputs messages intended for end user these should be wrapped into <code>Yii::t()</code> in order to be translatable.</li>
<li>Exceptions and other developer-oriented message should not be translated.</li>
<li>Consider proving <code>config.php</code> for <code>yii message</code> command to simplify translation.</li>
</ul>
<h2>Testing your extension <a href="http://www.yiiframework.com/doc-2.0/guide-extensions.html#testing-your-extension" name="testing-your-extension">&para;</a></h2>
<ul>
<li>Consider adding unit tests for PHPUnit.</li>
</ul>
</div>