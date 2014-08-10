<h1>安全</h1>
<p>好的安全性对于一个应用的健康与成功是至关重要的。不幸的是，或因为理解有限，也可能是该领域有太多障碍难以逾越，很多开发者都在安全这方面偷了懒。为了让您的 Yii 应用可以尽可能的安全，我们引入了很多很棒又很易用的安全特性。</p>
<p>&nbsp;</p>
<h2>加密与验证密码</h2>
<p>很多开发者都知道密码不能直接保存明文，但是很多开发者仍相信，用 <code>md5</code> 或是 <code>sha1</code> 加密密码还很安全。曾几何时，用上面那俩哈希算法还算安全，而现如今的现代硬件已经让快速地暴力破解这些哈希串成为了可能。（注：有数据显示目前的硬件水准暴力破解 md5 只要七分钟）</p>
<p>为了能给用户密码提供更多安全，即使是在最悲催的情况下（就是应用被破坏了），你需要使用一种能对暴力破解有抵抗力的哈希算法。目前最好的选择是 <code>bcrypt</code>。在 PHP 里，你可以用 PHP 的 <a href="http://php.net/manual/zh/function.crypt.php">crypt 函数</a>来创建一条 <code>bcrypt</code> 哈希串。Yii 提供了两个 helper（助手）函数，他们封装了 <code>crypt</code>，从而使得生成与验证这些哈希串更方便更容易。</p>
<p>当一个用户提供了一条密码（e.g. 注册的时候），这条密码需要被加密：</p>
<pre class="brush: php;toolbar: false">$hash = \yii\helpers\Security::generatePasswordHash($password);</pre>
<p>这条哈希串可以被存到相应模型的特性里，这样他就可以被存储进数据库以待备用。</p>
<p>当一个用户尝试登陆的时候，提交的密码必须与之前加密的存储密码相验证：</p>
<pre class="brush: php;toolbar: false">
use yii\helpers\Security;
if (Security::validatePassword($password, $hash)) {
    // 一切安好，则许其登陆
} else {
    // 错误密码则……
}
</pre>
<p>&nbsp;</p>
<h2>生成伪随机数据</h2>
<p>伪随机数据在很多情况下很有用，比如当通过电子邮件重置密码时，就需要生产一个 token（令牌），同时保存进数据库，并把它发送给相关邮箱地址，用以让端用户证明他对其账户拥有所有权。这样 token 的唯一性与不易猜测就很重要啦，如若不然，黑客就可能推测令牌的值，进而重置你用户的密码。</p>
<p>Yii 的 security（安全）助手类让生成伪随机数据简单得很：</p>
<pre class="brush: php;toolbar: false">
$key = \yii\helpers\Security::generateRandomKey();
</pre>
<p>注意，要想生成密码学上安全可靠的随机数据，你需要确保服务器上预先安装 PHP 的 <code>openssl</code> 扩展。（译者：一般都安装了，只是需要手动检查下有没有开启）</p>
<p>&nbsp;</p>
<h2>加密及解密</h2>
<p>Yii 提供了很方便的助手函数，可以帮助你基于一个密匙来加密或者解密数据。这样当数据被这样加密了之后，只有拥有密匙的人才能解密它。 举例而言，如果我们需要在数据库中保存某些信息，但是我们需要确保只有拥有密匙的人才能看到它们（即使被拖库了）时：</p>
<pre class="brush: php;toolbar: false">
// $data 和 $secretKey 是从表单处传入的
$encryptedData = \yii\helpers\Security::encrypt($data, $secretKey);
// 把 $encryptedData 存入数据库
</pre>
<p>这之后当用户需要读取数据时：</p>
<pre class="brush: php;toolbar: false">
// $secretKey 是从用户输入处获取的，$encryptedData 则来自数据库
$data = \yii\helpers\Security::decrypt($encryptedData, $secretKey);
</pre>
<p>&nbsp;</p>
<h2>确认数据完整性</h2>
<p>有这样一种情况是，你需要检查你的数据没有被第三方干扰或者因某些原因被损坏了。Yii 提供了一个简单的检查数据完整性的方法，它包含了两个助手函数。</p>
<p>基于密匙和数据给这个数据本身加个哈希的前缀：</p>
<pre class="brush: php;toolbar: false">
// $secretKey 是我们的应用或用户的密匙，$genuineData 获取自某一可信任的资源
$data = \yii\helpers\Security::hashData($genuineData, $secretKey);
</pre>
<p>检查数据完整性是否被破坏：</p>
<pre class="brush: php;toolbar: false">
// $secretKey 是我们的应用或用户的密匙，$genuineData 获取自某一不可信的资源
$data = \yii\helpers\Security::validateData($data, $secretKey);
</pre>
<p>跨站脚本(XSS)、跨站请求伪造(CSRF)防护，cookie保护部分的内容，请参考1.1版本的指南。</p>
<p>你还可以在控制器中禁用跨站请求伪造验证，通过设置其属性如下：</p>
<pre class="brush: php;toolbar: false">
namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        // CSRF 验证不会应用到这个或者其他的动作中
    }

}
</pre>
<p>同样的，也可以禁用动作的 CSRF 验证：</p>
<pre class="brush: php;toolbar: false">
namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        return parent::beforeAction($action);
    }
}
</pre>
<p>&nbsp;</p>
<h2>Cookies 安全</h2>
<ul>
	<li>validation</li>
	<li>httpOnly</li>
</ul>
<p>&nbsp;</p>
<h2>See Also</h2>
<a href="guidelist?id=49#security">视图安全</a>