<h1>缓存</h1>
<p>缓存是提升 Web 应用性能简便有效的方式。通过将相对静态的数据存储到缓存并在收到请求时取回缓存，应用程序便节省了每次重新生成这些数据所需的时间。</p>
<p>缓存可以应用在 Web 应用程序的任何层级任何位置。在服务器端，在较的低层面，缓存可能用于存储基础数据，例如从数据库中取出的最新文章列表；在较高的层面，缓存可能用于存储一段或整个 Web 页面，例如最新文章的渲染结果。在客户端，HTTP 缓存可能用于将最近访问的页面内容存储到浏览器缓存中。</p>
<p>Yii 支持如上所有缓存机制：</p>
<ul>
	<li><a href="guidelist?id=55">数据缓存</a></li>
	<li><a href="guidelist?id=56">片段缓存</a></li>
	<li><a href="guidelist?id=57">页面缓存</a></li>
	<li><a href="guidelist?id=58">HTTP 缓存</a></li>
</ul>