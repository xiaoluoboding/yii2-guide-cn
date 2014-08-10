<h1>数据小部件</h1>
<p>&nbsp;</p>
<h2>表格视图（ListView）</h2>
<p>[[yii\grid\GridView]] 是用来展示支持分页、排序功能的表格数据的强大界面组件。查阅 <a href="#">数据表格</a> 章节获取更多信息。</p>
<p>&nbsp;</p>
<h2>列表视图（ListView）</h2>
<p>&nbsp;</p>
<h2>细节视图（ListView）</h2>
<p>DetailView 显示单个数据 模型 的详细信息。</p>
<p>这个视图最适合以一个规范格式来显示模型（比如每个模型属性被显示为表格一行）。模型可以是 [[yii\base\Model]] 的一个实例或者是一个相关数组。</p>
<p>DetailView 使用 [[yii\widgets\DetailView::$attributes]] 属性来指定哪些模型属性应该被显示以及如何格式化。</p>
<p>DetailView的一个典型应用如下：</p>
<pre class="brush: php;toolbar: false">
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',             // title attribute (in plain text)
        'description:html',  // description attribute in HTML
        [                    // the owner name of the model
            'label' => 'Owner',
            'value' => $model->owner->name,
        ],
    ],
]);
</pre>
