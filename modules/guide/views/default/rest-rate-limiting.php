<h1>速率限制</h1>
<p>为防止滥用，你应该考虑增加速率限制到您的API。 例如，您可以限制每个用户的API的使用是在10分钟内最多100次的API调用。 如果一个用户同一个时间段内太多的请求被接收， 将返回响应状态代码 429 (这意味着过多的请求)。</p>
<p>要启用速率限制, [[yii\web\User::identityClass|user identity class]] 应该实现 [[yii\filters\RateLimitInterface]]. 这个接口需要实现以下三个方法：</p>
<ul class="task-list">
<li><code>getRateLimit()</code>: 返回允许的请求的最大数目及时间，例如，<code>[100, 600]</code> 表示在600秒内最多100次的API调用。</li>
<li><code>loadAllowance()</code>: 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。</li>
<li><code>saveAllowance()</code>: 保存允许剩余的请求数和当前的UNIX时间戳。</li>
</ul>
<p>你可以在user表中使用两列来记录容差和时间戳信息。 <code>loadAllowance()</code> 和 <code>saveAllowance()</code> 可以通过实现对符合当前身份验证的用户 的这两列值的读和保存。为了提高性能，你也可以 考虑使用缓存或NoSQL存储这些信息。</p>
<p>一旦 identity 实现所需的接口， Yii 会自动使用 [[yii\filters\RateLimiter]] 为 [[yii\rest\Controller]] 配置一个行为过滤器来执行速率限制检查。 如果速度超出限制 该速率限制器将抛出一个 [[yii\web\TooManyRequestsHttpException]]。 你可以在你的 REST 控制器类里配置速率限制，</p>
<pre class="brush: php;toolbar: false">
public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
    return $behaviors;
}
</pre>
<p>当速率限制被激活，默认情况下每个响应将包含以下HTTP头发送 目前的速率限制信息：</p>
<ul class="task-list">
<li><code>X-Rate-Limit-Limit</code>: 同一个时间段所允许的请求的最大数目;</li>
<li><code>X-Rate-Limit-Remaining</code>: 在当前时间段内剩余的请求的数量;</li>
<li><code>X-Rate-Limit-Reset</code>: 为了得到最大请求数所等待的秒数。</li>
</ul>
<p>你可以禁用这些头信息通过配置 [[yii\filters\RateLimiter::enableRateLimitHeaders]] 为false, 就像在上面的代码示例所示。</p>
<p>&nbsp;</p>