<h1>页面缓存</h1>
<p>页面缓存指的是在服务器端缓存整个页面的内容。随后当同一个页面被请求时，内容将从缓存中取出，而不是重新生成。</p>
<p>页面缓存由 [[yii\filters\PageCache]] 类提供支持，该类是一个过滤器。它可以像这样在控制器类中使用：</p>
<pre class="brush: php;toolbar: false">
public function behaviors()
{
    return [
        [
            'class' => 'yii\filters\PageCache',
            'only' => ['index'],
            'duration' => 60,
            'variations' => [
                \Yii::$app->language,
            ],
            'dependency' => [
                'class' => 'yii\caching\DbDependency',
                'sql' => 'SELECT COUNT(*) FROM post',
            ],
        ],
    ];
}
</pre>
<p>上述代码表示页面缓存只在 <code>index</code> 操作时启用，页面内容最多被缓存 60 秒，会随着当前应用的语言更改而变化。如果文章总数发生变化则缓存的页面会失效。</p>
<p>如你所见，页面缓存和片段缓存极其相似。它们都支持 <code>duration</code>，<code>dependencies</code>，<code>variations</code> 和 <code>enabled</code> 配置选项。它们的主要区别是页面缓存是由过滤器实现，而片段缓存则是一个小部件。</p>
<p>你可以在使用页面缓存的同时，使用片段缓存和动态内容。</p>