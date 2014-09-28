<h1>主题（Theming）</h1>
<p>主题目录包含了视图文件和布局文件。渲染视图时，激活主题的每个文件将覆盖应用中对应的视图或布局文件。 单个应用可以使用多个主题，每个主题可以提供完全不同的视觉效果。 任何时候都只有一个主题被激活。</p>
<blockquote>
<p>注意：由于和应用程序息息相关，界面主题通常并不用来重新分发。如果你想重新发布自定义外观，可以考虑使用资源包（<a href="0311.html">资源管理</a>）。</p>
</blockquote>
<p>&nbsp;</p>
<h2>主题配置</h2>
<p>主题配置通过应用程序的 view 组件来指定。在基础应用程序中要使用界面主题，可配置如下：</p>
<pre class="brush: php;toolbar:false;">
'components' => [
    'view' => [
        'theme' => [
            'pathMap' => ['@app/views' => '@webroot/themes/basic'],
            'baseUrl' => '@web/themes/basic',
        ],
    ],
],
</pre>
<p>上例中，<code>pathMap</code> 路径图定义了查找视图文件的路径，而<code>baseUrl</code> 则定义了被这些文件所引用的资源的根URL(base URL)。 例如，如果<code>pathMap</code>为<code>['/web/views' =&gt; '/web/themes/basic']</code>，那么已激活主题的应用视图文件<code>/web/views/site/index.php</code>就相应的变成<code>/web/themes/basic/site/index.php</code> 视图文件了。</p>
<p>&nbsp;</p>
<h2>使用多重路径</h2>
<p>可以把多个主题路径映射到同一个视图路径。例如，</p>
<pre class="brush: php;toolbar:false;">
'pathMap' => [
    '/web/views' => [
        '/web/themes/christmas',
        '/web/themes/basic',
    ],
]
</pre>
<p>上例，视图会先搜索<code>/web/themes/christmas/site/index.php</code>文件，如果该文件不存在，则搜索<code>/web/themes/basic/site/index.php</code>文件。如果还没找到，应用视图文件将被引用。</p>
<p>在你想临时或是有条件的覆盖一些视图时，这个功能会非常有用。</p>