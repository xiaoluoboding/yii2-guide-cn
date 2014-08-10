<h1>身份验证</h1>
<p>身份验证是验证用户身份的动作,也是登录操作的基础。通常，身份验证使用一个标识符的组合（用户名或邮箱）以及密码。用户通过表单提交这些值,然后应用再与之前存储的资料进行比对(如用户注册时资料)。</p>
<p>在Yii中，整个过程都是半自动地执行的，只需开发人员自己去实现 [[yii\web\IdentityInterface]] 接口，它是认证系统中最重要的类。通常情况下，<code>IdentityInterface</code> 是通过 <code>User</code> 模型来实现的。</p>
<p>你可以在<a href="guidelist?id=3">高级应用模板</a>找到一个功能齐全的身份验证的例子。下面只列出了接口方法：</p>
<pre class="brush: php;toolbar: false">
class User extends ActiveRecord implements IdentityInterface
{
    // ...

    /**
     * 通过给定的ID找到一个身份。
     *
     * @param string|integer $id 需要查找的ID
     * @return IdentityInterface|null 和给定的ID匹配的身份对象.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * 通过给定的令牌找到一个身份。
     *
     * @param string $token 需要查找的身份验证密钥
     * @return IdentityInterface|null 和给定的令牌匹配的身份对象.
     */
    public static function findIdentityByAccessToken($token)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string 当前用户的身份验证密钥
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean 当前用户的身份验证密钥是否有效
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
</pre>
<p>有两个易于理解的纲要方法： <code>findIdentity</code> 接受一个ID值，并返回与该ID相关联的模型实例。 <code>getId</code> 方法则返回ID本身。 两个其他方法--<code>getAuthKey</code> 和 <code>validateAuthKey</code>--用于提供&ldquo;保持登录状态(remember me)&rdquo;的cookie的额外安全性。<code>getAuthKey</code> 方法应该返回一个字符串，对于每个用户它都是唯一的。您可以用 <code>Security::generateRandomKey()</code> 可靠地创建一个唯一的字符串。将这字符串也保存为用户对象的一个字段是一个不错的注意：</p>
<pre class="brush: php;toolbar: false">
public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        if ($this->isNewRecord) {
            $this->auth_key = Security::generateRandomKey();
        }
        return true;
    }
    return false;
}
</pre>
<p><code>validateAuthKey</code> 方法需要将传入的 <code>$authKey</code> 变量，作为一个参数（从一个 cookie 中获得），与数据库中的数据进行比较。</p>