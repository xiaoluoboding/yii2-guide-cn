<h1>错误处理</h1>
<p>处理一个 RESTful API 请求时， 如果有一个用户请求错误或服务器发生意外时， 你可以简单地抛出一个异常来通知用户出错了。 如果你能找出错误的原因 (例如，所请求的资源不存在)，你应该 考虑抛出一个适当的HTTP状态代码的异常 (例如， [[yii\web\NotFoundHttpException]] 意味着一个404 HTTP状态代码)。 Yii 将通过HTTP状态码和文本 发送相应的响应。 它还将包括在响应主体异常的 序列化表示形式。 例如，</p>
<pre class="brush: php;toolbar: false">
HTTP/1.1 404 Not Found
Date: Sun, 02 Mar 2014 05:31:43 GMT
Server: Apache/2.2.26 (Unix) DAV/2 PHP/5.4.20 mod_ssl/2.2.26 OpenSSL/0.9.8y
Transfer-Encoding: chunked
Content-Type: application/json; charset=UTF-8

{
    "type": "yii\\web\\NotFoundHttpException",
    "name": "Not Found Exception",
    "message": "The requested resource was not found.",
    "code": 0,
    "status": 404
}
</pre>
<p>下面的列表总结了Yii的REST框架的HTTP状态代码:</p>
<ul class="task-list">
<li><code>200</code>: OK。一切正常。</li>
<li><code>201</code>: 响应 <code>POST</code> 请求时成功创建一个资源。<code>Location</code> header 包含的URL指向新创建的资源。</li>
<li><code>204</code>: 该请求被成功处理，响应不包含正文内容 (类似 <code>DELETE</code> 请求)。</li>
<li><code>304</code>: 资源没有被修改。可以使用缓存的版本。</li>
<li><code>400</code>: 错误的请求。可能通过用户方面的多种原因引起的，例如在请求体内有无效的JSON 数据，无效的操作参数，等等。</li>
<li><code>401</code>: 验证失败。</li>
<li><code>403</code>: 已经经过身份验证的用户不允许访问指定的 API 末端。</li>
<li><code>404</code>: 所请求的资源不存在。</li>
<li><code>405</code>: 不被允许的方法。 请检查 <code>Allow</code> header 允许的HTTP方法。</li>
<li><code>415</code>: 不支持的媒体类型。 所请求的内容类型或版本号是无效的。</li>
<li><code>422</code>: 数据验证失败 (例如，响应一个 <code>POST</code> 请求)。 请检查响应体内详细的错误消息。</li>
<li><code>429</code>: 请求过多。 由于限速请求被拒绝。</li>
<li><code>500</code>: 内部服务器错误。 这可能是由于内部程序错误引起的。</li>
</ul>