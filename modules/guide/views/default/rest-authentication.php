<h1>验证</h1>
<p>和Web应用程序不同，RESTful APIs 应该是无状态的（stateless），这意味着不能使用 sessions 或 cookies。因此，每个请求应该要携带某种认证证书来实现访问的安全性控制。一个通用的方法是在每个请求中发送一个秘密访问令牌（secret access token）来进行用户认证。由于一个访问令牌可以被用来唯一的识别和认证一个用户，<strong>API 请求应该总是通过 HTTPS 发送以防止 中间人（man-in-the-middle (MitM)）攻击。</strong></p>
<p>有一些不同的方法来发送访问令牌：</p>
<ul>
<li><a href="http://en.wikipedia.org/wiki/Basic_access_authentication" target="_blank">HTTP Basic Auth</a>: 访问令牌被当作用户名来发送。这个仅当访问令牌能安全保存在API消费者侧的情况下使用。比如，API 消费者（consumer）是一个服务器程序。</li>
<li>查询参数：访问令牌通过API URL中的一个查询参数来发送，比如 <code>https://example.com/users?access-token=xxxxxxxx</code>。由于大多数Web服务器将记录查询参数在服务器访问日志中，这个方法应该主要被用来服务于 <code>JSONP</code> 请求（不能使用 HTTP headers 来发送访问令牌access tokens）。</li>
<li><a href="http://oauth.net/2/" target="_blank">OAuth 2</a>: OAuth2协议，API 消费者通过一个认证服务器获取访问令牌并通过 <a href="http://tools.ietf.org/html/rfc6750" target="_blank">HTTP Bearer Tokens</a> 发送给API服务器。</li>
</ul>
<p>Yii 支持上述所有认证方式。你还可以很简单的创建新的认证方法。</p>
<p>启用API认证有两个步骤：</p>
<ol>
<li>通过配置REST控制器类的 <code>authenticator</code> 行为来指定认证方法。</li>
<li>在你的 用户识别类 中实现接口 <a href="http://www.yiiframework.com/doc-2.0/yii-web-identityinterface.html#findIdentityByAccessToken%28%29-detail">yii\web\IdentityInterface::findIdentityByAccessToken()</a>。</li>
</ol>
<p>例如，要使用 HTTP Basic Auth，你可以配置 <code>authenticator</code> 如下：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBasicAuth;

public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        'authenticator' => [
            'class' => HttpBasicAuth::className(),
        ],
    ]);
}
</pre>
<p>如果你想支持所有上述3种认证方法，你可以使用复合认证 <code>CompositeAuth</code> 如下：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        'authenticator' => [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ],
    ]);
}
</pre>
<p>每个 <code>authMethods</code> 元素都应该是一个 auth 方法的类名或者是一个配置数组。</p>
<p>实现 <code>findIdentityByAccessToken()</code> 方法是和具体应用程序相关的。比如，对于简单应用场景，每个用户只拥有一个访问令牌，你可以把访问令牌保存在user表的一个 <code>access_token</code> 列中。然后可以像下面这样方便的实现：</p>
<pre class="brush: php;toolbar: false">
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function findIdentityByAccessToken($token)
    {
        return static::findOne(['access_token' => $token]);
    }
}
</pre>
<p>如上在认证启用后，对于每个API请求，被请求的控制器会在它的 <code>beforeAction()</code> 方法中进行用户认证。</p>
<p>如果认证成功，控制器将执行其他检查（比如访问速率限制、鉴权）并执行受访动作。认证用户的标识信息可以通过 <code>Yii::$app-&gt;user-&gt;identity</code> 来获取。</p>
<p>如果认证失败，将返回HTTP状态码为401的应答，以及其它合适的头信息（比如对于HTTP Basic Auth 会返回一个 <code>WWW-Authenticate</code> 头）。</p>
<p>&nbsp;</p>
<h1>授权</h1>
<p>在用户认证通过后，你可能想检查他是否有足够的权限来访问请求资源的这个动作。这个过程被称为鉴权 <em>authorization</em> ，在 <a href="guidelist?id=5">授权</a> 章节有过详细描述。</p>
<p>你可以使用角色访问控制（Role-Based Access Control (RBAC)）组件来实现鉴权。</p>
<p>为了简化访问权限检查，你还可以覆盖 [[yii\rest\Controller::checkAccess()]] 方法然后在需要鉴权的地方调用它。缺省情况，[[yii\rest\ActiveController]] 的内置动作将在运行时调用这个方法：</p>
<pre class="brush: php;toolbar: false">
/**
 * Checks the privilege of the current user.
 *
 * This method should be overridden to check whether the current user has the privilege
 * to run the specified action against the specified data model.
 * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
 *
 * @param string $action the ID of the action to be executed
 * @param \yii\base\Model $model the model to be accessed. If null, it means no specific model is being accessed.
 * @param array $params additional parameters
 * @throws ForbiddenHttpException if the user does not have access
 */
public function checkAccess($action, $model = null, $params = [])
{
}
</pre>