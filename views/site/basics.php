<h1>Basic concepts of Yii <a href="#basic-concepts-of-yii" name="basic-concepts-of-yii">&para;</a>
</h1>
<h2>Component and Object <a href="#component-and-object" name="component-and-object">&para;</a>
</h2>
<p>Classes of the Yii framework usually extend from one of the two base classes <a href="./yii-base-object.html">yii\base\Object</a> or <a href="./yii-base-component.html">yii\base\Component</a>. These classes provide useful features that are added automatically to all classes extending from them.</p>
<p>The <a href="./yii-base-object.html">Object</a> class provides the <a href="../api/base/Object.md">configuration and property feature</a>. The <a href="./yii-base-component.html">Component</a> class extends from <a href="./yii-base-object.html">Object</a> and adds
    <a href="guide-events.html">event handling</a> and <a href="guide-behaviors.html">behaviors</a>.</p>
<p><a href="./yii-base-object.html">Object</a> is usually used for classes that represent basic data structures while
    <a href="./yii-base-component.html">Component</a> is used for application components and other classes that implement higher logic.</p>
<h2>Object Configuration <a href="#object-configuration" name="object-configuration">&para;</a>
</h2>
<p>The <a href="./yii-base-object.html">Object</a> class introduces a uniform way of configuring objects. Any descendant class of <a href="./yii-base-object.html">Object</a> should declare its constructor (if needed) in the following way so that it can be properly configured:</p>
<pre><code class="language-php"><span style="color: #0000BB"></span><span style="color: #007700">class&nbsp;</span><span style="color: #0000BB">MyClass&nbsp;</span><span style="color: #007700">extends&nbsp;\</span><span style="color: #0000BB">yii</span><span style="color: #007700">\</span><span style="color: #0000BB">base</span><span style="color: #007700">\</span><span style="color: #0000BB">Object<br /></span><span style="color: #007700">{<br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;</span><span style="color: #0000BB">__construct</span><span style="color: #007700">(</span><span style="color: #0000BB">$param1</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$param2</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$config&nbsp;</span><span style="color: #007700">=&nbsp;[])<br />&nbsp;&nbsp;&nbsp;&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #FF8000">//&nbsp;...&nbsp;initialization&nbsp;before&nbsp;configuration&nbsp;is&nbsp;applied<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">parent</span><span style="color: #007700">::</span><span style="color: #0000BB">__construct</span><span style="color: #007700">(</span><span style="color: #0000BB">$config</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;}<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;</span><span style="color: #0000BB">init</span><span style="color: #007700">()<br />&nbsp;&nbsp;&nbsp;&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">parent</span><span style="color: #007700">::</span><span style="color: #0000BB">init</span><span style="color: #007700">();<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #FF8000">//&nbsp;...&nbsp;initialization&nbsp;after&nbsp;configuration&nbsp;is&nbsp;applied<br />&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #007700">}<br />}</span></code></pre>
<p>In the above example, the last parameter of the constructor must take a configuration array which contains name-value pairs that will be used to initialize the object's properties at the end of the constructor. You can override the
    <code>init()</code>method to do initialization work after the configuration is applied.</p>
<p>By following this convention, you will be able to create and configure new objects using a configuration array like the following:</p>
<pre><code class="language-php"><span style="color: #0000BB">$object&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">Yii</span><span style="color: #007700">::</span><span style="color: #0000BB">createObject</span><span style="color: #007700">([<br />&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'class'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #DD0000">'MyClass'</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'property1'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #DD0000">'abc'</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'property2'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #DD0000">'cde'</span><span style="color: #007700">,<br />],&nbsp;[</span><span style="color: #0000BB">$param1</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$param2</span><span style="color: #007700">]);</span></code></pre>
<h2>Path Aliases <a href="#path-aliases" name="path-aliases">&para;</a>
</h2>
<p>Yii 2.0 expands the usage of path aliases to both file/directory paths and URLs. An alias must start with an
    <code>@</code>symbol so that it can be differentiated from file/directory paths and URLs. For example, the alias
    <code>@yii</code>refers to the Yii installation directory while
    <code>@web</code>contains the base URL for the currently running web application. Path aliases are supported in most places in the Yii core code. For example,
    <code>FileCache::cachePath</code>can accept both a path alias and a normal directory path.</p>
<p>Path aliases are also closely related to class namespaces. It is recommended that a path alias should be defined for each root namespace so that Yii's class autoloader can be used without any further configuration. For example, because
    <code>@yii</code>refers to the Yii installation directory, a class like
    <code>yii\web\Request</code>can be autoloaded by Yii. If you use a third party library such as Zend Framework, you may define a path alias
    <code>@Zend</code>which refers to its installation directory and Yii will be able to autoload any class in this library.</p>
<p>The following aliases are predefined by the core framework:</p>
<ul>
    <li>
        <code>@yii</code>- framework directory.</li>
    <li>
        <code>@app</code>- base path of currently running application.</li>
    <li>
        <code>@runtime</code>- runtime directory.</li>
    <li>
        <code>@vendor</code>- Composer vendor directory.</li>
    <li>
        <code>@webroot</code>- web root directory of currently running web application.</li>
    <li>
        <code>@web</code>- base URL of currently running web application.</li>
</ul>
<h2>Autoloading <a href="#autoloading" name="autoloading">&para;</a>
</h2>
<p>All classes, interfaces and traits are loaded automatically at the moment they are used. There's no need to use
    <code>include</code>or
    <code>require</code>. It is true for Composer-loaded packages as well as Yii extensions.</p>
<p>Yii's autoloader works according to <a href="https://github.com/php-fig/fig-standards/blob/master/proposed/psr-4-autoloader/psr-4-autoloader.md">PSR-4</a>. That means namespaces, classes, interfaces and traits must correspond to file system paths and file names accordinly, except for root namespace paths that are defined by an alias.</p>
<p>For example, if the standard alias
    <code>@app</code>refers to
    <code>/var/www/example.com/</code>then
    <code>\app\models\User</code>will be loaded from
    <code>/var/www/example.com/models/User.php</code>.</p>
<p>Custom aliases may be added using the following code:</p>
<pre><code class="language-php"><span style="color: #0000BB">Yii</span><span style="color: #007700">::</span><span style="color: #0000BB">setAlias</span><span style="color: #007700">(</span><span style="color: #DD0000">'@shared'</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">realpath</span><span style="color: #007700">(</span><span style="color: #DD0000">'~/src/shared'</span><span style="color: #007700">));</span></code></pre>
<p>Additional autoloaders may be registered using PHP's standard
    <code>spl_autoload_register</code>.</p>
<h2>Helper classes <a href="#helper-classes" name="helper-classes">&para;</a>
</h2>
<p>Helper classes typically contain static methods only and are used as follows:</p>
<pre><code class="language-php"><span style="color: #0000BB"></span><span style="color: #007700">use&nbsp;\</span><span style="color: #0000BB">yii</span><span style="color: #007700">\</span><span style="color: #0000BB">helpers</span><span style="color: #007700">\</span><span style="color: #0000BB">Html</span><span style="color: #007700">;<br />echo&nbsp;</span><span style="color: #0000BB">Html</span><span style="color: #007700">::</span><span style="color: #0000BB">encode</span><span style="color: #007700">(</span><span style="color: #DD0000">'Test&nbsp;&gt;&nbsp;test'</span><span style="color: #007700">);</span></code></pre>
<p>There are several classes provided by framework:</p>
<ul>
    <li>ArrayHelper</li>
    <li>Console</li>
    <li>FileHelper</li>
    <li>Html</li>
    <li>HtmlPurifier</li>
    <li>Image</li>
    <li>Inflector</li>
    <li>Json</li>
    <li>Markdown</li>
    <li>Security</li>
    <li>StringHelper</li>
    <li>Url</li>
    <li>VarDumper</li>
</ul>
</div>
</div>
