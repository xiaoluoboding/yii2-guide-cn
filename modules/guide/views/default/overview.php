<h1>Yii是什么</h1>
<p>Yii 是一个高性能，基于组件的 PHP 框架，用于快速开发现代 Web 应用程序。名字 Yii （读作 <code>易</code>）在中文里有&ldquo;极致简单与不断演变&rdquo;两重含义，也可看作 <strong>Yes It Is</strong>! 的缩写。</p>
<p>&nbsp;</p>
<h2>Yii 最适合做什么？</h2>
<p>Yii 是一个通用的 Web 编程框架，即可以用于开发各种基于 PHP 的 Web 应用。因为基于组件的框架结构和设计精巧的缓存支持，Yii 特别适合开发大型应用，如门户网站、论坛、内容管理系统（CMS）、电子商务项目和 RESTful Web 服务等。</p>
<p>&nbsp;</p>
<h2>Yii 和其他框架相比呢？</h2>
<ul class="task-list">
<li>和其他 PHP 框架类似，Yii 实现了 MVC（Model-View-Controller）设计模式并基于该模式组织代码。</li>
<li>Yii 的代码简洁优雅，这是 Yii 的编程哲学。它永远不会为了要迎合某个设计模式而对代码进行过度的设计。</li>
<li>Yii 是一个全栈框架，提供了大量久经考验，开箱即用的特性，例如：对关系型和 NoSQL 数据库都提供了查询生成器（QueryBuilders）和 ActiveRecord；RESTful API 的开发支持；多层缓存支持，等等。</li>
<li>Yii 非常易于扩展。你可以自定义或替换几乎任何一处核心代码。你还会受益于它坚实可靠的扩展架构，使用、再开发或再发布扩展。</li>
<li>高性能始终是 Yii 的首要目标之一。</li>
</ul>
<p>Yii 不是一场独角戏，它由一个<a href="http://www.yiiframework.com/about/">强大的开发者团队</a>提供支持，也有一个庞大的专家社区，持续不断地对 Yii 的开发作出贡献。Yii 开发者团队始终对 Web 开发最新潮流和其他框架及项目中的最佳实践和特性保持密切关注，那些有意义的最佳实践及特性会被不定期的整合进核心框架中，并提供简单优雅的接口。</p>
<p>&nbsp;</p>
<h2><a class="anchor" href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/intro-yii.md#yii-%E7%89%88%E6%9C%AC" name="user-content-yii-版本"></a>Yii 版本</h2>
<p>Yii 当前有两个主要版本：1.1 和 2.0。 1.1 版是上代的老版本，现在处于维护状态。2.0 版是一个完全重写的版本，采用了最新的技术和协议，包括依赖包管理器（Composer）、PHP 代码规范（PSR）、命名空间、Traits（特质）等等。 2.0 版代表了最新一代框架，是未来几年中我们的主要开发版本。本指南主要基于 2.0 版编写。</p>
<p>&nbsp;</p>
<h2><a class="anchor" href="https://github.com/yii2-chinesization/yii2-zh-cn/blob/master/guide-zh-CN/intro-yii.md#%E7%B3%BB%E7%BB%9F%E8%A6%81%E6%B1%82%E5%92%8C%E5%85%88%E5%86%B3%E6%9D%A1%E4%BB%B6" name="user-content-系统要求和先决条件"></a>系统要求和先决条件</h2>
<p>Yii 2.0 需要 PHP 5.4.0 或以上版本支持。你可以通过运行任何 Yii 发行包中附带的系统要求检查器查看每个具体特性所需的 PHP 配置。</p>
<p>使用 Yii 需要对面向对象编程（OOP）有基本了解，因为 Yii 是一个纯面向对象的框架。Yii 2.0 还使用了 PHP 的最新特性，例如 <a href="http://www.php.net/manual/en/language.namespaces.php">命名空间</a> 和 <a href="http://www.php.net/manual/en/language.oop5.traits.php">Trait（特质）</a>。理解这些概念将有助于你更快地掌握 Yii 2.0。</p>