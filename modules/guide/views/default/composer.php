<div class="col-md-9 guide-content">
<h1>Composer <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#composer" name="composer">&para;</a></h1>
<p>Yii2 uses Composer as its dependency management tool. Composer is a PHP utility that can automatically handle the installation of needed libraries and extensions, thereby keeping those third-party resources up to date while absolving you of the need to manually manage the project's dependencies.</p>
<h2>Installing Composer <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#installing-composer" name="installing-composer">&para;</a></h2>
<p>In order to install Composer, check the official guide for your operating system:</p>
<ul>
<li><a href="http://getcomposer.org/doc/00-intro.md#installation-nix">Linux</a></li>
<li><a href="http://getcomposer.org/doc/00-intro.md#installation-windows">Windows</a></li>
</ul>
<p>All of the details can be found in the guide, but you'll either download Composer directly from <a href="http://getcomposer.org/">http://getcomposer.org/</a>, or run the following command:</p>
<pre><code>curl -s http://getcomposer.org/installer | php
</code></pre>
<p>We strongly recommend a global composer installation.</p>
<h2>Working with composer <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#working-with-composer" name="working-with-composer">&para;</a></h2>
<p>The act of <a href="http://www.yiiframework.com/doc-2.0/guide-installation.html">installing a Yii application</a> with</p>
<pre><code>composer.phar create-project --stability dev yiisoft/yii2-app-basic
</code></pre>
<p>creates a new root directory for your project along with the <code>composer.json</code> and <code>compoer.lock</code> file.</p>
<p>While the former lists the packages, which your application requires directly together with a version constraint, while the latter keeps track of all installed packages and their dependencies in a specific revision. Therefore the <code>composer.lock</code> file should also be <a href="https://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file">committed to your version control system</a>.</p>
<p>These two files are strongly linked to the two composer commands <code>update</code> and <code>install</code>. Usually, when working with your project, such as creating another copy for development or deployment, you will use</p>
<pre><code>composer.phar install
</code></pre>
<p>to make sure you get exactly the same packages and versions as specified in <code>composer.lock</code>.</p>
<p>Only if want to intentionally update the packages in your project you should run</p>
<pre><code>composer.phar update
</code></pre>
<p>As an example, packages on <code>dev-master</code> will constantly get new updates when you run <code>update</code>, while running <code>install</code> won't, unless you've pulled an update of the <code>composer.lock</code> file.</p>
<p>There are several paramaters available to the above commands. Very commonly used ones are <code>--no-dev</code>, which would skip packages in the <code>require-dev</code> section and <code>--prefer-dist</code>, which downloads archives if available, instead of checking out repositories to your <code>vendor</code> folder.</p>
<blockquote>
<p>Composer commands must be executed within your Yii project's directory, where the <code>composer.json</code> file can be found. Depending upon your operating system and setup, you may need to provide paths to the PHP executable and to the <code>composer.phar</code> script.</p>
</blockquote>
<h2>Adding more packages to your project <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#adding-more-packages-to-your-project" name="adding-more-packages-to-your-project">&para;</a></h2>
<p>To add two new packages to your project run the follwing command:</p>
<pre><code>composer.phar require "michelf/php-markdown:&gt;=1.3" "ezyang/htmlpurifier:&gt;4.5.0"
</code></pre>
<p>This will resolve the dependencies and then update your <code>composer.json</code> file. The above example says that a version greater than or equal to 1.3 of Michaelf's PHP-Markdown package is required and version 4.5.0 or greater of Ezyang's HTMLPurifier.</p>
<p>For details of this syntax, see the <a href="https://getcomposer.org/doc/01-basic-usage.md#package-versions">official Composer documentation</a>.</p>
<p>The full list of available Composer-supported PHP packages can be found at <a href="http://packagist.org/">packagist</a>. You may also search packages interactively just by entering <code>composer.phar require</code>.</p>
<h3>Manually editing your version constraints <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#manually-editing-your-version-constraints" name="manually-editing-your-version-constraints">&para;</a></h3>
<p>You may also edit the <code>composer.json</code> file manually. Within the <code>require</code> section, you specify the name and version of each required package, same as with the command above.</p>
<pre><code class="language-json">{
    "require": {
        "michelf/php-markdown": "&gt;=1.4",
        "ezyang/htmlpurifier": "&gt;=4.6.0"
    }
}
</code></pre>
<p>Once you have edited the <code>composer.json</code>, you can invoke Composer to download the updated dependencies. Run</p>
<pre><code>composer.phar update michelf/php-markdown ezyang/htmlpurifier
</code></pre>
<p>afterwards.</p>
<blockquote>
<p>Depending on the package additional configuration may be required (eg. you have to register a module in the config), but autoloading of the classes should be handled by composer.</p>
</blockquote>
<h2>Using a specifc version of a package <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#using-a-specifc-version-of-a-package" name="using-a-specifc-version-of-a-package">&para;</a></h2>
<p>Yii always comes with the latest version of a required library that it is compatible with, but allows you to use an older version if you need to.</p>
<p>A good example for this is jQuery which has <a href="http://jquery.com/browser-support/">dropped old IE browser support</a> in version 2.x. When installing Yii via composer the installed jQuery version will be the latest 2.x release. When you want to use jQuery 1.10 because of IE browser support you can adjust your composer.json by requiring a specific version of jQuery like this:</p>
<pre><code class="language-json">{
    "require": {
        ...
        "yiisoft/jquery": "1.10.*"
    }
}
</code></pre>
<h2>FAQ <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#faq" name="faq">&para;</a></h2>
<h3>Getting "You must enable the openssl extension to download files via https" <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#getting-you-must-enable-the-openssl-extension-to-download-files-via-https" name="getting-you-must-enable-the-openssl-extension-to-download-files-via-https">&para;</a></h3>
<p>If you're using WAMP check <a href="http://stackoverflow.com/a/14265815/1106908">this answer at StackOverflow</a>.</p>
<h3>Getting "Failed to clone , git was not found, check that it is installed and in your Path env." <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#getting-failed-to-clone-git-was-not-found-check-that-it-is-installed-and-in-your-path-env" name="getting-failed-to-clone-git-was-not-found-check-that-it-is-installed-and-in-your-path-env">&para;</a></h3>
<p>Either install git or try adding <code>--prefer-dist</code> to the end of <code>install</code> or <code>update</code> command.</p>
<h3>Should I Commit The Dependencies In My Vendor Directory? <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#should-i-commit-the-dependencies-in-my-vendor-directory" name="should-i-commit-the-dependencies-in-my-vendor-directory">&para;</a></h3>
<p>Short answer: No. Long answer, see <a href="https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md">here</a>.</p>
<h2>See also <a href="http://www.yiiframework.com/doc-2.0/guide-composer.html#see-also" name="see-also">&para;</a></h2>
<ul>
<li><a href="http://getcomposer.org">Official Composer documentation</a>.</li>
</ul>
</div>